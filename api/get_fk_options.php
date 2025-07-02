<?php
require_once 'db.php';

$field = $_GET['field'] ?? '';

$options = [];

switch ($field) {
    case 'user_id':
        $stmt = $pdo->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM users ORDER BY id");
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 'product_id':
        $stmt = $pdo->query("SELECT id, title FROM products ORDER BY id");
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 'category_id':
        $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY id");
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;
    default:
        // Пустой массив для остальных полей
        $options = [];
}

header('Content-Type: application/json');
echo json_encode($options);
