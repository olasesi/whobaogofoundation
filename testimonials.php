<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';

// Handle form submission
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_testimonial'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    
    if (empty($name) || empty($email) || empty($comment)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            // Insert comment with pending status
            $stmt = $pdo->prepare(
                "INSERT INTO comments (post_id, author_name, author_email, author_ip, content, status, created_at)
                 VALUES (0, :name, :email, :ip, :content, 'pending', NOW())"
            );
            
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '',
                ':content' => $comment
            ]);
            
            $success = 'Thank you! Your testimonial has been submitted and is awaiting approval.';
            
            // Clear form
            $_POST = [];
        } catch (PDOException $e) {
            $error = 'Something went wrong. Please try again later.';
            error_log('Testimonial submission error: ' . $e->getMessage());
        }
    }
}

// Get approved testimonials (comments with post_id = 0 means they're testimonials)
$testimonials = $pdo->query(
    "SELECT author_name, author_email, content, created_at
     FROM comments
     WHERE post_id = 0 AND status = 'approved'
     ORDER BY created_at DESC"
)->fetchAll();

$totalTestimonials = count($testimonials);
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

  /* ── TESTIMONIALS PAGE ─────────────────────────── */
  .testimonials-container {
    padding: 4rem 0;
  }
  
  .testimonials-header {
    text-align: center;
    margin-bottom: 1rem;
  }
  .testimonials-count {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 3rem;
  }
  .testimonials-count::before {
    content: '💬';
    font-size: 1.2rem;
  }

  /* ── TESTIMONIAL ITEM ──────────────────────────── */
  .testimonials-list {
    max-width: 900px;
    margin: 0 auto 4rem;
  }
  .testimonial-item {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-md);
    padding: 2rem;
    margin-bottom: 2rem;
    transition: box-shadow 0.3s;
  }
  .testimonial-item:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
  }
  
  .testimonial-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.2rem;
  }
  .testimonial-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--red-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.2rem;
    color: var(--red);
    flex-shrink: 0;
  }
  .testimonial-meta h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 0.2rem;
    text-transform: uppercase;
  }
  .testimonial-date {
    font-size: 0.8rem;
    color: var(--red);
    font-weight: 500;
  }
  
  .testimonial-content {
    font-size: 0.95rem;
    line-height: 1.8;
    color: var(--ink-mid);
  }
  .testimonial-content p {
    margin-bottom: 1rem;
  }
  .testimonial-content p:last-child {
    margin-bottom: 0;
  }

  /* ── COMMENT FORM ──────────────────────────────── */
  .comment-form-section {
    max-width: 900px;
    margin: 0 auto;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-md);
    padding: 2.5rem;
  }
  .form-title {
    font-family: 'Fraunces', serif;
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--ink);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    padding-bottom: 0.8rem;
    border-bottom: 2px solid var(--red);
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
    padding: 0.8rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: var(--r-sm);
    font-size: 0.9rem;
    font-family: inherit;
    color: var(--ink);
    transition: border-color 0.2s;
  }
  .form-control:focus {
    outline: none;
    border-color: var(--red);
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
    background: var(--red);
    color: #fff;
    border: none;
    padding: 0.9rem 2.5rem;
    border-radius: var(--r-sm);
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
  }
  .submit-btn:hover {
    background: var(--red-dark);
    transform: translateY(-1px);
  }

  /* ── EMPTY STATE ───────────────────────────────── */
  .empty-testimonials {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--surface);
    border-radius: var(--r-lg);
    margin-bottom: 3rem;
  }
  .empty-testimonials-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
  }
  .empty-testimonials h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--ink);
    margin-bottom: 0.5rem;
  }
  .empty-testimonials p {
    color: var(--ink-light);
    font-size: 0.95rem;
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 768px) {
    .testimonials-container {
      padding: 2.5rem 0;
    }
    .testimonials-list,
    .comment-form-section {
      margin-left: 1.25rem;
      margin-right: 1.25rem;
    }
    .form-row {
      grid-template-columns: 1fr;
    }
    .testimonial-item {
      padding: 1.5rem;
    }
    .comment-form-section {
      padding: 1.5rem;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>Testimonials</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>TESTIMONIALS</span>
  </div>
</section>

<!-- ── TESTIMONIALS CONTENT ───────────────────────  -->
<section class="testimonials-container">
  <div class="wrap">
    
    <div class="testimonials-header">
      <div class="testimonials-count">COMMENT (<?= $totalTestimonials ?>)</div>
    </div>

    <?php if (empty($testimonials)): ?>
      <div class="empty-testimonials">
        <div class="empty-testimonials-icon">💬</div>
        <h3>No Testimonials Yet</h3>
        <p>Be the first to share your experience with us!</p>
      </div>
    <?php else: ?>
      <div class="testimonials-list">
        <?php foreach ($testimonials as $testimonial): 
          $date = new DateTime($testimonial['created_at']);
          $initials = '';
          $nameParts = explode(' ', $testimonial['author_name']);
          foreach ($nameParts as $part) {
            if (!empty($part)) {
              $initials .= strtoupper(substr($part, 0, 1));
            }
          }
          $initials = substr($initials, 0, 2);
        ?>
        <div class="testimonial-item">
          <div class="testimonial-header">
            <div class="testimonial-avatar"><?= $initials ?></div>
            <div class="testimonial-meta">
              <h3><?= htmlspecialchars($testimonial['author_name']) ?></h3>
              <div class="testimonial-date"><?= $date->format('F j, Y g:i a') ?></div>
            </div>
          </div>
          <div class="testimonial-content">
            <?php 
              // Split content by double newlines to create paragraphs
              $paragraphs = preg_split('/\n\s*\n/', $testimonial['content']);
              foreach ($paragraphs as $paragraph) {
                if (trim($paragraph)) {
                  echo '<p>' . nl2br(htmlspecialchars(trim($paragraph))) . '</p>';
                }
              }
            ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- ── COMMENT FORM ─────────────────────────── -->
    <div class="comment-form-section">
      <h2 class="form-title">Leave a Reply</h2>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label for="comment">Comment</label>
          <textarea 
            name="comment" 
            id="comment" 
            class="form-control" 
            placeholder="Share your experience with us..."
            required><?= isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '' ?></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="name">Name</label>
            <input 
              type="text" 
              name="name" 
              id="name" 
              class="form-control" 
              placeholder="Your full name"
              value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
              required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input 
              type="email" 
              name="email" 
              id="email" 
              class="form-control" 
              placeholder="your.email@example.com"
              value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
              required>
          </div>
        </div>

        <button type="submit" name="submit_testimonial" class="submit-btn">Submit Now</button>
      </form>
    </div>

  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>