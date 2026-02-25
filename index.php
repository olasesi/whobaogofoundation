<?php
require_once './includes/config.php';
require_once './includes/db.php';
include ('./includes/header.php');
?>


<main>

<!-- ── HERO ────────────────────────────────────── -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot">♥</span>
      African Social Impact Organization
    </div>
    <h1>
      Giving Back<br>
      to <span class="hl">Humanity</span><br>
      Every <span class="tc">Day</span>
    </h1>
    <p class="hero-desc">
      We are an African based social impact organization committed to touching lives of rural community dwellers through medical and educational support.
    </p>
    <div class="hero-btns">
      <a href="about-us.php" class="btn-fill">
        Read More Details <span class="ico">→</span>
      </a>
      
    </div>
    <div class="hero-trust">
      <div class="trust-avatars">
        <span>🧑</span><span>👩</span><span>🧒</span><span>👨</span>
      </div>
      <div class="trust-text">
        <strong>3,000+ lives touched</strong><br>
        across rural communities in Nigeria
      </div>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hv-ring r1"></div>
    <div class="hv-ring r2"></div>
    <div class="hv-card">
      <div class="hv-glow"></div>
      <div class="hv-body">
        <h3>Touching Lives Across Nigeria's Rural Communities</h3>
        <p>Propelled by passion, we ease the burdens of the unfortunate many weighed down by poverty.</p>
        <div class="hv-chips">
          <span class="chip">💻 Skill Development</span>
          <span class="chip">📚 Education Support</span>
          <span class="chip">🏥 Health Support</span>
        </div>
      </div>
    </div>
    <div class="fc a">
      <div class="fc-label">ICT Graduates</div>
      <div class="fc-val">450+</div>
      <div class="fc-sub">Free tuition training</div>
    </div>
    <div class="fc b">
      <div class="fc-ico">🎓</div>
      <div class="fc-label">Programs Active</div>
      <div class="fc-val">5+</div>
      <div class="fc-sub">Nationwide impact</div>
    </div>
  </div>
</section>

<!-- ── TICKER ───────────────────────────────────── -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <span class="ticker-item"><span class="tdot"></span>Skill Development Program</span>
    <span class="ticker-item"><span class="tdot"></span>Education Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Health Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Free ICT Training Hub</span>
    <span class="ticker-item"><span class="tdot"></span>SS3 Mock Examination Support</span>
    <span class="ticker-item"><span class="tdot"></span>Community Outreach</span>
    <span class="ticker-item"><span class="tdot"></span>Skill Development Program</span>
    <span class="ticker-item"><span class="tdot"></span>Education Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Health Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Free ICT Training Hub</span>
    <span class="ticker-item"><span class="tdot"></span>SS3 Mock Examination Support</span>
    <span class="ticker-item"><span class="tdot"></span>Community Outreach</span>
  </div>
</div>

<!-- ── STATS ────────────────────────────────────── -->
<div style="padding: 3rem 0 0;">
  <div class="stats-banner rev">
    <div class="sb-item">
      <div class="sb-num">3K+</div>
      <div class="sb-lbl">Lives Touched Across Rural Communities</div>
    </div>
    <div class="sb-item">
      <div class="sb-num t">450+</div>
      <div class="sb-lbl">ICT Graduates from Free Training Cohorts</div>
    </div>
    <div class="sb-item">
      <div class="sb-num s">3</div>
      <div class="sb-lbl">ICT Cohorts Successfully Completed</div>
    </div>
    <div class="sb-item">
      <div class="sb-num">2018</div>
      <div class="sb-lbl">Founded &amp; Serving Nigeria Since</div>
    </div>
  </div>
</div>

<!-- ── ABOUT ─────────────────────────────────────── -->
<section class="sec">
  <div class="wrap">
    <div class="about-grid">
      <div class="about-vis rev">
        <div class="about-dots"><?php for($i=0;$i<30;$i++) echo '<i></i>'; ?></div>
        <div class="about-blob">
          <div class="about-blob-inner">🤝</div>
        </div>
        <div class="about-quote-card">
          <p>"We hear their cry; we are here to stretch a hand to help."</p>
          <span>— Whoba Ogo Foundation</span>
        </div>
      </div>

      <div class="about-copy rev d2">
        <div class="eyebrow">Want to Know About Us</div>
        <h2 class="hdg">Giving Back to Humanity</h2>
        <p style="margin-top:0.8rem;">
          We are an African based social impact organization committed to touching lives of rural community dwellers through <strong>medical and educational support</strong>.
        </p>
        <p>
          We are propelled by a passion to ease the burdens of these unfortunate many, especially in rural communities of third world nations, who are being weighed down by the burdens of poverty. We do this by narrowing our gaze to what we believe forms the core of the issue.
        </p>
        <p>
          There is a very loud outcry by this multitude of voiceless underprivileged Africans who are bewildered by the hopelessness of their situation. All they are asking for is a listening ear and helping hand.
        </p>
        <div style="margin-top: 1.5rem;">
          <a href="about-us.php" class="btn-fill">Read More Details <span class="ico">→</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── THREE PILLARS (Mission / Program / Help) ─── -->
