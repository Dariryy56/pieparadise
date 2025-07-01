<?php
require 'db.php';

if (!isset($_GET['table'])) {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['error' => 'Table name not provided']);
    exit;
}

$table = $_GET['table'];

try {
    $stmt = $pdo->query("DESCRIBE $table");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($columns);
} catch (PDOException $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => $e->getMessage()]);
}
?>