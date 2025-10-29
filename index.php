<?php
require_once 'functions.php';

// Load data
$products = loadProducts();
$menu = loadMenu();
$news = loadNews();
$catering = loadCatering();

// Преобразуем данные кейтеринга к нужной структуре
if ($catering && is_array($catering) && !empty($catering)) {
    // Конвертируем существующие данные из JSON файла
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
} else {
    // Fallback данные если файл не загружен или пустой
    $catering = [
        ['icon' => '☕', 'title' => 'Кофе-брейк', 'description' => 'Ароматный кофе, премиум чай, свежая выпечка и десерты для корпоративных мероприятий', 'price' => 500],
        ['icon' => '🥂', 'title' => 'Фуршет на мероприятие', 'description' => 'Закусочные канапе, фреская выпечка, фруктовые композиции и алкогольные напитки', 'price' => 1200],
        ['icon' => '🎈', 'title' => 'Детский праздник', 'description' => 'Безалкогольные напитки, сладкие угощения, фруктовые салаты специально для детей', 'price' => 800],
        ['icon' => '🍽️', 'title' => 'Полный кейтеринг', 'description' => 'Полноценный сервис с профессиональными поварами, оборудованием и квалифицированным персоналом', 'price' => 2500],
        ['icon' => '⚽', 'title' => 'Спортивные мероприятия', 'description' => 'Энергетические напитки, здоровое питание и быстрые закуски для активных соревнований', 'price' => 600],
        ['icon' => '🎂', 'title' => 'Торжества', 'description' => 'Эксклюзивный десертный стол, банкетная выпечка и специальные напитки для особых случаев', 'price' => 1800]
    ];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanqurai bread & coffee - Свежеобжаренный кофе и хлеб</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
    <!-- Yandex Maps API -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script src="script.js"></script>
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <span>Tanqurai bread & coffee</span>
                </div>
                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item dropdown">
                            <a href="#hero" class="nav-link">Главная</a>
                            <div class="dropdown-content">
                                <a href="#about">О нас</a>
                                <a href="#news">Новости</a>
                                <a href="#catering">Кейтеринг</a>
                                <a href="#reservation">Бронирование</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#products" class="nav-link">Продукция</a>
                        </li>
                        <li class="nav-item">
                            <a href="#menu" class="nav-link">Меню</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#branches" class="nav-link">Контакты</a>
                            <div class="dropdown-content">
                                <a href="#branches">Адреса</a>
                                <a href="#footer">Контакты</a>
                            </div>
                        </li>
                    </ul>
                    <a href="tel:+77771234567" class="phone">+7 (777) 123-45-67</a>
                    <button class="cta-btn header-btn">Получить консультацию</button>
                </nav>
                <button class="burger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>

                <!-- Mobile Navigation Menu -->
                <nav class="mobile-nav">
                    <ul class="mobile-nav-list">
                        <li><a href="#hero" class="mobile-nav-link">Главная</a></li>
                        <li><a href="#products" class="mobile-nav-link">Продукция</a></li>
                        <li><a href="#menu" class="mobile-nav-link">Меню</a></li>
                        <li><a href="#branches" class="mobile-nav-link">Контакты</a></li>
                        <li><a href="tel:+77771234567" class="mobile-nav-link phone-link">+7 (777) 123-45-67</a></li>
                        <li><button class="cta-btn mobile-cta">Получить консультацию</button></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-text" data-aos="fade-up">
                <h1 class="hero-title">Свежеобжаренный кофе и свежая выпечка</h1>
                <p class="hero-subtitle">Доставка по всему Казахстану и СНГ</p>
                <p class="hero-about">Tanqurai bread & coffee - это ваш надежный партнер в мире кофе и выпечки. Мы предлагаем свежеобжаренный кофе, ароматный хлеб и профессиональное оборудование для кафе и ресторанов.</p>
            </div>
            <div class="hero-form" data-aos="fade-up" data-aos-delay="200">
                <form class="contact-form" method="POST" action="contact.php">
                    <input type="hidden" name="form_type" value="consultation">
                    <h3>Получить консультацию</h3>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Ваше имя" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Телефон" required>
                    </div>
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="agreement" required>
                            <span>Соглашаюсь с обработкой персональных данных</span>
                        </label>
                    </div>
                    <button type="submit" class="cta-btn">Отправить заявку</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products">
        <div class="container">
            <h2 data-aos="fade-up">Наша продукция</h2>
            <div class="swiper products-swiper" id="products-swiper">
                <div class="swiper-wrapper" id="products-wrapper">
                    <?php
                    $productIndex = 0;
                    if ($products) {
                        $allProducts = [];
                        foreach ($products as $category => $items) {
                            $allProducts = array_merge($allProducts, $items);
                        }

                        foreach ($allProducts as $product) {
                            ?>
                            <div class="swiper-slide">
                                <div class="product-card" data-aos="fade-up" data-aos-delay="0">
                                    <div class="product-image">
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                                    </div>
                                    <div class="product-content">
                                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                                        <span class="price"><?php echo htmlspecialchars($product['price']); ?> ₸<?php if ($product['price'] <= 1000) echo '/кг'; ?></span>
                                        <button class="cta-btn">Подробнее</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $productIndex++;
                        }
                    } else {
                        // Fallback products
                        $fallbackProducts = [
                            ['name' => 'Кофе Эспрессо', 'price' => 500, 'description' => 'Высококачественные зерна...', 'image' => 'images/espresso.jpg'],
                            ['name' => 'Кофе Капучино', 'price' => 600, 'description' => 'Бленд специально...', 'image' => 'images/cappuccino.jpg'],
                            ['name' => 'Эспрессо машина', 'price' => 150000, 'description' => 'Профессиональная кофемашина...', 'image' => 'images/barista.jpg']
                        ];
                        foreach ($fallbackProducts as $product) {
                            ?>
                            <div class="swiper-slide">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                                    </div>
                                    <div class="product-content">
                                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                                        <span class="price"><?php echo htmlspecialchars($product['price']); ?> ₸<?php if ($product['price'] <= 1000) echo '/кг'; ?></span>
                                        <button class="cta-btn">Подробнее</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <!-- Menu Section -->
            <h2 id="menu" data-aos="fade-up">Наше меню</h2>
            <div class="menu-grid" id="menu-grid">
                <?php
                if ($menu) {
                    foreach ($menu as $category => $items) {
                        ?>
                        <div class="menu-category">
                            <h3><?php echo htmlspecialchars(capitalizeCategory($category)); ?></h3>
                            <ul>
                                <?php foreach ($items as $item) { ?>
                                    <li>
                                        <span class="menu-item"><?php echo htmlspecialchars($item['name']); ?></span>
                                        <span class="price"><?php echo htmlspecialchars($item['price']); ?> ₸</span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php
                    }
                } else {
                    // Fallback menu
                    $fallbackMenu = [
                        'espresso-bar' => [['name' => 'Эспрессо', 'price' => 250], ['name' => 'Капучино', 'price' => 400]],
                        'desserts' => [['name' => 'Тирамису', 'price' => 600], ['name' => 'Чизкейк', 'price' => 500]]
                    ];
                    foreach ($fallbackMenu as $category => $items) {
                        ?>
                        <div class="menu-category">
                            <h3><?php echo htmlspecialchars(capitalizeCategory($category)); ?></h3>
                            <ul>
                                <?php foreach ($items as $item) { ?>
                                    <li>
                                        <span class="menu-item"><?php echo htmlspecialchars($item['name']); ?></span>
                                        <span class="price"><?php echo htmlspecialchars($item['price']); ?> ₸</span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="news" class="news section">
        <div class="container">
            <h2 data-aos="fade-up">Новости</h2>
            <div class="swiper news-swiper" id="news-swiper">
                <div class="swiper-wrapper" id="news-wrapper">
                    <?php
                    $newsIndex = 0;
                    if ($news) {
                        foreach ($news as $item) {
                            $imagePath = isset($item['image']) ? $item['image'] : 'images/coffee-bg.jpg';
                            $previewText = mb_substr($item['content'], 0, 100);
                            ?>
                            <div class="swiper-slide">
                                <div class="news-card" data-aos="fade-up" data-aos-delay="0">
                                    <div class="news-image">
                                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
                                    </div>
                                    <div class="news-content">
                                        <span class="news-date"><?php echo htmlspecialchars($item['date']); ?></span>
                                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                        <p><?php echo htmlspecialchars($previewText); ?>...</p>
                                        <button class="cta-btn read-more-btn" data-news-index="<?php echo $newsIndex; ?>" data-title="<?php echo htmlspecialchars($item['title']); ?>" data-content="<?php echo htmlspecialchars($item['content']); ?>" data-image="<?php echo htmlspecialchars($imagePath); ?>" data-date="<?php echo htmlspecialchars($item['date']); ?>">Читать далее</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $newsIndex++;
                        }
                    } else {
                        // Fallback news if no JSON
                        $fallbackNews = [
                            ['title' => 'Новая обжарка кофе прибыла', 'date' => '15.10.2025', 'content' => 'Мы обновили ассортимент! Попробуйте новый бленд премиум-класса с нотками шоколада и ореха. Новая партия свежеобжаренного кофе уже доступна в наших кофепностях. Бленд включает в себя три вида арабского кофе специального обжарки.', 'image' => 'images/coffee-bg.jpg'],
                            ['title' => 'Открытие новой кофейни', 'date' => '10.10.2025', 'content' => 'Приглашаем на открытие нашей третьей кофейни в Нур-Султане! Расположенная в центре города, новая кофейня предлагает уникальный интерьер и расширенное меню. Откроем двери для посетителей 15 ноября.', 'image' => 'images/coffee-texture.jpg'],
                            ['title' => 'Семинар по латте-арту', 'date' => '05.10.2025', 'content' => 'В ближайные выходные проведем мастер-класс по рисованию на кофе. Профессиональный бариста из Италии покажет удивительные узоры и поделится секретами техники латте-арта. Запись обязательна по телефону.', 'image' => 'images/wood-texture.jpg']
                        ];
                        foreach ($fallbackNews as $item) {
                            $previewText = mb_substr($item['content'], 0, 100);
                            ?>
                            <div class="swiper-slide">
                                <div class="news-card">
                                    <div class="news-image">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
                                    </div>
                                    <div class="news-content">
                                        <span class="news-date"><?php echo htmlspecialchars($item['date']); ?></span>
                                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                        <p><?php echo htmlspecialchars($previewText); ?>...</p>
                                        <button class="cta-btn read-more-btn" data-news-index="<?php echo $newsIndex; ?>" data-title="<?php echo htmlspecialchars($item['title']); ?>" data-content="<?php echo htmlspecialchars($item['content']); ?>" data-image="<?php echo htmlspecialchars($item['image']); ?>" data-date="<?php echo htmlspecialchars($item['date']); ?>">Читать далее</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $newsIndex++;
                        }
                    }
                    ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <!-- News Modal -->
    <div id="news-modal" class="modal">
        <div class="modal-content news-modal-content">
            <div class="modal-header">
                <h3 id="modal-news-title">Заголовок новости</h3>
                <span class="modal-close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="news-modal-image">
                    <img id="modal-news-image" src="" alt="News Image">
                </div>
                <div class="news-modal-meta">
                    <span id="modal-news-date" class="news-date"></span>
                </div>
                <div class="news-modal-text">
                    <p id="modal-news-content">Полный текст новости...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Modal Styles -->
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .news-modal-content {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 24px 0 24px;
        border-bottom: 1px solid #E8D5B0;
        margin-bottom: 24px;
    }

    .modal-header h3 {
        margin: 0;
        color: #4B2E16;
        font-size: 24px;
        font-weight: 600;
    }

    .modal-close {
        cursor: pointer;
        font-size: 32px;
        color: #6C5846;
        line-height: 1;
        padding: 0 8px;
        transition: color 0.3s ease;
    }

    .modal-close:hover {
        color: #8C6239;
    }

    .modal-body {
        padding: 0 24px 24px 24px;
    }

    .news-modal-image {
        text-align: center;
        margin-bottom: 20px;
    }

    .news-modal-image img {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(75, 46, 22, 0.1);
        display: block;
        margin: 0 auto;
    }

    .news-modal-meta {
        margin-bottom: 20px;
    }

    .news-modal-text {
        line-height: 1.6;
        color: #6C5846;
    }

    .read-more-btn {
        cursor: pointer;
    }

    /* Fixed height for news cards */
    .news-card {
        height: 550px;
        display: flex;
        flex-direction: column;
    }

    .news-image {
        height: 250px;
        flex-shrink: 0;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }

    .news-content {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 20px;
        height: calc(100% - 250px);
        position: relative;
    }

    .news-content h3 {
        flex-shrink: 0;
        margin-bottom: 10px;
    }

    .news-content .news-date {
        flex-shrink: 0;
        margin-bottom: 10px;
    }

    .news-content p {
        flex: 1;
        margin-bottom: 15px;
        max-height: 180px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 7;
        -webkit-box-orient: vertical;
        line-height: 1.4;
    }

    .news-content .read-more-btn {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        margin-top: 0;
    }

    @media (max-width: 768px) {
        .news-modal-content {
            width: 95%;
            max-height: 95vh;
        }

        .news-modal-image img {
            height: 200px;
        }

        .news-card {
            height: 450px;
        }

        .news-image {
            height: 200px;
        }
    }
    </style>

    <!-- Catering Section -->
    <section id="catering" class="catering">
        <div class="container">
            <h2>Кейтеринг</h2>
            <p class="catering-subtitle">Организуем незабываемые моменты для вашего праздника с безупречным сервисом и вкусом</p>
            <div class="catering-grid">
                <?php
                $delay = 100;
                foreach ($catering as $index => $service) {
                    if (is_array($service) && isset($service['title'])) {
                        $icon = $service['icon'] ?? '☕';
                        $title = $service['title'] ?? 'Без названия';
                        $description = $service['description'] ?? 'Без описания';
                        $price = $service['price'] ?? 0;
                        ?>
                        <div class="catering-item" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="catering-item-icon"><?php echo htmlspecialchars($icon); ?></div>
                            <h3><?php echo htmlspecialchars($title); ?></h3>
                            <p><?php echo htmlspecialchars($description); ?></p>
                            <span class="catering-price">От <?php echo htmlspecialchars($price); ?> ₸/человек</span>
                        </div>
                        <?php
                        $delay += 100;
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Branches Section -->
    <section id="branches" class="branches section">
        <div class="container">
            <h2 data-aos="fade-up">Где мы находимся</h2>

            <div class="map-with-addresses">
                <!-- Yandex Map -->
                <div class="full-map" data-aos="fade-up">
                    <div id="branches-map" style="width: 100%; height: 500px;"></div>
                    <div class="map-banner">
                        Найдите ближайший филиал
                    </div>
                </div>

                <div class="addresses-list" data-aos="fade-up">
                    <h3>Наши кофейни</h3>
                    <div class="address-item">
                        <h4>Кентау</h4>
                        <address>ул. Гагарина, 50</address>
                        <a href="tel:+77763335001" class="address-phone">+7 (776) 333-50-01</a>
                        <div class="address-meta">Пн-Пт: 9:00-21:00, Сб-Вс: 10:00-22:00</div>
                    </div>
                    <div class="address-item">
                        <h4>Туркестан</h4>
                        <address>ул. Амир Тимура, 28</address>
                        <a href="tel:+77763335002" class="address-phone">+7 (776) 333-50-02</a>
                        <div class="address-meta">Пн-Пт: 9:00-21:00, Сб-Вс: 10:00-22:00</div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Reservation Section -->
    <section id="reservation" class="reservation section">
        <div class="container">
            <h2 data-aos="fade-up">Забронировать столик</h2>
            <form class="reservation-form" method="POST" action="reservation.php" data-aos="fade-up">
                <div class="form-row">
                    <div class="form-group">
                        <label>Филиал</label>
                        <select name="branch" required>
                            <option value="">Выберите филиал</option>
                            <option value="Кентау">Кентау</option>
                            <option value="Туркестан">Туркестан</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="tel" name="phone" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Дата</label>
                        <input type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Время</label>
                        <input type="time" name="time" required>
                    </div>
                    <div class="form-group">
                        <label>Количество человек</label>
                        <input type="number" name="people" min="1" max="20" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Дополнительные пожелания</label>
                    <textarea name="notes" placeholder="Пожелания к заказу или мероприятия"></textarea>
                </div>
                <button type="submit" class="cta-btn">Забронировать</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Tanqurai bread & coffee</h4>
                    <p>Свежеобжаренный кофе и свежая выпечка</p>
                    <p>Доставка по всему Казахстану и СНГ</p>
                </div>
                <div class="footer-section">
                    <h4>Контакты</h4>
                    <p>+7 (777) 123-45-67</p>
                    <p>info@coffeepro.kz</p>
                    <p>ул. Гагарина, 50, Кентау</p>
                </div>
                <div class="footer-section">
                    <h4>Время работы</h4>
                    <p>Пн-Пт: 9:00 - 21:00</p>
                    <p>Сб-Вс: 10:00 - 22:00</p>
                </div>
                <div class="footer-section">
                    <h4>Мы в соцсетях</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">Instagram</a>
                        <a href="#" class="social-link">Facebook</a>
                        <a href="#" class="social-link">VK</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Tanqurai bread & coffee. Все права защищены.</p>
            </div>
        </div>

        <!-- Admin Button -->
        <a href="admin-login.php" class="admin-button" title="Админ панель">
            ⚙️
        </a>
    </footer>

    <script>
        // Initialize AOS
        AOS.init({
            once: false,
            mirror: true,
            duration: 800,
            easing: 'ease-in-out'
        });

        // Initialize Products Swiper
        const swiper = new Swiper('#products-swiper', {
            slidesPerView: 3,
            spaceBetween: 30,
            slidesPerGroup: 1,
            loop: true,
            speed: 800,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            }
        });

        // Initialize News Swiper
        const newsSwiper = new Swiper('#news-swiper', {
            slidesPerView: 3,
            spaceBetween: 30,
            slidesPerGroup: 1,
            loop: true,
            speed: 800,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            }
        });

        // Initialize Yandex Map
        let branchesMap;
        let branchesPlacemarks = [];

        ymaps.ready(function() {
            branchesMap = new ymaps.Map('branches-map', {
                center: [43.2, 69.5], // Center between Kentau and Turkistan
                zoom: 8,
                controls: ['zoomControl', 'fullscreenControl']
            });

            // Add placemarks for branches
            const kentaPlacemark = new ymaps.Placemark([43.5166, 68.5166], {
                balloonContent: '<strong>Кентау</strong><br>ул. Гагарина, 50<br>+7 (776) 333-50-01'
            }, {
                preset: 'islands#redIcon'
            });

            const turkesPlacemark = new ymaps.Placemark([43.3024, 68.2588], {
                balloonContent: '<strong>Туркестан</strong><br>ул. Амир Тимура, 28<br>+7 (776) 333-50-02'
            }, {
                preset: 'islands#redIcon'
            });

            branchesMap.geoObjects.add(kentaPlacemark);
            branchesMap.geoObjects.add(turkesPlacemark);

            branchesPlacemarks = [kentaPlacemark, turkesPlacemark];
        });

        // News Modal Functionality
        const newsModal = document.getElementById('news-modal');
        const modalTitle = document.getElementById('modal-news-title');
        const modalImage = document.getElementById('modal-news-image');
        const modalDate = document.getElementById('modal-news-date');
        const modalContent = document.getElementById('modal-news-content');
        const modalClose = document.querySelectorAll('.modal-close');

        // Handle read more button clicks
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('read-more-btn')) {
                e.preventDefault();

                const title = e.target.getAttribute('data-title');
                const content = e.target.getAttribute('data-content');
                const image = e.target.getAttribute('data-image');
                const date = e.target.getAttribute('data-date');

                // Fill modal with news data
                modalTitle.textContent = title;
                modalContent.textContent = content;
                modalImage.src = image;
                modalImage.alt = title;
                modalDate.textContent = date;

                // Show modal
                newsModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        });

        // Close modal functionality
        modalClose.forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                newsModal.classList.remove('show');
                document.body.style.overflow = '';
            });
        });

        // Close modal on outside click
        newsModal.addEventListener('click', function(e) {
            if (e.target === this) {
                newsModal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && newsModal.classList.contains('show')) {
                newsModal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // Mobile Menu Functionality
        const burger = document.querySelector('.burger');
        const mobileNav = document.querySelector('.mobile-nav');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link, .mobile-cta');

        // Toggle mobile menu
        burger.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileNav.classList.toggle('active');
            document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
        });

        // Close mobile menu when clicking on links
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                burger.classList.remove('active');
                mobileNav.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // Close mobile menu when clicking outside
        mobileNav.addEventListener('click', function(e) {
            if (e.target === this) {
                burger.classList.remove('active');
                this.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
</body>
</html>
