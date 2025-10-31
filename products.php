<?php
require_once 'functions.php';

$products = loadProducts();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Продукция - Tanqurai bread & coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=40&h=40&fit=crop&crop=center" alt="Coffee Logo" class="logo-icon">
                        <span>Tanqurai bread & coffee</span>
                    </a>
                </div>
                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item dropdown">
                            <a href="index.php" class="nav-link">Главная</a>
                            <div class="dropdown-content">
                                <a href="about.php">О нас</a>
                                <a href="news.php">Новости</a>
                                <a href="catering.php">Кейтеринг</a>
                                <a href="index.php#reservation">Бронирование</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="products.php" class="nav-link active">Продукция</a>
                        </li>
                        <li class="nav-item">
                            <a href="menu.php" class="nav-link">Меню</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="branches.php" class="nav-link">Контакты</a>
                            <div class="dropdown-content">
                                <a href="branches.php">Адреса</a>
                                <a href="contact.php">Контакты</a>
                            </div>
                        </li>
                    </ul>
                    <a href="tel:+77771234567" class="phone">+7 (777) 123-45-67</a>
                    <a href="index.php#hero" class="cta-btn header-btn">Получить консультацию</a>
                </nav>
                <button class="burger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>

                <!-- Mobile Navigation Menu -->
                <nav class="mobile-nav">
                    <ul class="mobile-nav-list">
                        <li><a href="index.php" class="mobile-nav-link">Главная</a></li>
                        <li><a href="about.php" class="mobile-nav-link">О нас</a></li>
                        <li><a href="news.php" class="mobile-nav-link">Новости</a></li>
                        <li><a href="catering.php" class="mobile-nav-link">Кейтеринг</a></li>
                        <li><a href="index.php#reservation" class="mobile-nav-link">Бронирование</a></li>
                        <li><a href="products.php" class="mobile-nav-link active">Продукция</a></li>
                        <li><a href="menu.php" class="mobile-nav-link">Меню</a></li>
                        <li><a href="branches.php" class="mobile-nav-link">Адреса</a></li>
                        <li><a href="contact.php" class="mobile-nav-link">Контакты</a></li>
                        <li><a href="tel:+77771234567" class="mobile-nav-link phone-link">+7 (777) 123-45-67</a></li>
                        <li><a href="index.php#hero" class="cta-btn mobile-cta">Получить консультацию</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Products Hero Section -->
    <section class="products-hero">
        <div class="hero-overlay">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text" data-aos="fade-up">
                        <h1 data-aos="fade-up">Наша продукция</h1>
                        <p data-aos="fade-up" data-aos-delay="200">Свежеобжаренный кофе, профессиональное оборудование и качественная выпечка для вашего бизнеса</p>
                    </div>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Видов продукции</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1000+</span>
                            <span class="stat-label">Довольных клиентов</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Поддержка</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-page section">
        <div class="container">
            <div class="products-grid">
                <?php
                if ($products) {
                    foreach ($products as $category => $items) {
                        foreach ($items as $product) { ?>
                            <div class="product-card" data-aos="fade-up">
                                <div class="product-image">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                                </div>
                                <div class="product-content">
                                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                                    <span class="price"><?php echo htmlspecialchars($product['price']); ?><?php if ($product['price'] <= 1000) echo '/кг'; ?></span>
                                    <button class="cta-btn">Подробнее</button>
                                </div>
                            </div>
                        <?php }
                    }
                } else {
                    // Fallback products
                    $fallbackProducts = [
                        ['name' => 'Кофе Эспрессо', 'price' => 500, 'description' => 'Высококачественные зерна...', 'image' => 'images/espresso.jpg'],
                        ['name' => 'Кофе Капучино', 'price' => 600, 'description' => 'Бленд специально...', 'image' => 'images/cappuccino.jpg'],
                        ['name' => 'Эспрессо машина', 'price' => 150000, 'description' => 'Профессиональная кофемашина...', 'image' => 'images/barista.jpg'],
                        ['name' => 'Кофе Латте', 'price' => 550, 'description' => 'Классический латте...', 'image' => 'images/latte.jpg'],
                        ['name' => 'Кофе Американо', 'price' => 450, 'description' => 'Легкий и бодрящий...', 'image' => 'images/americano.jpg'],
                        ['name' => 'Кофемашина Pro', 'price' => 200000, 'description' => 'Профессиональное оборудование...', 'image' => 'images/coffee-machine.jpg']
                    ];
                    foreach ($fallbackProducts as $product) { ?>
                        <div class="product-card" data-aos="fade-up">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                            </div>
                            <div class="product-content">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <span class="price"><?php echo htmlspecialchars($product['price']); ?><?php if ($product['price'] <= 1000) echo '/кг'; ?></span>
                                <button class="cta-btn">Подробнее</button>
                            </div>
                        </div>
                    <?php }
                }
                ?>
            </div>
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

        // Mobile Menu Functionality
        const burger = document.querySelector('.burger');
        const mobileNav = document.querySelector('.mobile-nav');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link, .mobile-cta');

        // Function to close mobile menu
        function closeMobileMenu() {
            burger.classList.remove('active');
            mobileNav.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Function to open/close mobile menu
        function toggleMobileMenu() {
            burger.classList.toggle('active');
            mobileNav.classList.toggle('active');
            document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
        }

        // Toggle mobile menu - add both click and touchstart for mobile compatibility
        burger.addEventListener('click', toggleMobileMenu);
        burger.addEventListener('touchstart', function(e) {
            e.preventDefault();
            toggleMobileMenu();
        });

        // Close mobile menu when clicking on links
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Prevent default behavior for links to allow menu to close first
                if (this.tagName === 'A') {
                    e.preventDefault();
                    const href = this.getAttribute('href');

                    // Close menu immediately
                    closeMobileMenu();

                    // Navigate after menu closes
                    setTimeout(() => {
                        window.location.href = href;
                    }, 100);
                } else {
                    // For buttons, just close menu
                    closeMobileMenu();
                }
            });

            // Add touchstart for mobile devices
            link.addEventListener('touchstart', function(e) {
                if (this.tagName === 'A') {
                    e.preventDefault();
                    const href = this.getAttribute('href');

                    // Close menu immediately
                    closeMobileMenu();

                    // Navigate after menu closes
                    setTimeout(() => {
                        window.location.href = href;
                    }, 100);
                } else {
                    // For buttons, just close menu
                    closeMobileMenu();
                }
            });
        });

        // Close mobile menu when clicking outside
        mobileNav.addEventListener('click', function(e) {
            if (e.target === this) {
                closeMobileMenu();
            }
        });

        // Close mobile menu when clicking outside (touch support)
        mobileNav.addEventListener('touchstart', function(e) {
            if (e.target === this) {
                closeMobileMenu();
            }
        });
    </script>
</body>
</html>
