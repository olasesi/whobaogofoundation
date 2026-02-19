<?php
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

  /* ── WORK CONTENT SECTIONS ─────────────────────── */
  .work-section {
    padding: 5rem 0;
  }
  .work-section:nth-child(even) {
    background: var(--surface);
  }
  
  .work-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
  }
  .work-grid.reverse {
    direction: rtl;
  }
  .work-grid.reverse > * {
    direction: ltr;
  }
  
  .work-img {
    border-radius: var(--r-2xl);
    overflow: hidden;
    position: relative;
  }
  .work-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    aspect-ratio: 4/3;
  }
  
  .work-content .work-label {
    font-size: 0.72rem;
    font-weight: 800;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    margin-bottom: 0.8rem;
  }
  .work-content h2 {
    font-family: 'Fraunces', serif;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 900;
    color: var(--ink);
    line-height: 1.2;
    margin-bottom: 1.5rem;
  }
  .work-content p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
    text-align: justify;
  }
  .read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: transparent;
    border: 2px solid var(--red);
    color: var(--red);
    font-weight: 700;
    font-size: 0.85rem;
    padding: 0.65rem 1.5rem;
    border-radius: 100px;
    transition: background 0.2s, color 0.2s;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }
  .read-more-btn:hover {
    background: var(--red);
    color: #fff;
  }

  /* ── CHARITY EVENTS SECTION ────────────────────── */
  .charity-events {
    padding: 5rem 0;
    text-align: center;
  }
  .volunteer-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--teal);
    color: #fff;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 0.75rem 1.8rem;
    border-radius: 100px;
    transition: background 0.2s;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    margin-bottom: 3.5rem;
  }
  .volunteer-btn:hover {
    background: var(--teal-dark);
  }
  
  .events-label {
    font-size: 0.72rem;
    font-weight: 800;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    margin-bottom: 0.8rem;
  }
  .events-title {
    font-family: 'Fraunces', serif;
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 900;
    color: var(--ink);
    margin-bottom: 3rem;
  }
  
  .events-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
  .event-card {
    position: relative;
    border-radius: var(--r-lg);
    overflow: hidden;
    aspect-ratio: 4/3;
  }
  .event-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .event-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, transparent 60%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 2rem;
  }
  .event-category {
    position: absolute;
    top: 1.5rem;
    left: 1.5rem;
    background: var(--teal);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.4rem 0.9rem;
    border-radius: 100px;
  }
  .event-title-vertical {
    position: absolute;
    left: 1.5rem;
    top: 50%;
    transform: translateY(-50%) rotate(-90deg);
    transform-origin: left center;
    font-family: 'Fraunces', serif;
    font-size: 1.2rem;
    font-weight: 900;
    color: rgba(255,255,255,0.15);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    white-space: nowrap;
  }
  .event-label {
    font-size: 0.7rem;
    font-weight: 800;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 0.5rem;
  }
  .event-name {
    font-family: 'Fraunces', serif;
    font-size: 1.3rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 768px) {
    .work-grid,
    .work-grid.reverse {
      grid-template-columns: 1fr;
      gap: 2.5rem;
      direction: ltr;
    }
    .work-img {
      order: -1;
    }
    .events-grid {
      grid-template-columns: 1fr;
    }
    .work-content p {
      text-align: left;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>Our Work</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>OUR WORK</span>
  </div>
</section>

<!-- ── EDUCATION PROGRAM ───────────────────────── -->
<section class="work-section" id="education-support">
  <div class="wrap">
    <div class="work-grid">
      <div class="work-img">
        <img src="/assets/images/education-program.jpg" alt="Access to Quality Education"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%230D9B7E%22%3E📚%3C/text%3E%3C/svg%3E'">
      </div>
      <div class="work-content">
        <div class="work-label">EDUCATION</div>
        <h2>Access to Quality Education</h2>
        <p>
          We believe that discovery is the bedrock of recovery and our goal is to discover students and nurture them to growth by supporting them with necessary tools that will focus them in the right direction. We provide access to education and create learning opportunities through Scholarships and Learning resources.
        </p>
        <a href="#" class="read-more-btn">Read More</a>
      </div>
    </div>
  </div>
</section>

<!-- ── HEALTH PROGRAM ──────────────────────────── -->
<section class="work-section" id="health-support">
  <div class="wrap">
    <div class="work-grid reverse">
      <div class="work-content">
        <div class="work-label">HEALTH</div>
        <h2>Quality Health Support</h2>
        <p>
          We partner with hospitals by making grants available to them which they would use to foot the medical bill of patients who cannot afford to carter for the cost of treatment for their life-threatening medical ailments.
        </p>
        <p>
          We also have a very soft spot for the issue of the Sickle Cell Disease. This is especially because Nigeria currently holds the highest count on the number of children born annually with the Sickle Cell Disease globally.
        </p>
        <a href="#" class="read-more-btn">Read More</a>
      </div>
      <div class="work-img">
        <img src="/assets/images/health-program.jpg" alt="Quality Health Support"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23FDE8E8%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%23E03535%22%3E🏥%3C/text%3E%3C/svg%3E'">
      </div>
    </div>
  </div>
</section>

<!-- ── SKILL DEVELOPMENT PROGRAM ───────────────── -->
<section class="work-section" id="skill-development">
  <div class="wrap">
    <div class="work-grid">
      <div class="work-img">
        <img src="/assets/images/skill-program.jpg" alt="Access to Skill Development"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23FEF3DC%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%23F5A623%22%3E💻%3C/text%3E%3C/svg%3E'">
      </div>
      <div class="work-content">
        <div class="work-label">SKILL DEVELOPMENT</div>
        <h2>Access to Skill Development</h2>
        <p>
          According to the world bank, one third of the working age population in low and middle income countries lack the basic skills required to get quality jobs, leaving them unable to achieve their full productive potential and limiting economic growth and investment, low skills perpetuate poverty and inequality.
        </p>
        <a href="/ict-hub" class="read-more-btn">Read More</a>
      </div>
    </div>
  </div>
</section>

<!-- ── CHARITY EVENTS ──────────────────────────── -->
<section class="charity-events">
  <div class="wrap">
    <a href="/contact" class="volunteer-btn">Become a Volunteer</a>
    
    <div class="events-label">GIVING BACK TO HUMANITY</div>
    <h2 class="events-title">Our Charity Events</h2>
    
    <div class="events-grid">
      <div class="event-card">
        <img src="/assets/images/event-health.jpg" alt="Health Outreach"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%230D9B7E%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22white%22%3E🏥%3C/text%3E%3C/svg%3E'">
        <div class="event-overlay">
          <span class="event-category">READ MORE</span>
          <div class="event-title-vertical">HEALTH OUTREACH</div>
          <div class="event-label">ARENA HEALTHCARE TOWN</div>
          <div class="event-name">Health Outreach</div>
        </div>
      </div>

      <div class="event-card">
        <img src="/assets/images/event-symposium.jpg" alt="Amsul Symposium"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23131511%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22white%22%3E🎤%3C/text%3E%3C/svg%3E'">
        <div class="event-overlay">
          <span class="event-category">READ MORE</span>
          <div class="event-title-vertical">AMSUL SYMPOSIUM @ LUTH</div>
          <div class="event-label">HE/THE HOMELESS SCHEDULE</div>
          <div class="event-name">Amsul Symposium @ Luth</div>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>