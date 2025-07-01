<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $errors = [];
    
    if (empty($username)) $errors[] = "Логин обязателен";
    if (empty($password)) $errors[] = "Пароль обязателен";
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && $password === $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'password' => $user['password']
                ];
                header("Location: ../account/account2.php");
                exit();
            } else {
                $errors[] = "Неверный логин или пароль";
            }
        } catch(PDOException $e) {
            $errors[] = "Ошибка при авторизации: " . $e->getMessage();
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }
    header("Location: ../Authoriz/index.php");
    exit();
} else {
    header("Location: ../Authoriz/index.php");
    exit();
}
?>