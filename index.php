<?php
require_once './includes/config.php';
require_once './includes/db.php';
include ('./includes/header.php');

// Fetch recent posts from database
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

<!-- ── HERO ────────────────────────────────────── -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot">♥</span>
      African Social Impact Organization
    </div>
    <h1>
      Giving Back<br>
      to <span class="hl">Humanity</span><br>
      Every <span class="tc">Day</span>
    </h1>
    <p class="hero-desc">
      We are an African based social impact organization committed to touching lives of rural community dwellers through medical and educational support.
    </p>
    <div class="hero-btns">
      <a href="about-us.php" class="btn-fill">
        Read More Details <span class="ico">→</span>
      </a>
      
    </div>
    <div class="hero-trust">
      <div class="trust-avatars">
        <span>🧑</span><span>👩</span><span>🧒</span><span>👨</span>
      </div>
      <div class="trust-text">
        <strong>3,000+ lives touched</strong><br>
        across rural communities in Nigeria
      </div>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hv-ring r1"></div>
    <div class="hv-ring r2"></div>
    <div class="hv-card">
      <div class="hv-glow"></div>
      <div class="hv-body">
        <h3>Touching Lives Across Nigeria's Rural Communities</h3>
        <p>Propelled by passion, we ease the burdens of the unfortunate many weighed down by poverty.</p>
        <div class="hv-chips">
          <span class="chip">💻 Skill Development</span>
          <span class="chip">📚 Education Support</span>
          <span class="chip">🏥 Health Support</span>
        </div>
      </div>
    </div>
    <div class="fc a">
      <div class="fc-label">ICT Graduates</div>
      <div class="fc-val">450+</div>
      <div class="fc-sub">Free tuition training</div>
    </div>
    <div class="fc b">
      <div class="fc-ico">🎓</div>
      <div class="fc-label">Programs Active</div>
      <div class="fc-val">5+</div>
      <div class="fc-sub">Nationwide impact</div>
    </div>
  </div>
</section>

<!-- ── TICKER ───────────────────────────────────── -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <span class="ticker-item"><span class="tdot"></span>Skill Development Program</span>
    <span class="ticker-item"><span class="tdot"></span>Education Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Health Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Free ICT Training Hub</span>
    <span class="ticker-item"><span class="tdot"></span>SS3 Mock Examination Support</span>
    <span class="ticker-item"><span class="tdot"></span>Community Outreach</span>
    <span class="ticker-item"><span class="tdot"></span>Skill Development Program</span>
    <span class="ticker-item"><span class="tdot"></span>Education Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Health Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Free ICT Training Hub</span>
    <span class="ticker-item"><span class="tdot"></span>SS3 Mock Examination Support</span>
    <span class="ticker-item"><span class="tdot"></span>Community Outreach</span>
  </div>
</div>

<!-- ── STATS ────────────────────────────────────── -->
<div style="padding: 3rem 0 0;">
  <div class="stats-banner rev">
    <div class="sb-item">
      <div class="sb-num">3K+</div>
      <div class="sb-lbl">Lives Touched Across Rural Communities</div>
    </div>
    <div class="sb-item">
      <div class="sb-num t">450+</div>
      <div class="sb-lbl">ICT Graduates from Free Training Cohorts</div>
    </div>
    <div class="sb-item">
      <div class="sb-num s">3</div>
      <div class="sb-lbl">ICT Cohorts Successfully Completed</div>
    </div>
    <div class="sb-item">
      <div class="sb-num">2018</div>
      <div class="sb-lbl">Founded &amp; Serving Nigeria Since</div>
    </div>
  </div>
</div>

