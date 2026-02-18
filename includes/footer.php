<footer>
  <div class="footer-main">
    <div class="f-about">
      <a href="index.php" style="display:inline-block;margin-bottom:1rem;">
        <img src="/assets/images/logo.png" alt="Whoba Ogo Foundation" style="height: 52px; width: auto;">
      </a>
      <p>We are a social impact organization committed to bringing about enhanced education and better health care for people in Nigeria.</p>
      <div style="display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1.3rem;">
        <span style="font-size:0.8rem;color:rgba(255,255,255,0.45);display:flex;gap:0.5rem;align-items:center;">
          <span style="opacity:0.6;">📍</span> No. 1 Tafawa Balewa Crescent, Surulere Lagos
        </span>
        <a href="mailto:inquiry@whobaogofoundation.org" style="font-size:0.8rem;color:rgba(255,255,255,0.45);display:flex;gap:0.5rem;align-items:center;transition:color 0.2s;" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">
          <span style="opacity:0.6;">✉</span> inquiry@whobaogofoundation.org
        </a>
        <a href="tel:08180452165" style="font-size:0.8rem;color:rgba(255,255,255,0.45);display:flex;gap:0.5rem;align-items:center;transition:color 0.2s;" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">
          <span style="opacity:0.6;">📞</span> 08180452165
        </a>
      </div>
      <div class="f-socials">
        <a href="#" class="f-soc" title="Facebook">f</a>
        <a href="#" class="f-soc" title="Twitter">𝕏</a>
        <a href="#" class="f-soc" title="Google+">G+</a>
        <a href="#" class="f-soc" title="LinkedIn">in</a>
      </div>
    </div>

    <div class="f-col">
      <h5>Quick Links</h5>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="our-work.php">Our Work</a></li>
        <li><a href="ict-hub.php">ICT Hub</a></li>
        <li><a href="testimonials.php">Testimonials</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
    </div>

    <div class="f-col">
      <h5>Programs</h5>
      <ul>
        <li><a href="our-work.php#skill-development">Skill Development</a></li>
        <li><a href="our-work.php#education-support">Education Support</a></li>
        <li><a href="our-work.php#health-support">Health Support</a></li>
        <li><a href="ict-hub.php">ICT Training Hub</a></li>
      </ul>
    </div>

    <div class="f-col">
      <h5>Get Involved</h5>
      <ul>
        <li><a href="donate.php">Donate Now</a></li>
        <li><a href="contact.php">Volunteer</a></li>
        <li><a href="contact.php">Partner With Us</a></li>
        <li><a href="testimonials.php">Testimonials</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bar">
    <p>
      <a href="index.php">Whoba Ogo Foundation</a> · Copyright <?php echo date('Y'); ?>. All Rights Reserved.
    </p>
    <p>Built with ♥ for the communities of Nigeria</p>
  </div>
</footer>

<script>
  // Scroll reveal
  const revEls = document.querySelectorAll('.rev');
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('in'); ro.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  revEls.forEach(el => ro.observe(el));
</script>

</body>
</html>