<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<style>
  .work-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    aspect-ratio: 4/3;
    display: block;
  }

  .events-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
  .event-card {
    position: relative;
    border-radius: 12px;
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
    background: var(--secondary);
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
    font-size: 1.3rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
  }

  @media (max-width: 768px) {
    .events-grid { grid-template-columns: 1fr; }
  }
</style>

<main>

  <!-- PAGE HERO -->
  <section style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/assets/images/about-hero-bg.jpg') center/cover; min-height: 320px; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; flex-wrap: wrap; gap: 1.5rem;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; line-height: 1.2;">Our Work</h1>
    </div>
    <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(224,53,53,0.9); padding: 0.8rem 1.5rem; border-radius: 100px;">
      <a href="/" style="color: #fff; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">HOME</a>
      <span style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">/</span>
      <span style="color: rgba(255,255,255,0.8); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">OUR WORK</span>
    </div>
  </section>

  <!-- EDUCATION PROGRAM -->
  <section class="section" id="education-support">
    <div class="about-grid">
      <div class="work-img" style="border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-xl);">
        <img src="assets/images/girls-education.jpg" alt="Access to Quality Education"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%230D9B7E%22%3E📚%3C/text%3E%3C/svg%3E'">
      </div>
      <div class="about-content">
        <div class="section-subtitle">EDUCATION</div>
        <h2 class="section-title">Access to Quality Education</h2>
        <p>We believe that discovery is the bedrock of recovery and our goal is to discover students and nurture them to growth by supporting them with necessary tools that will focus them in the right direction. We provide access to education and create learning opportunities through Scholarships and Learning resources.</p>
        <a href="education-support.php" class="btn btn-primary" style="margin-top: 1rem;">Read More →</a>
      </div>
    </div>
  </section>

  <!-- HEALTH PROGRAM -->
  <section class="section section-bg" id="health-support">
    <div class="about-grid">
      <div class="about-content">
        <div class="section-subtitle">HEALTH</div>
        <h2 class="section-title">Quality Health Support</h2>
        <p>We partner with hospitals by making grants available to them which they would use to foot the medical bill of patients who cannot afford to carter for the cost of treatment for their life-threatening medical ailments.</p>
        <p>We also have a very soft spot for the issue of the Sickle Cell Disease. This is especially because Nigeria currently holds the highest count on the number of children born annually with the Sickle Cell Disease globally.</p>
        <a href="health-support.php" class="btn btn-primary" style="margin-top: 1rem;">Read More →</a>
      </div>
      <div class="work-img" style="border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-xl);">
        <img src="assets/images/use-this.jpg" alt="Health Outreach" alt="Quality Health Support"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23FDE8E8%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%23E03535%22%3E🏥%3C/text%3E%3C/svg%3E'">
      </div>
    </div>
  </section>

  <!-- SKILL DEVELOPMENT PROGRAM -->
  <section class="section" id="skill-development">
    <div class="about-grid">
      <div class="work-img" style="border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-xl);">
        <img src="assets/images/cohort-3-training.jpg" alt="Access to Skill Development"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23FEF3DC%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%23F5A623%22%3E💻%3C/text%3E%3C/svg%3E'">
      </div>
      <div class="about-content">
        <div class="section-subtitle">SKILL DEVELOPMENT</div>
        <h2 class="section-title">Access to Skill Development</h2>
        <p>According to the world bank, one third of the working age population in low and middle income countries lack the basic skills required to get quality jobs, leaving them unable to achieve their full productive potential and limiting economic growth and investment, low skills perpetuate poverty and inequality.</p>
        <a href="icthub.php" class="btn btn-primary" style="margin-top: 1rem;">Read More →</a>
      </div>
    </div>
  </section>

  <!-- CHARITY EVENTS -->
  <section class="section section-bg" style="text-align: center;">
    <a href="/volunteer.php" class="btn btn-primary" style="margin-bottom: 2.5rem; display: inline-flex;">Become a Volunteer</a>

    <div class="section-subtitle">GIVING BACK TO HUMANITY</div>
    <h2 class="section-title">Our Charity Events</h2>

    <div class="events-grid" style="margin-top: 3rem; text-align: left;">

      <div class="event-card">
        <img src="assets/images/use-this.jpg" alt="Health Outreach"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%230D9B7E%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22white%22%3E🏥%3C/text%3E%3C/svg%3E'">
        <div class="event-overlay">
          <span class="event-category">READ MORE</span>
          <div class="event-title-vertical">HEALTH OUTREACH</div>
          <div class="event-label">ARENA HEALTHCARE TOWN</div>
          <div class="event-name">Health Outreach</div>
        </div>
      </div>

      <div class="event-card">
        <img src="assets/images/IMG_8760.jpg" alt="Amsul Symposium"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22450%22%3E%3Crect fill=%22%23131511%22 width=%22600%22 height=%22450%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22white%22%3E🎤%3C/text%3E%3C/svg%3E'">
        <div class="event-overlay">
          <span class="event-category">READ MORE</span>
          <div class="event-title-vertical">AMSUL SYMPOSIUM @ LUTH</div>
          <div class="event-label">HE/THE HOMELESS SCHEDULE</div>
          <div class="event-name">Amsul Symposium @ Luth</div>
        </div>
      </div>

    </div>
  </section>

</main>

<?php include './includes/footer.php'; ?>