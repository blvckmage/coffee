<?php
require_once 'functions.php';

$branches = loadBranches();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адреса - Tanqurai bread & coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Yandex Maps API -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
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
                            <a href="products.php" class="nav-link">Продукция</a>
                        </li>
                        <li class="nav-item">
                            <a href="menu.php" class="nav-link">Меню</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="branches.php" class="nav-link active">Контакты</a>
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
                        <li><a href="products.php" class="mobile-nav-link">Продукция</a></li>
                        <li><a href="menu.php" class="mobile-nav-link">Меню</a></li>
                        <li><a href="branches.php" class="mobile-nav-link active">Адреса</a></li>
                        <li><a href="contact.php" class="mobile-nav-link">Контакты</a></li>
                        <li><a href="tel:+77771234567" class="mobile-nav-link phone-link">+7 (777) 123-45-67</a></li>
                        <li><a href="index.php#hero" class="cta-btn mobile-cta">Получить консультацию</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Branches Section -->
    <section class="branches-page section">
        <div class="container">
            <h1 data-aos="fade-up">Где мы находимся</h1>

            <div class="map-with-addresses">
                <!-- Yandex Map -->
                <div class="full-map" data-aos="fade-up">
                    <div id="branches-map" style="width: 100%; height: 500px;"></div>
                    <div class="map-banner">
                        Найдите ближайший филиал
                    </div>
                </div>

                <div class="addresses-list" data-aos="fade-up">
                    <h2>Наши кофейни</h2>
                    <?php
                    if ($branches) {
                        foreach ($branches as $branch) {
                            ?>
                            <div class="address-item">
                                <h3><?php echo htmlspecialchars($branch['city']); ?></h3>
                                <address><?php echo htmlspecialchars($branch['address']); ?></address>
                                <a href="tel:<?php echo htmlspecialchars($branch['phone']); ?>" class="address-phone"><?php echo htmlspecialchars($branch['phone']); ?></a>
                                <div class="address-meta"><?php echo htmlspecialchars($branch['hours']); ?></div>
                            </div>
                            <?php
                        }
                    } else {
                        // Fallback addresses
                        $fallbackBranches = [
                            ['city' => 'Кентау', 'address' => 'ул. Гагарина, 50', 'phone' => '+7 (776) 333-50-01', 'hours' => 'Пн-Пт: 9:00-21:00, Сб-Вс: 10:00-22:00'],
                            ['city' => 'Туркестан', 'address' => 'ул. Амир Тимура, 28', 'phone' => '+7 (776) 333-50-02', 'hours' => 'Пн-Пт: 9:00-21:00, Сб-Вс: 10:00-22:00']
                        ];
                        foreach ($fallbackBranches as $branch) {
                            ?>
                            <div class="address-item">
                                <h3><?php echo htmlspecialchars($branch['city']); ?></h3>
                                <address><?php echo htmlspecialchars($branch['address']); ?></address>
                                <a href="tel:<?php echo htmlspecialchars($branch['phone']); ?>" class="address-phone"><?php echo htmlspecialchars($branch['phone']); ?></a>
                                <div class="address-meta"><?php echo htmlspecialchars($branch['hours']); ?></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
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
            const placemarks = [
                {coords: [43.5166, 68.5166], content: '<strong>Кентау</strong><br>ул. Гагарина, 50<br>+7 (776) 333-50-01'},
                {coords: [43.3024, 68.2588], content: '<strong>Туркестан</strong><br>ул. Амир Тимура, 28<br>+7 (776) 333-50-02'},
                {coords: [42.3417, 69.5993], content: '<strong>Шымкент</strong><br>пр. Тауке хана, 45<br>+7 (776) 333-50-03'},
                {coords: [42.9, 71.3667], content: '<strong>Тараз</strong><br>ул. Панфилова, 12<br>+7 (776) 333-50-04'}
            ];

            placemarks.forEach(function(placemarkData) {
                const placemark = new ymaps.Placemark(placemarkData.coords, {
                    balloonContent: placemarkData.content
                }, {
                    preset: 'islands#redIcon'
                });
                branchesMap.geoObjects.add(placemark);
                branchesPlacemarks.push(placemark);
            });
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
