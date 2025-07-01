<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require 'db.php'; // Подключаем файл с соединением к БД

// Получаем параметры фильтра
$category_slug = $_GET['category'] ?? '';
$title = $_GET['title'] ?? '';
$price_from = $_GET['price_from'] ?? '';
$price_to = $_GET['price_to'] ?? '';

// Базовый запрос с JOIN категорий
$sql = "SELECT p.* FROM products p 
        JOIN categories c ON p.category_id = c.id
        WHERE 1=1";
$params = [];

// Фильтр по категории (через slug)
if (!empty($category_slug)) {
    $sql .= " AND c.slug = :category_slug";
    $params[':category_slug'] = $category_slug;
}

// Фильтр по названию
if (!empty($title)) {
    $sql .= " AND p.title LIKE :title";
    $params[':title'] = '%' . $title . '%';
}

// Фильтр по цене "от"
if (is_numeric($price_from)) {
    $sql .= " AND p.price >= :price_from";
    $params[':price_from'] = (float)$price_from;
}

// Фильтр по цене "до"
if (is_numeric($price_to)) {
    $sql .= " AND p.price <= :price_to";
    $params[':price_to'] = (float)$price_to;
}

// Сортировка и выполнение
$sql .= " ORDER BY p.title ASC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>