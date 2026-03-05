<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';
?>

<main>

  <!-- ══════════════════════════════════════════════════════════════
       PAGE HERO
       ══════════════════════════════════════════════════════════════ -->
  <section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./assets/images/contact-bg.jpg') center/cover; min-height: 300px; display: flex; align-items: center; justify-content: space-between; padding: 3rem 2rem; position: relative;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; margin-bottom: 0.5rem;">Contact Us</h1>
    </div>
    <div style="background: var(--primary); padding: 0.8rem 1.5rem; border-radius: 100px; color: #fff; font-weight: 600; font-size: 0.9rem;">
      <a href="index.php" style="color: #fff; text-decoration: none;">HOME</a>
      <span style="margin: 0 0.8rem;"> / </span>
      <span>CONTACT US</span>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       CONTACT SECTION
       ══════════════════════════════════════════════════════════════ -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <div class="section-subtitle">GET IN TOUCH</div>
        <h2 class="section-title">We'd Love to Hear From You</h2>
        <p style="color: var(--gray); font-size: 1.05rem; margin-top: 1rem; max-width: 600px; margin-left: auto; margin-right: auto;">
          Have questions about our programs or want to get involved? Reach out to us using any of the methods below.
        </p>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem;">
        <!-- Contact Info -->
        <div>
          <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--dark); margin-bottom: 2rem;">Contact Information</h3>

          <div style="display: grid; gap: 2rem;">
            <!-- Address -->
            <div>
              <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.5rem;">📍</span>
                Location
              </h4>
              <p style="color: var(--gray); line-height: 1.7;">
                No. 1 Tafawa Balewa Crescent<br>
                Surulere, Lagos<br>
                Nigeria
              </p>
            </div>

            <!-- Email -->
            <div>
              <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.5rem;">✉</span>
                Email
              </h4>
              <p style="color: var(--gray);">
                <a href="mailto:inquiry@whobaogofoundation.org" style="color: var(--primary); text-decoration: none; font-weight: 600;">inquiry@whobaogofoundation.org</a>
              </p>
            </div>

            <!-- Phone -->
            <div>
              <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.5rem;">📞</span>
                Phone
              </h4>
              <p style="color: var(--gray);">
                <a href="tel:08180452165" style="color: var(--primary); text-decoration: none; font-weight: 600;">08180452165</a>
              </p>
            </div>

            <!-- Hours -->
            <div>
              <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 1.5rem;">🕐</span>
                Office Hours
              </h4>
              <p style="color: var(--gray); line-height: 1.7;">
                Monday - Friday: 9:00 AM - 5:00 PM<br>
                Saturday: 10:00 AM - 2:00 PM<br>
                Sunday: Closed
              </p>
            </div>
          </div>

          <!-- Social Links -->
          <div style="margin-top: 2.5rem;">
            <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">Follow Us</h4>
            <div style="display: flex; gap: 1rem;">
              <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 700; transition: all 0.3s;">f</a>
              <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 700; transition: all 0.3s;">𝕏</a>
              <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 700; transition: all 0.3s;">in</a>
            </div>
          </div>
        </div>

        <!-- Contact Form -->
        <div style="background: var(--light-gray); padding: 2rem; border-radius: 12px;">
          <form onsubmit="handleSubmit(event)">
            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Your Name</label>
              <input type="text" required style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Email Address</label>
              <input type="email" required style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Phone Number</label>
              <input type="tel" style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Subject</label>
              <input type="text" required style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Message</label>
              <textarea required style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem; min-height: 120px; resize: vertical;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message →</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       MAP SECTION (Placeholder)
       ══════════════════════════════════════════════════════════════ -->
  <section class="section section-bg">
    <div style="max-width: 1200px; margin: 0 auto;">
      <h2 class="section-title" style="text-align: center; margin-bottom: 2rem;">Find Us on the Map</h2>
      <div style="border-radius: 12px; overflow: hidden; height: 400px; background: var(--light-gray); display: flex; align-items: center; justify-content: center; color: var(--gray);">
        <!-- Google Maps embed or placeholder -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.4076435231765!2d3.3522847!3d6.490831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1sTafawa Balewa Crescent, Surulere, Lagos!2s!5e0!3m2!1sen!2sng!4v1234567890" 
          width="100%" 
          height="100%" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </section>

</main>

<script>
  function handleSubmit(e) {
    e.preventDefault();
    alert('Thank you for reaching out! We will respond to your message shortly.');
    e.target.reset();
  }
</script>

<?php include './includes/footer.php'; ?>
</body>
</html>