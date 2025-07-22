<?php
// --- 1. PENGATURAN KONEKSI DATABASE (PDO) ---
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "db_kkn"; // Nama database

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set error mode ke exception untuk penanganan error yang lebih baik
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // Hentikan eksekusi dan tampilkan pesan error jika koneksi gagal
    die("Koneksi database gagal: " . $e->getMessage());
}

// --- 2. PENGAMBILAN DATA DARI DATABASE ---
try {
    // Ambil data site_info (informasi situs)
    $stmtSiteInfo = $pdo->query("SELECT * FROM site_info LIMIT 1");
    $siteInfo = $stmtSiteInfo->fetch();
    // Jika tidak ada data, gunakan nilai default untuk menghindari error
    if (!$siteInfo) {
        $siteInfo = [
            'name' => 'Nama Website',
            'full_name' => 'Nama Lengkap Website',
            'address' => 'Alamat tidak tersedia',
            'rating' => 'N/A',
            'reviews' => '0',
            'hours' => '17:00 - 24:00',
            'phone' => '000000000000',
            'instagram' => '@username'
        ];
    }

    // Ambil data operating hours dari database
    $stmtOperatingHours = $pdo->query("SELECT * FROM operating_hours ORDER BY day_number ASC");
    $operatingHours = $stmtOperatingHours->fetchAll();
    
    // Format jam operasional untuk display
    $formattedHours = [];
    $todayHours = '';
    
    if (!empty($operatingHours)) {
        foreach ($operatingHours as $hour) {
            $dayName = $hour['day_name'];
            $openTime = $hour['open_time'];
            $closeTime = $hour['close_time'];
            $isOpen = $hour['is_open'];
            
            if ($isOpen == 1) {
                $formattedHours[$dayName] = $openTime . ' - ' . $closeTime;
            } else {
                $formattedHours[$dayName] = 'Tutup';
            }
        }
        
        // Ambil jam operasional untuk hari ini (contoh: hari pertama)
        if (!empty($operatingHours)) {
            $firstDay = $operatingHours[0];
            if ($firstDay['is_open'] == 1) {
                $todayHours = $firstDay['open_time'] . ' - ' . $firstDay['close_time'];
            } else {
                $todayHours = 'Tutup';
            }
        }
    } else {
        $todayHours = '07:00 - 23:00'; // Default jika tidak ada data
    }

    // Update site_info dengan jam operasional yang diambil dari database
    $siteInfo['hours'] = $todayHours;

    // Ambil data features (fitur-fitur)
    $stmtFeatures = $pdo->query("SELECT description FROM features");
    $features = $stmtFeatures->fetchAll(PDO::FETCH_COLUMN, 0); // Ambil hanya kolom pertama

// FILE:onnection.php (atau file sejenisnya)

// KODE ANDA YANG SUDAH ADA (INI SUDAH BENAR, JANGAN DIUBAH)
// =======================================================
// Ambil TOTAL semua menu
$totalMenuQuery = "SELECT COUNT(*) as total FROM menu_andalan";
$totalMenuResult = $pdo->query($totalMenuQuery);
$totalMenu = $totalMenuResult->fetch(PDO::FETCH_ASSOC)['total'];

// Ambil 6 menu teratas untuk ditampilkan di homepage
$menuQuery = "SELECT * FROM menu_andalan ORDER BY created_at DESC LIMIT 6";
$menuResult = $pdo->query($menuQuery);
$menuItems = $menuResult->fetchAll(PDO::FETCH_ASSOC);


// TAMBAHKAN KODE DI BAWAH INI
// =================================
// Ambil SEMUA menu untuk ditampilkan di dalam MODAL (tanpa LIMIT)
// Diurutkan berdasarkan kategori lalu nama menu agar lebih rapi
$semuaMenuQuery = "SELECT * FROM menu_andalan ORDER BY kategori, nama_menu ASC";
$semuaMenuResult = $pdo->query($semuaMenuQuery);
$semuaMenuItems = $semuaMenuResult->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $totalMenu = 0;
    $menuItems = [];
    $operatingHours = [];
    $formattedHours = [];
    $todayHours = '17:00 - 24:00';
    error_log("Database error: " . $e->getMessage());
}

