<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';

// Handle form submission
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            // Store contact message in comments table (or you could create a separate contacts table)
            $stmt = $pdo->prepare(
                "INSERT INTO comments (post_id, author_name, author_email, author_ip, content, status, created_at)
                 VALUES (-1, :name, :email, :ip, :message, 'pending', NOW())"
            );
            
            $messageContent = "Subject: " . $subject . "\n\n" . $message;
            
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '',
                ':message' => $messageContent
            ]);
            
            // Optionally send email notification to admin
            // mail('inquiry@whobaogofoundation.org', 'Contact Form: ' . $subject, $messageContent, 'From: ' . $email);
            
            $success = 'Thank you for contacting us! We will get back to you soon.';
            
            // Clear form
            $_POST = [];
        } catch (PDOException $e) {
            $error = 'Something went wrong. Please try again later.';
            error_log('Contact form error: ' . $e->getMessage());
        }
    }
}
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

  /* ── CONTACT PAGE ──────────────────────────────── */
  .contact-container {
    padding: 4rem 0;
  }
  
  .contact-header {
    text-align: center;
    margin-bottom: 3rem;
  }
  .contact-header-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--ink-light);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 0.8rem;
  }
  .contact-header h1 {
    font-family: 'Fraunces', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900;
    color: var(--ink);
    text-transform: uppercase;
  }

  /* ── CONTACT INFO CARDS ────────────────────────── */
  .contact-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-bottom: 4rem;
  }
  .contact-info-card {
    background: var(--surface);
    border-radius: var(--r-lg);
    padding: 2.5rem 2rem;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .contact-info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  }
  
  .contact-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    background: var(--red);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #fff;
  }
  .contact-info-card:nth-child(2) .contact-icon {
    background: var(--red);
  }
  .contact-info-card:nth-child(3) .contact-icon {
    background: var(--red);
  }
  
  .contact-info-card h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--ink);
    text-transform: uppercase;
    margin-bottom: 1rem;
  }
  .contact-info-card p {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--ink-mid);
    margin-bottom: 0.5rem;
  }
  .contact-info-card a {
    color: var(--ink-mid);
    transition: color 0.2s;
  }
  .contact-info-card a:hover {
    color: var(--red);
  }

  /* ── CONTACT FORM ──────────────────────────────── */
  .contact-form-section {
    max-width: 800px;
    margin: 0 auto;
  }
  .form-container {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 3rem;
  }
  
  .alert {
    padding: 1rem 1.2rem;
    border-radius: var(--r-sm);
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
  }
  .alert-success {
    background: var(--teal-soft);
    border: 1px solid var(--teal);
    color: var(--teal-dark);
  }
  .alert-error {
    background: var(--red-soft);
    border: 1px solid var(--red);
    color: var(--red-dark);
  }
  
  .form-group {
    margin-bottom: 1.5rem;
  }
  .form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--ink-mid);
    margin-bottom: 0.5rem;
  }
  .form-control {
    width: 100%;
    padding: 0.9rem 1.2rem;
    border: 1.5px solid var(--border);
    border-radius: var(--r-sm);
    font-size: 0.9rem;
    font-family: inherit;
    color: var(--ink);
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .form-control:focus {
    outline: none;
    border-color: var(--red);
    box-shadow: 0 0 0 3px var(--red-soft);
  }
  textarea.form-control {
    min-height: 150px;
    resize: vertical;
  }
  
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
  }
  
  .submit-btn {
    width: 100%;
    background: var(--red);
    color: #fff;
    border: none;
    padding: 1rem 2rem;
    border-radius: var(--r-sm);
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
  }
  .submit-btn:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 1024px) {
    .contact-info-grid {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }
  }

  @media (max-width: 768px) {
    .contact-container {
      padding: 2.5rem 0;
    }
    .form-row {
      grid-template-columns: 1fr;
    }
    .form-container {
      padding: 2rem 1.5rem;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>Contact Us</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>CONTACT US</span>
  </div>
</section>

<!-- ── CONTACT CONTENT ────────────────────────────  -->
<section class="contact-container">
  <div class="wrap">
    
    <div class="contact-header">
      <div class="contact-header-label">Get The Latest</div>
      <h1>Get In Touch</h1>
    </div>

    <!-- Contact Info Cards -->
    <div class="contact-info-grid">
      
      <!-- Address Card -->
      <div class="contact-info-card">
        <div class="contact-icon">🏠</div>
        <h3>Address:</h3>
        <p>No. 1 Tafawa Balewa Crescent,</p>
        <p>Off Adeniran Ogunsanya street,</p>
        <p>Surulere, Lagos.</p>
      </div>

      <!-- Email Card -->
      <div class="contact-info-card">
        <div class="contact-icon">✉</div>
        <h3>Email Address:</h3>
        <p><a href="mailto:info@whobaogofoundation.org">info@whobaogofoundation.org</a></p>
        <p><a href="mailto:inquiry@whobaogofoundation.org">inquiry@whobaogofoundation.org</a></p>
      </div>

      <!-- Phone Card -->
      <div class="contact-info-card">
        <div class="contact-icon">📞</div>
        <h3>Phone No:</h3>
        <p><a href="tel:+2348180452165">(+234) 818 045 2165</a></p>
        <p><a href="tel:014538555">01-453 8555</a></p>
      </div>

    </div>

    <!-- Contact Form -->
    <div class="contact-form-section">
      <div class="form-container">
        
        <?php if ($success): ?>
          <div class="alert alert-success">✓ <?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-error">✗ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
          
          <div class="form-row">
            <div class="form-group">
              <label for="name">Your Name *</label>
              <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control" 
                placeholder="John Doe"
                value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
                required>
            </div>

            <div class="form-group">
              <label for="email">Your Email *</label>
              <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                placeholder="john@example.com"
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                required>
            </div>
          </div>

          <div class="form-group">
            <label for="subject">Subject *</label>
            <input 
              type="text" 
              name="subject" 
              id="subject" 
              class="form-control" 
              placeholder="How can we help you?"
              value="<?= isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '' ?>"
              required>
          </div>

          <div class="form-group">
            <label for="message">Your Message *</label>
            <textarea 
              name="message" 
              id="message" 
              class="form-control" 
              placeholder="Write your message here..."
              required><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>
          </div>

          <button type="submit" name="submit_contact" class="submit-btn">Send Message</button>
        </form>

      </div>
    </div>

  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>