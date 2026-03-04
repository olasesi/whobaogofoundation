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

  /* ── PROGRAM DETAIL PAGE ───────────────────────── */
  .program-content {
    padding: 5rem 0;
  }
  .program-container {
    max-width: 900px;
    margin: 0 auto;
  }
  
  .program-title {
    font-family: 'Fraunces', serif;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 900;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 2rem;
  }
  
  .program-links {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2.5rem;
  }
  .program-link {
    color: var(--teal);
    font-weight: 600;
    font-size: 0.95rem;
    transition: color 0.2s;
  }
  .program-link:hover {
    color: var(--teal-dark);
    text-decoration: underline;
  }
  
  .program-section {
    margin-bottom: 3rem;
  }
  .program-section h2 {
    font-family: 'Fraunces', serif;
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--ink);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
  }
  .program-section h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--ink);
    margin: 1.5rem 0 1rem;
  }
  .program-section h4 {
    font-weight: 700;
    color: var(--ink);
    margin: 1.2rem 0 0.8rem;
  }
  .program-section p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }
  .program-section ul,
  .program-section ol {
    margin-left: 2rem;
    margin-bottom: 1.5rem;
  }
  .program-section li {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 0.8rem;
  }

  .read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--red);
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 0.8rem 1.8rem;
    border-radius: var(--r-sm);
    transition: background 0.2s, transform 0.15s;
  }
  .read-more-btn:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
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

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 768px) {
    .program-content {
      padding: 3rem 0;
    }
    .program-container {
      padding: 0 1.25rem;
    }
    .program-links {
      flex-direction: column;
      gap: 0.8rem;
    }
    .program-cards {
      grid-template-columns: 1fr;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>Education Support</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <a href="/our-work">OUR WORK</a>
    <span>/</span>
    <span>EDUCATION SUPPORT</span>
  </div>
</section>

<!-- ── PROGRAM CONTENT ────────────────────────────  -->
<section class="program-content">
  <div class="wrap">
    <div class="program-container">
      
      <h1 class="program-title">Access to Education</h1>

      <div class="program-links">
        <a href="https://whobaogofoundation.org/wp-content/uploads/2021/02/Application-Form-1.pdf" class="program-link" target="_blank">Application Form</a>
        <a href="https://whobaogofoundation.org/wp-content/uploads/2021/02/Guarantors-Form-1.pdf" class="program-link" target="_blank">Guarantors Form</a>
      </div>

      <div class="program-section">
        <p>
          We believe that discovery is the bedrock of recovery and our goal is to discover science inclined students and nurture them to growth by supporting them with necessary tools that will focus them in the right direction. We provide access to education and create learning opportunities through Scholarships and Learning resources.
        </p>
      </div>

      <div class="program-section">
        <h2>1. Training</h2>
        <p>
          We partner with various public primary and secondary schools in rural areas to use their facility to establish training centers where we offer free extra-curricular classes for pupils who are in certificate examination classes (Pri 6, JSS 3 and SSS 3).
        </p>
        <p>
          We facilitate this program by liaising with teacher in the community whom we pay an allowance and provide them with teaching aides.
        </p>
        <p>
          We monitor the impact of the trainings by keeping close record of the overall performance of the students both before and after the training program.
        </p>
      </div>

      <div class="program-section">
        <h2>2. Mock Examination</h2>
        <p>
          At the end of the training program, we conduct a 'mock' certificate examination for all the trainees. This examination is usually conducted to be as close to a perfect simulation as possible. This gives the students a foretaste of the examinations and as a result, they have a better chance at performing in well in the real exams.
        </p>
      </div>

      <div class="program-section">
        <h2>3. Scholarship</h2>
        <p>
          Beyond the extra training and the Mock examinations, we offer scholarships to students who exhibit exceptional academic performance in their Certificate examinations.
        </p>
      </div>

      <div class="program-section">
        <h3>SCHOLARSHIP OPPORTUNITIES</h3>

        <h4>Junior Secondary School Scholarships</h4>
        <p>
          This is for students who perform exceptionally in their First School Leaving Certificate Examinations (Primary 6). We sponsor them all the way up to their Junior Secondary School Certificate Examination.
        </p>

        <h4>Senior Secondary School Scholarships</h4>
        <p>
          This is for students who perform exceptionally in their Junior Secondary School Certificate Examination (JSS 3). We sponsor them all the way up to their Senior Secondary School Certificate Examination (SSS 3).
        </p>

        <h4>University Scholarships</h4>
        <p>
          This is for students who perform exceptionally in their Senior Secondary School Certificate Examination. We go ahead and sponsor them all the way through their first degree in any Indigenous university of their choosing, provided they secure admission into the institution.
        </p>

   
        <a href="school-of-nursing-scholarship.php" class="program-link">School of Nursing Scholarship</a>
        
        <p>
          This is for students who has an ambition to be a Nurse. The Foundation will sponsor them to School of Nursing provided they passed the entrance examination and meet the necessary requirement.
        </p>
      </div>

      <a href="school-of-nursing-scholarship.php" class="read-more-btn">
        ⓘ Read More
      </a>

      <!-- Program Cards -->
      <div class="program-cards">
        <div class="prog-card">
          <img src="assets/images/skd-scaled.jpg" alt="Skill Development Program"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22%3E%3Crect fill=%22%23FDE8E8%22 width=%22400%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23E03535%22%3E💻%3C/text%3E%3C/svg%3E'">
          <div class="prog-card-overlay">
            <div class="prog-card-badge">SKILL DEVELOPMENT PROGRAM</div>
          </div>
        </div>

        <div class="prog-card">
          <img src="assets/images/IMG-20210224-WA0000 (1).jpg" alt="Education Support Program"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22400%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%230D9B7E%22%3E📚%3C/text%3E%3C/svg%3E'">
          <div class="prog-card-overlay">
            <div class="prog-card-badge">EDUCATION SUPPORT PROGRAM</div>
          </div>
        </div>

        <div class="prog-card">
          <img src="assets/images/IMG_8844-scaled (1).jpg" alt="Health Support Program"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22%3E%3Crect fill=%22%23FEF3DC%22 width=%22400%22 height=%22300%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2240%22 fill=%22%23F5A623%22%3E🏥%3C/text%3E%3C/svg%3E'">
          <div class="prog-card-overlay">
            <div class="prog-card-badge">HEALTH SUPPORT PROGRAM</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>