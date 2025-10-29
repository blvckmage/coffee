<?php
require_once 'functions.php';

// Check authentication
$admins = loadAdmins() ?? [['username' => 'admin', 'password' => '123', 'role' => 'superadmin']];
if (!isAdminLoggedIn($admins)) {
    header('Location: admin-login.php');
    exit;
}

    // Load data
    $products = loadProducts() ?? [];
    $menu = loadMenu() ?? [];
    $catering = loadCatering();

    // Если данных нет или неправильная структура, используем fallback
    if (!$catering || !is_array($catering) || empty($catering)) {
        $catering = [
            ['icon' => '☕', 'title' => 'Кофе-брейк', 'description' => 'Ароматный кофе, премиум чай, свежая выпечка и десерты для корпоративных мероприятий', 'price' => 500],
            ['icon' => '🥂', 'title' => 'Фуршет на мероприятие', 'description' => 'Закусочные канапе, фреская выпечка, фруктовые композиции и алкогольные напитки', 'price' => 1200],
            ['icon' => '🎈', 'title' => 'Детский праздник', 'description' => 'Безалкогольные напитки, сладкие угощения, фруктовые салаты специально для детей', 'price' => 800],
            ['icon' => '🍽️', 'title' => 'Полный кейтеринг', 'description' => 'Полноценный сервис с профессиональными поварами, оборудованием и квалифицированным персоналом', 'price' => 2500],
            ['icon' => '⚽', 'title' => 'Спортивные мероприятия', 'description' => 'Энергетические напитки, здоровое питание и быстрые закуски для активных соревнований', 'price' => 600],
            ['icon' => '🎂', 'title' => 'Торжества', 'description' => 'Эксклюзивный десертный стол, банкетная выпечка и специальные напитки для особых случаев', 'price' => 1800]
        ];
    } else {
        // Преобразуем существующие данные к нужной структуре
        foreach ($catering as &$item) {
            if (isset($item['name']) && !isset($item['title'])) {
                $item['title'] = $item['name'];
                unset($item['name']);
            }
            if (!isset($item['icon'])) {
                $item['icon'] = '☕'; // Дефолтная иконка
            }
            if (isset($item['price']) && is_string($item['price'])) {
                // Конвертируем строки вида "От 500 ₸/человек" в числа
                $priceString = $item['price'];
                $priceNumbers = preg_replace('/[^0-9]/', '', $priceString);
                $item['price'] = (int)$priceNumbers;
            }
        }
    }
    $branches = loadBranches() ?? [];
    $news = loadNews() ?? [];
    $reservations = loadReservations() ?? [];

