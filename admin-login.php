<?php
require_once 'functions.php';

$admins = loadAdmins() ?? [['username' => 'admin', 'password' => '123', 'role' => 'superadmin']];

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = sanitizeInput($_POST['password'] ?? '');

    $errors = validateRequired([
        'Логин' => $username,
        'Пароль' => $password
    ]);

    if (empty($errors) && loginAdmin($username, $password, $admins)) {
        header('Location: admin.php');
        exit;
    } else {
        $errors[] = 'Неверные данные для входа';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ панель - Coffee Pro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(75, 46, 22, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #4B2E16;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #4B2E16;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #E8D5B0;
            border-radius: 8px;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #8C6239;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .alert-error {
            background: #ffe6e6;
            color: #d63031;
        }
        body {
            background: #F3EDE2;
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Вход в админ панель</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Войти</button>
        </form>
    </div>
</body>
</html>