// Pastikan variabel $pdo ada sebelum digunakan
if (isset($pdo)) {
    try {
        // Query untuk mengambil SEMUA menu andalan untuk modal menggunakan koneksi $pdo
        $sql_all = "SELECT nama_menu, kategori FROM menu_andalan ORDER BY kategori, nama_menu";
        $stmt = $pdo->query($sql_all);
        // Menggunakan fetchAll() karena fetch mode default (FETCH_ASSOC) sudah diatur di connection.php
        $allMenuItems = $stmt->fetchAll();

    } catch(PDOException $e) {
        // Jika terjadi error, biarkan $allMenuItems kosong dan catat errornya
        // Ini mencegah situs rusak jika query gagal.
        error_log("Gagal mengambil semua menu: " . $e->getMessage());
        $allMenuItems = [];
    }
}

// --- 3. PENGAMBILAN DATA TENANT ---
try {
    // Sesuaikan nama tabel dan kolom dengan database
    $stmt = $pdo->prepare("SELECT * FROM tenan ORDER BY nama_tenan ASC");
    $stmt->execute();
    $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Hitung total tenant dari database yang sebenarnya
    $totalTenants = count($tenants);

    // Jika tidak ada data, set ke 0
    if ($totalTenants == 0) {
        $totalTenants = 0;
    }

    // Kelompokkan tenant berdasarkan range_harga
    $categories = [];
    foreach ($tenants as $tenant) {
        $category = $tenant['range_harga'] ?? 'Lainnya';
        if (!isset($categories[$category])) {
            $categories[$category] = [];
        }
        $categories[$category][] = $tenant;
    }

    // Ambil range_harga unik untuk filter
    $uniqueCategories = array_keys($categories);
    sort($uniqueCategories);

} catch (PDOException $e) {
    $tenants = [];
    $totalTenants = 0; // Set ke 0 jika error
    $categories = [];
    $uniqueCategories = [];
    error_log("Gagal mengambil data tenant: " . $e->getMessage());
}

// --- 4. PENGAMBILAN DATA FASILITAS UTAMA ---
try {
    // Ambil data fasilitas utama
    $stmtFasilitas = $pdo->query("SELECT * FROM fasilitas_utama ORDER BY title ASC");
    $fasilitasUtama = $stmtFasilitas->fetchAll(PDO::FETCH_ASSOC);

    // Hitung total fasilitas utama
    $totalFasilitasUtama = count($fasilitasUtama);

    // Kelompokkan fasilitas berdasarkan kategori jika diperlukan
    $fasilitasByCategory = [];
    foreach ($fasilitasUtama as $fasilitas) {
        $category = $fasilitas['icon'] ?? 'default'; // Menggunakan icon sebagai kategori
        if (!isset($fasilitasByCategory[$category])) {
            $fasilitasByCategory[$category] = [];
        }
        $fasilitasByCategory[$category][] = $fasilitas;
    }

} catch (PDOException $e) {
    $fasilitasUtama = [];
    $totalFasilitasUtama = 0;
    $fasilitasByCategory = [];
    error_log("Gagal mengambil fasilitas utama: " . $e->getMessage());
}

