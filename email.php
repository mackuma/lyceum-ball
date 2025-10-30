<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $secret = "ES_0164cf81bc124efdbfd321b16ee1656e"; 
    $response = $_POST['h-captcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $verify = file_get_contents("https://hcaptcha.com/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
    $captcha_success = json_decode($verify);

    if (!$captcha_success->success) {
        echo "<p style='color:red; text-align:center;'>Ошибка: подтвердите, что вы не робот.</p>";
        echo "<p style='text-align:center;'><a href='javascript:history.back()'>← Вернуться</a></p>";
        exit;
    }

    $name = htmlspecialchars($_POST["name"] ?? '');
    $email = htmlspecialchars($_POST["email"] ?? '');
    $message = htmlspecialchars($_POST["message"] ?? '');

    $to = "maksinthesky@gmail.com";
    $subject = "Предложение по сценарию от $name";
    $body = "Имя: $name\nEmail: $email\n\nПредложение:\n$message";
    $headers = "From: noreply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost');

    if (mail($to, $subject, $body, $headers)) {
        echo "<p style='color:green; text-align:center;'>Спасибо! Ваше предложение отправлено.</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Ошибка отправки. Попробуйте позже.</p>";
    }
}
?>