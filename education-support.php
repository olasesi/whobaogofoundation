<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<main>

  <!-- PAGE HERO -->
  <section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./assets/images/education-bg.jpg') center/cover; min-height: 300px; display: flex; align-items: center; justify-content: space-between; padding: 3rem 2rem;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff;">Education Support</h1>
    </div>
    <div style="background: var(--primary); padding: 0.8rem 1.5rem; border-radius: 100px; color: #fff; font-weight: 600; font-size: 0.9rem;">
      <a href="index.php" style="color: #fff; text-decoration: none;">HOME</a>
      <span style="margin: 0 0.8rem;"> / </span>
      <span>EDUCATION SUPPORT</span>
    </div>
  </section>

  <!-- INTRO -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
        <div>
          <div class="section-subtitle">EDUCATION SUPPORT PROGRAM</div>
          <h2 class="section-title">Supporting Excellence in Education</h2>
          <p style="color: var(--gray); line-height: 1.8; margin: 1.5rem 0;">
            We provide comprehensive support to underprivileged SS3 students preparing for critical WAEC examinations. Our program includes mock examinations, study resources, mentorship, and counseling services.
          </p>
          <a href="contact.php" class="btn btn-primary">Get Support →</a>
        </div>
        <div style="border-radius: 12px; overflow: hidden; height: 400px; background: var(--light-gray); box-shadow: var(--shadow-lg);">
          <img src="./assets/images/IMG-20210224-WA0000 (1).jpg" alt="Education Support" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      </div>
    </div>
  </section>

  <!-- WHAT WE OFFER -->
  <section class="section section-bg">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <h2 class="section-title">What We Provide</h2>
      </div>

      <div class="programs-grid">
        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
          <h3>Study Materials</h3>
          <p>Comprehensive study guides, past papers, and learning resources for all major subjects.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">✏️</div>
          <h3>Mock Examinations</h3>
          <p>Regular mock exams under exam conditions to build confidence and identify weak areas.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">👨‍🏫</div>
          <h3>Mentorship & Tutoring</h3>
          <p>One-on-one tutoring sessions and mentorship from experienced educators and subject experts.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">💪</div>
          <h3>Motivation & Counseling</h3>
          <p>Emotional support, career guidance, and counseling to help students manage exam stress.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
          <h3>Study Groups</h3>
          <p>Collaborative learning through facilitated study groups and peer learning sessions.</p>
        </div>

        <div class="program-card">
          <div style="font-size: 3rem; margin-bottom: 1rem;">🏆</div>
          <h3>Incentives & Rewards</h3>
          <p>Recognition programs and incentives for dedicated students who achieve academic excellence.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- IMPACT -->
  <section class="section">
    <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
      <h2 class="section-title" style="margin-bottom: 2rem;">Our Impact</h2>
      
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
        <div style="background: var(--light-gray); padding: 2rem; border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">1000+</div>
          <p style="color: var(--gray); font-weight: 600;">Students Supported</p>
        </div>
        <div style="background: var(--light-gray); padding: 2rem; border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">85%</div>
          <p style="color: var(--gray); font-weight: 600;">Pass Rate</p>
        </div>
        <div style="background: var(--light-gray); padding: 2rem; border-radius: 12px;">
          <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">500+</div>
          <p style="color: var(--gray); font-weight: 600;">Tutor Hours</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section section-bg">
    <div style="max-width: 900px; margin: 0 auto; text-align: center;">
      <h2 class="section-title" style="margin-bottom: 1.5rem;">Every Student Deserves Excellence</h2>
      <p style="color: var(--gray); font-size: 1.05rem; margin-bottom: 2rem;">
        Your education is the key to unlocking your potential. Let us support you on your journey to success.
      </p>
      <a href="contact.php" class="btn btn-primary">Enroll Today →</a>
    </div>
  </section>

</main>

<?php include './includes/footer.php'; ?>
</body>
</html>