// --- 5. PENGAMBILAN DATA FITUR FASILITAS ---
try {
    // Ambil data fitur fasilitas dengan join ke fasilitas_utama untuk mendapatkan detail
    $stmtFitur = $pdo->query("
        SELECT
            ff.id,
            ff.fasilitas_id,
            ff.fitur,
            fu.title as fasilitas_title,
            fu.icon as fasilitas_icon,
            fu.description as fasilitas_description,
            fu.color as fasilitas_color
        FROM fitur_fasilitas ff
        LEFT JOIN fasilitas_utama fu ON ff.fasilitas_id = fu.id
        ORDER BY ff.fasilitas_id ASC, ff.fitur ASC
    ");
    $fiturFasilitas = $stmtFitur->fetchAll(PDO::FETCH_ASSOC);

    // Hitung total fitur fasilitas
    $totalFiturFasilitas = count($fiturFasilitas);

    // Kelompokkan fitur berdasarkan fasilitas_id
    $fiturByFasilitas = [];
    foreach ($fiturFasilitas as $fitur) {
        $fasilitasId = $fitur['fasilitas_id'];
        if (!isset($fiturByFasilitas[$fasilitasId])) {
            $fiturByFasilitas[$fasilitasId] = [];
        }
        $fiturByFasilitas[$fasilitasId][] = $fitur;
    }

    // Ambil hanya data fitur tanpa join (untuk keperluan tertentu)
    $stmtFiturOnly = $pdo->query("SELECT * FROM fitur_fasilitas ORDER BY fasilitas_id ASC");
    $fiturFasilitasOnly = $stmtFiturOnly->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $fiturFasilitas = [];
    $totalFiturFasilitas = 0;
    $fiturByFasilitas = [];
    $fiturFasilitasOnly = [];
    error_log("Gagal mengambil fitur fasilitas: " . $e->getMessage());
}

// --- FUNGSI HELPER ---

// Fungsi untuk format range harga (disesuaikan dengan format string)
function formatPrice($rangeHarga) {
    if (!empty($rangeHarga)) {
        // Jika range_harga sudah dalam format yang diinginkan, langsung return
        return htmlspecialchars($rangeHarga);
    }
    return "Harga bervariasi";
}

// Fungsi alternatif jika ingin memparse range harga dari string
function parseRangePrice($rangeString) {
    if (empty($rangeString)) {
        return "Harga bervariasi";
    }

    // Contoh parsing jika format range_harga adalah "10000-50000" atau "Rp 10.000 - Rp 50.000"
    $cleanString = preg_replace('/[^\d\-]/', '', $rangeString);

    if (strpos($cleanString, '-') !== false) {
        $parts = explode('-', $cleanString);
        if (count($parts) == 2) {
            $min = intval($parts[0]);
            $max = intval($parts[1]);

            if ($min > 0 && $max > 0) {
                return "Rp " . number_format($min, 0, ',', '.') . " - Rp " . number_format($max, 0, ',', '.');
            }
        }
    }

    // Jika tidak bisa diparse, return as is
    return htmlspecialchars($rangeString);
}

// Fungsi untuk mendapatkan fasilitas berdasarkan ID
function getFasilitasById($id) {
    global $fasilitasUtama;
    foreach ($fasilitasUtama as $fasilitas) {
        if ($fasilitas['id'] == $id) {
            return $fasilitas;
        }
    }
    return null;
}

// Fungsi untuk mendapatkan fitur berdasarkan fasilitas ID
function getFiturByFasilitasId($fasilitasId) {
    global $fiturByFasilitas;
    return $fiturByFasilitas[$fasilitasId] ?? [];
}

// Fungsi untuk mendapatkan warna berdasarkan nama warna
function getColorClass($color) {
    $colorMap = [
        'primary' => 'text-blue-600',
        'success' => 'text-green-600',
        'warning' => 'text-yellow-600',
        'info' => 'text-cyan-600',
        'danger' => 'text-red-600',
        'secondary' => 'text-gray-600'
    ];

    return $colorMap[$color] ?? 'text-gray-600';
}

// Fungsi untuk mendapatkan icon class berdasarkan nama icon
function getIconClass($icon) {
    $iconMap = [
        'fas fa-car' => 'fas fa-car',
        'fas fa-wifi' => 'fas fa-wifi',
        'fas fa-music' => 'fas fa-music',
        'fas fa-skating' => 'fas fa-skating',
        'fas fa-child' => 'fas fa-child',
        'fas fa-restroom' => 'fas fa-restroom'
    ];

    return $iconMap[$icon] ?? 'fas fa-circle';
}

// Fungsi untuk mendapatkan jam operasional berdasarkan hari
function getOperatingHoursByDay($dayName) {
    global $formattedHours;
    return $formattedHours[$dayName] ?? 'Tutup';
}

// Fungsi untuk mendapatkan semua jam operasional
function getAllOperatingHours() {
    global $formattedHours;
    return $formattedHours;
}

// Fungsi untuk mengecek apakah buka pada hari tertentu
function isOpenOnDay($dayName) {
    global $operatingHours;
    foreach ($operatingHours as $hour) {
        if ($hour['day_name'] == $dayName) {
            return $hour['is_open'] == 1;
        }
    }
    return false;
}

// Fungsi untuk menutup koneksi (opsional, PDO akan otomatis tertutup ketika script selesai)
function closeConnection() {
    global $pdo;
    $pdo = null;
}

// PERBAIKAN 5: Tambahkan validasi data untuk mencegah error
function getOperationalData() {
    global $siteInfo, $totalTenants, $totalFasilitasUtama, $todayHours;

    return [
        'hours' => $todayHours ?: '17:00 - 24:00',
        'capacity' => '500+',
        'tenants' => ($totalTenants > 0) ? $totalTenants . '+' : '20+',
        'area' => '2000 m²',
        'facilities' => ($totalFasilitasUtama > 0) ? $totalFasilitasUtama : 6
    ];
}

function formatNumber($number) {
    if ($number >= 1000) {
        return number_format($number / 1000, 1) . 'K';
    }
    return $number;
}

$operationalData = getOperationalData();


// --- 6. PENGAMBILAN DATA GALLERY ---
try {
    // Ambil semua data gallery
    $stmtGallery = $pdo->query("SELECT * FROM gallery ORDER BY id ASC");
    $galleryItems = $stmtGallery->fetchAll(PDO::FETCH_ASSOC);

    // Hitung total gallery items
    $totalGalleryItems = count($galleryItems);

    // Kelompokkan gallery berdasarkan kategori
    $galleryByCategory = [];
    foreach ($galleryItems as $item) {
        $category = $item['category'] ?? 'Lainnya';
        if (!isset($galleryByCategory[$category])) {
            $galleryByCategory[$category] = [];
        }
        $galleryByCategory[$category][] = $item;
    }

    // Ambil kategori unik untuk filter
    $uniqueGalleryCategories = array_keys($galleryByCategory);
    sort($uniqueGalleryCategories);

    // Ambil gallery berdasarkan kategori tertentu
    $suasanaGallery = $galleryByCategory['Suasana'] ?? [];
    $hiburanGallery = $galleryByCategory['Hiburan'] ?? [];
    $fasilitasGallery = $galleryByCategory['Fasilitas'] ?? [];
    $pengunjungGallery = $galleryByCategory['Pengunjung'] ?? [];
    $kulinerGallery = $galleryByCategory['Kuliner'] ?? [];
    $eventGallery = $galleryByCategory['Event'] ?? [];

} catch (PDOException $e) {
    $galleryItems = [];
    $totalGalleryItems = 0;
    $galleryByCategory = [];
    $uniqueGalleryCategories = [];
    $suasanaGallery = [];
    $hiburanGallery = [];
    $fasilitasGallery = [];
    $pengunjungGallery = [];
    $kulinerGallery = [];
    $eventGallery = [];
    error_log("Gagal mengambil data gallery: " . $e->getMessage());
}

// --- FUNGSI HELPER UNTUK GALLERY ---

// Fungsi untuk mendapatkan gallery berdasarkan kategori
function getGalleryByCategory($category) {
    global $galleryByCategory;
    return $galleryByCategory[$category] ?? [];
}

// Fungsi untuk mendapatkan gallery berdasarkan ID
function getGalleryById($id) {
    global $galleryItems;
    foreach ($galleryItems as $item) {
        if ($item['id'] == $id) {
            return $item;
        }
    }
    return null;
}

// Fungsi untuk mendapatkan path gambar gallery
function getGalleryImagePath($imageUrl) {
    if (empty($imageUrl)) {
        return 'images/default-gallery.jpg';
    }
    
    // Jika sudah path lengkap, return as is
    if (strpos($imageUrl, 'images/') === 0) {
        return $imageUrl;
    }
    
    // Jika hanya nama file, tambahkan path
    return 'images/gallery/' . $imageUrl;
}

// Fungsi untuk mendapatkan gallery terbaru
function getLatestGallery($limit = 6) {
    global $galleryItems;
    return array_slice($galleryItems, 0, $limit);
}

// Fungsi untuk mendapatkan gallery berdasarkan kategori dengan limit
function getGalleryByCategoryWithLimit($category, $limit = 4) {
    global $galleryByCategory;
    $items = $galleryByCategory[$category] ?? [];
    return array_slice($items, 0, $limit);
}

// Fungsi untuk mendapatkan semua kategori gallery
function getAllGalleryCategories() {
    global $uniqueGalleryCategories;
    return $uniqueGalleryCategories;
}

// Fungsi untuk format alt text gambar
function formatGalleryAlt($title, $category) {
    if (empty($title)) {
        return "Gallery item - " . $category;
    }
    return htmlspecialchars($title);
}

// Fungsi untuk mendapatkan total gallery berdasarkan kategori
function getTotalGalleryByCategory($category) {
    global $galleryByCategory;
    return count($galleryByCategory[$category] ?? []);
}

// Update fungsi getOperationalData untuk menambahkan data gallery
function getOperationalDataWithGallery() {
    global $siteInfo, $totalTenants, $totalFasilitasUtama, $todayHours, $totalGalleryItems;

    return [
        'hours' => $todayHours ?: '17:00 - 24:00',
        'capacity' => '500+',
        'tenants' => ($totalTenants > 0) ? $totalTenants . '+' : '20+',
        'area' => '2000 m²',
        'facilities' => ($totalFasilitasUtama > 0) ? $totalFasilitasUtama : 6,
        'gallery_items' => ($totalGalleryItems > 0) ? $totalGalleryItems : 0
    ];
}
?>