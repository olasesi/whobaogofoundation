<?php
require_once './includes/config.php';
require_once './includes/db.php';
include ('./includes/header.php');

$newsStmt = $pdo->prepare("
  SELECT id, title, slug, excerpt, featured_image, category_id, published_at, 
         (SELECT name FROM categories WHERE id = posts.category_id) AS category_name
  FROM posts
  WHERE post_type = 'post' AND status = 'published'
  ORDER BY published_at DESC
  LIMIT 6
");
$newsStmt->execute();
$posts = $newsStmt->fetchAll();
?>

<main>

  <!-- ══════════════════════════════════════════════════════════════
       HERO SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="hero">
    <div class="hero-content">
      <h1>Transforming Lives Through <span class="highlight">Education</span> & <span class="highlight">Healthcare</span></h1>
      <p class="hero-desc">We are an African-based social impact organization committed to touching lives of rural community dwellers through comprehensive medical and educational support programs.</p>
      
      <div class="hero-btns">
        <a href="about-us.php" class="btn btn-primary">Learn Our Story →</a>
        <a href="volunteer.php" class="btn btn-outline">Become a Volunteer</a>
      </div>

      <div class="hero-trust">
        <div class="trust-avatars">
          <span>🧑</span><span>👩</span><span>🧒</span><span>👨</span>
        </div>
        <div class="trust-text">
          <strong>3,000+ lives touched</strong> across rural communities in Nigeria
        </div>
      </div>
    </div>

    <div class="hero-image">
      <div class="hero-image-container">
        <img src="./assets/images/girls-education.jpg" alt="Girls Education Program">
        <div class="image-overlay"></div>
        
        <div class="stats-float left">
          <div class="stat-item">
            <div class="stat-icon">💻</div>
            <div class="stat-number">450+</div>
            <div class="stat-label">ICT Graduates</div>
          </div>
        </div>

        <div class="stats-float right">
          <div class="stat-item">
            <div class="stat-icon">🎓</div>
            <div class="stat-number">5+</div>
            <div class="stat-label">Programs Active</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       TICKER
       ══════════════════════════════════════════════════════════════ -->
  <div class="ticker">
    <div class="ticker-content" style="animation-duration: 50s;">
      <span class="ticker-item"><span class="ticker-dot"></span>Skill Development Program</span>
      <span class="ticker-item"><span class="ticker-dot"></span>Education Support Program</span>
      <span class="ticker-item"><span class="ticker-dot"></span>Health Support Program</span>
      <span class="ticker-item"><span class="ticker-dot"></span>Free ICT Training Hub</span>
      <span class="ticker-item"><span class="ticker-dot"></span>SS3 Mock Examination Support</span>
      <span class="ticker-item"><span class="ticker-dot"></span>Community Outreach</span>
      <span class="ticker-item"><span class="ticker-dot"></span>Skill Development Program</span>
      <span class="ticker-item"><span class="ticker-dot"></span>Education Support Program</span>
      <span class="ticker-item"><span class="ticker-dot"></span>Health Support Program</span>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════════════════
       STATS SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="stats-section">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="number">3K+</div>
        <div class="label">Lives Touched Across Rural Communities</div>
      </div>
      <div class="stat-card">
        <div class="number">450+</div>
        <div class="label">ICT Graduates from Free Training Cohorts</div>
      </div>
      <div class="stat-card">
        <div class="number">3</div>
        <div class="label">ICT Cohorts Successfully Completed</div>
      </div>
      <div class="stat-card">
        <div class="number">2018</div>
        <div class="label">Founded & Serving Nigeria Since</div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       ABOUT SECTION WITH CAROUSEL
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="section-subtitle">Our Mission</div>
    <h2 class="section-title">Giving Back to Humanity</h2>

    <div class="about-grid">
      <!-- CAROUSEL -->
      <div class="carousel-about">
        <div class="carousel-container-about">
          <div class="carousel-slide-about active">
            <img src="./assets/images/DSC_0891-1024x679.jpg" alt="We Serve Humanity">
          </div>
          <div class="carousel-slide-about">
            <img src="./assets/images/IMG_8760-1024x683.jpg" alt="Our Mission">
          </div>

          <!-- Controls -->
          <div class="carousel-dots-about">
            <button class="dot-about active" onclick="carouselGoTo(0)"></button>
            <button class="dot-about" onclick="carouselGoTo(1)"></button>
          </div>

          <!-- Arrows -->
          <button class="carousel-btn prev-about" onclick="carouselPrev()">‹</button>
          <button class="carousel-btn next-about" onclick="carouselNext()">›</button>
        </div>
      </div>

      <div class="about-content">
        <h3>Who We Are</h3>
        <p>We are an African-based social impact organization committed to touching lives of rural community dwellers through medical and educational support. Our work is rooted in a deep belief that every person deserves access to quality education and healthcare regardless of their socioeconomic status.</p>

        <h3>Our Approach</h3>
        <p>We are propelled by a passion to ease the burdens of the unfortunate many, especially in rural communities of third-world nations who are being weighed down by the burdens of poverty. We narrow our focus to what we believe forms the core of the issue.</p>

        <h3>Our Vision</h3>
        <p>There is a very loud outcry by this multitude of voiceless underprivileged Africans who are bewildered by the hopelessness of their situation. All they are asking for is a listening ear and a helping hand.</p>

        <a href="about-us.php" class="btn btn-primary" style="margin-top: 1.5rem;">Read Full Story →</a>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       PROGRAMS SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div class="section-subtitle">What We Offer</div>
    <h2 class="section-title">Our Programs</h2>

    <div class="programs-grid">
      <!-- Skill Development -->
      <div class="program-card">
        <div class="program-image">
          <img src="./assets/images/computer_lad-scaled (1).jpg" alt="Skill Development">
          <div class="program-overlay">💻</div>
        </div>
        <div class="program-content">
          <div class="program-icon">💻</div>
          <h3>Skill Development Program</h3>
          <p>Empowering youth with in-demand digital and vocational skills through our fully-equipped ICT Hub — completely tuition-free.</p>
          <a href="icthub.php" class="program-link">Explore the Hub →</a>
        </div>
      </div>

      <!-- Education Support -->
      <div class="program-card">
        <div class="program-image">
          <img src="./assets/images/IMG-20210224-WA0000 (1).jpg" alt="Education Support">
          <div class="program-overlay">📚</div>
        </div>
        <div class="program-content">
          <div class="program-icon">📚</div>
          <h3>Education Support Program</h3>
          <p>Supporting underprivileged SS3 students with mock examinations, study resources, and mentorship ahead of critical WAEC exams.</p>
          <a href="education-support.php" class="program-link">Learn More →</a>
        </div>
      </div>

      <!-- Health Support -->
      <div class="program-card">
        <div class="program-image">
          <img src="./assets/images/IMG_8844-scaled (1).jpg" alt="Health Support">
          <div class="program-overlay">🏥</div>
        </div>
        <div class="program-content">
          <div class="program-icon">🏥</div>
          <h3>Health Support Program</h3>
          <p>Bringing affordable, quality healthcare directly to rural communities where over 35% of Nigerians lack access to basic services.</p>
          <a href="health-support.php" class="program-link">Learn More →</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       OUR AWESOME TEAM SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="section-subtitle">Our Leaders</div>
    <h2 class="section-title">Our Awesome Team</h2>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 3rem; max-width: 600px; margin: 3rem auto 0;">
      <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md); padding: 2rem; text-align: center; transition: all 0.3s;">
        <div style="width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%; overflow: hidden; background: var(--light-gray); box-shadow: 0 0 0 3px var(--primary);">
          <img src="./assets/images/safiya.jpg" alt="Safiya Whoba" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Safiya Whoba</h4>
        <p style="font-size: 0.9rem; color: var(--primary); font-weight: 600;">Trustee</p>
      </div>

      <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md); padding: 2rem; text-align: center; transition: all 0.3s;">
        <div style="width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%; overflow: hidden; background: var(--light-gray); box-shadow: 0 0 0 3px var(--primary);">
          <img src="./assets/images/whoba-ogo.jpg" alt="Whoba Ogo" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Whoba Ogo</h4>
        <p style="font-size: 0.9rem; color: var(--primary); font-weight: 600;">Chairman, Board of Trustee</p>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       NEWS SECTION FROM DATABASE
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
      <div>
        <div class="section-subtitle">Latest Updates</div>
        <h2 class="section-title">Our Recent News</h2>
      </div>
      <a href="our-blog.php" class="btn btn-outline">View All News →</a>
    </div>

    <div class="programs-grid">
      <?php if (!empty($posts)): ?>
        <?php foreach (array_slice($posts, 0, 3) as $post): 
          $publishedDate = new DateTime($post['published_at']);
        ?>
        <div class="program-card">
          <div class="program-image">
            <?php if ($post['featured_image']): ?>
              <img src="<?= htmlspecialchars('assets/images/' . $post['featured_image']) ?>" 
                   alt="<?= htmlspecialchars($post['title']) ?>"
                   onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22400%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2240%22%3E📰%3C/text%3E%3C/svg%3E'">
            <?php else: ?>
              <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--secondary), var(--secondary-dark)); display: flex; align-items: center; justify-content: center; font-size: 3rem;">📰</div>
            <?php endif; ?>
          </div>
          <div class="program-content">
            <div style="font-size: 0.75rem; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">
              <?= htmlspecialchars($post['category_name']) ?>
            </div>
            <h3 style="font-size: 1.15rem;"><?= htmlspecialchars($post['title']) ?></h3>
            <p><?= htmlspecialchars(substr($post['excerpt'], 0, 100)) ?>...</p>
            <a href="<?= htmlspecialchars($post['slug']) ?>" class="program-link">Read Article →</a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--gray);">
          <p>No posts yet. Check back soon for updates!</p>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       CTA & NEWSLETTER
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div class="cta-section">
      <!-- Get Involved Card -->
      <div class="cta-card">
        <div class="cta-content">
          <h3>Get Involved</h3>
          <p>Whether you have time, skills, or resources, there's a way for you to contribute to our mission and help transform lives.</p>
          <a href="volunteer.php" class="btn btn-primary" style="margin-top: 1.5rem;">Become a Volunteer ♥</a>
        </div>
      </div>

      <!-- Contact Card -->
      <div class="cta-card secondary">
        <div class="cta-content">
          <h3>Get in Touch</h3>
          <p>Ready to partner with us or learn more about our work? We'd love to hear from you.</p>
          <div class="contact-info">
            <div class="contact-item">
              <div class="contact-icon">📍</div>
              <span>No. 1 Tafawa Balewa Crescent, Surulere, Lagos</span>
            </div>
            <div class="contact-item">
              <div class="contact-icon">✉</div>
              <a href="mailto:inquiry@whobaogofoundation.org">inquiry@whobaogofoundation.org</a>
            </div>
            <div class="contact-item">
              <div class="contact-icon">📞</div>
              <a href="tel:08180452165">08180452165</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Newsletter -->
    <div class="newsletter">
      <div>
        <h4>Stay Updated</h4>
        <p>Subscribe to our newsletter for the latest updates and opportunities to make a difference.</p>
      </div>
      <form class="newsletter-form" onsubmit="return false;">
        <input type="email" placeholder="Enter your email address" required>
        <button type="submit">Subscribe</button>
      </form>
    </div>
  </section>

