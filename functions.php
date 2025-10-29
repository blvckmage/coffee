<?php
session_start();
require_once 'config.php';

// Helper function for capitalizing categories
function capitalizeCategory($cat) {
    return ucwords(str_replace('-', ' ', $cat));
}

// Load products from JSON
function loadProducts() {
    $file = __DIR__ . '/data/products.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Load menu from JSON
function loadMenu() {
    $file = __DIR__ . '/data/menu.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Load news from JSON
function loadNews() {
    $file = __DIR__ . '/data/news.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Load catering from JSON
function loadCatering() {
    $file = __DIR__ . '/data/catering.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Load branches from JSON
function loadBranches() {
    $file = __DIR__ . '/data/branches.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Load reservations from JSON
function loadReservations() {
    $file = __DIR__ . '/data/reservations.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Load admins from JSON
function loadAdmins() {
    $file = __DIR__ . '/data/admins.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Save data to JSON
function saveJson($filename, $data) {
    $file = __DIR__ . '/data/' . $filename . '.json';
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Check if admin is logged in
function isAdminLoggedIn($admins) {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Get current admin
function getCurrentAdmin() {
    return $_SESSION['admin'] ?? null;
}

// Login admin
function loginAdmin($username, $password, $admins) {
    foreach ($admins as $admin) {
        if ($admin['username'] === $username && $admin['password'] === $password) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin'] = $admin;
            return true;
        }
    }
    return false;
}

// Logout admin
function logoutAdmin() {
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin']);
}

// Validate form fields
function validateRequired($fields) {
    $errors = [];
    foreach ($fields as $field => $value) {
        if (empty($value)) {
            $errors[] = "Поле \"$field\" обязательно для заполнения";
        }
    }
    return $errors;
}

// Sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Handle contact form
function handleContactForm() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $name = sanitizeInput($_POST['name'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $agreement = isset($_POST['agreement']);

    $errors = validateRequired([
        'Имя' => $name,
        'Телефон' => $phone
    ]);

    if (!$agreement) {
        $errors[] = 'Необходимо согласиться с обработкой персональных данных';
    }

    if (empty($errors)) {
        // Save to JSON or send email
        $contacts = loadContacts() ?? [];
        $contacts[] = [
            'name' => $name,
            'phone' => $phone,
            'date' => date('Y-m-d H:i:s')
        ];
        saveJson('contacts', $contacts);

        // Отправка уведомления в Telegram для контактных форм
        $contactMessage = "<b>💬 Новая контактная заявка!</b>\n\n";
        $contactMessage .= "<b>👤 Имя:</b> $name\n";
        $contactMessage .= "<b>📞 Телефон:</b> $phone\n";
        $contactMessage .= "\n<b>⏰ Получено:</b> " . date('d.m.Y H:i') . "\n";
        $contactMessage .= "<code>#контакт #заявка</code>";

        // Отправляем сообщение в Telegram
        $telegramResponse = telegramSendMessage($contactMessage);
        error_log("Telegram message sent for contact form: " . ($telegramResponse ? 'SUCCESS' : 'FAILED'));

        // Or send email
        // mail('admin@coffeepro.kz', 'Новая заявка', "Имя: $name\nТелефон: $phone");

        $_SESSION['success'] = 'Спасибо! Ваша заявка отправлена. Мы свяжемся с вами в ближайшее время.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Handle reservation form
function handleReservationForm() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    $name = sanitizeInput($_POST['name'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $branch = sanitizeInput($_POST['branch'] ?? '');
    $people = intval($_POST['people'] ?? 0);
    $date = sanitizeInput($_POST['date'] ?? '');
    $time = sanitizeInput($_POST['time'] ?? '');
    $notes = sanitizeInput($_POST['notes'] ?? '');

    $errors = validateRequired([
        'Имя' => $name,
        'Телефон' => $phone,
        'Филиал' => $branch,
        'Дата' => $date,
        'Время' => $time
    ]);

    if (empty($errors)) {
        $reservations = loadReservations() ?? [];
        $reservations[] = [
            'name' => $name,
            'phone' => $phone,
            'branch' => $branch,
            'people' => $people,
            'date' => $date,
            'time' => $time,
            'notes' => $notes,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        saveJson('reservations', $reservations);

        // Отправка уведомления в Telegram
        $message = "<b>🏨 Новый запрос на бронирование!</b>\n\n";
        $message .= "<b>👤 Имя:</b> $name\n";
        $message .= "<b>📞 Телефон:</b> $phone\n";
        $message .= "<b>🏢 Филиал:</b> $branch\n";
        $message .= "<b>👥 Количество человек:</b> $people\n";
        $message .= "<b>📅 Дата:</b> $date\n";
        $message .= "<b>🕐 Время:</b> $time\n";
        if (!empty($notes)) {
            $message .= "<b>📝 Пожелания:</b> $notes\n";
        }
        $message .= "\n<b>⏰ Получено:</b> " . date('d.m.Y H:i') . "\n";
        $message .= "<code>#бронирование #столик</code>";

        // Отправляем сообщение в Telegram
        $telegramResponse = telegramSendMessage($message);

        // Логируем результат отправки (опционально)
        error_log("Telegram message sent for reservation: " . ($telegramResponse ? 'SUCCESS' : 'FAILED'));

        $_SESSION['success'] = 'Спасибо! Ваш стол забронирован. Мы подтвердим бронирование по телефону.';
        header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?'));
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        header('Location: ' . strtok($_SERVER['HTTP_REFERER'], '?'));
        exit;
    }

}

// Load contacts from JSON
function loadContacts() {
    $file = __DIR__ . '/data/contacts.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return null;
}

// Handle image upload
function uploadImage($file, $prefix = 'item') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }

    // Validate file size (5MB max)
    if ($file['size'] > 5 * 1024 * 1024) {
        return false;
    }

    // Create uploads directory if not exists
    $uploadDir = __DIR__ . '/uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $prefix . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
    $filepath = $uploadDir . $filename;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return 'uploads/' . $filename;
    }

    return false;
}

?>
