<?php
session_start();
require 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user']['id'];

try {
    // Получаем заказы пользователя
    $ordersStmt = $pdo->prepare("
        SELECT o.id, o.order_date, 
               DATE_ADD(o.order_date, INTERVAL 3 DAY) as delivery_date, 
               o.total, o.status, o.payment_method,
               o.street, o.entrance, o.floor, o.apartment, o.phone
        FROM orders o
        WHERE o.user_id = ?
        ORDER BY o.order_date DESC
    ");
    $ordersStmt->execute([$userId]);
    $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Для каждого заказа получаем товары
    foreach ($orders as &$order) {
        $itemsStmt = $pdo->prepare("
            SELECT oi.product_id, p.title, p.image, oi.quantity, oi.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $itemsStmt->execute([$order['id']]);
        $order['items'] = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode($orders);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>