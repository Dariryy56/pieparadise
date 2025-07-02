<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Недопустимый метод запроса');
    }

    // Получаем данные
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Валидация
    if (empty($name)) throw new Exception('Поле "Имя" обязательно');
    if (empty($email)) throw new Exception('Поле "Email" обязательно');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception('Некорректный email');
    if (empty($message)) throw new Exception('Поле "Сообщение" обязательно');

    // Настройка PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pilipchakdara56@gmail.com';
    $mail->Password = 'lhhidjopvfetubea';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // От кого и кому
    $mail->setFrom('pilipchakdara56@gmail.com', 'PieParadise');
    $mail->addAddress('isip_d.yu.pilipchak@mpt.ru');
    $mail->addReplyTo($email, $name);

    // Содержание письма - HTML-шаблон
    $mail->Subject = "Новый отзыв на сайте PieParadise от $name";
    
    $mail->Body = '
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Новый отзыв</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px; }
            .header { background-color: #f8f9fa; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
            .logo { max-width: 150px; margin-bottom: 15px; }
            .content { padding: 25px; background-color: #fff; }
            .divider { height: 1px; background: #e0e0e0; margin: 20px 0; }
            .field { margin-bottom: 15px; }
            .field-label { font-weight: bold; color: #555; display: block; margin-bottom: 5px; }
            .field-value { padding: 10px; background: #f8f9fa; border-radius: 4px; }
            .message-content { padding: 15px; background: #f1f8ff; border-left: 4px solid #4dabf7; border-radius: 4px; }
            .footer { text-align: center; padding: 15px; color: #6c757d; font-size: 0.9em; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>PieParadise</h2>
                <p>Новый отзыв от клиента</p>
            </div>
            
            <div class="content">
                <p>Здравствуйте!</p>
                <p>На сайте PieParadise был оставлен новый отзыв. Пожалуйста, ознакомьтесь с деталями:</p>
                
                <div class="divider"></div>
                
                <div class="field">
                    <span class="field-label">Имя:</span>
                    <div class="field-value">'.htmlspecialchars($name).'</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Email:</span>
                    <div class="field-value">'.htmlspecialchars($email).'</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Дата отправки:</span>
                    <div class="field-value">'.date('d.m.Y H:i').'</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Сообщение:</span>
                    <div class="message-content">'.nl2br(htmlspecialchars($message)).'</div>
                </div>
                
                <div class="divider"></div>
                
                <p>Вы можете ответить на это письмо, чтобы связаться с клиентом.</p>
            </div>
            
            <div class="footer">
                <p>Это сообщение было отправлено автоматически. Пожалуйста, не отвечайте на него.</p>
                <p>&copy; '.date('Y').' PieParadise. Все права защищены.</p>
            </div>
        </div>
    </body>
    </html>
    ';

    // Текстовая версия для почтовых клиентов без HTML
    $mail->AltBody = "Новый отзыв от $name\n"
        . "Email: $email\n\n"
        . "Сообщение:\n$message\n\n"
        . date('d.m.Y H:i');

    // Отправка
    $mail->send();
    $response = ['success' => true, 'message' => 'Сообщение успешно отправлено!'];

} catch (Exception $e) {
    $response['message'] = 'Ошибка: ' . $e->getMessage();
}

echo json_encode($response);
?>