</main>

<style>
  /* Carousel Styles for About Section */
  .carousel-about {
    position: relative;
  }

  .carousel-container-about {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    aspect-ratio: 3/4;
    background: #f5f5f5;
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
    display: block;
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
    .carousel-container-about {
      order: -1;
      max-width: 400px;
      margin: 0 auto;
      width: 100%;
    }
  }
</style>

<script>
  let aboutCarouselIndex = 0;
  const aboutSlides = document.querySelectorAll('.carousel-slide-about');
  const aboutDots = document.querySelectorAll('.dot-about');

  function carouselGoTo(n) {
    aboutCarouselIndex = n;
    updateCarousel();
  }

  function carouselNext() {
    aboutCarouselIndex = (aboutCarouselIndex + 1) % aboutSlides.length;
    updateCarousel();
  }

  function carouselPrev() {
    aboutCarouselIndex = (aboutCarouselIndex - 1 + aboutSlides.length) % aboutSlides.length;
    updateCarousel();
  }

  function updateCarousel() {
    aboutSlides.forEach(slide => slide.classList.remove('active'));
    aboutDots.forEach(dot => dot.classList.remove('active'));
    
    aboutSlides[aboutCarouselIndex].classList.add('active');
    aboutDots[aboutCarouselIndex].classList.add('active');
  }

  // Auto-advance carousel every 5 seconds
  setInterval(carouselNext, 5000);

  // Initialize
  updateCarousel();
</script>

<?php include ('./includes/footer.php'); ?>
</body>
</html>