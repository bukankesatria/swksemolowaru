<?php
// Koneksi ke database
require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - <?= htmlspecialchars($siteInfo['name']) ?></title>
    <meta name="description" content="Hubungi <?= htmlspecialchars($siteInfo['full_name']) ?> untuk informasi lebih lanjut, reservasi, atau kerjasama. Lokasi strategis di <?= htmlspecialchars($siteInfo['address']) ?>.">
    <link rel="icon" type="image/png" href="images/logo/Logo Semolowaru-01.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Contact Page Custom Styles -->
    <style>
        /* === CONTACT PAGE STYLES COMPLETION === */

        /* Contact Hero Section */
        .contact-hero {
            height: 80vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23ff6b35" width="1200" height="600"/><circle fill="%23f39c12" cx="200" cy="150" r="40" opacity="0.3"/><circle fill="%23e74c3c" cx="600" cy="250" r="60" opacity="0.2"/><circle fill="%23f1c40f" cx="1000" cy="400" r="50" opacity="0.3"/></svg>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            position: relative;
        }

        .contact-hero .hero-content {
            color: white;
            text-align: center;
            animation: fadeInUp 1s ease;
        }

        .contact-hero .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .contact-hero .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        /* Contact Info Cards */
        .contact-info-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .contact-info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .contact-info-card:hover::before {
            left: 100%;
        }

        .contact-info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .contact-icon {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .contact-info-card:hover .contact-icon {
            transform: scale(1.1);
            color: var(--accent-color);
        }

        /* Contact Form */
        .contact-form {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .contact-form::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border-radius: 22px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .contact-form:hover::before {
            opacity: 1;
        }

        .contact-form .form-control,
        .contact-form .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .contact-form .form-control:focus,
        .contact-form .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
            background: white;
            transform: translateY(-2px);
        }

        .contact-form .form-label {
            color: var(--secondary-color);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .contact-form .form-control::placeholder {
            color: #adb5bd;
        }

        /* Map Container */
        .map-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .map-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .map-container iframe {
            transition: all 0.3s ease;
        }

        .map-container:hover iframe {
            transform: scale(1.02);
        }

        /* Location Info */
        .location-info {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .location-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .location-info div {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .location-info div:hover {
            background: #f8f9fa;
            border-radius: 5px;
            padding-left: 10px;
        }

        .location-info div:last-child {
            border-bottom: none;
        }

        /* Operating Hours Card */
        .operating-hours-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .operating-hours-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.05), rgba(243, 156, 18, 0.05));
            z-index: 1;
        }

        .operating-hours-card>* {
            position: relative;
            z-index: 2;
        }

        .operating-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            animation: pulse 2s infinite;
        }

        .day-schedule {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .day-schedule::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            transition: left 0.5s ease;
        }

        .day-schedule:hover::before {
            left: 100%;
        }

        .day-schedule:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-5px);
            border-color: var(--accent-color);
        }

        .day-schedule:hover .day-hours span {
            color: white !important;
        }

        .day-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .day-hours {
            font-size: 0.9rem;
        }

        /* Quick Contact Cards */
        /* Quick Contact Cards - Perbaikan */
        .quick-contact-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
            /* Tambahkan border dan background yang lebih kontras */
            border: 2px solid #e9ecef;
            min-height: 300px;
            /* Pastikan tinggi minimum */
        }

        .quick-contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Ubah background default agar lebih terlihat */
            background: linear-gradient(135deg, rgba(248, 249, 250, 0.8), rgba(233, 236, 239, 0.8));
            z-index: 1;
            transition: all 0.3s ease;
        }

        .quick-contact-card:hover::before {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(243, 156, 18, 0.1));
        }

        .quick-contact-card>* {
            position: relative;
            z-index: 2;
        }

        .quick-contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .quick-contact-icon {
            font-size: 3.5rem;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            /* Tambahkan shadow untuk icon agar lebih menonjol */
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .quick-contact-card:hover .quick-contact-icon {
            transform: scale(1.1) rotate(5deg);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        /* Perbaiki warna icon dengan kontras yang lebih baik */
        .quick-contact-card:nth-child(1) .quick-contact-icon {
            color: #25d366;
            /* WhatsApp green */
        }

        .quick-contact-card:nth-child(2) .quick-contact-icon {
            color: #007bff;
            /* Email blue */
        }

        .quick-contact-card:nth-child(3) .quick-contact-icon {
            color: #ff6b35;
            /* Primary color untuk reservasi */
        }

        /* Tambahkan styling untuk judul dan deskripsi */
        .quick-contact-card h5 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .quick-contact-card p {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .quick-contact-card:hover h5 {
            color: var(--primary-color);
        }

        .quick-contact-card:hover p {
            color: #495057;
        }

        /* Perbaikan untuk section container */
        .py-5 {
            padding-top: 4rem !important;
            padding-bottom: 4rem !important;
        }

        /* Pastikan row tidak terpotong */
        .quick-contact-card .row {
            margin: 0;
        }

        .quick-contact-card .col-lg-4 {
            margin-bottom: 2rem;
        }

        /* Responsive fixes */
        @media (max-width: 768px) {
            .quick-contact-card {
                padding: 30px 20px;
                margin-bottom: 30px;
                min-height: 280px;
            }

            .quick-contact-icon {
                font-size: 2.8rem;
                margin-bottom: 20px;
            }

            .quick-contact-card h5 {
                font-size: 1.2rem;
            }

            .quick-contact-card p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .quick-contact-card {
                padding: 25px 15px;
                min-height: 260px;
            }

            .quick-contact-icon {
                font-size: 2.5rem;
            }

            .quick-contact-card h5 {
                font-size: 1.1rem;
            }

            .quick-contact-card p {
                font-size: 0.85rem;
            }
        }

        /* Tambahan untuk memastikan spacing yang tepat */
        .container .row.g-4 {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1.5rem;
        }

        /* Perbaikan untuk button styling */
        .quick-contact-card .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .quick-contact-card .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .quick-contact-card .btn:hover::before {
            left: 100%;
        }

        .quick-contact-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Spesifik untuk warna button */
        .quick-contact-card .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .quick-contact-card .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .quick-contact-card .btn-custom {
            background: linear-gradient(135deg, #ff6b35, #f39c12);
            color: white;
        }

        /* Dark mode support untuk quick contact */
        @media (prefers-color-scheme: dark) {
            .quick-contact-card {
                background: #2c3e50;
                color: white;
                border-color: #4a5568;
            }

            .quick-contact-card::before {
                background: linear-gradient(135deg, rgba(44, 62, 80, 0.9), rgba(74, 85, 104, 0.9));
            }

            .quick-contact-card h5 {
                color: #e2e8f0;
            }

            .quick-contact-card p {
                color: #a0aec0;
            }

            .quick-contact-card:hover h5 {
                color: #ff6b35;
            }

            .quick-contact-card:hover p {
                color: #cbd5e0;
            }
        }

        /* Perbaikan tambahan untuk mencegah terpotong */
        .quick-contact-section {
            overflow: visible;
            padding: 80px 0;
        }

        .quick-contact-section .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Animasi entrance untuk cards */
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

        .quick-contact-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .quick-contact-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .quick-contact-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .quick-contact-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        /* Form Animation */
        .contact-form .form-control,
        .contact-form .form-select {
            position: relative;
        }

        .contact-form .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .contact-form .form-label {
            position: relative;
            transition: all 0.3s ease;
        }

        .contact-form .form-control:focus+.form-label,
        .contact-form .form-select:focus+.form-label {
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Success Message Animation */
        .success-message {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            margin-top: 20px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .success-message.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Loading Button Animation */
        .btn-loading {
            position: relative;
            overflow: hidden;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            opacity: 0;
        }

        .btn-loading.loading::after {
            opacity: 1;
        }

        .btn-loading.loading span {
            opacity: 0;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design for Contact Page */
        @media (max-width: 768px) {
            .contact-hero {
                height: 50vh;
            }

            .contact-hero .hero-title {
                font-size: 2.2rem;
            }

            .contact-hero .hero-subtitle {
                font-size: 1rem;
            }

            .contact-info-card {
                padding: 30px 20px;
                margin-bottom: 20px;
            }

            .contact-icon {
                font-size: 2.5rem;
            }

            .contact-form {
                padding: 30px 20px;
            }

            .operating-hours-card {
                padding: 30px 20px;
            }

            .operating-icon {
                font-size: 3rem;
            }

            .quick-contact-card {
                padding: 30px 20px;
                margin-bottom: 20px;
            }

            .quick-contact-icon {
                font-size: 2.5rem;
            }

            .day-schedule {
                padding: 12px;
                margin-bottom: 10px;
            }

            .day-name {
                font-size: 1rem;
            }

            .day-hours {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .contact-hero {
                height: 40vh;
            }

            .contact-hero .hero-title {
                font-size: 1.8rem;
            }

            .contact-hero .hero-subtitle {
                font-size: 0.9rem;
            }

            .contact-info-card {
                padding: 25px 15px;
            }

            .contact-form {
                padding: 25px 15px;
            }

            .operating-hours-card {
                padding: 25px 15px;
            }

            .quick-contact-card {
                padding: 25px 15px;
            }

            .location-info {
                padding: 20px;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {

            .contact-info-card,
            .contact-form,
            .operating-hours-card,
            .quick-contact-card,
            .location-info {
                background: #2c3e50;
                color: white;
            }

            .contact-form .form-control,
            .contact-form .form-select {
                background: #34495e;
                border-color: #4a5568;
                color: white;
            }

            .contact-form .form-control:focus,
            .contact-form .form-select:focus {
                background: #4a5568;
                border-color: var(--primary-color);
            }

            .day-schedule {
                background: #34495e;
                color: white;
            }

            .location-info div {
                border-color: #4a5568;
            }
        }

        /* Print Styles */
        @media print {

            .contact-hero,
            .quick-contact-card,
            .floating-whatsapp {
                display: none !important;
            }

            .contact-info-card,
            .contact-form,
            .operating-hours-card {
                box-shadow: none !important;
                border: 1px solid #ddd;
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
                    <li class="nav-item"><a class="nav-link fw-semibold" href="tenant.php">Tenant</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="fasilitas.php">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="galeri.php">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold active" href="kontak.php">Kontak</a></li>
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

    <!-- Contact Hero Section -->
    <section class="contact-hero" style="min-height: 90vh">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Hubungi Kami</h1>
                <p class="hero-subtitle no-status">Siap melayani Anda dengan informasi lengkap tentang <?= htmlspecialchars($siteInfo['name']) ?></p>
                <div class="rating-badge">
                    <i class="fas fa-star text-warning"></i>
                    <strong><?= htmlspecialchars($siteInfo['rating']) ?>/5</strong>
                    <span class="ms-2">(<?= htmlspecialchars($siteInfo['reviews']) ?> ulasan Google)</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="contact-info-card h-100">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Lokasi</h4>
                        <p class="mb-3"><?= nl2br(htmlspecialchars($siteInfo['address'])) ?></p>
                        <a href="https://maps.app.goo.gl/BaHAs5VQsMKqDSKFA" class="btn btn-custom btn-sm" target="_blank">
                            <i class="fas fa-directions me-1"></i> Petunjuk Arah
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-card h-100">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Telepon</h4>
                        <p class="mb-3"><?= htmlspecialchars($siteInfo['phone']) ?></p>
                        <a href="tel:<?= htmlspecialchars($siteInfo['phone']) ?>" class="btn btn-custom btn-sm">
                            <i class="fas fa-phone me-1"></i> Hubungi Sekarang
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-card h-100">
                        <div class="contact-icon">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Instagram</h4>
                        <p class="mb-3"><?= htmlspecialchars($siteInfo['instagram']) ?></p>
                        <a href="https://www.instagram.com/<?= substr(htmlspecialchars($siteInfo['instagram']), 1) ?>/" class="btn btn-custom btn-sm" target="_blank">
                            <i class="fab fa-instagram me-1"></i> Follow Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <h2 class="section-title text-start">Kirim Pesan</h2>
                    <p class="text-muted mb-4">Punya pertanyaan atau saran? Kirimkan pesan kepada kami dan tim kami akan merespons dengan cepat.</p>

                    <form id="contactForm" class="contact-form">
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3">Nama Lengkap</h6>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3">Email</h6>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3">Nomor Telepon</h6>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3">Subjek</h6>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Pilih Subjek</option>
                                <option value="Informasi Umum">Informasi Umum</option>
                                <option value="Reservasi">Reservasi</option>
                                <option value="Kerjasama">Kerjasama</option>
                                <option value="Saran">Saran</option>
                                <option value="Komplain">Komplain</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3">Pesan</h6>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                        </button>
                    </form>
                </div>

                <div class="col-lg-6">
                    <h2 class="section-title text-start">Lokasi Kami</h2>
                    <div class="map-container mb-4">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.2937908553396!2d112.7504734!3d-7.3218234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb91c8b2a5d5%3A0x4f57a3c5b4a8a5b!2sSemolowaru%2C%20Surabaya!5e0!3m2!1sid!2sid!4v1635123456789!5m2!1sid!2sid"
                            width="100%"
                            height="400"
                            style="border:0; border-radius: 15px;"
                            allowfullscreen=""
                            loading="lazy">
                        </iframe>
                    </div>

                    <div class="location-info">
                        <h5 class="fw-bold mb-3">Informasi Lokasi</h5>
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span><?= htmlspecialchars($siteInfo['address']) ?></span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-car text-primary me-2"></i>
                            <span>Parkir luas tersedia</span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-bus text-primary me-2"></i>
                            <span>Akses transportasi umum mudah</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Quick Contact Options -->
    <section class="quick-contact-section">
        <div class="container">
            <h2 class="section-title">Kontak Cepat</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="quick-contact-card">
                        <div class="quick-contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Reservasi & Layanan</h5>
                        <p class="mb-4">
                            Hubungi kami via WhatsApp untuk:
                        <ul class="mb-3 ps-4">
                            <li>Reservasi tempat untuk acara</li>
                            <li>Booking lapangan olahraga</li>
                            <li>Pemesanan katering dari tenant</li>
                        </ul>
                        Tim kami siap membantu Anda dengan cepat dan ramah.
                        </p>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $siteInfo['phone']) ?>" target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp me-1"></i> Chat via WhatsApp
                        </a>
                    </div>
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
    <script src="script.js"></script>

    <!-- Custom Contact Script -->
    <script>
        // Contact form handling
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const name = formData.get('name');
            const email = formData.get('email');
            const phone = formData.get('phone');
            const subject = formData.get('subject');
            const message = formData.get('message');

            // Create WhatsApp message
            const whatsappMessage = `Halo, saya ${name}%0A%0AEmail: ${email}%0ATelepon: ${phone}%0ASubjek: ${subject}%0A%0APesan:%0A${message}`;
            const whatsappUrl = `https://wa.me/<?= str_replace(['+', '-', ' '], '', htmlspecialchars($siteInfo['phone'])) ?>?text=${whatsappMessage}`;

            // Open WhatsApp
            window.open(whatsappUrl, '_blank');

            // Reset form
            this.reset();

            // Show success message
            alert('Terima kasih! Pesan Anda akan dikirim melalui WhatsApp.');
        });

        // Animate contact cards on scroll
        function animateOnScroll() {
            const cards = document.querySelectorAll('.contact-info-card, .quick-contact-card');

            cards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;
                const cardBottom = card.getBoundingClientRect().bottom;

                if (cardTop < window.innerHeight && cardBottom > 0) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        }

        // Initialize cards animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.contact-info-card, .quick-contact-card');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';
            });

            animateOnScroll();
        });

        window.addEventListener('scroll', animateOnScroll);
    </script>
</body>

</html>