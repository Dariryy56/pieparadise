<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pieparadise";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-запрос для получения данных о товарах
$sql = "SELECT id, image, name, description, price, weight FROM Товары";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    // Выводим данные каждой строки
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();

// Отправляем данные в формате JSON
header('Content-Type: application/json');
echo json_encode($products);


?>