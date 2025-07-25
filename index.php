<?php
// Koneksi ke database
require_once 'connection.php';

// Array gambar untuk slideshow (sesuaikan dengan gambar yang ada di folder images)
$heroImages = [
    'images/foto-utama2.JPG',
    'images/aneka-kuliner2.JPG',
    'images/event-spesial.JPG',
    'images/futsal-area.JPG',
    'images/skateboard-area.JPG'
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteInfo['name']) ?> - Sentra Wisata Kuliner di Surabaya</title>
    <meta name="description" content="Sentra Wisata Kuliner Semolowaru - Salah Satu Pusat kuliner di Surabaya dengan 20+ tenant, live music, dan fasilitas Lainnya. Buka <?= htmlspecialchars($siteInfo['hours']) ?>.">
    <link rel="icon" type="image/png" href="images/logo/Logo Semolowaru-01.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <style>
        /* Hero Slideshow Styles */
        .hero-slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }

        .hero-slide.active {
            opacity: 1;
        }

        .hero-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        /* Ensure content is above slideshow */
        .hero-content {
            position: relative;
            z-index: 10;
        }

        /* Slideshow indicators */
        .hero-indicators {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 15;
        }

        .hero-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hero-indicator.active {
            background: var(--primary-color);
            border-color: white;
            transform: scale(1.2);
        }

        /* Slideshow controls */
        .hero-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 15;
            background: rgba(0, 0, 0, 0.3);
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 15px 12px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .hero-controls:hover {
            background: rgba(0, 0, 0, 0.6);
            opacity: 1;
            color: var(--primary-color);
        }

        .hero-prev {
            left: 30px;
        }

        .hero-next {
            right: 30px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-controls {
                font-size: 1.2rem;
                padding: 12px 10px;
            }

            .hero-prev {
                left: 15px;
            }

            .hero-next {
                right: 15px;
            }

            .hero-indicators {
                bottom: 20px;
                gap: 10px;
            }

            .hero-indicator {
                width: 10px;
                height: 10px;
            }
        }

        @media (max-width: 576px) {
            .hero-controls {
                font-size: 1.2rem;
                padding: 12px 10px;
            }
        }

        @media (max-width: 399px) {
            .hero-section {
                min-height: 100vh;
                /* Kurangi tinggi agar tidak terlalu memakan layar */
            }

            .hero-title {
                font-size: 1.4rem;
                line-height: 1.3;
                text-align: center;
            }

            .hero-subtitle {
                font-size: 0.95rem;
                text-align: center;
            }

            .rating-badge {
                font-size: 0.9rem;
                text-align: center;
                display: block;
                margin-top: 10px;
            }

            .hero-content {
                text-align: center;
                padding-top: 40vh;
                padding-left: 10px;
                padding-right: 10px;
            }

            .hero-content .btn {
                display: block;
                width: 100%;
                margin: 8px 0;
                font-size: 0.9rem;
                padding: 10px 14px;
            }

            .hero-indicators {
                bottom: 15px;
                gap: 8px;
            }

            .hero-indicator {
                width: 8px;
                height: 8px;
            }

            .hero-controls {
                font-size: 1.2rem;
                padding: 12px 10px;
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
                    <li class="nav-item"><a class="nav-link fw-semibold active" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="tentang.php">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="tenant.php">Tenant</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="fasilitas.php">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="galeri.php">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="kontak.php">Kontak</a></li>
                </ul>
                <div class="ms-lg-3 mt-3 mt-lg-0">
                    <a href="https://www.instagram.com/<?= substr(htmlspecialchars($siteInfo['instagram']), 1) ?>/" class="text-decoration-none me-3" target="_blank">
                        <i class="fab fa-instagram fs-4" style="color: var(--primary-color);"></i>
                    </a>
                    <a href="https://maps.app.goo.gl/BaHAs5VQsMKqDSKFA" class="btn btn-custom btn-sm" target="_blank">
                        <i class="fas fa-map-marker-alt me-1"></i> Lihat Lokasi
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Slideshow -->
    <section id="beranda" class="hero-section" style="min-height: 125vh">
        <!-- Background Slideshow -->
        <div class="hero-slideshow">
            <?php foreach ($heroImages as $index => $image): ?>
                <div class="hero-slide <?= $index === 0 ? 'active' : '' ?>"
                    style="background-image: url('<?= $image ?>');"
                    data-slide="<?= $index ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Slideshow Controls -->
        <button class="hero-controls hero-prev" onclick="previousSlide()">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-controls hero-next" onclick="nextSlide()">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Slideshow Indicators -->
        <div class="hero-indicators">
            <?php foreach ($heroImages as $index => $image): ?>
                <div class="hero-indicator <?= $index === 0 ? 'active' : '' ?>"
                    onclick="goToSlide(<?= $index ?>)"
                    data-slide="<?= $index ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?= htmlspecialchars($siteInfo['full_name']) ?></h1>
                <p class="hero-subtitle">Salah Satu Pusat Kuliner di Surabaya dengan Suasana Outdoor yang Nyaman</p>
                <div class="rating-badge">
                    <i class="fas fa-star text-warning"></i>
                    <strong><?= htmlspecialchars($siteInfo['rating']) ?>/5</strong>
                    <span class="ms-2">(<?= htmlspecialchars($siteInfo['reviews']) ?> ulasan Google)</span>
                </div>
                <div class="mt-4">
                    <p class="fs-5 mb-3">
                        <i class="fas fa-clock me-2"></i>
                        Buka Setiap Hari: <?= htmlspecialchars($siteInfo['hours']) ?>
                    </p>
                </div>
                <div class="mt-4">
                    <a href="tenant.php" class="btn btn-custom btn-lg me-3">
                        <i class="fas fa-utensils me-2"></i>Jelajahi Tenant
                    </a>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $siteInfo['phone']) ?>" target="_blank" class="btn btn-success btn-lg me-3">
                        <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                    </a>
                    <a href="https://maps.app.goo.gl/BaHAs5VQsMKqDSKFA" class="btn btn-outline-light btn-lg" target="_blank">
                        <i class="fas fa-map-marker-alt me-2"></i>Lihat Lokasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Rest of your content remains the same -->
    <!-- Quick Info Cards -->
    <section class="py-5">
        <div class="container">
            <div class="quick-info p-4">
                <div class="row g-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <h5 class="fw-bold">Lokasi Strategis</h5>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($siteInfo['address'])) ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-clock"></i></div>
                            <h5 class="fw-bold">Buka Panjang</h5>
                            <p class="mb-0">Setiap Hari<br><?= htmlspecialchars($siteInfo['hours']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-music"></i></div>
                            <h5 class="fw-bold">Live Music</h5>
                            <p class="mb-0">Hiburan Setiap Malam<br>Musik & Pertunjukan</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="info-card">
                            <div class="info-icon"><i class="fas fa-skating"></i></div>
                            <h5 class="fw-bold">Skateboard Area</h5>
                            <p class="mb-0">Fasilitas Olahraga<br>Gratis untuk Umum</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Andalan Section -->
    <section id="menu-andalan" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Menu Andalan</h2>
                <p class="text-muted">Koleksi menu favorit pilihan pengunjung SWK Semolowaru</p>
                <?php if (isset($totalMenu) && $totalMenu > 0): ?>
                    <p class="text-primary fw-bold">
                        <i class="fas fa-utensils me-2"></i><?= $totalMenu ?> Menu Tersedia
                    </p>
                <?php endif; ?>
            </div>

            <!-- Menampilkan 6 menu pertama -->
            <?php if (!empty($semuaMenuItems)): ?>
                <div class="row justify-content-center mb-4">
                    <?php foreach (array_slice($semuaMenuItems, 0, 6) as $item): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($item['nama_menu']) ?></h5>
                                    <span class="badge bg-primary"><?= htmlspecialchars($item['kategori']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Tombol Lihat Semua Menu -->
            <div class="text-center mt-4">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#allMenuModal">
                            <i class="fas fa-list me-2"></i>Lihat Semua Menu
                            <?php if (isset($totalMenu) && $totalMenu > 0): ?>
                                <span class="badge bg-light text-primary ms-2"><?= $totalMenu ?></span>
                            <?php endif; ?>
                        </button>
                    </div>
                </div>
                <?php if (isset($totalMenu) && $totalMenu > 6): ?>
                    <p class="text-muted mt-3 small">
                        Menampilkan 6 dari <?= $totalMenu ?> menu tersedia
                    </p>
                <?php endif; ?>
            </div>

            <!-- Modal Semua Menu -->
            <div class="modal fade" id="allMenuModal" tabindex="-1" aria-labelledby="allMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="allMenuModalLabel">
                                <i class="fas fa-utensils me-2"></i>Semua Menu Tersedia
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (!empty($semuaMenuItems)): ?>
                                <div class="list-group">
                                    <?php foreach ($semuaMenuItems as $item): ?>
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><?= htmlspecialchars($item['nama_menu']) ?></h6>
                                            </div>
                                            <small class="badge bg-primary"><?= htmlspecialchars($item['kategori']) ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>Daftar menu lengkap akan segera tersedia.</p>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Why Choose SWK Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="section-title text-start">Kenapa Pilih SWK Semolowaru?</h2>
                    <p class="fs-5 text-muted mb-4">Lebih dari sekadar tempat makan, SWK Semolowaru adalah destinasi kuliner lengkap dengan berbagai fasilitas menarik untuk keluarga.</p>
                    <ul class="feature-list">
                        <?php foreach ($features as $feature): ?>
                            <li><i class="fas fa-check-circle"></i><?= htmlspecialchars($feature) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-4">
                        <a href="tentang.php" class="btn btn-custom"><i class="fas fa-arrow-right me-2"></i>Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="bg-primary rounded-4 p-4 text-white text-center d-flex flex-column justify-content-center" style="height: 200px;"><i class="fas fa-store fs-1 mb-3"></i>
                                <h4>20+</h4>
                                <p class="mb-0">Tenant Kuliner</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-warning rounded-4 p-4 text-dark text-center d-flex flex-column justify-content-center" style="height: 200px;"><i class="fas fa-users fs-1 mb-3"></i>
                                <h4>500+</h4>
                                <p class="mb-0">Pengunjung Harian</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success rounded-4 p-4 text-white text-center d-flex flex-column justify-content-center" style="height: 200px;"><i class="fas fa-star fs-1 mb-3"></i>
                                <h4><?= htmlspecialchars($siteInfo['rating']) ?></h4>
                                <p class="mb-0">Rating Google</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info rounded-4 p-4 text-white text-center d-flex flex-column justify-content-center" style="height: 200px;"><i class="fas fa-clock fs-1 mb-3"></i>
                                <h4>17</h4>
                                <p class="mb-0">Jam Buka</p>
                            </div>
                        </div>
                    </div>
                </div>
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
    <a href="https://wa.me/<?= str_replace(['+', '-', ' '], '', htmlspecialchars($siteInfo['phone'])) ?>" class="floating-whatsapp" target="_blank" title="Chat WhatsApp"><i class="fab fa-whatsapp"></i></a>

    <!-- Scripts -->
    <!-- Bootstrap JS Bundle (termasuk Popper) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hero Slideshow JavaScript
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.hero-indicator');
        const totalSlides = slides.length;
        let slideInterval;

        // Initialize slideshow
        function initSlideshow() {
            if (totalSlides > 1) {
                startAutoSlide();
            }
        }

        // Start automatic sliding
        function startAutoSlide() {
            slideInterval = setInterval(() => {
                nextSlide();
            }, 5000); // Change slide every 5 seconds
        }

        // Stop automatic sliding
        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        // Go to specific slide
        function goToSlide(slideIndex) {
            stopAutoSlide();

            // Remove active class from current slide and indicator
            slides[currentSlide].classList.remove('active');
            indicators[currentSlide].classList.remove('active');

            // Set new current slide
            currentSlide = slideIndex;

            // Add active class to new slide and indicator
            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.add('active');

            // Restart auto slide after manual navigation
            setTimeout(startAutoSlide, 3000);
        }

        // Next slide
        function nextSlide() {
            const nextIndex = (currentSlide + 1) % totalSlides;
            goToSlideWithoutRestart(nextIndex);
        }

        // Previous slide
        function previousSlide() {
            stopAutoSlide();
            const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
            goToSlideWithoutRestart(prevIndex);
            setTimeout(startAutoSlide, 3000);
        }

        // Go to slide without restarting auto-slide (for automatic transitions)
        function goToSlideWithoutRestart(slideIndex) {
            // Remove active class from current slide and indicator
            slides[currentSlide].classList.remove('active');
            indicators[currentSlide].classList.remove('active');

            // Set new current slide
            currentSlide = slideIndex;

            // Add active class to new slide and indicator
            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.add('active');
        }

        // Pause slideshow on hover
        const heroSection = document.querySelector('.hero-section');
        heroSection.addEventListener('mouseenter', stopAutoSlide);
        heroSection.addEventListener('mouseleave', () => {
            if (totalSlides > 1) {
                startAutoSlide();
            }
        });

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', initSlideshow);

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                previousSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        heroSection.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        heroSection.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide(); // Swipe left - next slide
                } else {
                    previousSlide(); // Swipe right - previous slide
                }
            }
        }
    </script>

    <script src="script.js"></script>

</body>

</html>