<!-- ── ABOUT ─────────────────────────────────────── -->
<section class="sec">
  <div class="wrap">
    <div class="about-grid">
      <!-- CAROUSEL - 2 IMAGES -->
      <div class="about-vis rev" style="position: relative;">
        <!-- Carousel Container -->
        <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 16px; overflow: hidden; background: #f5f5f5;">
          <!-- Slide 1 -->
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 1; transition: opacity 0.6s ease-in-out; display: flex; align-items: center; justify-content: center;" class="carousel-slide active">
            <img src="./assets/images/DSC_0891-1024x679.jpg" alt="We Serve Humanity" style="width: 100%; height: 100%; object-fit: cover;">
          </div>

          <!-- Slide 2 -->
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 0.6s ease-in-out; display: flex; align-items: center; justify-content: center;" class="carousel-slide">
            <img src="./assets/images/IMG_8760-1024x683.jpg" alt="Our Mission" style="width: 100%; height: 100%; object-fit: cover;">
          </div>

          <!-- Carousel Controls -->
          <div style="position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%); display: flex; gap: 0.8rem; z-index: 10;">
            <button onclick="homeCarouselGoTo(0)" style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); border: none; cursor: pointer; transition: all 0.3s;" class="carousel-dot active"></button>
            <button onclick="homeCarouselGoTo(1)" style="width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); border: none; cursor: pointer; transition: all 0.3s;" class="carousel-dot"></button>
          </div>

          <!-- Carousel Arrows -->
          <button onclick="homeCarouselPrev()" style="position: absolute; top: 50%; left: 1rem; transform: translateY(-50%); width: 48px; height: 48px; background: rgba(0,0,0,0.5); border: none; color: #fff; font-size: 24px; cursor: pointer; border-radius: 50%; transition: background 0.3s; z-index: 10;" onmouseover="this.style.background='rgba(0,0,0,0.8)'" onmouseout="this.style.background='rgba(0,0,0,0.5)'">‹</button>
          <button onclick="homeCarouselNext()" style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); width: 48px; height: 48px; background: rgba(0,0,0,0.5); border: none; color: #fff; font-size: 24px; cursor: pointer; border-radius: 50%; transition: background 0.3s; z-index: 10;" onmouseover="this.style.background='rgba(0,0,0,0.8)'" onmouseout="this.style.background='rgba(0,0,0,0.5)'">›</button>
        </div>

        <!-- Quote Card -->
        <div class="about-quote-card" style="margin-top: 2rem;">
          <p>"We hear their cry; we are here to stretch a hand to help."</p>
          <span>— Whoba Ogo Foundation</span>
        </div>
      </div>

      <div class="about-copy rev d2">
        <div class="eyebrow">Want to Know About Us</div>
        <h2 class="hdg">Giving Back to Humanity</h2>
        <p style="margin-top:0.8rem;">
          We are an African based social impact organization committed to touching lives of rural community dwellers through <strong>medical and educational support</strong>.
        </p>
        <p>
          We are propelled by a passion to ease the burdens of these unfortunate many, especially in rural communities of third world nations, who are being weighed down by the burdens of poverty. We do this by narrowing our gaze to what we believe forms the core of the issue.
        </p>
        <p>
          There is a very loud outcry by this multitude of voiceless underprivileged Africans who are bewildered by the hopelessness of their situation. All they are asking for is a listening ear and helping hand.
        </p>
        <div style="margin-top: 1.5rem;">
          <a href="about-us.php" class="btn-fill">Read More Details <span class="ico">→</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── THREE PILLARS (Mission / Program / Help) ─── -->
<section class="sec pillars-bg">
  <div class="wrap">
    <div style="text-align:center;" class="rev">
      <div class="eyebrow" style="justify-content:center;">To Humanity</div>
      <h2 class="hdg">How We Serve</h2>
    </div>
    <div class="progs-grid">
      <!-- Card 1: Red with background image -->
      <div class="prog-card red-card rev" style="background-image: url('./assets/images/computer_lad-scaled (1).jpg'); background-size: cover; background-position: center; position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1;"></div>
        <div class="prog-body" style="position: relative; z-index: 2;">
          <div class="prog-ico">💻</div>
          <h3 style="color: #fff;">Skill Development Program</h3>
          <p style="color: rgba(255,255,255,0.9);">Empowering youth with in-demand digital and vocational skills through our fully-equipped ICT Hub — completely tuition-free of charge.</p>
          <a href="icthub.php" class="prog-link" style="color: #fff;">Explore the Hub →</a>
        </div>
      </div>

      <!-- Card 2: Teal with background image -->
      <div class="prog-card teal-card rev d1" style="background-image: url('./assets/images/IMG-20210224-WA0000 (1).jpg'); background-size: cover; background-position: center; position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1;"></div>
        <div class="prog-body" style="position: relative; z-index: 2;">
          <div class="prog-ico">📚</div>
          <h3 style="color: #fff;">Education Support Program</h3>
          <p style="color: rgba(255,255,255,0.9);">Supporting underprivileged SS3 students with mock examinations, study resources, and mentorship ahead of critical WAEC examinations.</p>
          <a href="education-support.php" class="prog-link" style="color: #fff;">Learn More →</a>
        </div>
      </div>

      <!-- Card 3: Sun with background image -->
      <div class="prog-card sun-card rev d2" style="background-image: url('./assets/images/IMG_8844-scaled (1).jpg'); background-size: cover; background-position: center; position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1;"></div>
        <div class="prog-body" style="position: relative; z-index: 2;">
          <div class="prog-ico">🏥</div>
          <h3 style="color: #fff;">Health Support Program</h3>
          <p style="color: rgba(255,255,255,0.9);">Bringing affordable, quality healthcare directly to rural communities where over 35% of Nigerians lack access to basic health services.</p>
          <a href="health-support.php" class="prog-link" style="color: #fff;">Learn More →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── MISSION ────────────────────────────────────── -->
