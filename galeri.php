<?php
// Koneksi ke database
require_once 'connection.php';

// Siapkan data categories untuk filter
$categories = ['Semua']; // Mulai dengan 'Semua'
$categories = array_merge($categories, $uniqueGalleryCategories);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - <?= htmlspecialchars($siteInfo['name']) ?></title>
    <meta name="description" content="Galeri foto kegiatan dan suasana di Sentra Wisata Kuliner Semolowaru - Lihat momen-momen indah pengunjung kami">
    <link rel="icon" type="image/png" href="images/logo/Logo Semolowaru-01.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
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
                    <li class="nav-item"><a class="nav-link fw-semibold" href="tenant.php">Tenant</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="fasilitas.php">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold active" href="galeri.php">Galeri</a></li>
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

    <!-- Gallery Hero Section -->
    <section class="facilities-hero" style="min-height: 80vh">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Galeri Kegiatan</h1>
                <p class="hero-subtitle">Lihat momen-momen indah dan keseruan aktivitas di SWK Semolowaru</p>
                <div class="mt-4">
                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-images me-2"></i><?= $totalGalleryItems ?> Foto Tersedia
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Filter Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-3">Filter Kategori</h3>
                        <div class="gallery-filter-buttons">
                            <?php foreach ($categories as $index => $category): ?>
                                <button class="btn btn-outline-primary me-2 mb-2 filter-btn <?= $index === 0 ? 'active' : '' ?>"
                                    data-filter="<?= $category === 'Semua' ? 'all' : strtolower($category) ?>">
                                    <?= htmlspecialchars($category) ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Grid Section -->
    <section class="py-5">
        <div class="container">
            <?php if (!empty($galleryItems)): ?>
                <div class="row g-4" id="galleryGrid">
                    <?php foreach ($galleryItems as $image): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 gallery-item" data-category="<?= strtolower($image['category']) ?>">
                            <div class="gallery-card">
                                <div class="gallery-image-container">
                                    <?php if (!empty($image['image_url'])): ?>
                                        <img src="<?= getGalleryImagePath($image['image_url']) ?>"
                                            alt="<?= formatGalleryAlt($image['title'], $image['category']) ?>"
                                            class="gallery-image-real">
                                    <?php else: ?>
                                        <div class="gallery-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <h5><?= htmlspecialchars($image['title']) ?></h5>
                                            <p><?= htmlspecialchars($image['description']) ?></p>
                                            <button class="btn btn-light btn-sm" onclick="openLightbox(<?= $image['id'] ?>)">
                                                <i class="fas fa-expand-alt me-1"></i>Lihat Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery-info">
                                    <h6 class="gallery-title"><?= htmlspecialchars($image['title']) ?></h6>
                                    <p class="gallery-description"><?= htmlspecialchars($image['description']) ?></p>
                                    <span class="gallery-category"><?= htmlspecialchars($image['category']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-images fs-1 text-muted mb-3"></i>
                            <h3 class="text-muted">Belum ada foto galeri</h3>
                            <p class="text-muted">Foto-foto kegiatan akan segera ditampilkan di sini.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Gallery Stats Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <i class="fas fa-camera fs-1 mb-3"></i>
                        <h3 class="fw-bold"><?= $totalGalleryItems ?>+</h3>
                        <p>Foto Kegiatan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <i class="fas fa-users fs-1 mb-3"></i>
                        <h3 class="fw-bold">1000+</h3>
                        <p>Momen Bahagia</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <i class="fas fa-heart fs-1 mb-3"></i>
                        <h3 class="fw-bold">500+</h3>
                        <p>Kenangan Indah</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <i class="fas fa-star fs-1 mb-3"></i>
                        <h3 class="fw-bold"><?= htmlspecialchars($siteInfo['rating']) ?></h3>
                        <p>Rating Pengunjung</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Share Your Moment Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-3">Bagikan Momen Anda!</h3>
                    <p class="fs-5 mb-4">Tag <?= htmlspecialchars($siteInfo['instagram']) ?> di Instagram dan gunakan hashtag #SWKSemolowaru untuk berbagi momen indah Anda bersama kami.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="https://www.instagram.com/<?= substr(htmlspecialchars($siteInfo['instagram']), 1) ?>/" class="btn btn-primary btn-lg" target="_blank">
                        <i class="fab fa-instagram me-2"></i>Follow Instagram
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-labelledby="lightboxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lightboxModalLabel">Detail Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3" id="lightboxImageContainer" style="min-height: 300px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                        <i class="fas fa-image fs-1 text-primary" style="opacity: 0.5;"></i>
                    </div>
                    <div class="mt-3">
                        <h4 id="lightboxTitle" class="mb-2"></h4>
                        <p id="lightboxDescription" class="text-muted mb-3"></p>
                        <span id="lightboxCategory" class="badge bg-primary"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="shareToInstagram()">
                        <i class="fab fa-instagram me-1"></i>Share ke Instagram
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <script src="script.js"></script>

    <script>
        // Gallery filtering functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const filter = this.getAttribute('data-filter');

                    galleryItems.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-category') === filter) {
                            item.style.display = 'block';
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'scale(1)';
                            }, 100);
                        } else {
                            item.style.opacity = '0';
                            item.style.transform = 'scale(0.8)';
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Initialize gallery items animation
            galleryItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.5s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Lightbox functionality
        const galleryData = <?= json_encode($galleryItems) ?>;

        // Perbaikan JavaScript untuk Lightbox functionality
        function openLightbox(imageId) {
            const image = galleryData.find(img => img.id === imageId);
            if (image) {
                document.getElementById('lightboxTitle').textContent = image.title;
                document.getElementById('lightboxDescription').textContent = image.description;
                document.getElementById('lightboxCategory').textContent = image.category;

                // Update lightbox image dengan container yang lebih baik
                const lightboxContainer = document.getElementById('lightboxImageContainer');

                if (image.image_url) {
                    const imagePath = getGalleryImagePath(image.image_url);
                    lightboxContainer.innerHTML = `
                <div class="lightbox-image-container">
                    <img src="${imagePath}" 
                         alt="${image.title}" 
                         class="img-fluid" 
                         style="max-width: 100%; height: auto; max-height: 500px; object-fit: contain; border-radius: 10px;"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\\'lightbox-image\\' style=\\'height: 300px;\\' ><i class=\\'fas fa-image fs-1 text-primary\\' ></i></div>';">
                </div>
            `;
                } else {
                    lightboxContainer.innerHTML = `
                <div class="lightbox-image" style="height: 300px;">
                    <i class="fas fa-image fs-1 text-primary"></i>
                </div>
            `;
                }

                // Inisialisasi dan tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
                modal.show();
            }
        }

        // Fungsi untuk menyesuaikan ukuran gambar setelah load
        function adjustImageSize() {
            const modal = document.getElementById('lightboxModal');
            const images = modal.querySelectorAll('img');

            images.forEach(img => {
                img.onload = function() {
                    const maxHeight = window.innerHeight * 0.6; // 60% dari tinggi viewport
                    const maxWidth = modal.querySelector('.modal-dialog').offsetWidth - 100;

                    if (this.naturalHeight > maxHeight) {
                        this.style.height = maxHeight + 'px';
                        this.style.width = 'auto';
                    }

                    if (this.offsetWidth > maxWidth) {
                        this.style.width = maxWidth + 'px';
                        this.style.height = 'auto';
                    }
                };
            });
        }

        // Event listener untuk modal
        document.getElementById('lightboxModal').addEventListener('shown.bs.modal', function() {
            adjustImageSize();
        });

        // Responsive handling untuk window resize
        window.addEventListener('resize', function() {
            if (document.getElementById('lightboxModal').classList.contains('show')) {
                adjustImageSize();
            }
        });

        function shareToInstagram() {
            window.open('https://www.instagram.com/<?= substr(htmlspecialchars($siteInfo['instagram']), 1) ?>/', '_blank');
        }

        // Helper function for JavaScript
        function getGalleryImagePath(imageUrl) {
            if (!imageUrl) return 'images/default-gallery.jpg';
            if (imageUrl.indexOf('images/') === 0) return imageUrl;
            return 'images/gallery/' + imageUrl;
        }
    </script>

    <style>
        /* Gallery specific styles */
        .gallery-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .gallery-image-container {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .gallery-image {
            height: 100%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .gallery-image-real {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-card:hover .gallery-image-real {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay-content {
            text-align: center;
            color: white;
            padding: 20px;
        }

        .gallery-overlay-content h5 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .gallery-overlay-content p {
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .gallery-info {
            padding: 20px;
        }

        .gallery-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .gallery-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .gallery-category {
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .gallery-filter-buttons .filter-btn {
            transition: all 0.3s ease;
        }

        .gallery-filter-buttons .filter-btn.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .gallery-filter-buttons .filter-btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Perbaikan CSS untuk Lightbox Modal */
        .lightbox-image {
            min-height: 300px;
            max-height: 500px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .lightbox-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            max-height: 500px;
            border-radius: 10px;
        }

        /* Perbaikan untuk modal size */
        .modal-lg {
            max-width: 800px;
        }

        .modal-dialog-centered {
            min-height: calc(100vh - 60px);
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .lightbox-image {
                min-height: 250px;
                max-height: 400px;
            }

            .modal-lg {
                max-width: 95%;
                margin: 10px auto;
            }
        }

        @media (max-width: 576px) {
            .lightbox-image {
                min-height: 200px;
                max-height: 300px;
            }

            .modal-dialog {
                margin: 5px;
            }
        }

        /* Perbaikan untuk container gambar */
        .lightbox-image-container {
            width: 100%;
            height: auto;
            position: relative;
            background: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
        }

        .lightbox-image-container img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        /* Untuk icon default jika tidak ada gambar */
        .lightbox-image-container .fas {
            font-size: 4rem;
            color: var(--primary-color);
            opacity: 0.5;
        }

        .gallery-item {
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {

            .gallery-image,
            .gallery-image-real {
                height: 200px;
            }

            .gallery-image {
                font-size: 2.5rem;
            }

            .gallery-info {
                padding: 15px;
            }
        }

        .stat-box {
            text-align: center;
            padding: 30px 20px;
            border-radius: 15px;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .stat-box:hover {
            transform: translateY(-10px);
        }
    </style>

</body>

</html>