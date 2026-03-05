<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<main>

  <!-- ══════════════════════════════════════════════════════════════
       PAGE HERO
       ══════════════════════════════════════════════════════════════ -->
  <section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./assets/images/about-hero-bg.jpg') center/cover; min-height: 300px; display: flex; align-items: center; justify-content: space-between; padding: 3rem 2rem; position: relative;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; margin-bottom: 0.5rem;">About Us</h1>
    </div>
    <div style="background: var(--primary); padding: 0.8rem 1.5rem; border-radius: 100px; color: #fff; font-weight: 600; font-size: 0.9rem;">
      <a href="index.php" style="color: #fff; text-decoration: none;">HOME</a>
      <span style="margin: 0 0.8rem;"> / </span>
      <span>ABOUT US</span>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       ABOUT INTRO WITH CAROUSEL
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="about-grid">
      <!-- Carousel -->
      <div class="carousel-about">
        <div class="carousel-container-about">
          <div class="carousel-slide-about active">
            <img src="./assets/images/use-this.jpg" alt="We Serve Humanity">
          </div>
          <div class="carousel-slide-about">
            <img src="./assets/images/banner-3-1024x435.png" alt="Our Mission">
          </div>

          <div class="carousel-dots-about">
            <button class="dot-about active" onclick="goToSlide(0)"></button>
            <button class="dot-about" onclick="goToSlide(1)"></button>
          </div>

          <button class="carousel-btn prev-about" onclick="prevSlide()">‹</button>
          <button class="carousel-btn next-about" onclick="nextSlide()">›</button>
        </div>
      </div>

      <!-- Content -->
      <div class="about-content">
        <div class="section-subtitle">ABOUT US</div>
        <h2 style="font-size: 2rem; font-weight: 800; color: var(--dark); margin-bottom: 1.5rem;">We Serve Humanity</h2>
        
        <p>We are an African-based social impact organization committed to touching lives of rural community dwellers through <strong>medical and educational support</strong>.</p>

        <!-- Accordion -->
        <div style="margin-top: 2rem;">
          <div class="accordion-item-about">
            <div class="accordion-header-about" onclick="toggleAccordion(this)">
              <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.5rem;">💡</span>
                <h4 style="font-weight: 700; margin: 0;">Our Vision</h4>
              </div>
              <span style="font-weight: 700; color: var(--primary);">+</span>
            </div>
            <div class="accordion-body-about">
              <p>To be a major beacon of hope to rural community dwellers across Africa, availing them more opportunity to live healthy lives and fulfill potentials like everyone else.</p>
            </div>
          </div>

          <div class="accordion-item-about">
            <div class="accordion-header-about" onclick="toggleAccordion(this)">
              <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.5rem;">❤️</span>
                <h4 style="font-weight: 700; margin: 0;">Our Mission</h4>
              </div>
              <span style="font-weight: 700; color: var(--primary);">+</span>
            </div>
            <div class="accordion-body-about">
              <p>Committed to enhancing the quality of life by supporting initiatives that bring tangible change to rural communities across Nigeria through education, healthcare, and skill development programs.</p>
            </div>
          </div>

          <div class="accordion-item-about">
            <div class="accordion-header-about" onclick="toggleAccordion(this)">
              <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.5rem;">✓</span>
                <h4 style="font-weight: 700; margin: 0;">Our Values</h4>
              </div>
              <span style="font-weight: 700; color: var(--primary);">+</span>
            </div>
            <div class="accordion-body-about">
              <p><strong>Compassion:</strong> We lead with empathy and understanding.</p>
              <p><strong>Integrity:</strong> We operate with transparency and honesty.</p>
              <p><strong>Excellence:</strong> We strive for the highest standards in everything we do.</p>
              <p><strong>Community:</strong> We believe in the power of working together.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       OUR STORY
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="max-width: 900px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <div class="section-subtitle">WHERE IT STARTED</div>
        <h2 class="section-title">Our Story</h2>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
        <div>
          <p style="color: var(--gray); line-height: 1.8; margin-bottom: 1rem;">
            We are an African based social impact organization committed to touching lives of rural community dwellers through medical and educational support.
          </p>
          <p style="color: var(--gray); line-height: 1.8; margin-bottom: 1rem;">
            We are propelled by a passion to ease the burdens of these unfortunate many, especially in rural communities of third world nations, who are being weighed down by the burdens of poverty. We do this by narrowing our gaze to what we believe forms the core of the issue.
          </p>
          <p style="color: var(--gray); line-height: 1.8;">
            As they say, <em>"A healthy body and a healthy (well informed) mind is the sure recipe for success".</em>
          </p>
        </div>

        <div>
          <p style="color: var(--gray); line-height: 1.8; margin-bottom: 1rem;">
            Therefore, we channel the waves of our passion towards providing <strong>Educational support</strong> and <strong>Health support</strong> to less privileged communities across the nations where we work.
          </p>
          <p style="color: var(--gray); line-height: 1.8; margin-bottom: 1rem;">
            This vision was born in the heart of our founder, Whoba Ogo, who started out his journey of life from very humble beginnings. Having experienced the harsh realities being faced on a daily basis by inhabitants of rural communities, and having also experienced in his own journey the world of difference a helping hand can make in redefining one's future, he decided to set up this foundation to be that 'Helping hand' to many.
          </p>
        </div>
      </div>

      <div style="text-align: center; margin-top: 2.5rem;">
        <a href="contact.php" class="btn btn-primary">JOIN US NOW →</a>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       TEAM SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="text-align: center; margin-bottom: 3rem;">
      <div class="section-subtitle">OUR TEAM</div>
      <h2 class="section-title">Meet Our Leadership</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 3rem; max-width: 600px; margin: 0 auto;">
      <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md); padding: 2rem; text-align: center;">
        <div style="width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%; overflow: hidden; background: var(--light-gray); box-shadow: 0 0 0 3px var(--primary);">
          <img src="./assets/images/safiya.jpg" alt="Safiya Whoba" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Safiya Whoba</h4>
        <p style="font-size: 0.9rem; color: var(--primary); font-weight: 600;">Trustee</p>
      </div>

      <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md); padding: 2rem; text-align: center;">
        <div style="width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%; overflow: hidden; background: var(--light-gray); box-shadow: 0 0 0 3px var(--primary);">
          <img src="./assets/images/whoba-ogo.jpg" alt="Whoba Ogo" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Whoba Ogo</h4>
        <p style="font-size: 0.9rem; color: var(--primary); font-weight: 600;">Chairman, Board of Trustee</p>
      </div>
    </div>
  </section>

