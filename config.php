<?php
// Конфигурация Telegram бота
define('TELEGRAM_BOT_TOKEN', '8388015592:AAHsIVNMTXOZZKgTMDbPtjyDqONQqHSgWRw'); // Укажите токен вашего бота
define('TELEGRAM_CHAT_ID', '-5094594763'); // Укажите ID группового чата

// Функции для работы с Telegram
function telegramSendMessage($text) {
    $botToken = TELEGRAM_BOT_TOKEN;
    $data = [
        'chat_id' => TELEGRAM_CHAT_ID,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $botToken . "/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Функция проверки капчи (если нужно)
// function verifyRecaptcha($token) {
//     // Реализация проверки Google reCAPTCHA
// }
?>
