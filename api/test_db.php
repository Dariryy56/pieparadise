<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$cartId = $data['cart_id'];
$change = $data['change'];
$userId = $_SESSION['user_id'];

// Проверяем принадлежность корзины
$stmt = $pdo->prepare("SELECT * FROM cart WHERE id = ? AND user_id = ?");
$stmt->execute([$cartId, $userId]);
$cartItem = $stmt->fetch();

if (!$cartItem) {
    echo json_encode(['success' => false, 'message' => 'Элемент не найден']);
    exit;
}

$newQuantity = $cartItem['quantity'] + $change;
if ($newQuantity < 0) $newQuantity = 0;

if ($newQuantity === 0) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$cartId]);
    $action = 'delete';
} else {
    $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $stmt->execute([$newQuantity, $cartId]);
    $action = 'update';
}

// Получаем информацию о товаре
$productStmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
$productStmt->execute([$cartItem['product_id']]);
$product = $productStmt->fetch();

$itemTotal = $newQuantity * $product['price'];

// Общая сумма корзины
$totalStmt = $pdo->prepare("
    SELECT SUM(p.price * c.quantity) AS grand_total
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$totalStmt->execute([$userId]);
$grandTotal = $totalStmt->fetch()['grand_total'] ?? 0;

echo json_encode([
    'success' => true,
    'action' => $action,
    'newQuantity' => $newQuantity,
    'itemTotal' => $itemTotal,
    'grandTotal' => $grandTotal
]);
?>