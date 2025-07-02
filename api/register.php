<?php
session_start();
require_once 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    // Валидация
    $errors = [];

    if (empty($username))
        $errors[] = "Логин обязателен";
    if (empty($email))
        $errors[] = "Email обязателен";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Некорректный email";
    if (empty($phone))
        $errors[] = "Телефон обязателен";
    if (empty($first_name))
        $errors[] = "Имя обязательно";
    if (empty($last_name))
        $errors[] = "Фамилия обязательна";
    if (empty($password))
        $errors[] = "Пароль обязателен";
    if ($password !== $password_confirm)
        $errors[] = "Пароли не совпадают";

    // Добавьте в блок валидации
    if (empty($phone)) {
        $errors[] = "Телефон обязателен";
    } elseif (!preg_match('/^\+7\d{10}$/', $phone)) {
        $errors[] = "Телефон должен быть в формате: +7XXXXXXXXXX (11 цифр)";
    }
    // Проверка уникальности логина и email
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Пользователь с таким логином или email уже существует";
    }

    if (empty($errors)) {
        try {
            // Регистрация пользователя
            $stmt = $pdo->prepare("INSERT INTO users (username, email, phone, first_name, last_name, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $email, $phone, $first_name, $last_name, $password]);

            // Получаем ID нового пользователя
            $userId = $pdo->lastInsertId();

            // Устанавливаем сессию
            $_SESSION['user'] = [
                'id' => $userId,
                'username' => $username,
                'email' => $email,
                'phone' => $phone,
                'first_name' => $first_name,
                'last_name' => $last_name
            ];

            header("Location: ../account/account2.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Ошибка при регистрации: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../Registration/index.php");
        exit();
    }
} else {
    header("Location: ../Registration/index.php");
    exit();
}
?>