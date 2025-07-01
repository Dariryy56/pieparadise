<?php
session_start();
require 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$orderId = $input['order_id'] ?? null;

if (!$orderId) {
    echo json_encode(['success' => false, 'message' => 'Не указан заказ']);
    exit;
}

try {
    // Сначала проверяем, принадлежит ли заказ пользователю
    $checkStmt = $pdo->prepare("SELECT user_id FROM orders WHERE id = ?");
    $checkStmt->execute([$orderId]);
    $order = $checkStmt->fetch();
    
    if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
        echo json_encode(['success' => false, 'message' => 'Заказ не найден или не принадлежит вам']);
        exit;
    }
    
    // Удаляем заказ
    $pdo->beginTransaction();
    
    // Сначала удаляем товары заказа
    $deleteItemsStmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
    $deleteItemsStmt->execute([$orderId]);
    
    // Затем сам заказ
    $deleteOrderStmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $deleteOrderStmt->execute([$orderId]);
    
    $pdo->commit();
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?>