<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../Authoriz/index.php");
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $errors = [];
    
    // Получаем данные из формы (единый порядок полей)
    $data = [
        'username' => trim($_POST['username']),
        'email' => trim($_POST['email']),
        'first_name' => trim($_POST['first_name']),
        'last_name' => trim($_POST['last_name']),
        'phone' => trim($_POST['phone']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password'] ?? '')
    ];

    // Упрощенная проверка email
    if (empty($data['email'])) {
        $errors[] = "Email не может быть пустым";
    } elseif (strpos($data['email'], '@') === false || strpos($data['email'], '.') === false) {
        $errors[] = "Email должен содержать символы '@' и '.'";
    }

    // Проверка пароля (если введен)
    if (!empty($data['password'])) {
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Пароли не совпадают";
        }
    } else {
        // Если пароль не меняли - оставляем старый
        $data['password'] = $user['password'];
    }

    function validate_phone($phone) {
    return preg_match('/^\+\d{11}$/', $phone);
}


    function validate_email($email) {
    $allowed_domains = ['gmail.com', 'mail.ru', 'yandex.ru', 'yandex.com'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
    $domain = substr(strrchr($email, "@"), 1);
    return in_array($domain, $allowed_domains);
}

function validate_name($name) {
    return preg_match('/^[А-ЯЁ][а-яё]+$/u', $name);
}

   // Проверка уникальности username (логина), исключая текущего пользователя
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
    $stmt->execute([$data['username'], $user['id']]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Такой логин уже существует";
    }

    // Проверка уникальности email, исключая текущего пользователя
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$data['email'], $user['id']]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Такой email уже существует";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, phone = ?, password = ? WHERE id = ?");
            if ($stmt->execute([
                $data['username'],
                $data['email'],
                $data['first_name'],
                $data['last_name'],
                $data['phone'],
                $data['password'],
                $user['id']
            ])) {
                // Обновляем сессию
                $_SESSION['user'] = array_merge($user, [
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'password' => $data['password']
                ]);
                $_SESSION['success'] = "Данные успешно сохранены";
                header("Location: ../account/account2.php");
                exit();
            }
        } catch(PDOException $e) {
            $errors[] = "Ошибка базы данных: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }
    header("Location: ../account/account2.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    session_start();
    $user_id = $_SESSION['user_id'];
    
    try {
        $pdo->beginTransaction();
        
        // Удаление заказов пользователя
        $stmt = $pdo->prepare("DELETE orders, order_items 
                              FROM orders 
                              JOIN order_items ON orders.id = order_items.order_id 
                              WHERE orders.user_id = ?");
        $stmt->execute([$user_id]);
        
        // Удаление корзины
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        // Удаление аккаунта
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        
        $pdo->commit();
        
        session_destroy();
        echo "<script>alert('Аккаунт удалён'); window.location.href = '../Authoriz/index.php';</script>";
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<script>alert('Ошибка при удалении аккаунта: " . $e->getMessage() . "');</script>";
    }
}
?>