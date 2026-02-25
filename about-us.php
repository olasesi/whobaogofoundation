<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<style>
  /* ── PAGE HERO BANNER ──────────────────────────── */
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

  /* ── ABOUT INTRO SECTION ───────────────────────── */
  .about-intro {
    padding: 5rem 0;
  }
  .about-intro-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: flex-start;
  }
  .about-intro-img {
    border-radius: var(--r-2xl);
    overflow: hidden;
    position: relative;
    aspect-ratio: 4/5;
  }
  .about-intro-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .about-label {
    font-size: 0.72rem;
    font-weight: 800;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    margin-bottom: 0.8rem;
  }
  .about-intro h2 {
    font-family: 'Fraunces', serif;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 900;
    color: var(--ink);
    line-height: 1.2;
    margin-bottom: 1.5rem;
  }
  .about-intro p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }

  /* ── ACCORDION SECTION ────────────────────────── */
  .accordion-item {
    border: 1px solid var(--border);
    border-radius: var(--r-md);
    margin-bottom: 1rem;
    overflow: hidden;
    background: var(--white);
  }
  .accordion-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.2rem 1.5rem;
    cursor: pointer;
    background: var(--surface);
    transition: background 0.2s;
  }
  .accordion-header:hover { background: var(--red-soft); }
  .accordion-header.active { background: var(--red-soft); }
  .accordion-title {
    display: flex;
    align-items: center;
    gap: 0.8rem;
  }
  .accordion-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
  }
  .accordion-title h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--ink);
  }
  .accordion-toggle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--red);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: transform 0.3s;
  }
  .accordion-header.active .accordion-toggle { transform: rotate(45deg); }
  .accordion-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }
  .accordion-body-inner {
    padding: 1.5rem;
    color: var(--ink-mid);
    line-height: 1.8;
    font-size: 0.9rem;
  }

  /* ── OUR STORY SECTION ────────────────────────── */
  .our-story {
    background: var(--surface);
    padding: 5rem 0;
  }
  .story-content {
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
  }
  .story-label {
    font-size: 0.72rem;
    font-weight: 800;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    margin-bottom: 0.8rem;
  }
  .story-content h2 {
    font-family: 'Fraunces', serif;
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 900;
    color: var(--ink);
    margin-bottom: 2rem;
  }
  .story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    text-align: left;
    margin-top: 2.5rem;
  }
  .story-grid p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1rem;
  }
  .story-grid p strong {
    color: var(--ink);
    font-weight: 700;
  }
  .story-grid p em {
    font-style: italic;
    color: var(--ink-light);
  }
  .join-btn {
    margin-top: 2.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: transparent;
    border: 2px solid var(--red);
    color: var(--red);
    font-weight: 700;
    font-size: 0.88rem;
    padding: 0.75rem 1.8rem;
    border-radius: 100px;
    transition: background 0.2s, color 0.2s;
  }
  .join-btn:hover {
    background: var(--red);
    color: #fff;
  }

  /* ── OUR TEAM SECTION ─────────────────────────── */
  .our-team-section {
    padding: 5rem 0;
  }
  .team-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  /* ── RESPONSIVE ───────────────────────────────── */
  @media (max-width: 768px) {
    .page-hero {
      flex-direction: column;
      align-items: flex-start;
      padding: 2rem 1.25rem;
      min-height: 240px;
    }
    .breadcrumb {
      margin-top: 1.5rem;
    }
    .about-intro-grid {
      grid-template-columns: 1fr;
      gap: 2.5rem;
    }
    .about-intro-img {
      order: -1;
      max-width: 400px;
      margin: 0 auto;
      width: 100%;
    }
    .story-grid {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>About Us</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>ABOUT US</span>
  </div>
</section>

<!-- ── ABOUT INTRO ─────────────────────────────── -->
<section class="about-intro">
  <div class="wrap">
    <div class="about-intro-grid">
      <!-- Image -->
      <div class="about-intro-img">
        <img src="/assets/images/about-intro.jpg" alt="We Serve Humanity"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22500%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22400%22 height=%22500%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%230D9B7E%22%3E🤝%3C/text%3E%3C/svg%3E'">
      </div>

      <!-- Content -->
      <div class="about-intro-content">
        <div class="about-label">ABOUT US</div>
        <h2>We Serve Humanity</h2>
        <p>
          We are an African based social impact organization committed to touching lives of rural community dwellers through <strong>medical and educational support</strong>.
        </p>

        <!-- Accordion Items -->
        <div class="accordion">
          <div class="accordion-item">
            <div class="accordion-header" onclick="toggleAccordion(this)">
              <div class="accordion-title">
                <span class="accordion-icon">💡</span>
                <h4>Our Vision</h4>
              </div>
              <span class="accordion-toggle">+</span>
            </div>
            <div class="accordion-body">
              <div class="accordion-body-inner">
                To be a major beacon of hope to rural community dwellers across Africa, availing them more opportunity to live healthy lives and fulfill potentials like everyone else.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <div class="accordion-header" onclick="toggleAccordion(this)">
              <div class="accordion-title">
                <span class="accordion-icon">❤️</span>
                <h4>Our Mission</h4>
              </div>
              <span class="accordion-toggle">+</span>
            </div>
            <div class="accordion-body">
              <div class="accordion-body-inner">
                Committed to enhancing the quality of life by supporting initiatives that bring tangible change to rural communities across Nigeria through education, healthcare, and skill development programs.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <div class="accordion-header" onclick="toggleAccordion(this)">
              <div class="accordion-title">
                <span class="accordion-icon">✓</span>
                <h4>Our Values</h4>
              </div>
              <span class="accordion-toggle">+</span>
            </div>
            <div class="accordion-body">
              <div class="accordion-body-inner">
                <strong>Compassion:</strong> We lead with empathy and understanding.<br><br>
                <strong>Integrity:</strong> We operate with transparency and honesty.<br><br>
                <strong>Excellence:</strong> We strive for the highest standards in everything we do.<br><br>
                <strong>Community:</strong> We believe in the power of working together.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── OUR STORY ───────────────────────────────── -->
<section class="our-story">
  <div class="wrap">
    <div class="story-content">
      <div class="story-label">WHERE IT STARTED</div>
      <h2>Our Story</h2>

      <div class="story-grid">
        <div>
          <p>
            We are an African based social impact organization committed to touching lives of rural community dwellers through medical and educational support.
          </p>
          <p>
            We are propelled by a passion to ease the burdens of these unfortunate many, especially in rural communities of third world nations, who are being weighed down by the burdens of poverty. We do this by narrowing our gaze to what we believe forms the core of the issue.
          </p>
          <p>
            As they say, <em>"A healthy body and a healthy (well informed) mind is the sure recipe for success".</em>
          </p>
        </div>

        <div>
          <p>
            Therefore, we channel the waves of our passion towards providing <strong>Educational support</strong> and <strong>Health support</strong> to less privileged communities across the nations where we work.
          </p>
          <p>
            This vision was born in the heart of our founder, Whoba Ogo, who started out his journey of life from very humble beginnings. Having experienced the harsh realities being faced on a daily basis by inhabitants of rural communities, and having also experienced in his own journey the world of difference a helping hand can make in redefining one's future, he decided to set up this foundation to be that 'Helping hand' to many.
          </p>
        </div>
      </div>

      <a href="/contact" class="join-btn">JOIN US NOW</a>
    </div>
  </div>
</section>

<!-- ── OUR TEAM ────────────────────────────────── -->
<section class="our-team-section">
  <div class="wrap">
    <div class="team-header">
      <div class="story-label">OUR TEAM</div>
      <h2 class="hdg">Meet Our Leadership</h2>
    </div>

    <div class="team-grid">
      <div class="team-card rev">
        <div class="team-avatar">
          <img src="/assets/images/safiya.jpg" alt="Safiya Whoba"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">SW</div>
        </div>
        <div class="team-name">Safiya Whoba</div>
        <span class="team-role">Trustee</span>
      </div>

      <div class="team-card rev">
        <div class="team-avatar">
          <img src="/assets/images/whoba-ogo.jpg" alt="Whoba Ogo"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">WO</div>
        </div>
        <div class="team-name">Whoba Ogo</div>
        <span class="team-role">Chairman, Board of Trustee</span>
      </div>
    </div>
  </div>
</section>

</main>

<script>
  function toggleAccordion(header) {
    const item = header.parentElement;
    const body = item.querySelector('.accordion-body');
    const allItems = document.querySelectorAll('.accordion-item');
    
    // Close all other accordions
    allItems.forEach(otherItem => {
      if (otherItem !== item) {
        otherItem.querySelector('.accordion-header').classList.remove('active');
        otherItem.querySelector('.accordion-body').style.maxHeight = '0';
      }
    });
    
    // Toggle current accordion
    header.classList.toggle('active');
    
    if (header.classList.contains('active')) {
      body.style.maxHeight = body.scrollHeight + 'px';
    } else {
      body.style.maxHeight = '0';
    }
  }
</script>

<?php include './includes/footer.php'; ?>