<section class="sec pillars-bg">
  <div class="wrap">
    <div style="text-align:center;" class="rev">
      <div class="eyebrow" style="justify-content:center;">To Humanity</div>
      <h2 class="hdg">How We Serve</h2>
    </div>
    <div class="pillars-grid">
      <div class="pillar-card rev d1">
        <div class="pillar-ico red">🎯</div>
        <h3>Our Mission</h3>
        <p>Committed to enhancing the quality of life by supporting initiatives that bring tangible change to rural communities across Nigeria.</p>
        <a href="about-us.php" class="pillar-arrow">Learn More →</a>
      </div>
      <div class="pillar-card rev d2">
        <div class="pillar-ico teal">📋</div>
        <h3>Our Program</h3>
        <p>Our work is focused on providing health and educational support to the most vulnerable — children, the elderly, and rural families.</p>
        <a href="our-work.php" class="pillar-arrow">Learn More →</a>
      </div>
      <div class="pillar-card rev d3">
        <div class="pillar-ico sun">🤲</div>
        <h3>Help &amp; Support</h3>
        <p>Our work has gotten to another height through your generosity. Partner with us to stretch the helping hand even further.</p>
        <a href="contact.php" class="pillar-arrow">Get Involved →</a>
      </div>
    </div>
  </div>
</section>

<!-- ── PROGRAMS ──────────────────────────────────── -->
<section class="sec">
  <div class="wrap">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;margin-bottom:0.5rem;" class="rev">
      <div>
        <div class="eyebrow">Our Work</div>
        <h2 class="hdg">Our Programs</h2>
      </div>
      
    </div>
    <div class="progs-grid">
      <div class="prog-card red-card rev">
        <div class="prog-body">
          <div class="prog-ico">💻</div>
          <h3>Skill Development Program</h3>
          <p>Empowering youth with in-demand digital and vocational skills through our fully-equipped ICT Hub — completely tuition-free of charge.</p>
          <a href="icthub.php" class="prog-link">Explore the Hub →</a>
        </div>
      </div>
      <div class="prog-card teal-card rev d1">
        <div class="prog-body">
          <div class="prog-ico">📚</div>
          <h3>Education Support Program</h3>
          <p>Supporting underprivileged SS3 students with mock examinations, study resources, and mentorship ahead of critical WAEC examinations.</p>
          <a href="education-support.php" class="prog-link">Learn More →</a>
        </div>
      </div>
      <div class="prog-card sun-card rev d2">
        <div class="prog-body">
          <div class="prog-ico">🏥</div>
          <h3>Health Support Program</h3>
          <p>Bringing affordable, quality healthcare directly to rural communities where over 35% of Nigerians lack access to basic health services.</p>
          <a href="health-support.php" class="prog-link">Learn More →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── MISSION ────────────────────────────────────── -->
<section style="padding: 4rem 0;">
  <div class="mission-wrap rev">
    <div class="mission-grid">
      <div>
        <div class="mission-badge">✦ It Starts With The Passion</div>
        <h2 class="mission-hdg">
          Let's Make the<br>
          World <span class="rc">Better</span> —<br>
          It Starts With <span class="tc">You</span>
        </h2>
        <p class="mission-sub">
          There is a very loud outcry by this multitude of voiceless underprivileged Africans who are bewildered by the hopelessness of their situation. All they are asking for is a listening ear and helping hand.
        </p>
        <a href="donate.php" class="btn-fill">Join Our Mission <span class="ico">♥</span></a>
      </div>
      <div class="mission-facts">
        <div class="mfact">
          <span class="mfact-dot"></span>
          <span>Approximately 1 out of every 3 children in Nigeria is either out of school or is in a school where they are unable to acquire basic literary and numeracy skills.</span>
        </div>
        <div class="mfact">
          <span class="mfact-dot" style="background:var(--teal);"></span>
          <span>Over 35% of Nigerians lack access to affordable health care. The most victimized of these are the children and the elderly. This is because they are most susceptible to health challenges.</span>
        </div>
        <div class="mfact">
          <span class="mfact-dot" style="background:var(--sun);"></span>
          <span><strong style="color:rgba(255,255,255,0.85);">We hear their cry; we are here to stretch a hand to help.</strong></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── TEAM ───────────────────────────────────────── -->
