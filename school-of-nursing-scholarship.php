<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<main>

  <!-- PAGE HERO -->
  <section style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('./assets/images/about-hero-bg.jpg') center/cover no-repeat; min-height: 320px; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; flex-wrap: wrap; gap: 1.5rem;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; line-height: 1.2;">School of Nursing Scholarship</h1>
    </div>
    <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(224,53,53,0.9); padding: 0.8rem 1.5rem; border-radius: 100px;">
      <a href="index.php" style="color: #fff; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">HOME</a>
      <span style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">/</span>
      <span style="color: rgba(255,255,255,0.8); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">School of Nursing Scholarship</span>
    </div>
  </section>

  <!-- SCHOLARSHIP CONTENT -->
  <section class="section">
    <div class="section-subtitle">Educational Support</div>
    <h2 class="section-title">Whoba Ogo Foundation School of Nursing Scholarship</h2>

    <div style="max-width: 900px; margin: 2.5rem 0 0;">
      <p style="color: var(--gray); line-height: 1.8; margin-bottom: 1.5rem;">
        In keeping with our cardinal objective of providing educational support, the Whoba Foundation School of Nursing Scholarship is designed to be accessible by students who exhibited exceptional academic performance in their senior secondary certificate examination and also wish to study nursing. This scholarship is available in various categories as some beneficiaries stand a chance of getting 10% – 100% tuition waiver as approved by the board of trustees.
      </p>

      <ol style="margin-left: 1.5rem; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
        <li style="color: var(--gray); line-height: 1.8;">A candidate who meet the eligibility requirement can apply to the foundation via our website or through our liaison office.</li>
        <li style="color: var(--gray); line-height: 1.8;">Shortlisted candidates who meet the requirement for their choice school will be supported in purchasing the application forms to write the entrance examination into the school or designated nursing schools in partnership with the foundation <em>(if any)</em>.</li>
        <li style="color: var(--gray); line-height: 1.8;">The foundation organizes free pre-entrance examination classes/training/tutorials for shortlisted candidates. <em>(This is available only in some states/regions/countries where students lack easy access to education)</em>.</li>
        <li style="color: var(--gray); line-height: 1.8;">Candidates who successfully pass their examination and are offered admission into the chosen school stand a chance of getting between 10% – 100% tuition waiver.</li>
        <li style="color: var(--gray); line-height: 1.8;">Passing the entrance examination for a chosen nursing school does not guarantee automatic scholarship for any student. The scholarship is highly competitive as the foundation gets thousands of applicants each year and the number of beneficiaries each year is determined by the board. However, students who pass their examination and are offered admission in their choice school of nursing stand a chance of being selected as beneficiaries of this scholarship program.</li>
        <li style="color: var(--gray); line-height: 1.8;">The scholarship package for each beneficiary <em>(part or full tuition payment and the duration of the scholarship)</em> is to be determined by the board.</li>
        <li style="color: var(--gray); line-height: 1.8;">After the examination, candidates who passed and have been offered admission, would write a letter to the foundation, attaching a copy of their result and offer of admission and indicate their interest by apply for the scholarship.</li>
      </ol>
    </div>
  </section>

  <!-- ELIGIBILITY REQUIREMENTS -->
  <section class="section section-bg">
    <div class="section-subtitle">Qualifications</div>
    <h2 class="section-title">Eligibility Requirements</h2>

    <div style="max-width: 900px; margin: 2.5rem 0 0;">
      <ol style="margin-left: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        <li style="color: var(--gray); line-height: 1.8;">Candidate must be between the ages of 17 and 20 years.</li>
        <li style="color: var(--gray); line-height: 1.8;">Candidate who graduated from secondary school within the last 3 years.</li>
        <li style="color: var(--gray); line-height: 1.8;">Candidate must have a minimum of 5 credits including Mathematics and English.</li>
      </ol>
    </div>
  </section>

  <!-- APPLICATION BUTTONS -->
  <section class="section">
    <p style="color: var(--gray); line-height: 1.8; margin-bottom: 2.5rem; max-width: 900px;">
      The candidate that meets the above criteria: are to choose any of their preferable school of nursing, interested candidate should click here to apply
    </p>

    <div class="cta-section" style="max-width: 900px;">
      <div class="cta-card">
        <div class="cta-content">
          <h3>Fill Online Scholarship Application Form</h3>
          <a href="#" class="btn btn-primary" style="background: #fff; color: var(--primary); margin-top: 1.5rem; display: inline-flex;">Apply Online →</a>
        </div>
      </div>

      <div class="cta-card secondary">
        <div class="cta-content">
          <h3>Download Scholarship Application Form / Requirement</h3>
          <a href="#" class="btn btn-primary" style="background: #fff; color: var(--secondary-dark); margin-top: 1.5rem; display: inline-flex;">Download Form ⬇</a>
        </div>
      </div>
    </div>

    <p style="color: var(--primary); font-weight: 700; font-size: 1rem; margin-top: 1.5rem;">
      To be printed in colored ONLY
    </p>
  </section>

</main>

<?php include './includes/footer.php'; ?>