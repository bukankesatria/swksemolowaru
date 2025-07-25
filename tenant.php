<?php
// Koneksi ke database
require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant - <?= htmlspecialchars($siteInfo['name']) ?></title>
    <link rel="icon" type="image/png" href="images/logo/Logo Semolowaru-01.png">
    <meta name="description" content="Daftar lengkap tenant kuliner di <?= htmlspecialchars($siteInfo['name']) ?>. Temukan berbagai pilihan makanan dan minuman favorit Anda.">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <style>
        .stat-box:hover p {
            color: white !important;
        }

        /* Tenant Page Styles */
        .tenant-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .tenant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .tenant-image {
            height: 200px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .tenant-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .tenant-image:hover img {
            transform: scale(1.05);
        }

        .tenant-image .image-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: white;
            font-size: 3rem;
        }

        .tenant-body {
            padding: 1.5rem;
        }

        .tenant-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .tenant-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: var(--primary-color);
            color: white;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .tenant-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .tenant-price {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .filter-btn {
            margin: 0.25rem;
            padding: 0.5rem 1rem;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: white;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .stats-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 3rem 0;
            margin-bottom: 3rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8rem 0 4rem;
            margin-top: 20px;
        }

        .search-box {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-box input {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            border: 2px solid #e0e0e0;
            font-size: 1.1rem;
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }

        .no-results {
            text-align: center;
            padding: 4rem 0;
            color: #666;
        }

        .no-results i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Image Popup Styles */
        .image-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .image-popup.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .image-popup-content {
            position: relative;
            width: 400px;
            height: 600px;
            max-width: 90vw;
            max-height: 80vh;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            transform: scale(0.9) translateY(20px);
            transition: all 0.2s ease;
            background: white;
        }

        .image-popup.active .image-popup-content {
            transform: scale(1) translateY(0);
        }

        .image-popup-content img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .image-popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #333;
            transition: all 0.3s ease;
            z-index: 10001;
        }

        .image-popup-close:hover {
            background: white;
            transform: scale(1.1);
        }

        .image-popup-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 3rem 2rem 1.5rem;
            text-align: center;
        }

        .image-popup-title h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .image-popup-title p {
            font-size: 1rem;
            margin: 0;
            opacity: 0.9;
        }

        /* Hover indicator */
        .tenant-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .tenant-image:hover::after {
            opacity: 1;
        }

        .tenant-image::before {
            content: 'Klik untuk melihat';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.2s ease;
            z-index: 2;
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .tenant-image:hover::before {
            opacity: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .image-popup-content {
                width: 300px;
                height: 450px;
                max-width: 85vw;
                max-height: 70vh;
            }

            .image-popup-title {
                padding: 1.5rem 1rem 1rem;
            }

            .image-popup-title h3 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .image-popup-content {
                width: 280px;
                height: 400px;
                max-width: 90vw;
                max-height: 65vh;
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
                    <li class="nav-item"><a class="nav-link fw-semibold" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="tentang.php">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold active" href="tenant.php">Tenant</a></li>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Tenant Kuliner</h1>
            <p class="fs-5 mb-4">Temukan berbagai pilihan kuliner lezat dari tenant-tenant terbaik di SWK Semolowaru</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number"><?= $totalTenants ?>+</div>
                        <div class="stat-label">Tenant Kuliner</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number"><?= count($uniqueCategories) ?>+</div>
                        <div class="stat-label">Kategori Makanan</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Pengunjung Harian</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <section class="filter-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- Search Box -->
                    <div class="search-box">
                        <input type="text" class="form-control" id="searchTenant" placeholder="Cari tenant favorit Anda...">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tenant List Section -->
    <section class="py-5">
        <div class="container">
            <div id="tenantContainer">
                <?php if (!empty($tenants)): ?>
                    <div class="row g-4" id="tenantList">
                        <?php foreach ($tenants as $tenant): ?>
                            <div class="col-lg-4 col-md-6 tenant-item" data-category="<?= htmlspecialchars($tenant['range_harga']) ?>" data-name="<?= htmlspecialchars(strtolower($tenant['nama_tenan'])) ?>">
                                <div class="card tenant-card">
                                    <div class="tenant-image"
                                        <?php if (!empty($tenant['foto_url'])): ?>
                                        onclick="openImagePopup('<?= htmlspecialchars('images/tenan/' . $tenant['foto_url']) ?>', '<?= htmlspecialchars($tenant['nama_tenan']) ?>', '<?= htmlspecialchars($tenant['range_harga']) ?>')"
                                        <?php endif; ?>>
                                        <?php if (!empty($tenant['foto_url'])): ?>
                                            <img src="<?= htmlspecialchars('images/tenan/' . $tenant['foto_url']) ?>" alt="<?= htmlspecialchars($tenant['nama_tenan']) ?>">
                                        <?php else: ?>
                                            <div class="image-placeholder">
                                                <i class="fas fa-store"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="tenant-body">
                                        <h5 class="tenant-title"><?= htmlspecialchars($tenant['nama_tenan']) ?></h5>

                                        <div class="tenant-price">
                                            <i class="fas fa-utensils me-2"></i>
                                            <?= htmlspecialchars($tenant['range_harga']) ?>
                                        </div>

                                        <?php if (!empty($tenant['menu'])): ?>
                                            <div class="mt-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-list me-1"></i>
                                                    <strong>Menu:</strong> <?= htmlspecialchars($tenant['menu']) ?>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-store-slash"></i>
                        <h4>Belum Ada Tenant</h4>
                        <p>Tenant kuliner akan segera hadir. Silakan cek kembali nanti!</p>
                    </div>
                <?php endif; ?>

                <!-- No Results Message (Hidden by default) -->
                <div id="noResults" class="no-results" style="display: none;">
                    <i class="fas fa-search"></i>
                    <h4>Tidak Ada Hasil</h4>
                    <p>Tidak ditemukan tenant yang sesuai dengan pencarian Anda. Coba kata kunci lain atau pilih kategori yang berbeda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Popup -->
    <div class="image-popup" id="imagePopup">
        <div class="image-popup-content">
            <button class="image-popup-close" onclick="closeImagePopup()">
                <i class="fas fa-times"></i>
            </button>
            <img id="popupImage" src="" alt="">
            <div class="image-popup-title">
                <h3 id="popupTitle"></h3>
                <p id="popupSubtitle"></p>
            </div>
        </div>
    </div>

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
    <a href="https://wa.me/<?= str_replace(['+', '-', ' '], '', htmlspecialchars($siteInfo['phone'])) ?>" class="floating-whatsapp" target="_blank" title="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tenantItems = document.querySelectorAll('.tenant-item');
            const searchInput = document.getElementById('searchTenant');
            const noResults = document.getElementById('noResults');
            const tenantList = document.getElementById('tenantList');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                tenantItems.forEach(item => {
                    const itemName = item.dataset.name;

                    if (itemName.includes(searchTerm)) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0) {
                    tenantList.style.display = 'none';
                    noResults.style.display = 'block';
                } else {
                    tenantList.style.display = 'flex';
                    noResults.style.display = 'none';
                }
            });
        });

        // Image popup functionality
        function openImagePopup(imageSrc, title, subtitle) {
            const popup = document.getElementById('imagePopup');
            const popupImage = document.getElementById('popupImage');
            const popupTitle = document.getElementById('popupTitle');
            const popupSubtitle = document.getElementById('popupSubtitle');

            popupImage.src = imageSrc;
            popupImage.alt = title;
            popupTitle.textContent = title;
            popupSubtitle.textContent = subtitle;

            popup.classList.add('active');
        }


        function closeImagePopup() {
            const popup = document.getElementById('imagePopup');
            popup.classList.remove('active');
        }

        // Close popup with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                clearTimeout(hoverTimeout);
                const popup = document.getElementById('imagePopup');
                popup.classList.remove('active');
            }
        });
    </script>
</body>

</html>