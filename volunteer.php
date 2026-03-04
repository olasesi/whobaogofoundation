<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<style>
  /* ── PAGE HERO BANNER ──────────────────────────── */
  .page-hero {
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                url('/assets/images/volunteer-hero-bg.jpg') center/cover;
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

  /* ── VOLUNTEER PAGE ────────────────────────────── */
  .volunteer-content {
    padding: 5rem 0;
  }

  .volunteer-intro-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: start;
    margin-bottom: 4rem;
  }

  .volunteer-intro-image {
    border-radius: var(--r-sm);
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .volunteer-intro-image img {
    width: 100%;
    height: auto;
    display: block;
  }

  .volunteer-intro-text p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }

  .volunteer-intro-text p strong {
    font-weight: 700;
  }

  .volunteer-intro-text p em {
    font-style: italic;
  }

  /* ── TAGLINE SECTION ───────────────────────────── */
  .volunteer-tagline {
    background: #1db584;
    color: #fff;
    display: inline-block;
    padding: 0.6rem 1.2rem;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    border-radius: 4px;
    letter-spacing: 0.05em;
    margin: 3rem 0 2rem 0;
  }

  /* ── IMPACT SECTION ────────────────────────────── */
  .impact-section {
    margin-bottom: 4rem;
  }

  .impact-label {
    color: var(--red);
    font-weight: 700;
    font-size: 1rem;
  }

  .impact-number {
    font-family: 'Fraunces', serif;
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 900;
    color: var(--ink);
    margin-bottom: 0.5rem;
  }

  .impact-subtitle {
    color: var(--teal);
    font-size: 1.1rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 1rem;
  }

  .impact-description {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }

  /* ── RESPONSIVE ────────────────────────────────– */
  @media (max-width: 768px) {
    .volunteer-content {
      padding: 3rem 0;
    }
    .volunteer-intro-section {
      grid-template-columns: 1fr;
      gap: 2rem;
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
    <h1>Volunteer</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>VOLUNTEER</span>
  </div>
</section>

<!-- ── VOLUNTEER CONTENT ──────────────────────────  -->
<section class="volunteer-content">
  <div class="wrap">
    
    <!-- ── INTRO WITH IMAGE ────────────────────────── -->
    <div class="volunteer-intro-section">
      <div class="volunteer-intro-image">
        <img src="./assets/images/about_refugee_population-700x500.jpg" alt="Volunteer with us" 
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22500%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22400%22 height=%22500%22/%3E%3C/svg%3E'">
      </div>

      <div class="volunteer-intro-text">
        <p>
          UNICEF reports that a sizable number of childern in Nigeria are either out of school or in school where basic teaching facilities are lacking. This leaves millions of children with a very bleak and insure future.
        </p>

        <p>
          WHO also reports that over 35% of Nigerians lack access to affordable health care and most affected of these are children and the aged given that they are most susceptible to health challenges
        </p>

        <p>
          At <strong>WHOBA OGO FOUNDATION(WOF)</strong> we believe that <em>"A health body and an informed mind are recipe for success"</em> so we channel the waves of our passion towards providing <strong>Educational and Health support</strong> to less privileged in communities across Nigeria and beyond.
        </p>
      </div>
    </div>

    <!-- ── TAGLINE ────────────────────────────────── -->
    <div class="volunteer-tagline">Helping Hand | Giving Back to Humanity</div>

    <!-- ── IMPACT SECTION ─────────────────────────── -->
    <div class="impact-section">
      <div class="impact-label">IMPACTING</div>
      <div class="impact-number">2,000,000</div>
      <div class="impact-subtitle">ACROSS 20,000</div>
      <div class="impact-label">COMMUNITIES BY 2025</div>

      <p class="impact-description">
        Our work is focused on providing health support, especially to rural community dwellers, particularly in Nigeria. We work with partners to provide effective diagnostics, drugs and develop innovative approaches to deliver general health services to those who need it most.
      </p>

      <p class="impact-description">
        We are working towards tangibly impacting 2 million lives across 20,000 communities in Africa by the year 2025.
      </p>
    </div>

  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>