<section style="padding: 4rem 0;">
  <div class="mission-wrap rev">
    <div class="mission-grid">
      <div>
        <div class="mission-badge">✦ It Starts With The Passion</div>
        <h2 class="mission-hdg">
          Let's Make the<br>
          World <span class="rc">Better</span> —<br>
          It Starts With <span class="tc">You</span>
        </h2>
        <p class="mission-sub">
          There is a very loud outcry by this multitude of voiceless underprivileged Africans who are bewildered by the hopelessness of their situation. All they are asking for is a listening ear and helping hand.
        </p>
        <a href="donate.php" class="btn-fill">Join Our Mission <span class="ico">♥</span></a>
      </div>
      <div class="mission-facts">
        <div class="mfact">
          <span class="mfact-dot"></span>
          <span>Approximately 1 out of every 3 children in Nigeria is either out of school or is in a school where they are unable to acquire basic literary and numeracy skills.</span>
        </div>
        <div class="mfact">
          <span class="mfact-dot" style="background:var(--teal);"></span>
          <span>Over 35% of Nigerians lack access to affordable health care. The most victimized of these are the children and the elderly. This is because they are most susceptible to health challenges.</span>
        </div>
        <div class="mfact">
          <span class="mfact-dot" style="background:var(--sun);"></span>
          <span><strong style="color:rgba(255,255,255,0.85);">We hear their cry; we are here to stretch a hand to help.</strong></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── TEAM ───────────────────────────────────────── -->
<section class="sec" style="text-align:center;">
  <div class="wrap">
    <div class="rev">
      <div class="eyebrow" style="justify-content:center;">To Humanity</div>
      <h2 class="hdg">Our Awesome Team</h2>
    </div>
    <div class="team-grid">
      <div class="team-card rev d1">
        <div class="team-avatar">
          <img src="assets/images/safiya.jpg" alt="Safiya Whoba"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">SW</div>
        </div>
        <div class="team-name">Safiya Whoba</div>
        <span class="team-role">Trustee</span>
      </div>
      <div class="team-card rev d2">
        <div class="team-avatar">
          <img src="assets/images/whoba-ogo.jpg" alt="Whoba Ogo"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">WO</div>
        </div>
        <div class="team-name">Whoba Ogo</div>
        <span class="team-role">Chairman, Board of Trustee</span>
      </div>
    </div>
  </div>
</section>

