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
  .volunteer-container {
    max-width: 900px;
    margin: 0 auto;
  }

  .volunteer-title {
    font-family: 'Fraunces', serif;
    font-size: clamp(1.8rem, 3vw, 2.2rem);
    font-weight: 900;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 2.5rem;
    text-align: center;
  }

  .volunteer-section {
    margin-bottom: 3rem;
  }
  .volunteer-section p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }
  .volunteer-section p em {
    font-style: italic;
  }
  .volunteer-section p strong {
    font-weight: 700;
  }

  .volunteer-section ol {
    margin-left: 2rem;
    margin-bottom: 1.5rem;
  }
  .volunteer-section li {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1rem;
  }
  .volunteer-section li em {
    font-style: italic;
  }
  .volunteer-section li strong {
    font-weight: 700;
  }

  /* ── REQUIREMENTS SECTION ──────────────────────── */
  .requirements-title {
    font-family: 'Fraunces', serif;
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 1.5rem;
  }

  .requirement-item {
    background: #f9f9f9;
    padding: 1.5rem;
    border-radius: var(--r-sm);
    margin-bottom: 1.2rem;
    border-left: 4px solid var(--red);
  }
  .requirement-item h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--red);
    margin-bottom: 0.5rem;
  }
  .requirement-item p {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--ink-mid);
    margin: 0;
  }

  /* ── APPLICATION BUTTONS ───────────────────────── */
  .application-info {
    margin: 3rem 0;
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
    text-decoration: none;
  }
  .app-btn:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
  }
  .app-btn-icon {
    font-size: 1.1rem;
  }

  .info-note {
    text-align: center;
    color: var(--red);
    font-weight: 700;
    font-size: 1.05rem;
  }

  /* ── WHY VOLUNTEER SECTION ─────────────────────── */
  .why-volunteer {
    background: #f9f9f9;
    padding: 2.5rem;
    border-radius: var(--r-sm);
    margin-bottom: 3rem;
  }
  .why-volunteer h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 1.5rem;
  }
  .benefit-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
  }
  .benefit-item {
    display: flex;
    gap: 1rem;
  }
  .benefit-icon {
    font-size: 1.5rem;
    color: var(--red);
    flex-shrink: 0;
    margin-top: 0.2rem;
  }
  .benefit-text {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--ink-mid);
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 768px) {
    .volunteer-content {
      padding: 3rem 0;
    }
    .volunteer-container {
      padding: 0 1.25rem;
    }
    .application-buttons {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }
    .benefit-list {
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
    <h1>Volunteer With Us</h1>
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
    <div class="volunteer-container">
      
      <h1 class="volunteer-title">Make a Difference With Whoba Ogo Foundation</h1>

      <div class="volunteer-section">
        <p>
          At Whoba Ogo Foundation, we believe that meaningful change happens when dedicated individuals come together to support our mission. We are committed to bringing about enhanced education and better health care for people in Nigeria and beyond. If you share our passion for making a real impact in underserved communities, we invite you to volunteer with us.
        </p>

        <p>
          Volunteering with Whoba Ogo Foundation offers an opportunity to directly contribute to educational advancement and healthcare improvement across Nigeria. Whether you have professional expertise, local knowledge, or simply a desire to help, there are volunteer roles suited to your skills and availability.
        </p>
      </div>

      <!-- ── WHY VOLUNTEER SECTION ────────────────── -->
      <div class="why-volunteer">
        <h3>Why Volunteer With Us?</h3>
        <div class="benefit-list">
          <div class="benefit-item">
            <div class="benefit-icon">✓</div>
            <div class="benefit-text"><strong>Direct Impact:</strong> See firsthand the difference you make in education and healthcare delivery</div>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon">✓</div>
            <div class="benefit-text"><strong>Skill Development:</strong> Gain valuable experience and develop new competencies</div>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon">✓</div>
            <div class="benefit-text"><strong>Community Connection:</strong> Build relationships with communities and fellow volunteers</div>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon">✓</div>
            <div class="benefit-text"><strong>Make a Statement:</strong> Be part of a movement towards sustainable development</div>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon">✓</div>
            <div class="benefit-text"><strong>Flexible Commitment:</strong> Volunteer part-time, full-time, or for specific projects</div>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon">✓</div>
            <div class="benefit-text"><strong>Recognition:</strong> Your contributions are valued and recognized by our team</div>
          </div>
        </div>
      </div>

      <!-- ── VOLUNTEER OPPORTUNITIES ───────────────── -->
      <div class="volunteer-section">
        <h2 class="requirements-title">Volunteer Opportunities</h2>
        
        <div class="requirement-item">
          <h3>Healthcare Support Volunteers</h3>
          <p>Assist in health outreach programs, community health education, and healthcare initiatives. Ideal for medical professionals, nurses, health educators, or healthcare enthusiasts.</p>
        </div>

        <div class="requirement-item">
          <h3>Education Support Volunteers</h3>
          <p>Contribute to educational programs including tutoring, curriculum development, and educational workshops. Great for teachers, academics, and education professionals.</p>
        </div>

        <div class="requirement-item">
          <h3>Administrative & Coordination Volunteers</h3>
          <p>Help with program coordination, data management, event organization, and administrative support. Suitable for professionals with project management or organizational skills.</p>
        </div>

        <div class="requirement-item">
          <h3>Community Outreach Volunteers</h3>
          <p>Engage directly with communities, facilitate workshops, and help build relationships with beneficiaries. Open to individuals with strong communication and interpersonal skills.</p>
        </div>

        <div class="requirement-item">
          <h3>Technical & IT Volunteers</h3>
          <p>Support our ICT Hub initiatives, provide tech training, and help with digital infrastructure. Perfect for software developers, IT professionals, and tech enthusiasts.</p>
        </div>
      </div>

      <!-- ── ELIGIBILITY REQUIREMENTS ───────────────── -->
      <div class="volunteer-section">
        <h2 class="requirements-title">Who Can Volunteer?</h2>
        
        <ol>
          <li><strong>Minimum Age:</strong> Volunteers should be at least 18 years old (or 16+ with parental consent for specific programs)</li>
          
          <li><strong>Commitment:</strong> A willingness to commit to volunteer work with consistency and dedication</li>
          
          <li><strong>Skills & Experience:</strong> Relevant skills, professional expertise, or genuine enthusiasm are preferred but not mandatory</li>
          
          <li><strong>Background Check:</strong> Volunteers working with vulnerable populations must clear a background check</li>
          
          <li><strong>Communication:</strong> Ability to communicate effectively in English and/or local languages is beneficial</li>
          
          <li><strong>Reliability:</strong> Dependability and punctuality are essential for program success</li>
        </ol>
      </div>

      <!-- ── HOW TO GET INVOLVED ────────────────────── -->
      <div class="volunteer-section">
        <h2 class="requirements-title">How to Get Involved</h2>
        
        <ol>
          <li><strong>Complete the Application:</strong> Fill out our volunteer application form with information about your background and interests</li>
          
          <li><strong>Initial Screening:</strong> Our team will review your application and contact you for an initial conversation</li>
          
          <li><strong>Orientation & Training:</strong> Selected volunteers will participate in an orientation program and receive relevant training for their role</li>
          
          <li><strong>Begin Your Journey:</strong> Start your volunteer experience and make a tangible difference in lives across Nigeria and beyond</li>
        </ol>
      </div>

      <!-- ── APPLICATION INFO ──────────────────────── -->
      <div class="application-info">
        <p>
          Ready to make a difference? Join us in our mission to transform communities through education and healthcare support.
        </p>

        <div class="application-buttons">
          <a href="#" class="app-btn">
            <span class="app-btn-icon">ⓘ</span>
            Volunteer Application Form
          </a>
          
          <a href="#" class="app-btn">
            <span class="app-btn-icon">⬇</span>
            Download Volunteer Information
          </a>
        </div>

        <p class="info-note">Questions? Contact us at info@whaboagofoundation.org</p>
      </div>

    </div>
  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>