</main>

<style>
  .accordion-item-about {
    background: #fff;
    border: 1px solid var(--border-gray);
    border-radius: 8px;
    margin-bottom: 1rem;
    overflow: hidden;
  }

  .accordion-header-about {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.2rem;
    background: var(--light-gray);
    cursor: pointer;
    transition: all 0.3s;
  }

  .accordion-header-about:hover {
    background: var(--primary-light);
  }

  .accordion-body-about {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }

  .accordion-body-about p {
    margin: 0;
    padding: 1.2rem;
    color: var(--gray);
    line-height: 1.7;
  }

  .accordion-body-about p + p {
    padding-top: 0;
  }

  .carousel-about {
    position: relative;
  }

  .carousel-container-about {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    aspect-ratio: 3/4;
    background: var(--light-gray);
  }

  .carousel-slide-about {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.6s ease-in-out;
  }

  .carousel-slide-about.active {
    opacity: 1;
  }

  .carousel-slide-about img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .carousel-dots-about {
    position: absolute;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 0.8rem;
    z-index: 10;
  }

  .dot-about {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    padding: 0;
  }

  .dot-about.active {
    background: #fff;
    transform: scale(1.2);
  }

  .carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    background: rgba(0, 0, 0, 0.5);
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
    z-index: 10;
  }

  .carousel-btn:hover {
    background: rgba(0, 0, 0, 0.8);
  }

  .prev-about {
    left: 1rem;
  }

  .next-about {
    right: 1rem;
  }

  @media (max-width: 768px) {
    .about-grid {
      grid-template-columns: 1fr !important;
    }

    .carousel-container-about {
      order: -1;
      max-width: 400px;
      margin: 0 auto;
      width: 100%;
    }
  }
</style>

<script>
  let currentSlideIndex = 0;
  const slides = document.querySelectorAll('.carousel-slide-about');
  const dots = document.querySelectorAll('.dot-about');

  function goToSlide(n) {
    currentSlideIndex = n;
    updateSlides();
  }

  function nextSlide() {
    currentSlideIndex = (currentSlideIndex + 1) % slides.length;
    updateSlides();
  }

  function prevSlide() {
    currentSlideIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
    updateSlides();
  }

  function updateSlides() {
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    slides[currentSlideIndex].classList.add('active');
    dots[currentSlideIndex].classList.add('active');
  }

  // Auto-advance every 5 seconds
  setInterval(nextSlide, 5000);

  // Initialize
  updateSlides();

  function toggleAccordion(header) {
    const item = header.parentElement;
    const body = item.querySelector('.accordion-body-about');
    const allItems = document.querySelectorAll('.accordion-item-about');

    allItems.forEach(otherItem => {
      if (otherItem !== item) {
        otherItem.querySelector('.accordion-header-about').style.background = 'var(--light-gray)';
        otherItem.querySelector('.accordion-body-about').style.maxHeight = '0';
      }
    });

    if (body.style.maxHeight === '0px' || body.style.maxHeight === '') {
      header.style.background = 'var(--primary-light)';
      body.style.maxHeight = body.scrollHeight + 'px';
    } else {
      header.style.background = 'var(--light-gray)';
      body.style.maxHeight = '0';
    }
  }
</script>

<?php include './includes/footer.php'; ?>
</body>
</html>