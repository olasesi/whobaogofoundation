<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<style>
        .page-hero {
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                url('/assets/images/about-hero-bg.jpg') center/cover;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    position: relative;
  }
  .page-hero-content h1 {
    font-family: 'Fraunces', serif;
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: -0.02em;
    margin-bottom: 0.5rem;
  }

  .breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(224,53,53,0.9);
    padding: 0.8rem 1.5rem;
    border-radius: 100px;
  }
  .breadcrumb a,
  .breadcrumb span {
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
  }
  .breadcrumb a:hover { opacity: 0.8; }
  .breadcrumb span { opacity: 0.7; }

  /* ── GALLERY SECTION ───────────────────────────── */
  .gallery-section {
    padding: 4rem 0;
    border-bottom: 1px solid var(--border);
  }
  .gallery-section:last-of-type {
    border-bottom: none;
  }
  
  .gallery-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  .gallery-header h2 {
    font-family: 'Fraunces', serif;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 900;
    color: var(--ink);
    margin-bottom: 1rem;
  }
  .gallery-header p {
    font-size: 0.95rem;
    line-height: 1.7;
    color: var(--ink-mid);
    max-width: 900px;
    margin: 0 auto;
  }

  /* ── IMAGE CAROUSEL ────────────────────────────── */
  .carousel-container {
    position: relative;
    overflow: hidden;
    margin: 0 auto;
    max-width: 1200px;
  }
  .carousel-track {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding: 0.5rem 0;
  }
  .carousel-track::-webkit-scrollbar {
    display: none;
  }
  .carousel-item {
    flex: 0 0 auto;
    width: 200px;
    height: 200px;
    border-radius: var(--r-md);
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .carousel-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  }
  .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ── CAROUSEL DOTS ─────────────────────────────── */
  .carousel-dots {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
  }
  .carousel-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--border);
    cursor: pointer;
    transition: background 0.3s, width 0.3s;
  }
  .carousel-dot.active {
    background: var(--red);
    width: 24px;
    border-radius: 4px;
  }

  /* ── LIGHTBOX MODAL ────────────────────────────── */
  .lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.95);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }
  .lightbox.active {
    display: flex;
  }
  .lightbox-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
  }
  .lightbox-content img {
    max-width: 100%;
    max-height: 90vh;
    border-radius: var(--r-md);
  }
  .lightbox-close {
    position: absolute;
    top: -3rem;
    right: 0;
    background: none;
    border: none;
    color: #fff;
    font-size: 2.5rem;
    cursor: pointer;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s;
  }
  .lightbox-close:hover {
    opacity: 0.7;
  }
  .lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.2);
    border: none;
    color: #fff;
    font-size: 2rem;
    cursor: pointer;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
  }
  .lightbox-nav:hover {
    background: rgba(255,255,255,0.3);
  }
  .lightbox-prev {
    left: -5rem;
  }
  .lightbox-next {
    right: -5rem;
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 768px) {
    .carousel-item {
      width: 160px;
      height: 160px;
    }
    .lightbox-prev {
      left: 1rem;
    }
    .lightbox-next {
      right: 1rem;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>Gallery</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>GALLERY</span>
  </div>
</section>

<!-- ── MEDICAL OUTREACH ────────────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>Medical Outreach</h2>
      <p>Medical outreached to elderly people in Ihitte/Uboma Local Government Area of Imo State. Free Medical Treatment, Consultation, Blood Pressure and Sugar level was administered to the Community.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-medical">
        <div class="carousel-item" onclick="openLightbox(0, 'medical')">
          <img src="/assets/images/gallery/medical-1.jpg" alt="Medical Outreach"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%230D9B7E%22%3E🏥%3C/text%3E%3C/svg%3E'">
        </div>
      </div>
      <div class="carousel-dots" id="dots-medical"></div>
    </div>
  </div>
</section>

<!-- ── WATER PROJECT ──────────────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>Water Project</h2>
      <p>Rehabilitation of Ihitte/Uboma Community Water project. The Foundation renovated the abandoned water project which has been overgrown by thick grasses. The Foundation employed a facility manager and provided a power generator to ensure steady water supply to the Community.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-water">
        <?php for($i=1; $i<=5; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'water')">
          <img src="/assets/images/gallery/water-<?= $i ?>.jpg" alt="Water Project <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%230D9B7E%22%3E💧%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-water"></div>
    </div>
  </div>
</section>

<!-- ── 2020 REGISTRATION OF SSCE ──────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>2020 Registration Of SSCE</h2>
      <p>Registration of SS3 students of Nwaeruru Mbakwe Comprehensive School in Ihitte/Uboma Local Government Area of Imo State for SSCE Examination by Whoba Ogo Foundation graced by the Royal Highness Eze Umuihi, Imo State.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-ssce2020">
        <?php for($i=1; $i<=5; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'ssce2020')">
          <img src="/assets/images/gallery/ssce-2020-<?= $i ?>.jpg" alt="2020 SSCE Registration <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23FDE8E8%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23E03535%22%3E📚%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-ssce2020"></div>
    </div>
  </div>
</section>

<!-- ── 2021 REGISTRATION OF SSCE ──────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>2021 Registration Of SSCE</h2>
      <p>71 students from Nwaeruru Mbakwe Comprehensive School in Ihitte/Uboma Local Government Area of Imo State were registered for SSCE.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-ssce2021">
        <?php for($i=1; $i<=5; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'ssce2021')">
          <img src="/assets/images/gallery/ssce-2021-<?= $i ?>.jpg" alt="2021 SSCE Registration <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23FDE8E8%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23E03535%22%3E🎓%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-ssce2021"></div>
    </div>
  </div>
</section>

<!-- ── VISIT TO SCHOOL ────────────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>Visit Of Whoba Ogo Foundation To Nwaeruru-Mbakwe Comprehensive Secondary School</h2>
      <p>Before the arrival of the Whoba Ogo Foundation, the state of Nwaeruru Mbakwe Secondary School Ihitte/Uboma was a devastating one. Almost all building in the school is bad and at the verge of collapsing, roofs have fallen off, even when it rains, its pours directly on the students.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-visit">
        <?php for($i=1; $i<=6; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'visit')">
          <img src="/assets/images/gallery/visit-<?= $i ?>.jpg" alt="School Visit <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23FEF3DC%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23F5A623%22%3E🏫%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-visit"></div>
    </div>
  </div>
</section>

<!-- ── SCHOOL RENOVATION ──────────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>Renovation Of Nwaeruru-Mbakwe Comprehensive Secondary School By Whoba Ogo Foundation</h2>
      <p>After the visit of Whoba Ogo Foundation, new infrastructure was built, library, classroom, chairs were provided for all the students in different classes, staffrooms, students and teachers' restroom, students' hostels.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-renovation">
        <?php for($i=1; $i<=5; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'renovation')">
          <img src="/assets/images/gallery/renovation-<?= $i ?>.jpg" alt="School Renovation <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%230D9B7E%22%3E🏗️%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-renovation"></div>
    </div>
  </div>
</section>

<!-- ── NEW FACE OF SCHOOL ─────────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>The New Face Of Nwaeruru Mbakwe Comprehensive School</h2>
      <p>The new Face of Nwaeruru-Mbakwe comprehensive secondary school Umuihi Ihite/Uboma Local Government Area of Imo State, after the total renovation of infrastructure by Whoba Ogo Foundation.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-newface">
        <?php for($i=1; $i<=4; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'newface')">
          <img src="/assets/images/gallery/newface-<?= $i ?>.jpg" alt="New School Face <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23FEF3DC%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23F5A623%22%3E✨%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-newface"></div>
    </div>
  </div>
</section>

<!-- ── WIDOW'S MITE ───────────────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>Widow's Mite</h2>
      <p>Widows in Ihitte/Uboma Local Government Area of Imo State receiving Financial Support from Whoba Ogo Foundation.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-widows">
        <?php for($i=1; $i<=5; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'widows')">
          <img src="/assets/images/gallery/widows-<?= $i ?>.jpg" alt="Widow's Mite <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23FDE8E8%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23E03535%22%3E❤️%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-widows"></div>
    </div>
  </div>
</section>

<!-- ── EMPOWERMENT OF COBBLERS ────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>Empowerment of Cobblers</h2>
      <p>The Whoba Ogo Foundation empowered 10 idle but skilled cobblers with all the materials needed to start their business including renting of shops for them in Isinweke Market.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-cobblers">
        <?php for($i=1; $i<=5; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'cobblers')">
          <img src="/assets/images/gallery/cobblers-<?= $i ?>.jpg" alt="Cobbler Empowerment <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%230D9B7E%22%3E👞%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-cobblers"></div>
    </div>
  </div>
</section>

<!-- ── CHURCH PROJECT ─────────────────────────── -->
<section class="gallery-section">
  <div class="wrap">
    <div class="gallery-header">
      <h2>Church Project</h2>
      <p>Renovation of Church by Whoba Ogo Foundation in Ihitte/Uboma Local Government Area of Imo State.</p>
    </div>

    <div class="carousel-container">
      <div class="carousel-track" id="carousel-church">
        <?php for($i=1; $i<=4; $i++): ?>
        <div class="carousel-item" onclick="openLightbox(<?= $i-1 ?>, 'church')">
          <img src="/assets/images/gallery/church-<?= $i ?>.jpg" alt="Church Project <?= $i ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23FEF3DC%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23F5A623%22%3E⛪%3C/text%3E%3C/svg%3E'">
        </div>
        <?php endfor; ?>
      </div>
      <div class="carousel-dots" id="dots-church"></div>
    </div>
  </div>
</section>

</main>

<!-- ── LIGHTBOX MODAL ──────────────────────────── -->
<div class="lightbox" id="lightbox">
  <div class="lightbox-content">
    <button class="lightbox-close" onclick="closeLightbox()">×</button>
    <button class="lightbox-nav lightbox-prev" onclick="changeLightboxImage(-1)">‹</button>
    <img id="lightbox-img" src="" alt="">
    <button class="lightbox-nav lightbox-next" onclick="changeLightboxImage(1)">›</button>
  </div>
</div>

<script>
  let currentLightboxIndex = 0;
  let currentCarouselId = '';

  // Initialize all carousels
  function initCarousels() {
    const carousels = document.querySelectorAll('[id^="carousel-"]');
    carousels.forEach(carousel => {
      const id = carousel.id.replace('carousel-', '');
      const dotsContainer = document.getElementById(`dots-${id}`);
      const items = carousel.querySelectorAll('.carousel-item');
      
      // Create dots
      const dotCount = Math.ceil(items.length / 5) || 1;
      for (let i = 0; i < dotCount; i++) {
        const dot = document.createElement('span');
        dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
        dot.onclick = () => scrollCarousel(id, i);
        dotsContainer.appendChild(dot);
      }
      
      // Update dots on scroll
      carousel.addEventListener('scroll', () => updateDots(id));
    });
  }

  function scrollCarousel(id, dotIndex) {
    const carousel = document.getElementById(`carousel-${id}`);
    const scrollAmount = carousel.offsetWidth * dotIndex;
    carousel.scrollTo({ left: scrollAmount, behavior: 'smooth' });
  }

  function updateDots(id) {
    const carousel = document.getElementById(`carousel-${id}`);
    const dots = document.querySelectorAll(`#dots-${id} .carousel-dot`);
    const scrollPosition = carousel.scrollLeft;
    const scrollWidth = carousel.scrollWidth - carousel.offsetWidth;
    const activeIndex = Math.round((scrollPosition / scrollWidth) * (dots.length - 1));
    
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === activeIndex);
    });
  }

  // Lightbox functions
  function openLightbox(index, carouselId) {
    currentLightboxIndex = index;
    currentCarouselId = carouselId;
    
    const carousel = document.getElementById(`carousel-${carouselId}`);
    const images = carousel.querySelectorAll('img');
    
    document.getElementById('lightbox-img').src = images[index].src;
    document.getElementById('lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
  }

  function changeLightboxImage(direction) {
    const carousel = document.getElementById(`carousel-${currentCarouselId}`);
    const images = carousel.querySelectorAll('img');
    
    currentLightboxIndex += direction;
    
    if (currentLightboxIndex < 0) currentLightboxIndex = images.length - 1;
    if (currentLightboxIndex >= images.length) currentLightboxIndex = 0;
    
    document.getElementById('lightbox-img').src = images[currentLightboxIndex].src;
  }

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (!document.getElementById('lightbox').classList.contains('active')) return;
    
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') changeLightboxImage(-1);
    if (e.key === 'ArrowRight') changeLightboxImage(1);
  });

  // Close lightbox on background click
  document.getElementById('lightbox').addEventListener('click', (e) => {
    if (e.target.id === 'lightbox') closeLightbox();
  });

  // Initialize on page load
  initCarousels();
</script>

<?php include './includes/footer.php'; ?>