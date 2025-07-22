<?php
// Include connection.php untuk mendapatkan data dari database
require_once 'connection.php';

// Perbaikan 1: Tambahkan error handling untuk database connection
if (!isset($pdo) || !$pdo) {
    die("Database connection failed. Please check your connection settings.");
}

// Perbaikan 2: Ambil data statistik dari database dengan handling yang lebih baik
try {
    // PERBAIKAN: Gunakan query yang lebih robust untuk menghitung tenant aktif
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenan WHERE status = 'aktif' OR status = 'active'");
    $stmt->execute();
    $jumlahTenant = $stmt->fetchColumn();

    // Jika tidak ada tenant aktif, coba cari dengan kondisi lain
    if (!$jumlahTenant || $jumlahTenant == 0) {
        // Coba dengan status yang berbeda
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenan WHERE status != 'nonaktif' AND status != 'inactive' AND status != 'tutup'");
        $stmt->execute();
        $jumlahTenant = $stmt->fetchColumn();
    }

    // Jika masih tidak ada, hitung semua tenant yang ada
    if (!$jumlahTenant || $jumlahTenant == 0) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenan");
        $stmt->execute();
        $jumlahTenant = $stmt->fetchColumn();
    }

    // Pastikan jumlah tenant minimal 1 untuk tampilan yang baik
    if (!$jumlahTenant || $jumlahTenant == 0) {
        $jumlahTenant = 20; // Default fallback
    }

    // PERBAIKAN: Ambil data fasilitas utama dari database
    $fasilitasUtama = [];
    try {
        $stmt = $pdo->prepare("SELECT * FROM fasilitas_utama ORDER BY title ASC LIMIT 6");
        $stmt->execute();
        $fasilitasUtama = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Jika tabel fasilitas_utama tidak ada, coba table fasilitas
        try {
            $stmt = $pdo->prepare("SELECT * FROM fasilitas WHERE status = 'aktif' ORDER BY urutan ASC LIMIT 6");
            $stmt->execute();
            $fasilitasUtama = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Jika kedua tabel tidak ada, gunakan array kosong
            $fasilitasUtama = [];
        }
    }

    // PERBAIKAN: Ambil data fasilitas dengan fitur dari database
    $fasilitasWithFitur = [];
    try {
        $stmt = $pdo->prepare("
            SELECT 
                fu.id,
                fu.title,
                fu.description,
                fu.icon,
                fu.color,
                GROUP_CONCAT(ff.fitur ORDER BY ff.fitur ASC SEPARATOR '|') as fitur_list
            FROM fasilitas_utama fu
            LEFT JOIN fitur_fasilitas ff ON fu.id = ff.fasilitas_id
            GROUP BY fu.id, fu.title, fu.description, fu.icon, fu.color
            ORDER BY fu.title ASC
        ");
        $stmt->execute();
        $fasilitasWithFitur = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process fitur_list into array
        foreach ($fasilitasWithFitur as &$fasilitas) {
            if (!empty($fasilitas['fitur_list'])) {
                $fasilitas['fitur_array'] = explode('|', $fasilitas['fitur_list']);
            } else {
                $fasilitas['fitur_array'] = [];
            }
        }
    } catch (PDOException $e) {
        $fasilitasWithFitur = [];
    }


    // PERBAIKAN: Ambil site info dari database
    $siteInfo = [
        'name' => 'Semolowaru Food Court',
        'full_name' => 'Semolowaru Food Court',
        'address' => 'Jl. Semolowaru Utara No. 1, Surabaya',
        'phone' => '+6282233914519',
        'instagram' => '@semolowaru_foodcourt',
        'rating' => 4.5,
        'reviews' => 150
    ];

    // Coba ambil dari database jika ada
    try {
        $stmt = $pdo->prepare("SELECT * FROM site_info LIMIT 1");
        $stmt->execute();
        $siteInfoDB = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($siteInfoDB) {
            $siteInfo = array_merge($siteInfo, $siteInfoDB);
        }
    } catch (PDOException $e) {
        // Gunakan default jika tabel tidak ada
    }
} catch (PDOException $e) {
    // Jika ada error, gunakan nilai default
    $jumlahTenant = 20;
    $fasilitasUtama = [];
    $fasilitasWithFitur = [];

    // Log error untuk debugging
    error_log("Database query failed in tentang.php: " . $e->getMessage());
}

