<?php
session_start();
require 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

try {
    $pdo->beginTransaction();
    
    // Получаем товары из корзины
    $cartStmt = $pdo->prepare("
        SELECT c.product_id, c.quantity, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?
    ");
    $cartStmt->execute([$_SESSION['user']['id']]);
    $cartItems = $cartStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($cartItems)) {
        throw new Exception('Корзина пуста');
    }
    
    // Рассчитываем общую сумму
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    // Создаем заказ
    $orderStmt = $pdo->prepare("
        INSERT INTO orders (
            user_id, order_date, delivery_date, total, status, 
            payment_method, street, entrance, floor, apartment, phone
        ) VALUES (
            ?, NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), ?, 'В обработке',
            ?, ?, ?, ?, ?, ?
        )
    ");
    
    $orderStmt->execute([
        $_SESSION['user']['id'],
        $total,
        $input['payment_method'],
        $input['street'],
        $input['entrance'],
        $input['floor'],
        $input['apartment'],
        $input['phone']
    ]);
    
    $orderId = $pdo->lastInsertId();
    
    // Добавляем товары в заказ
    foreach ($cartItems as $item) {
        $itemStmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        $itemStmt->execute([
            $orderId,
            $item['product_id'],
            $item['quantity'],
            $item['price']
        ]);
    }
    
    // Очищаем корзину
    $clearCartStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $clearCartStmt->execute([$_SESSION['user']['id']]);
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'order_id' => $orderId,
        'message' => 'Заказ успешно оформлен'
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Ошибка: ' . $e->getMessage()
    ]);
}
?>