<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);
    $new_password_confirm = trim($_POST['new_password_confirm']);

    $errors = [];
    
    // Проверка существования пользователя
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if (!$stmt->fetch()) {
        $errors[] = "Неизвестный логин";
    }
    
    if (empty($username)) $errors[] = "Логин обязателен";
    if (empty($new_password)) $errors[] = "Пароль обязателен";
    if ($new_password !== $new_password_confirm) $errors[] = "Пароли не совпадают";
    
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        if ($stmt->execute([$new_password, $username])) {
            $_SESSION['success'] = "Пароль успешно изменен";
            header("Location: ../Authoriz/index.php");
            exit();
        } else {
            $errors[] = "Ошибка при изменении пароля";
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../Password/index.php");
        exit();
    }
}
?>