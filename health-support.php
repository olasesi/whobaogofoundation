<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<main>

  <!-- PAGE HERO -->
  <section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./assets/images/health-bg.jpg') center/cover; min-height: 300px; display: flex; align-items: center; justify-content: space-between; padding: 3rem 2rem;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff;">Health Support</h1>
    </div>
    <div style="background: var(--primary); padding: 0.8rem 1.5rem; border-radius: 100px; color: #fff; font-weight: 600; font-size: 0.9rem;">
      <a href="index.php" style="color: #fff; text-decoration: none;">HOME</a>
      <span style="margin: 0 0.8rem;"> / </span>
      <span>HEALTH SUPPORT</span>
    </div>
  </section>

  <!-- INTRO -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
        <div>
          <div class="section-subtitle">HEALTH SUPPORT PROGRAM</div>
          <h2 class="section-title">Bringing Healthcare to Rural Communities</h2>
          <p style="color: var(--gray); line-height: 1.8; margin: 1.5rem 0;">
            Over 35% of Nigerians lack access to affordable healthcare. We're committed to bringing quality, accessible healthcare directly to underserved rural communities where need is greatest.
          </p>
          <a href="contact.php" class="btn btn-primary">Get Help →</a>
        </div>
        <div style="border-radius: 12px; overflow: hidden; height: 400px; background: var(--light-gray); box-shadow: var(--shadow-lg);">
          <img src="./assets/images/IMG_8844-scaled (1).jpg" alt="Health Support" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      </div>
    </div>
  </section>

  <!-- WHAT WE OFFER -->
  <section class="section section-bg">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <h2 class="section-title">Our Healthcare Services</h2>
      </div>

      <div class="programs-grid">
        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🏥</div>
          <h3>Medical Outreach</h3>
          <p>Regular health screening and medical check-ups in remote communities. Diagnosis and treatment by qualified healthcare professionals.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">💊</div>
          <h3>Medication & Supplies</h3>
          <p>Provision of essential medications and medical supplies at affordable or no cost to those who cannot afford them.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">👶</div>
          <h3>Maternal & Child Health</h3>
          <p>Prenatal care, safe delivery support, postnatal care, and child health programs for vulnerable mothers and children.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">📢</div>
          <h3>Health Awareness</h3>
          <p>Education and awareness campaigns on disease prevention, hygiene, nutrition, and healthy lifestyle practices.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🩹</div>
          <h3>Preventive Care</h3>
          <p>Immunization programs, health screenings, and preventive health measures to reduce disease occurrence.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🤝</div>
          <h3>Community Health Workers</h3>
          <p>Training local community health workers to provide ongoing health support and health education in their communities.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CHALLENGES -->
  <section class="section">
    <div style="max-width: 1000px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <h2 class="section-title">The Challenge We Address</h2>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div style="background: var(--primary-light); padding: 2rem; border-radius: 12px;">
          <h4 style="font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; font-size: 1.1rem;">The Problem</h4>
          <p style="color: var(--dark-gray); line-height: 1.7;">
            Rural communities lack access to basic healthcare facilities, trained healthcare workers, and affordable medications. This leads to preventable deaths, reduced productivity, and perpetuated poverty cycles.
          </p>
        </div>

        <div style="background: var(--secondary-light); padding: 2rem; border-radius: 12px;">
          <h4 style="font-weight: 700; color: var(--secondary); margin-bottom: 0.5rem; font-size: 1.1rem;">Our Solution</h4>
          <p style="color: var(--dark-gray); line-height: 1.7;">
            Through targeted healthcare interventions, community engagement, and capacity building, we bring quality healthcare to remote communities and empower them with health knowledge for lasting change.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- IMPACT -->
  <section class="section section-bg">
    <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
      <h2 class="section-title" style="margin-bottom: 2rem;">Our Health Impact</h2>
      
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
        <div style="background: #fff; padding: 2rem; border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">50K+</div>
          <p style="color: var(--gray); font-weight: 600;">People Screened</p>
        </div>
        <div style="background: #fff; padding: 2rem; border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">20+</div>
          <p style="color: var(--gray); font-weight: 600;">Outreach Missions</p>
        </div>
        <div style="background: #fff; padding: 2rem; border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">10K+</div>
          <p style="color: var(--gray); font-weight: 600;">Lives Improved</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section">
    <div style="max-width: 900px; margin: 0 auto; text-align: center;">
      <h2 class="section-title" style="margin-bottom: 1.5rem;">Everyone Deserves Access to Healthcare</h2>
      <p style="color: var(--gray); font-size: 1.05rem; margin-bottom: 2rem;">
        Help us bring quality healthcare to underserved communities. Whether through volunteering, donations, or partnerships, your contribution saves lives.
      </p>
      <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="volunteer.php" class="btn btn-primary">Volunteer →</a>
        <a href="contact.php" class="btn btn-outline">Support Us →</a>
      </div>
    </div>
  </section>

</main>

<?php include './includes/footer.php'; ?>
</body>
</html>