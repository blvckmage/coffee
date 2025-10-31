<?php
require_once 'functions.php';

$news = loadNews();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости - Tanqurai bread & coffee</title>
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
                        <li><a href="about.php" class="mobile-nav-link">О нас</a></li>
                        <li><a href="news.php" class="mobile-nav-link active">Новости</a></li>
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

    <!-- News Hero Section -->
    <section class="news-hero">
        <div class="hero-overlay">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 data-aos="fade-up">Новости и события</h1>
                        <p data-aos="fade-up" data-aos-delay="200">Следите за последними новостями, акциями и событиями от Tanqurai bread & coffee</p>
                    </div>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Новостей</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1000+</span>
                            <span class="stat-label">Читателей</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Обновления</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-page section">
        <div class="container">
            <div class="news-intro" data-aos="fade-up">
                <h2>Последние новости</h2>
                <p>Будьте в курсе всех новостей и акций нашей сети кофеен</p>
            </div>



            <div class="news-grid">
                <?php
                if ($news) {
                    foreach ($news as $index => $item) {
                        $imagePath = isset($item['image']) ? $item['image'] : 'images/coffee-bg.jpg';
                        ?>
                        <div class="news-card" data-aos="fade-up" data-category="coffee">
                            <div class="news-image">
                                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
                                <div class="news-category-badge">Кофе</div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span class="news-date"><?php echo htmlspecialchars($item['date']); ?></span>
                                    <div class="news-stats">
                                        <span class="news-views">👁️ 245</span>
                                        <span class="news-likes">❤️ 12</span>
                                    </div>
                                </div>
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($item['content'], 0, 150)); ?>...</p>
                                <div class="news-actions">
                                    <button class="cta-btn read-more-btn" data-news-index="<?php echo $index; ?>" data-title="<?php echo htmlspecialchars($item['title']); ?>" data-content="<?php echo htmlspecialchars($item['content']); ?>" data-image="<?php echo htmlspecialchars($imagePath); ?>" data-date="<?php echo htmlspecialchars($item['date']); ?>">Читать далее</button>
                                    <button class="share-btn" title="Поделиться">📤</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Fallback news
                    $fallbackNews = [
                        ['title' => 'Новая обжарка кофе прибыла', 'date' => '15.10.2025', 'content' => 'Мы обновили ассортимент! Попробуйте новый бленд премиум-класса с нотками шоколада и ореха. Новая партия свежеобжаренного кофе уже доступна в наших кофепностях.', 'image' => 'images/coffee-bg.jpg'],
                        ['title' => 'Открытие новой кофейни', 'date' => '10.10.2025', 'content' => 'Приглашаем на открытие нашей третьей кофейни в Нур-Султане! Расположенная в центре города, новая кофейня предлагает уникальный интерьер и расширенное меню.', 'image' => 'images/coffee-texture.jpg'],
                        ['title' => 'Семинар по латте-арту', 'date' => '05.10.2025', 'content' => 'В ближайные выходные проведем мастер-класс по рисованию на кофе. Профессиональный бариста из Италии покажет удивительные узоры и поделится секретами техники латте-арта.', 'image' => 'images/wood-texture.jpg']
                    ];
                    foreach ($fallbackNews as $index => $item) {
                        ?>
                        <div class="news-card">
                            <div class="news-image">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
                            </div>
                            <div class="news-content">
                                <span class="news-date"><?php echo htmlspecialchars($item['date']); ?></span>
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($item['content'], 0, 150)); ?>...</p>
                                <button class="cta-btn read-more-btn" data-news-index="<?php echo $index; ?>" data-title="<?php echo htmlspecialchars($item['title']); ?>" data-content="<?php echo htmlspecialchars($item['content']); ?>" data-image="<?php echo htmlspecialchars($item['image']); ?>" data-date="<?php echo htmlspecialchars($item['date']); ?>">Читать далее</button>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
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



        // Share button functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('share-btn')) {
                const title = e.target.closest('.news-card').querySelector('h3').textContent;
                const url = window.location.href;

                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    });
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(`${title} - ${url}`).then(() => {
                        // Show temporary feedback
                        const originalText = e.target.textContent;
                        e.target.textContent = 'Скопировано!';
                        setTimeout(() => {
                            e.target.textContent = originalText;
                        }, 2000);
                    });
                }
            }
        });

        // Add initial animation to news cards
        const newsCards = document.querySelectorAll('.news-card');
        newsCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    </script>
</body>
</html>