<section class="sec" style="text-align:center;">
  <div class="wrap">
    <div class="rev">
      <div class="eyebrow" style="justify-content:center;">To Humanity</div>
      <h2 class="hdg">Our Awesome Team</h2>
    </div>
    <div class="team-grid">
      <div class="team-card rev d1">
        <div class="team-avatar">
          <img src="assets/images/safiya.jpg" alt="Safiya Whoba"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">SW</div>
        </div>
        <div class="team-name">Safiya Whoba</div>
        <span class="team-role">Trustee</span>
      </div>
      <div class="team-card rev d2">
        <div class="team-avatar">
          <img src="assets/images/whoba-ogo.jpg" alt="Whoba Ogo"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">WO</div>
        </div>
        <div class="team-name">Whoba Ogo</div>
        <span class="team-role">Chairman, Board of Trustee</span>
      </div>
    </div>
  </div>
</section>

<!-- ── NEWS ───────────────────────────────────────── -->
<section class="sec news-bg">
  <div class="wrap">
    <div class="news-hdr rev">
      <div>
        <div class="eyebrow">To Humanity</div>
        <h2 class="hdg">Our Recent News</h2>
      </div>
      <a href="our-blog.php" class="btn-outline">All News →</a>
    </div>
    <div class="news-grid">
      <div class="nc feat rev">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#0D9B7E,#044030);"><img src="./assets/images/mock-770x532.jpg" alt="mock" title="Mock examination"/></div>
          <div class="nc-date">10 DEC</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">Education</div>
          <h4>Whoba Ogo Foundation SS3 Mock Examination Exercise</h4>
          <p>Students across rural communities participated in our comprehensive mock examination programme, gaining crucial preparation ahead of their WAEC examinations.</p>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d1">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#B8861B,#6A4700);"><img src="./assets/images/capture.jpg" alt="mock" title="Mock examination"/></div>
          <div class="nc-date">19 SEP</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>Outstanding Participant (Whoba Ogo Foundation Free ICT Training)</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d2">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#E03535,#7A1010);"><img src="./assets/images/image3.jpg" alt="Outstanding Participant" title="Outstanding Participant"/></div>
          <div class="nc-date">01 APR</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>Whoba Ogo Foundation (WOF) ICT Center — Empowering the Next Generation</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#076E58,#021A13);"><img src="./assets/images/cohort-3-training.jpg" alt="cohort-3-training" title="cohort-3-training"/></div>
          <div class="nc-date">04 MAR</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>WOF ICT Cohort 3 Tuition-Free Training Kicks Off with Over</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d1">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#3B5998,#1A2D5A);"><img src="./assets/images/wof3.jpg" alt="cohort-3-screen" title="cohort-3-screen"/></div>
          <div class="nc-date">15 FEB</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>WOF ICT Cohort 3 Screening Exercise: Over 450 Applicants</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d2">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#7B3F00,#3D1F00);"><img src="./assets/images/wof-graduation.jpeg" alt="graduation" title="graduation"/></div>
          <div class="nc-date">24 SEP</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>WOF Graduation Ceremony of Cohort 1 and Orientation of Cohort 2</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA ────────────────────────────────────────── -->
<section class="sec">
  <div class="cta-row">
    <div class="cta-card red rev">
      <h3>Help Us Touch More Lives</h3>
      <p>Your contribution — big or small — funds free ICT training, educational support, and healthcare access for those who need it most in Nigeria.</p>
      <a href="donate.php" class="btn-white red-text">Donate Today ♥</a>
    </div>
    <div class="cta-card teal rev d1">
      <h3>Get in Touch With Us</h3>
      <p>Ready to partner, volunteer, or learn more about our work? We'd love to hear from you.</p>
      <a href="contact.php" class="btn-white teal-text">Contact Us →</a>
      <div class="contact-items">
        <div class="ci">
          <span class="ci-ico">📍</span>
          No. 1 Tafawa Balewa Crescent, Surulere, Lagos
        </div>
        <div class="ci">
          <span class="ci-ico">✉</span>
          inquiry@whobaogofoundation.org
        </div>
        <div class="ci">
          <span class="ci-ico">📞</span>
          08180452165
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── NEWSLETTER ─────────────────────────────────── -->
<div class="newsletter">
  <div class="newsletter-inner">
    <div>
      <h4>Newsletter</h4>
      <p>Sign up for our mailing list to get latest updates and offers</p>
    </div>
    <form class="newsletter-form" onsubmit="return false;">
      <input type="email" placeholder="Enter your email address" aria-label="Email address">
      <button type="submit">Subscribe</button>
    </form>
  </div>
</div>

</main>

<?php include ('./includes/footer.php'); ?>
<!-- ── FOOTER ─────────────────────────────────────── -->

</body>
</html>