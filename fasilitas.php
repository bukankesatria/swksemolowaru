<?php
// Include koneksi database
require_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - <?= htmlspecialchars($siteInfo['name']) ?></title>
    <link rel="icon" type="image/png" href="images/logo/Logo Semolowaru-01.png">
    <meta name="description" content="Fasilitas lengkap di <?= htmlspecialchars($siteInfo['full_name']) ?> - parkir luas, WiFi gratis, live music, skateboard area, dan berbagai fasilitas pendukung lainnya.">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #ff6b35;
            --secondary-color: #2c3e50;
            --accent-color: #f39c12;
            --dark-color: #1a1a1a;
        }

        /* Hero Section with Slider */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 60vh;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            color: white;
            text-align: center;
            animation: fadeInUp 1s ease;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        .rating-badge {
            background: rgba(255, 255, 255, 0.9);
            color: var(--secondary-color);
            padding: 15px 25px;
            border-radius: 50px;
            display: inline-block;
            margin: 20px 0;
            font-weight: 600;
        }

        /* Facility Slider Styles */
        .facilities-slider {
            position: relative;
            height: 400px;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.8s ease-in-out;
        }

        .slide.active {
            opacity: 1;
            transform: translateX(0);
        }

        .slide.prev {
            transform: translateX(-100%);
        }

        .slide-content {
            text-align: center;
            z-index: 2;
        }

        .slide-icon {
            width: 50px;
            height: auto;
            object-fit: contain;
        }


        .slide-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .slide-description {
            font-size: 1.1rem;
            font-weight: 300;
            opacity: 0.9;
        }

        /* Slider Indicators */
        .slider-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: white;
            transform: scale(1.2);
        }

        /* Slider Navigation */
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .slider-nav:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .slider-nav.prev {
            left: 20px;
        }

        .slider-nav.next {
            right: 20px;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIconPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .facilities-slider {
                height: 300px;
            }

            .slide-icon {
                font-size: 3.5rem;
            }

            .slide-title {
                font-size: 1.5rem;
            }

            .slide-description {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo/Logo Semolowaru-02.png" alt="<?= htmlspecialchars($siteInfo['name']) ?>" style="height: 70px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="tentang.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="tenant.php">Tenant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold active" href="fasilitas.php">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="galeri.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="kontak.php">Kontak</a>
                    </li>
                </ul>

                <div class="ms-3">
                    <a href="https://www.instagram.com/<?= substr($siteInfo['instagram'], 1) ?>/" class="text-decoration-none me-3" target="_blank">
                        <i class="fab fa-instagram fs-4" style="color: var(--primary-color);"></i>
                    </a>
                    <a href="https://maps.app.goo.gl/BaHAs5VQsMKqDSKFA" class="btn btn-custom btn-sm" target="_blank">
                        <i class="fas fa-map-marker-alt me-1"></i> Lihat Lokasi
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">Fasilitas Lengkap</h1>
                        <p class="hero-subtitle">Nikmati berbagai fasilitas pendukung yang membuat pengalaman kuliner Anda semakin berkesan</p>

                        <div class="rating-badge">
                            <i class="fas fa-star text-warning"></i>
                            <strong>4.8/5</strong>
                            <span class="ms-2">(234 ulasan fasilitas)</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="facilities-slider">
                        <div class="slider-container">
                            <!-- Slide 1 -->
                            <div class="slide active">
                                <div class="slide-content text-center">
                                    <img src="images/icons/parkir.jpg" alt="Parkir Luas" class="slide-icon mb-3" style="width: 800px; height: auto;">
                                </div>
                            </div>

                            <!-- Slide 2 -->
                            <div class="slide">
                                <div class="slide-content text-center">
                                    <img src="images/icons/futsal.JPG" alt="Lapangan Futsal dan Basket" class="slide-icon mb-3" style="width: 800px; height: auto;">
                                </div>
                            </div>

                            <!-- Slide 3 -->
                            <div class="slide">
                                <div class="slide-content text-center">
                                    <img src="images/icons/music.JPG" alt="Live Music" class="slide-icon mb-3" style="width: 800px; height: auto;">
                                </div>
                            </div>

                            <!-- Slide 4 -->
                            <div class="slide">
                                <div class="slide-content text-center">
                                    <img src="images/icons/skateboard.JPG" alt="Skateboard Area" class="slide-icon mb-3" style="width: 800px; height: auto;">
                                </div>
                            </div>

                            <!-- Slide 5 -->
                            <div class="slide">
                                <div class="slide-content text-center">
                                    <img src="images/icons/kids-zone.JPG" alt="Kids Zone" class="slide-icon mb-3" style="width: 800px; height: auto;">
                                </div>
                            </div>

                            <!-- Slide 6 -->
                            <div class="slide">
                                <div class="slide-content text-center">
                                    <img src="images/icons/foodcourt.JPG" alt="Food Court" class="slide-icon mb-3" style="width: 800px; height: auto;">
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <button class="slider-nav prev" onclick="changeSlide(-1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-nav next" onclick="changeSlide(1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>

                            <!-- Indicators -->
                            <div class="slider-indicators">
                                <div class="indicator active" onclick="currentSlide(1)"></div>
                                <div class="indicator" onclick="currentSlide(2)"></div>
                                <div class="indicator" onclick="currentSlide(3)"></div>
                                <div class="indicator" onclick="currentSlide(4)"></div>
                                <div class="indicator" onclick="currentSlide(5)"></div>
                                <div class="indicator" onclick="currentSlide(6)"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <!-- Main Facilities -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Fasilitas Utama</h2>
                <p class="fs-5 text-muted">Fasilitas lengkap untuk kenyamanan dan kepuasan pengunjung</p>
            </div>

            <div class="row g-4">
                <?php if (!empty($fasilitasUtama)): ?>
                    <?php foreach ($fasilitasUtama as $fasilitas): ?>
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start mb-4">
                                        <div class="me-4">
                                            <div class="bg-<?= htmlspecialchars($fasilitas['color']) ?> rounded-circle p-3 text-white">
                                                <i class="<?= htmlspecialchars($fasilitas['icon']) ?> fs-3"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="fw-bold mb-3"><?= htmlspecialchars($fasilitas['title']) ?></h4>
                                            <p class="text-muted mb-4"><?= htmlspecialchars($fasilitas['description']) ?></p>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <?php
                                        // Ambil fitur untuk fasilitas ini
                                        $fiturList = getFiturByFasilitasId($fasilitas['id']);
                                        foreach ($fiturList as $fitur):
                                        ?>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <small class="text-muted"><?= htmlspecialchars($fitur['fitur']) ?></small>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Fasilitas utama sedang dalam proses pembaruan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Support Facilities -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Fasilitas Pendukung</h2>
                <p class="fs-5 text-muted">Fasilitas tambahan yang melengkapi kenyamanan Anda</p>
            </div>

            <div class="row g-4">
                <?php
                // Fasilitas pendukung (bisa diambil dari database atau hardcoded)
                $fasilitasPendukung = [
                    [
                        'icon' => 'fas fa-toilet',
                        'title' => 'Toilet Bersih',
                        'description' => 'Fasilitas toilet yang bersih dan terawat',
                        'color' => 'info'
                    ],
                    [
                        'icon' => 'fas fa-pray',
                        'title' => 'Mushola',
                        'description' => 'Tempat ibadah yang nyaman dan bersih',
                        'color' => 'success'
                    ],
                    [
                        'icon' => 'fas fa-shield-alt',
                        'title' => 'Keamanan 24 Jam',
                        'description' => 'Petugas keamanan yang siaga 24 jam',
                        'color' => 'danger'
                    ],
                    [
                        'icon' => 'fas fa-utensils',
                        'title' => 'Peralatan Makan',
                        'description' => 'Penyediaan peralatan makan lengkap',
                        'color' => 'warning'
                    ],
                    [
                        'icon' => 'fas fa-cash-register',
                        'title' => 'Pembayaran Digital',
                        'description' => 'Mendukung berbagai metode pembayaran',
                        'color' => 'primary'
                    ],
                    [
                        'icon' => 'fas fa-first-aid',
                        'title' => 'P3K',
                        'description' => 'Kotak P3K dan bantuan medis darurat',
                        'color' => 'danger'
                    ]
                ];

                foreach ($fasilitasPendukung as $fasilitas):
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="bg-<?= $fasilitas['color'] ?> rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                    <i class="<?= $fasilitas['icon'] ?> fs-2 text-white"></i>
                                </div>
                                <h5 class="fw-bold mb-3"><?= htmlspecialchars($fasilitas['title']) ?></h5>
                                <p class="text-muted"><?= htmlspecialchars($fasilitas['description']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3">Siap Merasakan Pengalaman Kuliner Terbaik?</h2>
                    <p class="fs-5 mb-4">Nikmati berbagai fasilitas lengkap dan kuliner terbaik di <?= htmlspecialchars($siteInfo['name']) ?>. Kunjungi kami sekarang!</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="https://maps.app.goo.gl/BaHAs5VQsMKqDSKFA" class="btn btn-light btn-lg me-3" target="_blank">
                        <i class="fas fa-map-marker-alt me-2"></i>Lihat Lokasi
                    </a>
                    <a href="https://www.instagram.com/<?= substr($siteInfo['instagram'], 1) ?>/" class="btn btn-outline-light btn-lg" target="_blank">
                        <i class="fab fa-instagram me-2"></i>Follow IG
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="mb-4">
                        <img src="images/logo/Logo Semolowaru-02.png" alt="<?= htmlspecialchars($siteInfo['name']) ?>" style="height: 60px;">
                    </div>
                    <p class="text-light mb-3"><?= htmlspecialchars($siteInfo['full_name']) ?> - Tempat kuliner terbaik dengan fasilitas lengkap dan suasana yang nyaman untuk keluarga.</p>
                    <div class="d-flex gap-3">
                        <a href="https://www.instagram.com/<?= substr($siteInfo['instagram'], 1) ?>/" class="text-white fs-4" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="tel:<?= htmlspecialchars($siteInfo['phone']) ?>" class="text-white fs-4">
                            <i class="fas fa-phone"></i>
                        </a>
                        <a href="https://maps.app.goo.gl/BaHAs5VQsMKqDSKFA" class="text-white fs-4" target="_blank">
                            <i class="fas fa-map-marker-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5 class="fw-bold mb-3">Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-light text-decoration-none">Beranda</a></li>
                        <li><a href="tentang.php" class="text-light text-decoration-none">Tentang</a></li>
                        <li><a href="tenant.php" class="text-light text-decoration-none">Tenant</a></li>
                        <li><a href="fasilitas.php" class="text-light text-decoration-none">Fasilitas</a></li>
                        <li><a href="galeri.php" class="text-light text-decoration-none">Galeri</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="fw-bold mb-3">Jam Operasional</h5>
                    <?php if (!empty($operatingHours)): ?>
                        <?php foreach (array_slice($operatingHours, 0, 7) as $hour): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?= htmlspecialchars($hour['day_name']) ?></span>
                                <span class="text-light">
                                    <?php if ($hour['is_open'] == 1): ?>
                                        <?= htmlspecialchars($hour['open_time']) ?> - <?= htmlspecialchars($hour['close_time']) ?>
                                    <?php else: ?>
                                        Tutup
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-light">Setiap hari: 07:00 - 24:00</p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span class="text-light"><?= htmlspecialchars($siteInfo['address']) ?></span>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <span class="text-light"><?= htmlspecialchars($siteInfo['phone']) ?></span>
                    </div>
                    <div class="mb-2">
                        <i class="fab fa-instagram me-2"></i>
                        <a class="text-light text-decoration-none" href="https://www.instagram.com/swk_semolowaru/" target="_blank" rel="noopener noreferrer">
                            SWK Semolowaru
                        </a>
                    </div>
                    <div class="mb-2">
                        <i class="fab fa-instagram me-2"></i>
                        <a class="text-light text-decoration-none" href="https://www.instagram.com/kelurahan_semolowaru" target="_blank" rel="noopener noreferrer">
                            Kelurahan Semolowaru
                        </a>
                    </div>
                    <div class="mb-2">
                        <i class="fab fa-instagram me-2"></i>
                        <a class="text-light text-decoration-none" href="https://www.instagram.com/dinkopdag_surabaya/" target="_blank" rel="noopener noreferrer">
                            Dinkopumdag Surabaya
                        </a>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-globe me-2"></i>
                        <a class="text-light text-decoration-none" href="https://sswalfa.surabaya.go.id/" target="_blank" rel="noopener noreferrer">
                            sswalfa.surabaya.go.id
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0 text-light">&copy; <?= date('Y') ?> <?= htmlspecialchars($siteInfo['name']) ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/<?= str_replace(['+', '-', ' '], '', $siteInfo['phone']) ?>"
        class="floating-whatsapp" target="_blank" title="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>


    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        const totalSlides = slides.length;
        let autoSlideInterval;

        function showSlide(index) {
            // Remove active class from all slides and indicators
            slides.forEach(slide => {
                slide.classList.remove('active', 'prev');
            });
            indicators.forEach(indicator => {
                indicator.classList.remove('active');
            });

            // Add active class to current slide and indicator
            slides[index].classList.add('active');
            indicators[index].classList.add('active');

            // Add prev class to previous slide for smooth transition
            const prevIndex = (index - 1 + totalSlides) % totalSlides;
            slides[prevIndex].classList.add('prev');
        }

        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
            showSlide(currentSlideIndex);
        }

        function prevSlide() {
            currentSlideIndex = (currentSlideIndex - 1 + totalSlides) % totalSlides;
            showSlide(currentSlideIndex);
        }

        function changeSlide(direction) {
            if (direction === 1) {
                nextSlide();
            } else {
                prevSlide();
            }
            resetAutoSlide();
        }

        function currentSlide(index) {
            currentSlideIndex = index - 1;
            showSlide(currentSlideIndex);
            resetAutoSlide();
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 4000); // Change slide every 4 seconds
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Initialize slider
        document.addEventListener('DOMContentLoaded', function() {
            showSlide(0);
            startAutoSlide();
        });

        // Pause auto-slide on hover
        const sliderContainer = document.querySelector('.facilities-slider');
        sliderContainer.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });

        sliderContainer.addEventListener('mouseleave', () => {
            startAutoSlide();
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        sliderContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        sliderContainer.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                nextSlide();
                resetAutoSlide();
            }
            if (touchEndX > touchStartX + 50) {
                prevSlide();
                resetAutoSlide();
            }
        }
    </script>

</body>

</html>