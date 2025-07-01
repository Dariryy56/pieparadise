<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$cartId = $input['cart_id'] ?? null;
$change = (int)($input['change'] ?? 0);

if (!$cartId) {
    echo json_encode(['success' => false, 'message' => 'Не указана запись корзины']);
    exit;
}

try {
    // Получаем текущее количество
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cartId, $_SESSION['user']['id']]);
    $item = $stmt->fetch();

    if (!$item) {
        echo json_encode(['success' => false, 'message' => 'Товар не найден']);
        exit;
    }

    $newQuantity = $item['quantity'] + $change;

    if ($newQuantity <= 0) {
        // Удаляем товар
        $deleteStmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $deleteStmt->execute([$cartId, $_SESSION['user']['id']]);
        echo json_encode(['success' => true, 'deleted' => true]);
    } else {
        // Обновляем количество
        $updateStmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $updateStmt->execute([$newQuantity, $cartId, $_SESSION['user']['id']]);
        
        // Получаем данные товара для пересчёта суммы
        $productStmt = $pdo->prepare("SELECT p.price FROM products p JOIN cart c ON p.id = c.product_id WHERE c.id = ?");
        $productStmt->execute([$cartId]);
        $product = $productStmt->fetch();
        
        echo json_encode([
            'success' => true,
            'newQuantity' => $newQuantity,
            'itemTotal' => $product['price'] * $newQuantity
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?>