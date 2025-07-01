<?php
require 'vendor/autoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Недопустимый метод запроса');
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $errors = [];

    if (empty($name)) $errors[] = "Поле 'Имя' обязательно";
    if (empty($email)) $errors[] = "Поле 'Email' обязательно";
    if (empty($message)) $errors[] = "Поле 'Сообщение' обязательно";
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email";
    }

    if (!empty($errors)) {
        $response['message'] = implode(', ', $errors);
        echo json_encode($response);
        exit;
    }

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pilipchakdara56@gmail.com'; // Замените на реальный email
    $mail->Password = 'D5a8s9h1a'; // Замените на реальный пароль
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($email, $name);
    $mail->addAddress('isip_d.yu.pilipchak@mpt.ru');
    $mail->Subject = "Новый отзыв от $name";
    $mail->Body = "Имя: $name\nEmail: $email\n\nСообщение:\n$message";

    $mail->send();
    $response = ['success' => true, 'message' => 'Сообщение успешно отправлено'];

} catch (Exception $e) {
    $response['message'] = 'Ошибка при отправке: ' . $e->getMessage();
}

echo json_encode($response);
?>