// PERBAIKAN: Pastikan semua variabel yang diperlukan ada
if (!isset($jumlahTenant)) $jumlahTenant = 20;
if (!isset($fasilitasUtama)) $fasilitasUtama = [];
if (!isset($fasilitasWithFitur)) $fasilitasWithFitur = [];

// Data values tetap hardcoded karena ini adalah nilai-nilai perusahaan
$values = [
    [
        'icon' => 'fas fa-heart',
        'title' => 'Kualitas Terjamin',
        'description' => 'Kami berkomitmen menyajikan makanan berkualitas tinggi dengan standar higienis yang ketat dari setiap tenant.'
    ],
    [
        'icon' => 'fas fa-users',
        'title' => 'Kebersamaan',
        'description' => 'Menciptakan ruang yang nyaman untuk berkumpul bersama keluarga, teman, dan komunitas lokal.'
    ],
    [
        'icon' => 'fas fa-leaf',
        'title' => 'Ramah Lingkungan',
        'description' => 'Menerapkan konsep outdoor yang hijau dengan penataan taman dan penggunaan material ramah lingkungan.'
    ],
    [
        'icon' => 'fas fa-handshake',
        'title' => 'Mendukung UMKM',
        'description' => 'Memberikan platform bagi pelaku usaha kuliner lokal untuk berkembang dan meraih kesuksesan.'
    ]
];



