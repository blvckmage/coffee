<?php
require_once 'config.php';

header('Content-Type: application/json');

// Получаем данные из POST запроса
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Проверяем обязательные поля
if (!$data || !isset($data['name']) || !isset($data['phone']) || !isset($data['service'])) {
    echo json_encode(['success' => false, 'message' => 'Недостаточно данных']);
    exit;
}

// Формируем сообщение для Telegram
$message = "🍽️ <b>Новый заказ на кейтеринг!</b>\n\n";
$message .= "👤 <b>Имя:</b> " . htmlspecialchars($data['name']) . "\n";
$message .= "📱 <b>Телефон:</b> " . htmlspecialchars($data['phone']) . "\n";
$message .= "🎯 <b>Тип кейтеринга:</b> " . htmlspecialchars($data['service']) . "\n";

if (!empty($data['date'])) {
    $message .= "📅 <b>Дата мероприятия:</b> " . htmlspecialchars($data['date']) . "\n";
}

if (!empty($data['guests'])) {
    $message .= "👥 <b>Количество гостей:</b> " . htmlspecialchars($data['guests']) . "\n";
}

if (!empty($data['message'])) {
    $message .= "\n💬 <b>Дополнительная информация:</b>\n" . htmlspecialchars($data['message']) . "\n";
}

$message .= "\n⏰ <b>Время заказа:</b> " . date('d.m.Y H:i:s');

// Отправляем сообщение в Telegram
$response = telegramSendMessage($message);

if ($response) {
    $result = json_decode($response, true);
    if ($result && isset($result['ok']) && $result['ok']) {
        echo json_encode(['success' => true, 'message' => 'Заказ успешно отправлен']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка отправки в Telegram']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к Telegram API']);
}
?>