<!-- ── NEWS - DYNAMIC FROM DATABASE ───────────────────────────────────────── -->
<section class="sec news-bg">
  <div class="wrap">
    <div class="news-hdr rev">
      <div>
        <div class="eyebrow">To Humanity</div>
        <h2 class="hdg">Our Recent News</h2>
      </div>
      <a href="our-blog.php" class="btn-outline">All News →</a>
    </div>
    <div class="news-grid">
      <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $index => $post): 
          $publishedDate = new DateTime($post['published_at']);
          $isFeature = ($index === 0); // First post is featured
          $cardClass = $isFeature ? 'nc feat' : 'nc';
          $delayClass = '';
          if (!$isFeature) {
            if ($index === 1) $delayClass = 'd1';
            elseif ($index === 2) $delayClass = 'd2';
          }
        ?>
        <div class="<?= $cardClass ?> rev <?= $delayClass ?>">
          <div class="nc-img">
            <div class="nc-img-inner" style="background:linear-gradient(135deg,#0D9B7E,#044030);">
              <?php if ($post['featured_image']): ?>
                <img src="<?= htmlspecialchars($_ENV['BASE_URL'] . 'assets/images/' . $post['featured_image']) ?>" 
                     alt="<?= htmlspecialchars($post['title']) ?>" 
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22400%22 height=%22300%22/%3E%3C/svg%3E'">
              <?php else: ?>
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg,#0D9B7E,#044030); display: flex; align-items: center; justify-content: center; font-size: 3rem;">📰</div>
              <?php endif; ?>
            </div>
            <div class="nc-date"><?= $publishedDate->format('d M') ?></div>
          </div>
          <div class="nc-body">
            <?php if ($post['category_name']): ?>
              <div class="nc-cat"><?= htmlspecialchars($post['category_name']) ?></div>
            <?php endif; ?>
            <h4><?= htmlspecialchars($post['title']) ?></h4>
            <?php if ($post['excerpt']): ?>
              <p><?= htmlspecialchars(substr($post['excerpt'], 0, 120)) ?>...</p>
            <?php endif; ?>
            <a href="/<?= htmlspecialchars($post['slug']) ?>" class="nc-link">Read More →</a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 2rem; color: #888;">
          <p>No posts yet. Check back soon for updates!</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ── CTA ────────────────────────────────────────── -->
<section class="sec">
  <div class="cta-row">
    <div class="cta-card red rev">
      <h3>Help Us Touch More Lives</h3>
      <p>Your contribution — big or small — funds free ICT training, educational support, and healthcare access for those who need it most in Nigeria.</p>
      <a href="donate.php" class="btn-white red-text">Donate Today ♥</a>
    </div>
    <div class="cta-card teal rev d1">
      <h3>Get in Touch With Us</h3>
      <p>Ready to partner, volunteer, or learn more about our work? We'd love to hear from you.</p>
      <a href="contact.php" class="btn-white teal-text">Contact Us →</a>
      <div class="contact-items">
        <div class="ci">
          <span class="ci-ico">📍</span>
          No. 1 Tafawa Balewa Crescent, Surulere, Lagos
        </div>
        <div class="ci">
          <span class="ci-ico">✉</span>
          inquiry@whobaogofoundation.org
        </div>
        <div class="ci">
          <span class="ci-ico">📞</span>
          08180452165
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── NEWSLETTER ─────────────────────────────────── -->
<div class="newsletter">
  <div class="newsletter-inner">
    <div>
      <h4>Newsletter</h4>
      <p>Sign up for our mailing list to get latest updates and offers</p>
    </div>
    <form class="newsletter-form" onsubmit="return false;">
      <input type="email" placeholder="Enter your email address" aria-label="Email address">
      <button type="submit">Subscribe</button>
    </form>
  </div>
</div>

</main>

<script>
  // Home carousel functionality
  let homeCurrentSlide = 0;
  const homeSlides = document.querySelectorAll('.carousel-slide');
  const homeDots = document.querySelectorAll('.carousel-dot');

  function homeShowSlide(n) {
    homeSlides.forEach(slide => slide.style.opacity = '0');
    homeDots.forEach(dot => dot.style.background = 'rgba(255,255,255,0.5)');
    
    homeSlides[n].style.opacity = '1';
    homeDots[n].style.background = '#fff';
    homeDots[n].style.transform = 'scale(1.2)';
  }

  function homeCarouselNext() {
    homeCurrentSlide = (homeCurrentSlide + 1) % homeSlides.length;
    homeShowSlide(homeCurrentSlide);
  }

  function homeCarouselPrev() {
    homeCurrentSlide = (homeCurrentSlide - 1 + homeSlides.length) % homeSlides.length;
    homeShowSlide(homeCurrentSlide);
  }

  function homeCarouselGoTo(n) {
    homeCurrentSlide = n;
    homeShowSlide(homeCurrentSlide);
  }

  // Auto-advance carousel every 5 seconds
  setInterval(homeCarouselNext, 5000);

  // Initialize
  homeShowSlide(0);
</script>

<?php include ('./includes/footer.php'); ?>
</body>
</html>