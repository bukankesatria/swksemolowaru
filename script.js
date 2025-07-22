
// SCRIPT.JS YANG DIPERBAIKI - VERSI FINAL
// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add loading animation to food cards
document.addEventListener('DOMContentLoaded', function() {
    const foodCards = document.querySelectorAll('.food-card');
    
    foodCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
});

// Interactive hover effects
document.querySelectorAll('.info-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.background = 'linear-gradient(135deg, #ff6b35, #f39c12)';
        this.style.color = 'white';
        this.style.transform = 'translateY(-10px) scale(1.05)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.background = '';
        this.style.color = '';
        this.style.transform = '';
    });
});

// PERBAIKAN: Dynamic time update yang AMAN
function updateCurrentTime() {
    const now = new Date();
    const hours = now.getHours();
    const isOpen = hours >= 7 && hours < 24;
    
    // HANYA jalankan di halaman index dan HANYA untuk elemen yang tepat
    const currentPage = window.location.pathname;
    const isIndexPage = currentPage === '/' || currentPage.includes('index.php') || currentPage === '';
    
    // Cek apakah ada operational info section (halaman fasilitas)
    const hasOperationalInfo = document.querySelector('.operational-info-section');
    
    if (isIndexPage && !hasOperationalInfo) {
        // Cari elemen hero subtitle yang BUKAN di halaman fasilitas
        const heroSubtitle = document.querySelector('.hero-section .hero-subtitle:not(.no-status)');
        
        if (heroSubtitle && !heroSubtitle.querySelector('.badge')) {
            if (isOpen) {
                heroSubtitle.innerHTML += ' <span class="badge bg-success ms-2">BUKA SEKARANG</span>';
            } else {
                heroSubtitle.innerHTML += ' <span class="badge bg-danger ms-2">TUTUP</span>';
            }
        }
    }
}

