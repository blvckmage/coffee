<?php
require_once 'functions.php';

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
        ['icon' => '🍽️', 'title' => 'Полный кейтеринг', 'description' => 'Полноценный сервис с профессиональными поварами, оборудованием и квалифицированным персоналом', 'price' => 2500]
    ];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кейтеринг - Tanqurai bread & coffee</title>
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
                        <li><a href="about.php" class="mobile-nav-link">О нас</a></li>
                        <li><a href="news.php" class="mobile-nav-link">Новости</a></li>
                        <li><a href="catering.php" class="mobile-nav-link active">Кейтеринг</a></li>
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

    <!-- Catering Hero Section -->
    <section class="catering-hero">
        <div class="hero-overlay">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 data-aos="fade-up">Кейтеринг</h1>
                        <p data-aos="fade-up" data-aos-delay="200">Организуем незабываемые моменты для вашего праздника с безупречным сервисом и вкусом</p>
                    </div>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Мероприятий</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Клиентов</span>
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

    <!-- Catering Section -->
    <section class="catering-page section">
        <div class="container">
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
                            <button class="cta-btn order-catering-btn" data-service="<?php echo htmlspecialchars($title); ?>">Заказать кейтеринг</button>
                        </div>
                        <?php
                        $delay += 100;
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Catering Gallery Section -->
    <section class="catering-gallery section">
        <div class="container">
            <div class="gallery-intro" data-aos="fade-up">
                <h2>Наши работы</h2>
                <p>Посмотрите на наши прошлые кейтеринги и мероприятия</p>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item" data-aos="fade-up" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1559329007-40df8b6ddff7?w=600&h=400&fit=crop" alt="Корпоративный кейтеринг">
                    <div class="gallery-overlay">
                        <h3>Корпоративное мероприятие</h3>
                        <p>Кофе-брейк для 50 человек</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="fade-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=600&h=400&fit=crop" alt="Свадьба">
                    <div class="gallery-overlay">
                        <h3>Свадьба</h3>
                        <p>Полный банкет на 80 гостей</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="fade-up" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&h=400&fit=crop" alt="День рождения">
                    <div class="gallery-overlay">
                        <h3>День рождения</h3>
                        <p>Детский праздник с анимацией</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="fade-up" data-aos-delay="400">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&h=400&fit=crop" alt="Конференция">
                    <div class="gallery-overlay">
                        <h3>Конференция</h3>
                        <p>Фуршет для 120 участников</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="fade-up" data-aos-delay="500">
                    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=600&h=400&fit=crop" alt="Выпускной">
                    <div class="gallery-overlay">
                        <h3>Выпускной вечер</h3>
                        <p>Банкет для выпускников</p>
                    </div>
                </div>
                <div class="gallery-item" data-aos="fade-up" data-aos-delay="600">
                    <img src="https://images.unsplash.com/photo-1551218808-94e220e084d2?w=600&h=400&fit=crop" alt="Юбилей">
                    <div class="gallery-overlay">
                        <h3>Юбилей компании</h3>
                        <p>Корпоративный банкет</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catering Modal -->
    <div id="catering-modal" class="modal">
        <div class="modal-content catering-modal-content">
            <div class="modal-header">
                <h3>Заказать кейтеринг</h3>
                <span class="modal-close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="catering-form" class="catering-form">
                    <div class="form-group">
                        <label for="customer-name">Ваше имя *</label>
                        <input type="text" id="customer-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="customer-phone">Номер телефона *</label>
                        <input type="tel" id="customer-phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="catering-type">Тип кейтеринга *</label>
                        <select id="catering-type" name="service" required>
                            <option value="">Выберите тип кейтеринга</option>
                            <?php
                            foreach ($catering as $service) {
                                if (is_array($service) && isset($service['title'])) {
                                    echo '<option value="' . htmlspecialchars($service['title']) . '">' . htmlspecialchars($service['title']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="event-date">Дата мероприятия</label>
                        <input type="date" id="event-date" name="date">
                    </div>
                    <div class="form-group">
                        <label for="guest-count">Количество гостей</label>
                        <input type="number" id="guest-count" name="guests" min="1" placeholder="Примерно">
                    </div>
                    <div class="form-group">
                        <label for="additional-info">Дополнительная информация</label>
                        <textarea id="additional-info" name="message" rows="3" placeholder="Особые пожелания, аллергии и т.д."></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeCateringModal()">Отмена</button>
                        <button type="submit" class="btn btn-primary">Отправить заказ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div id="gallery-modal" class="modal">
        <div class="modal-content gallery-modal-content">
            <div class="modal-header">
                <h3 id="gallery-modal-title">Наше мероприятие</h3>
                <span class="modal-close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="gallery-modal-slider">
                    <div class="gallery-modal-main-image">
                        <img id="gallery-modal-main-img" src="" alt="Мероприятие">
                    </div>
                    <div class="gallery-modal-thumbnails">
                        <div class="gallery-modal-thumbnail active" data-image="https://images.unsplash.com/photo-1559329007-40df8b6ddff7?w=800&h=600&fit=crop" data-title="Корпоративное мероприятие" data-description="Кофе-брейк для 50 человек">
                            <img src="https://images.unsplash.com/photo-1559329007-40df8b6ddff7?w=150&h=100&fit=crop" alt="Фото 1">
                        </div>
                        <div class="gallery-modal-thumbnail" data-image="https://images.unsplash.com/photo-1551218808-94e220e084d2?w=800&h=600&fit=crop" data-title="Корпоративное мероприятие" data-description="Кофе-брейк для 50 человек">
                            <img src="https://images.unsplash.com/photo-1551218808-94e220e084d2?w=150&h=100&fit=crop" alt="Фото 2">
                        </div>
                        <div class="gallery-modal-thumbnail" data-image="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&h=600&fit=crop" data-title="Корпоративное мероприятие" data-description="Кофе-брейк для 50 человек">
                            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=150&h=100&fit=crop" alt="Фото 3">
                        </div>
                        <div class="gallery-modal-thumbnail" data-image="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&h=600&fit=crop" data-title="Свадьба" data-description="Полный банкет на 80 гостей">
                            <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=150&h=100&fit=crop" alt="Фото 4">
                        </div>
                        <div class="gallery-modal-thumbnail" data-image="https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&h=600&fit=crop" data-title="День рождения" data-description="Детский праздник с анимацией">
                            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=150&h=100&fit=crop" alt="Фото 5">
                        </div>
                        <div class="gallery-modal-thumbnail" data-image="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&h=600&fit=crop" data-title="Выпускной вечер" data-description="Банкет для выпускников">
                            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=150&h=100&fit=crop" alt="Фото 6">
                        </div>
                    </div>
                </div>
                <div class="gallery-modal-info">
                    <h4 id="gallery-modal-event-title">Корпоративное мероприятие</h4>
                    <p id="gallery-modal-description">Кофе-брейк для 50 человек</p>
                    <div class="gallery-modal-details">
                        <div class="detail-item">
                            <span class="detail-label">Тип мероприятия:</span>
                            <span class="detail-value" id="gallery-modal-type">Кофе-брейк</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Количество гостей:</span>
                            <span class="detail-value" id="gallery-modal-guests">50 человек</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Уровень сервиса:</span>
                            <span class="detail-value" id="gallery-modal-service">Высокий</span>
                        </div>
                    </div>
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

        // Catering Modal Functionality
        const cateringModal = document.getElementById('catering-modal');
        const cateringForm = document.getElementById('catering-form');
        const modalClose = document.querySelectorAll('.modal-close');

        // Handle order catering button clicks
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('order-catering-btn')) {
                e.preventDefault();
                const serviceType = e.target.getAttribute('data-service');

                // Pre-select the service type in the form
                const cateringTypeSelect = document.getElementById('catering-type');
                if (serviceType && cateringTypeSelect) {
                    cateringTypeSelect.value = serviceType;
                }

                // Show modal
                cateringModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        });

        // Close modal functionality
        modalClose.forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                closeCateringModal();
            });
        });

        // Close modal on outside click
        cateringModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCateringModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && cateringModal.classList.contains('show')) {
                closeCateringModal();
            }
        });

        function closeCateringModal() {
            cateringModal.classList.remove('show');
            document.body.style.overflow = '';
            cateringForm.reset();
        }

        // Handle form submission
        cateringForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                phone: formData.get('phone'),
                service: formData.get('service'),
                date: formData.get('date'),
                guests: formData.get('guests'),
                message: formData.get('message')
            };

            // Show loading state
            const submitBtn = cateringForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Отправка...';
            submitBtn.disabled = true;

            // Send data to Telegram bot
            fetch('send_catering_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Спасибо! Ваш заказ на кейтеринг отправлен. Мы свяжемся с вами в ближайшее время.');
                    closeCateringModal();
                } else {
                    alert('Произошла ошибка при отправке заказа. Пожалуйста, попробуйте еще раз или позвоните нам.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при отправке заказа. Пожалуйста, попробуйте еще раз или позвоните нам.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        // Gallery Modal Functionality
        const galleryModal = document.getElementById('gallery-modal');
        const galleryModalMainImg = document.getElementById('gallery-modal-main-img');
        const galleryModalTitle = document.getElementById('gallery-modal-title');
        const galleryModalEventTitle = document.getElementById('gallery-modal-event-title');
        const galleryModalDescription = document.getElementById('gallery-modal-description');
        const galleryModalType = document.getElementById('gallery-modal-type');
        const galleryModalGuests = document.getElementById('gallery-modal-guests');
        const galleryModalService = document.getElementById('gallery-modal-service');

        // Handle gallery item clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.gallery-item')) {
                e.preventDefault();
                const galleryItem = e.target.closest('.gallery-item');
                const overlay = galleryItem.querySelector('.gallery-overlay');
                const title = overlay.querySelector('h3').textContent;
                const description = overlay.querySelector('p').textContent;

                // Set modal content based on the clicked item
                galleryModalTitle.textContent = title;
                galleryModalEventTitle.textContent = title;
                galleryModalDescription.textContent = description;

                // Set details based on event type
                if (title.includes('Корпоративное')) {
                    galleryModalType.textContent = 'Кофе-брейк';
                    galleryModalGuests.textContent = '50 человек';
                    galleryModalService.textContent = 'Высокий';
                    galleryModalMainImg.src = 'https://images.unsplash.com/photo-1559329007-40df8b6ddff7?w=800&h=600&fit=crop';
                } else if (title.includes('Свадьба')) {
                    galleryModalType.textContent = 'Полный банкет';
                    galleryModalGuests.textContent = '80 человек';
                    galleryModalService.textContent = 'Премиум';
                    galleryModalMainImg.src = 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&h=600&fit=crop';
                } else if (title.includes('День рождения')) {
                    galleryModalType.textContent = 'Детский праздник';
                    galleryModalGuests.textContent = '30 человек';
                    galleryModalService.textContent = 'С анимацией';
                    galleryModalMainImg.src = 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&h=600&fit=crop';
                } else if (title.includes('Конференция')) {
                    galleryModalType.textContent = 'Фуршет';
                    galleryModalGuests.textContent = '120 человек';
                    galleryModalService.textContent = 'Бизнес-класс';
                    galleryModalMainImg.src = 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&h=600&fit=crop';
                } else if (title.includes('Выпускной')) {
                    galleryModalType.textContent = 'Банкет';
                    galleryModalGuests.textContent = '100 человек';
                    galleryModalService.textContent = 'Торжественный';
                    galleryModalMainImg.src = 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&h=600&fit=crop';
                } else if (title.includes('Юбилей')) {
                    galleryModalType.textContent = 'Корпоративный банкет';
                    galleryModalGuests.textContent = '70 человек';
                    galleryModalService.textContent = 'VIP';
                    galleryModalMainImg.src = 'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=800&h=600&fit=crop';
                }

                // Show modal
                galleryModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        });

        // Handle thumbnail clicks in gallery modal
        document.addEventListener('click', function(e) {
            if (e.target.closest('.gallery-modal-thumbnail')) {
                const thumbnail = e.target.closest('.gallery-modal-thumbnail');
                const imageSrc = thumbnail.getAttribute('data-image');
                const title = thumbnail.getAttribute('data-title');
                const description = thumbnail.getAttribute('data-description');

                // Update main image
                galleryModalMainImg.src = imageSrc;

                // Update info
                galleryModalEventTitle.textContent = title;
                galleryModalDescription.textContent = description;

                // Update active thumbnail
                document.querySelectorAll('.gallery-modal-thumbnail').forEach(thumb => {
                    thumb.classList.remove('active');
                });
                thumbnail.classList.add('active');
            }
        });

        // Close gallery modal functionality
        galleryModal.addEventListener('click', function(e) {
            if (e.target === this || e.target.classList.contains('modal-close')) {
                galleryModal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // Close gallery modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && galleryModal.classList.contains('show')) {
                galleryModal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    </script>
</body>
</html>
