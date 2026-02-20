<?php
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
  /* ── SCHOLARSHIP PAGE ──────────────────────────── */
  .scholarship-content {
    padding: 5rem 0;
  }
  .scholarship-container {
    max-width: 900px;
    margin: 0 auto;
  }
  
  .scholarship-title {
    font-family: 'Fraunces', serif;
    font-size: clamp(1.8rem, 3vw, 2.2rem);
    font-weight: 900;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 2.5rem;
    text-align: center;
  }
  
  .scholarship-section {
    margin-bottom: 3rem;
  }
  .scholarship-section p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }
  .scholarship-section p em {
    font-style: italic;
  }
  
  .scholarship-section ol {
    margin-left: 2rem;
    margin-bottom: 1.5rem;
  }
  .scholarship-section li {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1rem;
  }
  .scholarship-section li em {
    font-style: italic;
  }

  /* ── ELIGIBILITY SECTION ───────────────────────── */
  .eligibility-title {
    font-family: 'Fraunces', serif;
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 1.5rem;
  }

  /* ── APPLICATION BUTTONS ───────────────────────── */
  .application-info {
    margin: 2.5rem 0;
  }
  .application-info p {
    font-size: 0.95rem;
    color: var(--ink-mid);
    margin-bottom: 2rem;
  }
  
  .application-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 1rem;
  }
  .app-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    background: var(--red);
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 1rem 1.5rem;
    border-radius: var(--r-sm);
    text-align: center;
    transition: background 0.2s, transform 0.15s;
  }
  .app-btn:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
  }
  .app-btn-icon {
    font-size: 1.1rem;
  }
  
  .print-note {
    text-align: center;
    color: var(--red);
    font-weight: 700;
    font-size: 1.05rem;
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 768px) {
    .scholarship-content {
      padding: 3rem 0;
    }
    .scholarship-container {
      padding: 0 1.25rem;
    }
    .application-buttons {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>School of Nursing Scholarship</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>SCHOOL OF NURSING SCHOLARSHIP</span>
  </div>
</section>

<!-- ── SCHOLARSHIP CONTENT ────────────────────────  -->
<section class="scholarship-content">
  <div class="wrap">
    <div class="scholarship-container">
      
      <h1 class="scholarship-title">Whoba Ogo Foundation School of Nursing Scholarship</h1>

      <div class="scholarship-section">
        <p>
          In keeping with our cardinal objective of providing educational support, the Whoba Foundation School of Nursing Scholarship is designed to be accessible by students who exhibited exceptional academic performance in their senior secondary certificate examination and also wish to study nursing. This scholarship is available in various categories as some beneficiaries stand a chance of getting 10% – 100% tuition waiver as approved by the board of trustees.
        </p>

        <ol>
          <li>A candidate who meet the eligibility requirement can apply to the foundation via our website or through our liaison office.</li>
          
          <li>Shortlisted candidates who meet the requirement for their choice school will be supported in purchasing the application forms to write the entrance examination into the school or designated nursing schools in partnership with the foundation <em>(if any)</em>.</li>
          
          <li>The foundation organizes free pre-entrance examination classes/training/tutorials for shortlisted candidates. <em>(This is available only in some states/regions/countries where students lack easy access to education)</em>.</li>
          
          <li>Candidates who successfully pass their examination and are offered admission into the chosen school stand a chance of getting between 10% – 100% tuition waiver.</li>
          
          <li>Passing the entrance examination for a chosen nursing school does not guarantee automatic scholarship for any student. The scholarship is highly competitive as the foundation gets thousands of applicants each year and the number of beneficiaries each year is determined by the board. However, students who pass their examination and are offered admission in their choice school of nursing stand a chance of being selected as beneficiaries of this scholarship program.</li>
          
          <li>The scholarship package for each beneficiary <em>(part or full tuition payment and the duration of the scholarship)</em> is to be determined by the board.</li>
          
          <li>After the examination, candidates who passed and have been offered admission, would write a letter to the foundation, attaching a copy of their result and offer of admission and indicate their interest by apply for the scholarship.</li>
        </ol>
      </div>

      <div class="scholarship-section">
        <h2 class="eligibility-title">Eligibility Requirements</h2>
        
        <ol>
          <li>Candidate must be between the ages of 17 and 20 years.</li>
          <li>Candidate who graduated from secondary school within the last 3 three years</li>
          <li>Candidate must have a minimum of 5 credits including Mathematics and English</li>
        </ol>
      </div>

      <div class="application-info">
        <p>
          The candidate that meets the above criteria: are to choose any of their preferable school of nursing, interested candidate should click here to apply
        </p>

        <div class="application-buttons">
          <a href="#" class="app-btn">
            <span class="app-btn-icon">ⓘ</span>
            Fill Online Scholarship Application Form
          </a>
          
          <a href="#" class="app-btn">
            <span class="app-btn-icon">⬇</span>
            Download Scholarship Application Form/ Requirement
          </a>
        </div>

        <p class="print-note">To be printed in colored ONLY</p>
      </div>

    </div>
  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>