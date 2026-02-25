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

  /* ── ICT HUB CONTENT ───────────────────────────── */
  .ict-content {
    padding: 5rem 0;
  }
  .ict-header {
    text-align: center;
    margin-bottom: 3rem;
  }
  .ict-header h1 {
    font-family: 'Fraunces', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900;
    color: var(--red);
    text-transform: uppercase;
    margin-bottom: 2rem;
  }
  
  .ict-section {
    max-width: 900px;
    margin: 0 auto 3rem;
  }
  .ict-section h2 {
    font-family: 'Fraunces', serif;
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--ink);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
  }
  .ict-section h3 {
    font-family: 'Fraunces', serif;
    font-size: 1rem;
    font-weight: 900;
    color: var(--ink);
    text-transform: uppercase;
    margin: 1.5rem 0 1rem;
  }
  .ict-section p {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
    text-align: justify;
  }
  .ict-section p strong {
    color: var(--ink);
    font-weight: 700;
  }
  
  .ict-section ul,
  .ict-section ol {
    margin-left: 2rem;
    margin-bottom: 1.5rem;
  }
  .ict-section li {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
    margin-bottom: 1rem;
  }
  .ict-section li strong {
    color: var(--ink);
  }

  /* ── APPLICATION BUTTON ────────────────────────── */
  .apply-section {
    text-align: center;
    margin: 3rem auto;
    padding: 2rem;
  }
  .apply-btn-image {
    display: inline-block;
    transition: transform 0.3s;
  }
  .apply-btn-image:hover {
    transform: scale(1.05);
  }
  .apply-btn-image img {
    max-width: 500px;
    width: 100%;
    height: auto;
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 768px) {
    .ict-content {
      padding: 3rem 0;
    }
    .ict-section {
      padding: 0 1.25rem;
    }
    .ict-section p {
      text-align: left;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>ICT Hub</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>ICT HUB</span>
  </div>
</section>

<!-- ── ICT HUB CONTENT ─────────────────────────── -->
<section class="ict-content">
  <div class="wrap">
    
    <div class="ict-header">
      <h1>ICT Innovation Hub</h1>
    </div>

    <div class="ict-section">
      <h2>WHOBA OGO FOUNDATION</h2>
      <p>
        The ICT Hub is a Tech Initiative sponsored by the Whoba Ogo Foundation with a vision to empower IT enthusiasts who have developed passion for technology. The training is available for over Five hundred (500) students, undergraduates and youths across Nigeria. The pioneer ICT Hub is set to kick off in Imo state, Nigeria.
      </p>
    </div>

    <div class="ict-section">
      <h2>ICT HUB GOAL:</h2>
      <ol>
        <li>The Hub will create an ICT center where participants who are financially constrained can also have equal opportunities to pursue and fulfil their ambitions through acquisition of relevant ICT skills.</li>
        <li>The goal of the program among others is to support aspiring individuals in the tech industry by providing specialized training and workshop in emerging IT related courses.</li>
      </ol>
    </div>

    <div class="ict-section">
      <h2>COURSES:</h2>
      <p>
        The ICT Hub will provide essential and high demand ICT skills in <strong>Graphics Design, Web Design, Desktop Publishing, Digital Marketing & Content Creation, FullStack Development, Mobile/Android/iOS Operating System Development.</strong> The training will run through a duration of 2-6months depending on the volume and depth of the courses.
      </p>
      <p>These courses are divided into two (2)</p>
    </div>

    <div class="ict-section">
      <h2>COURSE DURATION:</h2>
      <ol>
        <li>
          <strong>2-3 Month Duration:</strong> This includes courses such as; <strong>Digital Marketing/Content Creation, Web Design, Graphics Design.</strong> The 2-3 Month course is designed to provide a focused and intensive learning experience within a relatively short timeframe, students can gain essential knowledge and skills in their chosen field.
        </li>
        <li>
          <strong>6-Month Duration:</strong> This includes courses such as; <strong>Mobile/Android/iOS Operating System, Development, FullStack Development.</strong> The 6-month course offers a comprehensive and in-depth learning experience, providing adequate time for students to be integrated into the advance concepts with practical application.
        </li>
      </ol>
    </div>

    <div class="ict-section">
      <h2>COURSE SUMMARY:</h2>
      <ol>
        <li>
          <strong>Graphics Design:</strong> Participants of this course will equip themselves with extensive graphics knowledge. This will enable participants to create stunning designs for both "print media and web purposes". Software such as: <strong>Photoshop, Adobe Photoshop, Adobe Illustrator & CorelDRAW</strong> among others will be mastered.
        </li>
        <li>
          <strong>Web Design:</strong> This course trains participants to create personal and professional websites for <strong>Schools, Companies, Churches, NGO's & E-commerce</strong> with the use of <strong>WordPress & Elementor as well as other CMS (Content Management System) plugins.</strong>
        </li>
        <li>
          <strong>Desktop Publishing:</strong> This combines a wide range of knowledge allowing participants to gain mastery of <strong>Office technologies (Microsoft Office, Word, Excel, PowerPoint), Publishing technologies</strong> such as; <strong>Adobe Page Maker, CorelDRAW</strong>
        </li>
        <li>
          <strong>FullStack Development:</strong> This enables participants to create custom-and-tailor made Web & Mobile applications using <strong>Programming languages such as; JavaScript, React, Node.JS, Python, MongoDB, Express.JS, HTML, CSS, Bootstrap</strong>
        </li>
        <li>
          <strong>Mobile/Android/iOS Operating System Development:</strong> This package involves creating applications specifically designed for smartphones and tablets running on Android Operating System. Here are extensive things that <strong>Mobile/Android/iOS Operating System Development</strong> include: <strong>Java/Kotlin programming, Android Studio Android architecture components, App optimization and performance.</strong>
        </li>
        <li>
          <strong>Videography & Audio Editing:</strong>
        </li>
      </ol>
    </div>

    <div class="ict-section">
      <h2>BENEFITS OF THIS PROGRAM</h2>
      <ol>
        <li>
          <strong>Career Advancement:</strong> Participating in this program will enhance a participant resumes and open doors for exciting job opportunities in the tech industry.
        </li>
        <li>
          <strong>Exposure To Real-World Challenges:</strong> The program will help gain exposure to real-world challenges. This experience will help participants develop problem-solving skills and resilience, preparing students to handle uncertainties in their tech journey.
        </li>
        <li>
          <strong>Access To Resources:</strong> This program will provide access to experienced facilitators with equipped classroom.
        </li>
        <li>
          <strong>Skill Development:</strong> This program will provide individuals the opportunities to acquire valuable skills in various ICT-related areas. These skills will enhance their employability and make them more versatile in the job market.
        </li>
      </ol>
    </div>

    <div class="ict-section">
      <h2>APPLICATION GUIDELINES:</h2>
    </div>

    <div class="ict-section">
      <h3>WHO CAN APPLY?</h3>
      <p>
        Youths between the age range of 16-35years, who are IT driven and seek to be impacted with adequate IT knowledge and skills with a minimum qualification of O'Level/SSCE required.
      </p>
    </div>

    <div class="ict-section">
      <h3>TO APPLY</h3>
      <p>
        Click on the link below or scan the QR Code provided to fill an application form. After successful submission of the application, a confirmation email will be sent to the email provided. Follow the instructions in the mail and submit at the <strong>L'arcade Shopping Complex, Plot C, 14C L'arcade Avenue, Okohia Layout, World Bank, New Owerri, Imo State.</strong>
      </p>
      <p>
        Please note that <strong>ONLY</strong> applicants who have submitted their printed confirmation email and other required documentations at the above address will be shortlisted.
      </p>
    </div>

    <!-- Application Button -->
    <div class="apply-section">
      <a href="#" class="apply-btn-image">
        <img src="/assets/images/apply-now-btn.png" alt="ICT Hub Application - Click Here"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22500%22 height=%22150%22%3E%3Crect fill=%22%23FEF3DC%22 width=%22500%22 height=%22150%22 rx=%2275%22/%3E%3Ctext x=%2250%25%22 y=%2235%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial,sans-serif%22 font-size=%2224%22 font-weight=%22bold%22 fill=%22%23000%22%3EAPPLY NOW%3C/text%3E%3Ctext x=%2250%25%22 y=%2265%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial,sans-serif%22 font-size=%2232%22 font-weight=%22bold%22 fill=%22%23000%22%3EICT HUB APPLICATION%3C/text%3E%3Ctext x=%2285%25%22 y=%2265%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial,sans-serif%22 font-size=%2220%22 fill=%22%23F5A623%22%3ECLICK HERE%3C/text%3E%3C/svg%3E'">
      </a>
    </div>

  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>