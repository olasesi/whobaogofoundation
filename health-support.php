<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<style>
  /* ── PAGE HERO BANNER ──────────────────────────── */
  .page-hero {
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                url('/assets/images/health-hero-bg.jpg') center/cover;
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

  /* ── HEALTH SUPPORT PAGE ───────────────────────── */
  .health-content {
    padding: 5rem 0;
  }
  .health-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
  }

  /* ── TITLE SECTION ─────────────────────────────── */
  .health-title {
    font-family: 'Fraunces', serif;
    font-size: clamp(1.8rem, 3vw, 2.2rem);
    font-weight: 900;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 2.5rem;
    text-align: center;
  }

  /* ── PROGRAMS SECTIONS ─────────────────────────── */
  .program-section {
    margin-bottom: 4rem;
  }

  .program-number {
    font-family: 'Fraunces', serif;
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
  }

  .program-title {
    font-family: 'Fraunces', serif;
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--ink-dark);
    margin-bottom: 1.5rem;
    text-transform: capitalize;
  }

  .program-content p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }

  .program-content p em {
    font-style: italic;
  }

  .program-content p strong {
    font-weight: 700;
  }

  /* ── APPROACH SECTION ──────────────────────────── */
  .approach-section {
    background: #f9f9f9;
    padding: 3rem 2rem;
    border-radius: var(--r-sm);
    margin: 4rem 0;
  }

  .approach-title {
    font-family: 'Fraunces', serif;
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    text-align: center;
  }

  .approach-content {
    max-width: 900px;
    margin: 0 auto;
  }

  .approach-content p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }

  /* ── IMPACT SECTION ────────────────────────────── */
  .impact-section {
    background: var(--red);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--r-sm);
    margin: 3rem 0;
    text-align: center;
  }

  .impact-tagline {
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1rem;
    opacity: 0.9;
  }

  .impact-number {
    font-family: 'Fraunces', serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 900;
    margin-bottom: 0.5rem;
  }

  .impact-description {
    font-size: 1rem;
    line-height: 1.8;
    max-width: 600px;
    margin: 0 auto 1.5rem;
  }

  /* ── ACHIEVEMENTS & GOALS ──────────────────────── */
  .achievements-title {
    font-family: 'Fraunces', serif;
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 2rem;
    text-align: center;
  }

  .achievement-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
  }

  .achievement-item {
    background: #f9f9f9;
    padding: 2rem;
    border-radius: var(--r-sm);
    border-top: 4px solid var(--red);
  }

  .achievement-item h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 0.75rem;
  }

  .achievement-item p {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--ink-mid);
    margin: 0;
  }

  /* ── PROGRAM CARDS ─────────────────────────────── */
  .program-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 3rem;
  }

  .prog-card {
    position: relative;
    border-radius: var(--r-lg);
    overflow: hidden;
    aspect-ratio: 4/3;
    cursor: pointer;
    transition: transform 0.3s;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
  }

  .prog-card:hover {
    transform: translateY(-4px);
  }

  .prog-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .prog-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, transparent 50%);
    display: flex;
    align-items: flex-end;
    padding: 1.5rem;
  }

  .prog-card-badge {
    background: var(--teal);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.5rem 1rem;
    border-radius: 100px;
  }

  /* ── RESPONSIVE ────────────────────────────────– */
  @media (max-width: 768px) {
    .health-content {
      padding: 3rem 0;
    }
    .health-container {
      padding: 0 1.25rem;
    }
    .achievement-grid {
      grid-template-columns: 1fr;
    }
    .program-cards {
      grid-template-columns: 1fr;
    }
    .page-hero {
      flex-direction: column;
      align-items: flex-start;
      gap: 2rem;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>Health Support</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
   
    <span>HEALTH SUPPORT</span>
  </div>
</section>

<!-- ── HEALTH CONTENT ────────────────────────────── -->
<section class="health-content">
  <div class="health-container">

    <h1 class="health-title">Health Support Programs</h1>

    <!-- ── PROGRAM 1: HEALTH GRANTS ───────────────── -->
    <div class="program-section">
      <div class="program-number">1. HEALTH GRANTS</div>
      <div class="program-title">Healthcare Funding & Support</div>

      <p>
        We partner with hospitals by making grants available to them which they would use to foot the medical bill of patients who cannot afford to cater for the cost of treatment for their life-threatening medical ailments.
      </p>

      <p>
        Potential beneficiaries are vetted by a team consisting of at least a program officer from our organization and a member of the medical team directly overseeing the patient.
      </p>
    </div>

    <!-- ── PROGRAM 2: SICKLE CELL CAMPAIGN ──────────── -->
    <div class="program-section">
      <div class="program-number">2. Save the Sickle Cell Child Campaign (SSCC)</div>
      <div class="program-title">Supporting Sickle Cell Patients</div>

      <p>
        We have a very soft spot for the issue of the Sickle Cell Disease. This is especially because Nigeria currently holds the highest count on the number of children born annually with the Sickle Cell Disease globally.
      </p>

      <p>
        Our objective with this campaign is to reach as many rural communities as possible with information on ways to avoid the issue as well as the best available ways to manage victims of the Sickle Cell Disease to enable them to have as much a normal life as possible.
      </p>
    </div>

    <!-- ── PROGRAM 3: HEALTH AND WELLNESS CAMPAIGNS ── -->
    <div class="program-section">
      <div class="program-number">3. Health and Wellness Campaigns</div>
      <div class="program-title">Community Health Education</div>

      <p>
        Periodically, we carry out health awareness campaigns aimed at bringing basic information which everyone needs to know and apply in order to live at optimum health or at least mitigate avoidable health complications. These campaigns are usually comprised of health talks and basic medical tests which we provide free of charge to every member of our audience.
      </p>
    </div>

    <!-- ── OUR APPROACH ──────────────────────────– -->
    <div class="approach-section">
      <h3 class="approach-title">Let Save Humanity</h3>
      <div class="approach-content">
        <p>
          Our work is focused on providing health support, especially to rural community dwellers, particularly in Nigeria. We work with partners to provide effective diagnostics, drugs and develop innovative approaches to deliver general health services to those who need it most.
        </p>

        <p>
          We are working towards tangibly impacting 2 million lives across 20,000 communities in Africa by the year 2025.
        </p>
      </div>
    </div>

    <!-- ── IMPACT & GOALS ────────────────────────── -->
    <div class="achievement-grid">
      <div class="achievement-item">
        <h3>Our Mission</h3>
        <p>
          Provide accessible healthcare support to underserved communities, ensuring that financial constraints do not prevent individuals from receiving life-saving medical treatment.
        </p>
      </div>

      <div class="achievement-item">
        <h3>Our Vision</h3>
        <p>
          Transform healthcare delivery in rural Nigeria by establishing sustainable health infrastructure and community-based health initiatives that empower people to achieve optimal wellness.
        </p>
      </div>

      <div class="achievement-item">
        <h3>Our Approach</h3>
        <p>
          We combine grant funding, community education, and partnerships with medical institutions to create a comprehensive health support system for vulnerable populations.
        </p>
      </div>

      <div class="achievement-item">
        <h3>Our Goal</h3>
        <p>
          Impact 2 million lives across 20,000 communities by 2025 through health grants, disease prevention campaigns, and sustainable healthcare initiatives.
        </p>
      </div>
    </div>

    <!-- ── WE WORK TOWARDS ──────────────────────── -->
    <div class="impact-section">
      <div class="impact-tagline">We Work Towards Achieving This By:</div>
      
      <div style="max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 1rem;">
          <div style="color: var(--red); font-size: 1.5rem; flex-shrink: 0;">▶</div>
          <p style="text-align: left; margin: 0;">Embarking on massive enlightenment campaigns in both rural and urban communities.</p>
        </div>

        <div style="margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 1rem;">
          <div style="color: var(--red); font-size: 1.5rem; flex-shrink: 0;">▶</div>
          <p style="text-align: left; margin: 0;">Planting clubs in secondary schools. This sinks the message deep in the hearts of these young ones who grow to become natural ambassadors of the SSCC Campaign.</p>
        </div>

        <div style="margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 1rem;">
          <div style="color: var(--red); font-size: 1.5rem; flex-shrink: 0;">▶</div>
          <p style="text-align: left; margin: 0;">Partnering with cottage hospitals and medical centers in rural communities by providing grants and aid to enable the members of the community access proper medical treatment when/if a crisis occurs.</p>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 1rem;">
          <div style="color: var(--red); font-size: 1.5rem; flex-shrink: 0;">▶</div>
          <p style="text-align: left; margin: 0;">Establish medical centers in locations where none exists to cater for the medical needs of the community dwellers.</p>
        </div>
      </div>
    </div>

  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>