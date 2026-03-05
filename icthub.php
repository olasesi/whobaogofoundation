<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<main>

  <!-- ══════════════════════════════════════════════════════════════
       PAGE HERO
       ══════════════════════════════════════════════════════════════ -->
  <section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./assets/images/ict-bg.jpg') center/cover; min-height: 300px; display: flex; align-items: center; justify-content: space-between; padding: 3rem 2rem; position: relative;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; margin-bottom: 0.5rem;">ICT Hub</h1>
    </div>
    <div style="background: var(--primary); padding: 0.8rem 1.5rem; border-radius: 100px; color: #fff; font-weight: 600; font-size: 0.9rem;">
      <a href="index.php" style="color: #fff; text-decoration: none;">HOME</a>
      <span style="margin: 0 0.8rem;"> / </span>
      <span>ICT HUB</span>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       INTRO SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
        <div>
          <div class="section-subtitle">SKILL DEVELOPMENT</div>
          <h2 class="section-title">Free ICT Training for Youth</h2>
          <p style="color: var(--gray); line-height: 1.8; margin: 1.5rem 0;">
            Our fully-equipped ICT Hub is committed to empowering young Nigerians with in-demand digital and vocational skills. Through comprehensive, hands-on training programs, we're creating opportunities for youth to build successful careers.
          </p>
          <a href="contact.php" class="btn btn-primary">Enroll Now →</a>
        </div>
        <div style="border-radius: 12px; overflow: hidden; height: 400px; background: var(--light-gray); box-shadow: var(--shadow-lg);">
          <img src="./assets/images/computer_lad-scaled (1).jpg" alt="ICT Hub" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       PROGRAMS SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <div class="section-subtitle">OUR CURRICULUM</div>
        <h2 class="section-title">Training Programs</h2>
        <p style="color: var(--gray); font-size: 1rem; margin-top: 1rem;">
          We offer comprehensive programs designed to prepare students for today's digital job market
        </p>
      </div>

      <div class="programs-grid">
        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">💻</div>
          <h3>Web Development</h3>
          <p>Learn HTML, CSS, JavaScript, and modern frameworks. Build responsive websites and web applications from scratch.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
          <h3>Mobile Development</h3>
          <p>Master Android and iOS development. Create powerful mobile applications for real-world use cases.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🎨</div>
          <h3>UI/UX Design</h3>
          <p>Design beautiful and functional user interfaces. Learn design principles, prototyping, and user research methods.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
          <h3>Data Analytics</h3>
          <p>Learn data analysis, visualization, and business intelligence. Make data-driven decisions with Excel and BI tools.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🔐</div>
          <h3>Cybersecurity</h3>
          <p>Understand security principles, ethical hacking, and risk management. Protect organizations from digital threats.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">☁️</div>
          <h3>Cloud Computing</h3>
          <p>Master AWS, Azure, and Google Cloud. Deploy and manage scalable applications in the cloud.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       STATS SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
        <div style="text-align: center; padding: 2rem; background: var(--light-gray); border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">450+</div>
          <p style="color: var(--gray); font-weight: 600;">Graduates Trained</p>
        </div>
        <div style="text-align: center; padding: 2rem; background: var(--light-gray); border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">3</div>
          <p style="color: var(--gray); font-weight: 600;">Cohorts Completed</p>
        </div>
        <div style="text-align: center; padding: 2rem; background: var(--light-gray); border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">100%</div>
          <p style="color: var(--gray); font-weight: 600;">Free Tuition</p>
        </div>
        <div style="text-align: center; padding: 2rem; background: var(--light-gray); border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">90%</div>
          <p style="color: var(--gray); font-weight: 600;">Employment Rate</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       FEATURES SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <h2 class="section-title">Why Choose Our ICT Hub?</h2>
      </div>

      <div class="programs-grid">
        <div class="program-card">
          <h3>Industry-Expert Instructors</h3>
          <p>Learn from professionals with real-world experience in tech companies and startups.</p>
        </div>

        <div class="program-card">
          <h3>Modern Equipment</h3>
          <p>Access fully equipped computer labs with latest hardware and software technologies.</p>
        </div>

        <div class="program-card">
          <h3>Hands-On Projects</h3>
          <p>Build real-world projects and portfolio pieces that showcase your skills to employers.</p>
        </div>

        <div class="program-card">
          <h3>Job Placement Support</h3>
          <p>Get career guidance, interview prep, and job placement assistance after graduation.</p>
        </div>

        <div class="program-card">
          <h3>Flexible Schedules</h3>
          <p>Choose between full-time and part-time programs that fit your lifestyle and commitments.</p>
        </div>

        <div class="program-card">
          <h3>Community & Mentorship</h3>
          <p>Join a supportive community of learners and access mentorship from industry professionals.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       ADMISSION PROCESS
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="max-width: 1000px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <div class="section-subtitle">GET STARTED</div>
        <h2 class="section-title">Enrollment Process</h2>
      </div>

      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
        <div style="text-align: center;">
          <div style="width: 60px; height: 60px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1rem;">1</div>
          <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Apply</h4>
          <p style="color: var(--gray); font-size: 0.9rem;">Submit your application form and basic information</p>
        </div>

        <div style="text-align: center;">
          <div style="width: 60px; height: 60px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1rem;">2</div>
          <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Interview</h4>
          <p style="color: var(--gray); font-size: 0.9rem;">Meet with our team to discuss your goals</p>
        </div>

        <div style="text-align: center;">
          <div style="width: 60px; height: 60px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1rem;">3</div>
          <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Onboard</h4>
          <p style="color: var(--gray); font-size: 0.9rem;">Complete orientation and begin training</p>
        </div>

        <div style="text-align: center;">
          <div style="width: 60px; height: 60px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1rem;">4</div>
          <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Launch</h4>
          <p style="color: var(--gray); font-size: 0.9rem;">Graduate and start your tech career</p>
        </div>
      </div>

      <div style="text-align: center; margin-top: 3rem;">
        <a href="contact.php" class="btn btn-primary" style="font-size: 1.05rem; padding: 1rem 2rem;">Ready to Enroll? Contact Us →</a>
      </div>
    </div>
  </section>

</main>

<?php include './includes/footer.php'; ?>
</body>
</html>