// Terapkan validasi
$jumlahTenant = max(1, (int)$jumlahTenant); // Minimal 1 tenant

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - <?= htmlspecialchars($siteInfo['name']) ?></title>
    <link rel="icon" type="image/png" href="images/logo/Logo Semolowaru-01.png">
    <meta name="description" content="Pelajari lebih lanjut tentang <?= htmlspecialchars($siteInfo['full_name']) ?> - sejarah, visi misi, dan komitmen kami untuk menyajikan pengalaman kuliner terbaik di Surabaya.">

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
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold active" href="tentang.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="tenant.php">Tenant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="fasilitas.php">Fasilitas</a>
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
    <section class="hero-section" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); min-height: 60vh;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">Tentang <?= htmlspecialchars($siteInfo['name']) ?></h1>
                        <p class="hero-subtitle">Mengenal lebih dekat perjalanan kami dalam menghadirkan destinasi kuliner terbaik di Surabaya</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <div class="bg-white rounded-4 p-4 shadow-lg" style="display: inline-block;">
                            <i class="fas fa-utensils display-1" style="color: var(--primary-color);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Overview Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-image">
                        <div class="bg-light rounded-4 overflow-hidden" style="min-height: 400px; height: 100%; background: linear-gradient(45deg, #f8f9fa, #e9ecef);">
                            <img src="images/foto-utama.jpg" alt="Foto Utama <?= htmlspecialchars($siteInfo['name']) ?>"
                                class="img-fluid w-100 h-100"
                                style="object-fit: cover;">
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="section-title text-start">Tentang SWK Semolowaru</h2>
                        <p class="fs-5 text-muted mb-4">
                            <?= htmlspecialchars($siteInfo['full_name']) ?> hadir sebagai jawaban atas kebutuhan masyarakat Surabaya akan tempat kuliner yang nyaman, terjangkau, dan beragam.
                        </p>

                        <p class="mb-4">
                            Berlokasi strategis di <?= htmlspecialchars($siteInfo['address']) ?>, <?= htmlspecialchars($siteInfo['name']) ?> menghadirkan pengalaman kuliner yang berbeda dengan menggabungkan cita rasa tradisional dan modern dalam satu tempat.
                        </p>

                        <a href="#visi-misi" class="btn btn-custom">
                            <i class="fas fa-arrow-down me-2"></i>Pelajari Visi & Misi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle p-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-store fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-primary"><?= formatNumber($jumlahTenant) ?>+</h3>
                        <p class="text-muted mb-0">Tenant Kuliner</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-success text-white rounded-circle p-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-clock fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-success"><?= $operationalData['hours'] ?></h3>
                        <p class="text-muted mb-0">Jam Operasional</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-warning text-white rounded-circle p-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-map-marker-alt fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-warning">3500 m&sup2;</h3>
                        <p class="text-muted mb-0">Area Outdoor</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="text-center">
                        <div class="bg-info text-white rounded-circle p-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-users fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-info"><?= $operationalData['capacity'] ?></h3>
                        <p class="text-muted mb-0">Kapasitas Pengunjung</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Operating Hours Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Jam Operasional</h2>
                <p class="fs-5 text-muted">Jadwal buka setiap hari untuk melayani Anda</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <?php if (!empty($operatingHours) && is_array($operatingHours)): ?>
                                <div class="row">
                                    <?php foreach ($operatingHours as $hour): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                                <div>
                                                    <h6 class="mb-0 fw-bold"><?= htmlspecialchars($hour['day_name'] ?? 'Hari') ?></h6>
                                                </div>
                                                <div class="text-end">
                                                    <?php if (isset($hour['is_open']) && $hour['is_open'] == 1): ?>
                                                        <span class="badge bg-success me-2">Buka</span>
                                                        <span class="text-muted">
                                                            <?= htmlspecialchars($hour['open_time'] ?? '17:00') ?> -
                                                            <?= htmlspecialchars($hour['close_time'] ?? '24:00') ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Tutup</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <!-- Default operating hours jika data tidak tersedia -->
                                <div class="text-center py-4">
                                    <i class="fas fa-clock fs-1 text-primary mb-3"></i>
                                    <h5 class="text-primary mb-3">Jam Operasional</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="bg-light p-3 rounded mb-3">
                                                <h6 class="mb-2">Senin - Kamis</h6>
                                                <span class="badge bg-success me-2">Buka</span>
                                                <span class="text-muted">17:00 - 23:00</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-light p-3 rounded mb-3">
                                                <h6 class="mb-2">Jumat - Minggu</h6>
                                                <span class="badge bg-success me-2">Buka</span>
                                                <span class="text-muted">17:00 - 23:00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-0">Untuk informasi terbaru, silakan hubungi kami</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section id="visi-misi" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Visi & Misi Kami</h2>
                <p class="fs-5 text-muted">Komitmen kami dalam menghadirkan pengalaman kuliner terbaik</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <i class="fas fa-eye display-4 text-primary"></i>
                            </div>
                            <h3 class="fw-bold mb-4">Visi</h3>
                            <p class="fs-5 text-muted">
                                Menjadi destinasi kuliner outdoor terdepan di Surabaya yang menghadirkan
                                pengalaman berkuliner yang berkesan, nyaman, dan terjangkau untuk semua kalangan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <i class="fas fa-bullseye display-4 text-primary"></i>
                            </div>
                            <h3 class="fw-bold mb-4">Misi</h3>
                            <ul class="list-unstyled fs-5 text-muted text-start">
                                <li class="mb-3"><i class="fas fa-check text-primary me-2"></i>Menyediakan platform bagi UMKM kuliner lokal</li>
                                <li class="mb-3"><i class="fas fa-check text-primary me-2"></i>Menghadirkan suasana kuliner yang nyaman dan higienis</li>
                                <li class="mb-3"><i class="fas fa-check text-primary me-2"></i>Memberikan hiburan dan fasilitas pendukung</li>
                                <li class="mb-0"><i class="fas fa-check text-primary me-2"></i>Membangun komunitas pecinta kuliner</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Nilai-Nilai Kami</h2>
                <p class="fs-5 text-muted">Prinsip yang menjadi fondasi dalam setiap layanan kami</p>
            </div>

            <div class="row g-4">
                <?php foreach ($values as $value): ?>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start">
                                    <div class="me-4">
                                        <div class="bg-primary rounded-circle p-3 text-white">
                                            <i class="<?= $value['icon'] ?> fs-4"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-3"><?= $value['title'] ?></h4>
                                        <p class="text-muted mb-0"><?= $value['description'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Facilities Section - Data dari Database -->
    <?php if (!empty($fasilitasWithFitur)): ?>
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Fasilitas Unggulan</h2>
                    <p class="fs-5 text-muted">Fasilitas lengkap untuk kenyamanan pengunjung</p>
                </div>

                <div class="row g-4">
                    <?php foreach ($fasilitasWithFitur as $fasilitas): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <div class="bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="<?= htmlspecialchars($fasilitas['icon']) ?> fs-2 <?= getColorClass($fasilitas['color']) ?>"></i>
                                        </div>
                                    </div>
                                    <h5 class="fw-bold text-center mb-3"><?= htmlspecialchars($fasilitas['title']) ?></h5>
                                    <p class="text-muted text-center mb-3"><?= htmlspecialchars($fasilitas['description']) ?></p>

                                    <?php if (!empty($fasilitas['fitur_array'])): ?>
                                        <ul class="list-unstyled">
                                            <?php foreach ($fasilitas['fitur_array'] as $fitur): ?>
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    <small class="text-muted"><?= htmlspecialchars($fitur) ?></small>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-5">
                    <a href="fasilitas.php" class="btn btn-custom btn-lg">
                        <i class="fas fa-th-large me-2"></i>Lihat Semua Fasilitas
                    </a>
                </div>
            </div>
        </section>
    <?php elseif (!empty($fasilitasUtama)): ?>
        <!-- Fallback jika fasilitasWithFitur kosong tapi fasilitasUtama ada -->
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Fasilitas Unggulan</h2>
                    <p class="fs-5 text-muted">Fasilitas lengkap untuk kenyamanan pengunjung</p>
                </div>

                <div class="row g-4">
                    <?php
                    $facilitiesShown = array_slice($fasilitasUtama, 0, 6);
                    foreach ($facilitiesShown as $fasilitas):
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4 text-center">
                                    <div class="mb-3">
                                        <i class="<?= htmlspecialchars($fasilitas['icon']) ?> display-4" style="color: var(--primary-color);"></i>
                                    </div>
                                    <h5 class="fw-bold mb-3"><?= htmlspecialchars($fasilitas['title']) ?></h5>
                                    <p class="text-muted mb-0"><?= htmlspecialchars($fasilitas['description']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-5">
                    <a href="fasilitas.php" class="btn btn-custom btn-lg">
                        <i class="fas fa-th-large me-2"></i>Lihat Semua Fasilitas
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Gallery Preview -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Suasana <?= htmlspecialchars($siteInfo['name']) ?></h2>
                <p class="fs-5 text-muted">Lihat suasana outdoor yang nyaman dan fasilitas lengkap kami</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <div class="bg-white rounded-4 p-4 text-center shadow-sm" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                            <div>
                                <i class="fas fa-utensils display-4 text-primary mb-3"></i>
                                <h5>Area Kuliner</h5>
                                <p class="text-muted mb-0"><?= formatNumber($jumlahTenant) ?>+ tenant beragam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <div class="bg-white rounded-4 p-4 text-center shadow-sm" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                            <div>
                                <i class="fas fa-music display-4 text-warning mb-3"></i>
                                <h5>Live Music</h5>
                                <p class="text-muted mb-0">Hiburan setiap malam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <div class="bg-white rounded-4 p-4 text-center shadow-sm" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                            <div>
                                <i class="fas fa-star display-4 text-success mb-3"></i>
                                <h5>Rating Tinggi</h5>
                                <p class="text-muted mb-0">
                                    <?= number_format($siteInfo['rating'] ?? 4.5, 1) ?>/5
                                    dari <?= formatNumber($siteInfo['reviews'] ?? 150) ?> ulasan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="galeri.php" class="btn btn-custom btn-lg">
                    <i class="fas fa-images me-2"></i>Lihat Galeri Lengkap
                </a>
            </div>
        </div>
    </section>


    <!-- Contact Preview -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="fs-5 text-muted">Dapatkan informasi lebih lanjut tentang <?= htmlspecialchars($siteInfo['name']) ?></p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-map-marker-alt display-5 text-primary"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Lokasi</h5>
                            <p class="text-muted"><?= htmlspecialchars($siteInfo['address']) ?></p>
                            <a href="https://maps.app.goo.gl/BaHAs5VQsMKqDSKFA" class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fas fa-directions me-1"></i> Petunjuk Arah
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-phone display-5 text-success"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Telepon</h5>
                            <p class="text-muted"><?= htmlspecialchars($siteInfo['phone']) ?></p>
                            <a href="tel:<?= htmlspecialchars($siteInfo['phone']) ?>" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-phone me-1"></i> Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="fab fa-instagram display-5 text-danger"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Instagram</h5>
                            <p class="text-muted"><?= htmlspecialchars($siteInfo['instagram']) ?></p>
                            <a href="https://www.instagram.com/<?= substr($siteInfo['instagram'], 1) ?>/" class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="fab fa-instagram me-1"></i> Follow Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="kontak.php" class="btn btn-custom btn-lg">
                    <i class="fas fa-envelope me-2"></i>Kontak Lengkap
                </a>
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

    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-custom position-fixed bottom-0 end-0 m-4 rounded-circle" style="width: 50px; height: 50px; display: none; z-index: 1000;">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

</body>

</html>