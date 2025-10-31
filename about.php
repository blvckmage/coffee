<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас - Tanqurai bread & coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
                        <li><a href="about.php" class="mobile-nav-link active">О нас</a></li>
                        <li><a href="news.php" class="mobile-nav-link">Новости</a></li>
                        <li><a href="catering.php" class="mobile-nav-link">Кейтеринг</a></li>
                        <li><a href="index.php#reservation" class="mobile-nav-link">Бронирование</a></li>
                        <li><a href="products.php" class="mobile-nav-link">Продукция</a></li>
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

    <!-- About Section -->
    <section class="about-page section">
        <div class="container">
            <h1 data-aos="fade-up">О нас</h1>

            <!-- Hero About -->
            <div class="about-hero" data-aos="fade-up">
                <div class="about-hero-text">
                    <h2>Добро пожаловать в Tanqurai bread & coffee</h2>
                    <p>Мы создаем незабываемые моменты с каждым глотком кофе и кусочком свежей выпечки</p>
                </div>
                <div class="about-hero-image">
                    <img src="images/coffee-bg.jpg" alt="Tanqurai coffee" loading="lazy">
                </div>
            </div>

            <!-- Our Story Timeline -->
            <div class="story-section" data-aos="fade-up">
                <h2>Наша история</h2>
                <div class="timeline">
                    <div class="timeline-item" data-aos="fade-right">
                        <div class="timeline-content">
                            <h3>2020</h3>
                            <p>Основание первой кофейни в Кентау. Начало нашей миссии по распространению качественного кофе в Казахстане.</p>
                        </div>
                        <div class="timeline-marker"><img src="images/espresso.jpg" alt="Coffee" loading="lazy"></div>
                    </div>
                    <div class="timeline-item" data-aos="fade-left">
                        <div class="timeline-content">
                            <h3>2021</h3>
                            <p>Открытие второго филиала в Туркестане. Расширение ассортимента свежей выпечки.</p>
                        </div>
                        <div class="timeline-marker"><img src="images/latte.jpg" alt="Bread" loading="lazy"></div>
                    </div>
                    <div class="timeline-item" data-aos="fade-right">
                        <div class="timeline-content">
                            <h3>2022</h3>
                            <p>Запуск программы обучения бариста. Начало поставок кофе для других кафе.</p>
                        </div>
                        <div class="timeline-marker"><img src="images/barista.jpg" alt="Barista training" loading="lazy"></div>
                    </div>
                    <div class="timeline-item" data-aos="fade-left">
                        <div class="timeline-content">
                            <h3>2023</h3>
                            <p>Открытие филиалов в Шымкенте и Таразе. Развитие кейтеринговых услуг.</p>
                        </div>
                        <div class="timeline-marker"><img src="images/hero-bg.jpg" alt="New branches" loading="lazy"></div>
                    </div>
                    <div class="timeline-item" data-aos="fade-right">
                        <div class="timeline-content">
                            <h3>2024</h3>
                            <p>Запуск онлайн-магазина. Более 10 000 довольных клиентов по всему Казахстану.</p>
                        </div>
                        <div class="timeline-marker"><img src="images/coffee-texture.jpg" alt="Success" loading="lazy"></div>
                    </div>
                </div>
            </div>

            <!-- Philosophy Section -->
            <div class="philosophy-section" data-aos="fade-up">
                <div class="philosophy-content">
                    <h2>Наша философия</h2>
                    <p>Мы верим, что кофе - это не просто напиток, а искусство. Каждый день наши бариста вручную обжаривают зерна, чтобы достичь идеального баланса вкуса и аромата.</p>
                    <div class="philosophy-stats">
                        <div class="stat-item">
                            <span class="stat-number">4</span>
                            <span class="stat-label">Филиала</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">10K+</span>
                            <span class="stat-label">Довольных клиентов</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Видов кофе</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Поддержка</span>
                        </div>
                    </div>
                </div>
                <div class="philosophy-image">
                    <img src="images/barista.jpg" alt="Our barista" loading="lazy">
                </div>
            </div>

            <!-- Values Section -->
            <div class="values-section" data-aos="fade-up">
                <h2>Наши ценности</h2>
                <div class="values-grid">
                    <div class="value-item" data-aos="zoom-in">
                        <div class="value-icon">⭐</div>
                        <h3>Качество</h3>
                        <p>Мы используем только лучшие ингредиенты и оборудование</p>
                    </div>
                    <div class="value-item" data-aos="zoom-in" data-aos-delay="100">
                        <div class="value-icon">🌱</div>
                        <h3>Свежеть</h3>
                        <p>Все продукты готовятся ежедневно на месте</p>
                    </div>
                    <div class="value-item" data-aos="zoom-in" data-aos-delay="200">
                        <div class="value-icon">❤️</div>
                        <h3>Сервис</h3>
                        <p>Мы стремимся к тому, чтобы каждый клиент чувствовал себя особенным</p>
                    </div>
                    <div class="value-item" data-aos="zoom-in" data-aos-delay="300">
                        <div class="value-icon">💡</div>
                        <h3>Инновации</h3>
                        <p>Мы постоянно экспериментируем с новыми вкусами и рецептами</p>
                    </div>
                    <div class="value-item" data-aos="zoom-in" data-aos-delay="400">
                        <div class="value-icon">🤝</div>
                        <h3>Сообщество</h3>
                        <p>Мы поддерживаем местные фермеров и поставщиков</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Section -->
            <div class="gallery-section" data-aos="fade-up">
                <h2>Наши моменты</h2>
                <div class="gallery-grid">
                    <div class="gallery-item" data-aos="fade-up">
                        <img src="images/coffee-texture.jpg" alt="Coffee brewing" loading="lazy">
                    </div>
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="100">
                        <img src="images/americano.jpg" alt="Americano coffee" loading="lazy">
                    </div>
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="200">
                        <img src="images/cappuccino.jpg" alt="Cappuccino art" loading="lazy">
                    </div>
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="300">
                        <img src="images/latte.jpg" alt="Latte macchiato" loading="lazy">
                    </div>
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="400">
                        <img src="images/espresso.jpg" alt="Espresso shot" loading="lazy">
                    </div>
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="500">
                        <img src="images/hero-bg.jpg" alt="Coffee shop interior" loading="lazy">
                    </div>
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