// Handle form submissions
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'logout':
                logoutAdmin();
                header('Location: admin-login.php');
                exit;
                break;

            case 'add_product':
                $category = sanitizeInput($_POST['category'] ?? '');
                $name = sanitizeInput($_POST['name'] ?? '');
                $price = intval($_POST['price'] ?? 0);
                $description = sanitizeInput($_POST['description'] ?? '');

                $errors = validateRequired([
                    'Категория' => $category,
                    'Название' => $name,
                    'Цена' => $price
                ]);

                // Handle image upload
                $imagePath = uploadImage($_FILES['image'] ?? null, 'product');
                if (!$imagePath) {
                    $imagePath = 'images/placeholder.jpg';
                }

                if (empty($errors)) {
                    if (!isset($products[$category])) {
                        $products[$category] = [];
                    }
                    $products[$category][] = [
                        'name' => $name,
                        'price' => $price,
                        'description' => $description,
                        'image' => $imagePath
                    ];
                    saveJson('products', $products);
                    $success = 'Продукт добавлен!';
                }
                break;

            case 'add_menu_item':
                $category = sanitizeInput($_POST['category'] ?? '');
                $name = sanitizeInput($_POST['name'] ?? '');
                $price = intval($_POST['price'] ?? 0);

                $errors = validateRequired([
                    'Категория' => $category,
                    'Название' => $name,
                    'Цена' => $price
                ]);

                if (empty($errors)) {
                    if (!isset($menu[$category])) {
                        $menu[$category] = [];
                    }
                    $menu[$category][] = [
                        'name' => $name,
                        'price' => $price
                    ];
                    saveJson('menu', $menu);
                    $success = 'Элемент меню добавлен!';
                }
                break;

            case 'delete_product':
                $category = sanitizeInput($_POST['category']);
                $index = intval($_POST['index']);
                if (isset($products[$category][$index])) {
                    array_splice($products[$category], $index, 1);
                    if (empty($products[$category])) {
                        unset($products[$category]);
                    }
                    saveJson('products', $products);
                    $success = 'Продукт удален!';
                }
                break;

            case 'delete_menu_item':
                $category = sanitizeInput($_POST['category']);
                $index = intval($_POST['index']);
                if (isset($menu[$category][$index])) {
                    array_splice($menu[$category], $index, 1);
                    if (empty($menu[$category])) {
                        unset($menu[$category]);
                    }
                    saveJson('menu', $menu);
                    $success = 'Элемент меню удален!';
                }
                break;

            case 'add_admin':
                $username = sanitizeInput($_POST['username'] ?? '');
                $password = sanitizeInput($_POST['password'] ?? '');
                $role = sanitizeInput($_POST['role'] ?? 'admin');

                $errors = validateRequired([
                    'Логин' => $username,
                    'Пароль' => $password
                ]);

                if (empty($errors)) {
                    // Check if username exists
                    $usernameExists = false;
                    foreach ($admins as $admin) {
                        if ($admin['username'] === $username) {
                            $usernameExists = true;
                            break;
                        }
                    }

                    if ($usernameExists) {
                        $errors[] = 'Админ с таким логином уже существует';
                    } else {
                        $admins[] = [
                            'username' => $username,
                            'password' => $password,
                            'role' => $role
                        ];
                        saveJson('admins', $admins);
                        $success = 'Админ добавлен!';
                    }
                }
                break;

            case 'add_news':
                $title = sanitizeInput($_POST['title'] ?? '');
                $content = sanitizeInput($_POST['content'] ?? '');
                $date = sanitizeInput($_POST['date'] ?? '');
                $image = sanitizeInput($_POST['image'] ?? '');

                $errors = validateRequired([
                    'Заголовок' => $title,
                    'Содержание' => $content,
                    'Дата' => $date
                ]);

                if (empty($errors)) {
                    $news[] = [
                        'title' => $title,
                        'content' => $content,
                        'date' => $date,
                        'image' => $image ?: 'images/coffee-bg.jpg'
                    ];
                    saveJson('news', $news);
                    $success = 'Новость добавлена!';
                }
                break;

            case 'update_news':
                $index = intval($_POST['news_index']);
                $title = sanitizeInput($_POST['title'] ?? '');
                $content = sanitizeInput($_POST['content'] ?? '');
                $date = sanitizeInput($_POST['date'] ?? '');
                $image = sanitizeInput($_POST['image'] ?? '');

                $errors = validateRequired([
                    'Заголовок' => $title,
                    'Содержание' => $content,
                    'Дата' => $date
                ]);

                if (empty($errors) && isset($news[$index])) {
                    $news[$index] = [
                        'title' => $title,
                        'content' => $content,
                        'date' => $date,
                        'image' => $image ?: 'images/coffee-bg.jpg'
                    ];
                    saveJson('news', $news);
                    $success = 'Новость обновлена!';
                }
                break;

            case 'update_product':
                $category = sanitizeInput($_POST['category'] ?? '');
                $index = intval($_POST['product_index']);
                $name = sanitizeInput($_POST['name'] ?? '');
                $price = intval($_POST['price'] ?? 0);
                $description = sanitizeInput($_POST['description'] ?? '');

                $errors = validateRequired([
                    'Категория' => $category,
                    'Название' => $name,
                    'Цена' => $price
                ]);

                // Handle image upload
                $imagePath = uploadImage($_FILES['image'] ?? null, 'product');
                if (!$imagePath) {
                    $imagePath = $products[$category][$index]['image'] ?? 'images/placeholder.jpg';
                }

                if (empty($errors) && isset($products[$category][$index])) {
                    $products[$category][$index] = [
                        'name' => $name,
                        'price' => $price,
                        'description' => $description,
                        'image' => $imagePath
                    ];
                    saveJson('products', $products);
                    $success = 'Продукт обновлен!';
                }
                break;

            case 'update_menu_item':
                $category = sanitizeInput($_POST['category'] ?? '');
                $index = intval($_POST['menu_index']);
                $name = sanitizeInput($_POST['name'] ?? '');
                $price = intval($_POST['price'] ?? 0);

                $errors = validateRequired([
                    'Категория' => $category,
                    'Название' => $name,
                    'Цена' => $price
                ]);

                if (empty($errors) && isset($menu[$category][$index])) {
                    $menu[$category][$index] = [
                        'name' => $name,
                        'price' => $price
                    ];
                    saveJson('menu', $menu);
                    $success = 'Элемент меню обновлен!';
                }
                break;

            case 'delete_news':
                $index = intval($_POST['index']);
                if (isset($news[$index])) {
                    array_splice($news, $index, 1);
                    saveJson('news', $news);
                    $success = 'Новость удалена!';
                }
                break;

            case 'add_catering_item':
                $icon = sanitizeInput($_POST['icon'] ?? '');
                $title = sanitizeInput($_POST['title'] ?? '');
                $description = sanitizeInput($_POST['description'] ?? '');
                $price = intval($_POST['price'] ?? 0);

                $errors = validateRequired([
                    'Иконка' => $icon,
                    'Название' => $title,
                    'Описание' => $description,
                    'Цена' => $price
                ]);

                if (empty($errors)) {
                    $catering[] = [
                        'icon' => $icon,
                        'title' => $title,
                        'description' => $description,
                        'price' => $price
                    ];
                    saveJson('catering', $catering);
                    $catering = loadCatering(); // Reload data
                    $success = 'Услуга кейтеринга добавлена!';
                }
                break;

            case 'update_catering_item':
                $index = intval($_POST['catering_index']);
                $icon = sanitizeInput($_POST['icon'] ?? '');
                $title = sanitizeInput($_POST['title'] ?? '');
                $description = sanitizeInput($_POST['description'] ?? '');
                $price = intval($_POST['price'] ?? 0);

                $errors = validateRequired([
                    'Иконка' => $icon,
                    'Название' => $title,
                    'Описание' => $description,
                    'Цена' => $price
                ]);

                if (empty($errors) && isset($catering[$index])) {
                    $catering[$index] = [
                        'icon' => $icon,
                        'title' => $title,
                        'description' => $description,
                        'price' => $price
                    ];
                    saveJson('catering', $catering);
                    $catering = loadCatering(); // Reload data
                    $success = 'Услуга кейтеринга обновлена!';
                }
                break;

            case 'delete_catering_item':
                $index = intval($_POST['index']);
                if (isset($catering[$index])) {
                    array_splice($catering, $index, 1);
                    saveJson('catering', $catering);
                    $catering = loadCatering(); // Reload data
                    $success = 'Услуга кейтеринга удалена!';
                }
                break;

            case 'delete_admin':
                $index = intval($_POST['index']);
                if ($index > 0 && isset($admins[$index])) { // Don't delete first admin
                    array_splice($admins, $index, 1);
                    saveJson('admins', $admins);
                    $success = 'Админ удален!';
                } else {
                    $errors[] = 'Нельзя удалить первого админа';
                }
                break;

            default:
                $errors[] = 'Неизвестное действие';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель - Coffee Pro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-panel">
        <h1>Админ панель - Coffee Pro</h1>

        <div class="admin-header">
            <div class="admin-tabs">
                <button class="admin-tab active" data-tab="products">Продукты</button>
                <button class="admin-tab" data-tab="menu">Меню</button>
                <button class="admin-tab" data-tab="catering">Кейтеринг</button>
                <button class="admin-tab" data-tab="news">Новости</button>
                <button class="admin-tab" data-tab="admins">Админы</button>
            </div>
            <div class="admin-info">
                <span>Здравствуйте, <?php echo htmlspecialchars(getCurrentAdmin()['username']); ?>!</span>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-secondary">Выход</button>
                </form>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <!-- Products Section -->
        <div id="products" class="admin-section active">
            <div class="admin-form">
                <h3>Добавить продукт</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_product">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Категория</label>
                            <input type="text" name="category" required>
                        </div>
                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Цена</label>
                            <input type="number" name="price" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Изображение</label>
                        <input type="file" name="image" accept="image/*">
                        <small>Выберите изображение (JPG, PNG, GIF, max 5MB)</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить продукт</button>
                </form>
            </div>

            <div class="items-list">
                <h3>Существующие продукты</h3>
                <?php foreach ($products as $category => $items): ?>
                    <?php foreach ($items as $index => $product): ?>
                        <div class="item-card">
                            <div class="item-info">
                                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <span><?php echo htmlspecialchars($product['price']); ?> ₸</span>
                            </div>
                        <div class="item-actions">
                            <button class="btn btn-primary btn-small" onclick="openProductModal('<?php echo htmlspecialchars($category); ?>', <?php echo $index; ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo htmlspecialchars($product['description']); ?>')">Изменить</button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete_product">
                                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Удалить продукт?')">Удалить</button>
                            </form>
                        </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Menu Section -->
        <div id="menu" class="admin-section">
            <div class="admin-form">
                <h3>Добавить элемент меню</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add_menu_item">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Категория</label>
                            <input type="text" name="category" required>
                        </div>
                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Цена</label>
                            <input type="number" name="price" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить элемент меню</button>
                </form>
            </div>

            <div class="items-list">
                <h3>Текущее меню</h3>
                <?php foreach ($menu as $category => $items): ?>
                    <?php foreach ($items as $index => $item): ?>
                        <div class="item-card">
                            <div class="item-info">
                                <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                <span><?php echo htmlspecialchars($item['price']); ?> ₸</span>
                                <small><?php echo htmlspecialchars(capitalizeCategory($category)); ?></small>
                            </div>
                            <div class="item-actions">
                                <button class="btn btn-primary btn-small" onclick="openMenuModal('<?php echo htmlspecialchars($category); ?>', <?php echo $index; ?>, '<?php echo htmlspecialchars($item['name']); ?>', <?php echo $item['price']; ?>)">Изменить</button>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete_menu_item">
                                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Удалить элемент меню?')">Удалить</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Catering Section -->
        <div id="catering" class="admin-section">
            <div class="admin-form">
                <h3>Добавить услугу кейтеринга</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add_catering_item">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Иконка (emoji или HTML)</label>
                            <input type="text" name="icon" required placeholder="☕">
                        </div>
                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Цена от</label>
                            <input type="number" name="price" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" required rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить услугу</button>
                </form>
            </div>

            <div class="items-list">
                <h3>Услуги кейтеринга</h3>
                <?php
                // Безопасная проверка массива перед выводом
                if (is_array($catering) && !empty($catering)):
                    foreach ($catering as $index => $item):
                        if (is_array($item)):
                            $icon = $item['icon'] ?? '☕';
                            $title = $item['title'] ?? 'Без названия';
                            $description = $item['description'] ?? 'Без описания';
                            $price = $item['price'] ?? 0;
                            ?>
                            <div class="item-card">
                                <div class="item-info">
                                    <h4><?php echo htmlspecialchars($icon); ?> <?php echo htmlspecialchars($title); ?></h4>
                                    <p><?php echo htmlspecialchars($description); ?></p>
                                    <span>От <?php echo htmlspecialchars($price); ?> ₸/человек</span>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-primary btn-small" onclick="openCateringModal(<?php echo $index; ?>, '<?php echo htmlspecialchars($icon); ?>', '<?php echo htmlspecialchars($title); ?>', '<?php echo htmlspecialchars($description); ?>', <?php echo intval($price); ?>)">Изменить</button>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete_catering_item">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Удалить услугу?')">Удалить</button>
                                    </form>
                                </div>
                            </div>
                            <?php
                        endif;
                    endforeach;
                else:
                    echo '<p>Нет услуг кейтеринга</p>';
                endif;
                ?>
            </div>
        </div>

        <!-- Modal Windows -->
        <!-- Catering Edit Modal -->
        <div id="catering-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Редактировать услугу кейтеринга</h3>
                    <span class="modal-close">&times;</span>
                </div>
                <form method="POST" id="catering-edit-form">
                    <input type="hidden" name="action" value="update_catering_item">
                    <input type="hidden" name="catering_index" id="catering-index">
                    <div class="form-group">
                        <label>Иконка</label>
                        <input type="text" name="icon" id="catering-icon" required>
                    </div>
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" name="title" id="catering-title" required>
                    </div>
                    <div class="form-group">
                        <label>Цена от</label>
                        <input type="number" name="price" id="catering-price" required>
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" id="catering-description" required rows="3"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-secondary modal-close-btn">Отмена</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- News Section -->
        <div id="news" class="admin-section">
            <div class="admin-form">
                <h3>Добавить новость</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add_news">
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Содержание</label>
                        <textarea name="content" required rows="4"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Дата</label>
                            <input type="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label>Изображение</label>
                            <input type="text" name="image" value="images/coffee-bg.jpg">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить новость</button>
                </form>
            </div>

            <div class="items-list">
                <h3>Существующие новости</h3>
                <?php foreach ($news ?: [] as $index => $item): ?>
                    <div class="item-card">
                        <div class="item-info">
                            <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                            <p><?php echo htmlspecialchars(substr($item['content'], 0, 100)); ?>...</p>
                            <small><?php echo htmlspecialchars($item['date']); ?></small>
                        </div>
                        <div class="item-actions">
                            <button class="btn btn-primary btn-small" onclick="openNewsModal(<?php echo $index; ?>)">Изменить</button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete_news">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Удалить новость?')">Удалить</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Admins Section -->
        <div id="admins" class="admin-section">
            <div class="admin-form">
                <h3>Добавить админа</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add_admin">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Логин</label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Пароль</label>
                            <input type="text" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Роль</label>
                            <select name="role">
                                <option value="admin">Администратор</option>
                                <option value="superadmin">Супер администратор</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить админа</button>
                </form>
            </div>

            <div class="items-list">
                <h3>Существующие админы</h3>
                <?php foreach ($admins as $index => $admin): ?>
                    <div class="item-card">
                        <div class="item-info">
                            <h4><?php echo htmlspecialchars($admin['username']); ?></h4>
                            <span>Роль: <?php echo htmlspecialchars($admin['role']); ?></span>
                        </div>
                        <div class="item-actions">
                            <?php if ($index > 0): // Don't allow deleting first admin ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete_admin">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Удалить админа?')">Удалить</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Modal Windows -->
        <!-- News Edit Modal -->
        <div id="news-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Редактировать новость</h3>
                    <span class="modal-close">&times;</span>
                </div>
                <form method="POST" id="news-edit-form">
                    <input type="hidden" name="action" value="update_news">
                    <input type="hidden" name="news_index" id="news-index">
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input type="text" name="title" id="news-title" required>
                    </div>
                    <div class="form-group">
                        <label>Содержание</label>
                        <textarea name="content" id="news-content" required rows="4"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Дата</label>
                            <input type="date" name="date" id="news-date" required>
                        </div>
                        <div class="form-group">
                            <label>Изображение</label>
                            <input type="text" name="image" id="news-image">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-secondary modal-close-btn">Отмена</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Edit Modal -->
        <div id="product-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Редактировать продукт</h3>
                    <span class="modal-close">&times;</span>
                </div>
                <form method="POST" enctype="multipart/form-data" id="product-edit-form">
                    <input type="hidden" name="action" value="update_product">
                    <input type="hidden" name="product_index" id="product-index">
                    <div class="form-group">
                        <label>Категория</label>
                        <input type="text" name="category" id="product-category" required>
                    </div>
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" name="name" id="product-name" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Цена</label>
                            <input type="number" name="price" id="product-price" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" id="product-description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Изображение</label>
                        <input type="file" name="image" id="product-image-file" accept="image/*">
                        <small>Выберите изображение (JPG, PNG, GIF, max 5MB)</small>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-secondary modal-close-btn">Отмена</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menu Edit Modal -->
        <div id="menu-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Редактировать элемент меню</h3>
                    <span class="modal-close">&times;</span>
                </div>
                <form method="POST" id="menu-edit-form">
                    <input type="hidden" name="action" value="update_menu_item">
                    <input type="hidden" name="menu_index" id="menu-index">
                    <div class="form-group">
                        <label>Категория</label>
                        <input type="text" name="category" id="menu-category" required>
                    </div>
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" name="name" id="menu-name" required>
                    </div>
                    <div class="form-group">
                        <label>Цена</label>
                        <input type="number" name="price" id="menu-price" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-secondary modal-close-btn">Отмена</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.admin-tab');
            const sections = document.querySelectorAll('.admin-section');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Hide all sections
                    sections.forEach(s => s.classList.remove('active'));

                    // Show target section
                    const targetSection = document.getElementById(targetTab);
                    if (targetSection) {
                        targetSection.classList.add('active');
                    }
                });
            });
        });

        // Modal functionality
        function openNewsModal(index) {
            const newsData = <?php echo json_encode($news); ?>;
            const newsItem = newsData[index];

            document.getElementById('news-index').value = index;
            document.getElementById('news-title').value = newsItem.title;
            document.getElementById('news-content').value = newsItem.content;
            document.getElementById('news-date').value = newsItem.date;
            document.getElementById('news-image').value = newsItem.image;

            document.getElementById('news-modal').classList.add('show');
        }

        function openProductModal(category, index, name, price, description) {
            document.getElementById('product-index').value = index;
            document.getElementById('product-category').value = category;
            document.getElementById('product-name').value = name;
            document.getElementById('product-price').value = price;
            document.getElementById('product-description').value = description;

            document.getElementById('product-modal').classList.add('show');
        }

        function openMenuModal(category, index, name, price) {
            document.getElementById('menu-index').value = index;
            document.getElementById('menu-category').value = category;
            document.getElementById('menu-name').value = name;
            document.getElementById('menu-price').value = price;

            document.getElementById('menu-modal').classList.add('show');
        }

        function openCateringModal(index, icon, title, description, price) {
            document.getElementById('catering-index').value = index;
            document.getElementById('catering-icon').value = icon;
            document.getElementById('catering-title').value = title;
            document.getElementById('catering-description').value = description;
            document.getElementById('catering-price').value = price;

            document.getElementById('catering-modal').classList.add('show');
        }

        // Close modal functionality
        document.querySelectorAll('.modal-close, .modal-close-btn').forEach(element => {
            element.addEventListener('click', function() {
                this.closest('.modal').classList.remove('show');
            });
        });

        // Close modal on outside click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
