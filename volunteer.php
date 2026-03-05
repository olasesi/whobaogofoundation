<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<main>

  <!-- ══════════════════════════════════════════════════════════════
       PAGE HERO
       ══════════════════════════════════════════════════════════════ -->
  <section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./assets/images/volunteer-bg.jpg') center/cover; min-height: 300px; display: flex; align-items: center; justify-content: space-between; padding: 3rem 2rem; position: relative;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; margin-bottom: 0.5rem;">Become a Volunteer</h1>
    </div>
    <div style="background: var(--primary); padding: 0.8rem 1.5rem; border-radius: 100px; color: #fff; font-weight: 600; font-size: 0.9rem;">
      <a href="index.php" style="color: #fff; text-decoration: none;">HOME</a>
      <span style="margin: 0 0.8rem;"> / </span>
      <span>VOLUNTEER</span>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       INTRO SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="max-width: 900px; margin: 0 auto; text-align: center;">
      <div class="section-subtitle">JOIN OUR MISSION</div>
      <h2 class="section-title">Helping Hand | Giving Back to Humanity</h2>
      <p style="color: var(--gray); font-size: 1.05rem; line-height: 1.8; margin: 1.5rem 0;">
        We believe that meaningful change happens when passionate individuals come together with a shared purpose. As a volunteer with Whoba Ogo Foundation, you'll be part of a dedicated team touching lives and creating opportunities in rural communities across Nigeria.
      </p>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       IMPACT SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <h2 class="section-title">Impacting 2,000,000 Across 20,000 Communities by 2025</h2>
        <p style="color: var(--gray); font-size: 1rem; margin-top: 1rem;">
          Your contribution, no matter how small, helps us achieve this ambitious vision.
        </p>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow-md);">
          <p style="color: var(--gray); line-height: 1.8; margin-bottom: 0;">
            Every volunteer who joins our team brings unique skills, perspectives, and passion. Together, we're building a movement of change-makers dedicated to improving educational outcomes and healthcare access in underserved communities.
          </p>
        </div>
        <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow-md);">
          <p style="color: var(--gray); line-height: 1.8; margin-bottom: 0;">
            From mentoring students to healthcare outreach, from administrative support to fundraising, there are many ways to contribute your talents. The impact you make will inspire generations to come.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       OUR STATEMENT
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="max-width: 900px; margin: 0 auto; text-align: center; background: var(--primary-light); padding: 3rem; border-radius: 12px;">
      <h3 style="font-size: 1.5rem; color: var(--primary); font-weight: 700; margin-bottom: 1rem;">WHOBA OGO FOUNDATION STATEMENT</h3>
      <p style="font-size: 1.1rem; color: var(--dark); font-style: italic; line-height: 1.8; margin-bottom: 0;">
        "A healthy body and an informed mind are the recipe for success. When communities have access to quality education and healthcare, they unlock their full potential and transform their futures."
      </p>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       WHY VOLUNTEER
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <div class="section-subtitle">WHY VOLUNTEER WITH US?</div>
        <h2 class="section-title">Make a Real Difference</h2>
      </div>

      <div class="programs-grid">
        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
          <h3>Clear Impact</h3>
          <p>See directly how your efforts improve lives in real communities. Your work matters and creates lasting change.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🤝</div>
          <h3>Community</h3>
          <p>Join a passionate team of like-minded individuals committed to social impact. Build meaningful relationships and friendships.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
          <h3>Personal Growth</h3>
          <p>Develop new skills, gain valuable experience, and expand your perspective by working with diverse communities.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🌍</div>
          <h3>Global Vision</h3>
          <p>Be part of a movement creating systemic change in education and healthcare across Africa and beyond.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">💼</div>
          <h3>Professional Network</h3>
          <p>Connect with leaders, professionals, and changemakers working in social impact and development sectors.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🎓</div>
          <h3>Learning Opportunities</h3>
          <p>Participate in training sessions and workshops that enhance your knowledge and professional capabilities.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       VOLUNTEER OPPORTUNITIES
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <div class="section-subtitle">HOW YOU CAN HELP</div>
        <h2 class="section-title">Volunteer Opportunities</h2>
      </div>

      <div class="programs-grid">
        <div class="program-card">
          <h3>Education Program</h3>
          <p>Mentor students, conduct tutoring sessions, support WAEC exam preparation, and help develop educational materials.</p>
          <a href="contact.php" class="program-link">Get Involved →</a>
        </div>

        <div class="program-card">
          <h3>Health Outreach</h3>
          <p>Assist in healthcare awareness campaigns, help organize medical outreach events, and support community health initiatives.</p>
          <a href="contact.php" class="program-link">Get Involved →</a>
        </div>

        <div class="program-card">
          <h3>Skills Training</h3>
          <p>Teach digital skills, conduct vocational training, develop curriculum, and mentor ICT trainees at our hub.</p>
          <a href="contact.php" class="program-link">Get Involved →</a>
        </div>

        <div class="program-card">
          <h3>Administrative Support</h3>
          <p>Assist with project management, documentation, data entry, and general office support operations.</p>
          <a href="contact.php" class="program-link">Get Involved →</a>
        </div>

        <div class="program-card">
          <h3>Fundraising & Development</h3>
          <p>Help with fundraising campaigns, grant writing, donor relations, and resource mobilization efforts.</p>
          <a href="contact.php" class="program-link">Get Involved →</a>
        </div>

        <div class="program-card">
          <h3>Social Media & Communications</h3>
          <p>Create content, manage social media accounts, write stories, and help amplify our message to wider audiences.</p>
          <a href="contact.php" class="program-link">Get Involved →</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       CALL TO ACTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="max-width: 900px; margin: 0 auto; text-align: center;">
      <h2 class="section-title" style="margin-bottom: 1.5rem;">Ready to Make a Difference?</h2>
      <p style="color: var(--gray); font-size: 1.05rem; margin-bottom: 2rem;">
        Join us in transforming lives through education, healthcare, and skill development. No matter your background or experience level, there's a way for you to contribute.
      </p>
      <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="contact.php" class="btn btn-primary">Contact Us →</a>
        <a href="about-us.php" class="btn btn-outline">Learn More →</a>
      </div>
    </div>
  </section>

</main>

<?php include './includes/footer.php'; ?>
</body>
</html>