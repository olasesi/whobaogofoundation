<?php
require_once './includes/config.php';
require_once './includes/db.php';
include './includes/header.php';

// Handle testimonial submission
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
    } elseif (strlen($comment) < 10) {
        $error = 'Comment must be at least 10 characters.';
    } else {
        try {
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
            $_POST = [];
        } catch (PDOException $e) {
            $error = 'Something went wrong. Please try again later.';
        }
    }
}

// Get approved testimonials
$testimonials = $pdo->query(
    "SELECT author_name, author_email, content, created_at
     FROM comments
     WHERE post_id = 0 AND status = 'approved'
     ORDER BY created_at DESC"
)->fetchAll();

$totalTestimonials = count($testimonials);
?>

<main>

  <!-- PAGE HERO -->
  <section style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('./assets/images/testimonials-bg.jpg') center/cover; min-height: 300px; display: flex; align-items: center; justify-content: space-between; padding: 3rem 2rem;">
    <div>
      <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff;">Testimonials</h1>
    </div>
    <div style="background: var(--primary); padding: 0.8rem 1.5rem; border-radius: 100px; color: #fff; font-weight: 600; font-size: 0.9rem;">
      <a href="index.php" style="color: #fff; text-decoration: none;">HOME</a>
      <span style="margin: 0 0.8rem;"> / </span>
      <span>TESTIMONIALS</span>
    </div>
  </section>

  <!-- TESTIMONIALS SECTION -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 3rem;">
        <div class="section-subtitle">WHAT PEOPLE SAY</div>
        <h2 class="section-title">Success Stories & Testimonials</h2>
        <p style="color: var(--gray); font-size: 1rem; margin-top: 1rem;">
          Hear from the people whose lives have been transformed by Whoba Ogo Foundation's programs.
        </p>
        <div style="margin-top: 1rem; font-size: 1.1rem; font-weight: 700; color: var(--primary);">
          💬 <?= $totalTestimonials ?> Testimonials
        </div>
      </div>

      <!-- TESTIMONIALS GRID -->
      <?php if (empty($testimonials)): ?>
        <div style="text-align: center; padding: 4rem 2rem; background: var(--light-gray); border-radius: 12px; margin-bottom: 3rem;">
          <div style="font-size: 3rem; margin-bottom: 1rem;">💬</div>
          <h3 style="font-size: 1.5rem; color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">No Testimonials Yet</h3>
          <p style="color: var(--gray);">Be the first to share your experience with us!</p>
        </div>
      <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
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
          <div style="background: #fff; border: 1px solid var(--border-gray); border-radius: 12px; padding: 2rem; box-shadow: var(--shadow-md); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
              <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; flex-shrink: 0;">
                <?= $initials ?>
              </div>
              <div>
                <h4 style="font-weight: 700; color: var(--dark); margin: 0; font-size: 1.05rem;"><?= htmlspecialchars($testimonial['author_name']) ?></h4>
                <p style="color: var(--primary); font-size: 0.8rem; margin: 0.3rem 0 0; font-weight: 600;"><?= $date->format('M j, Y') ?></p>
              </div>
            </div>
            <p style="color: var(--gray); line-height: 1.7; margin: 0;">
              "<?= htmlspecialchars(substr($testimonial['content'], 0, 150)) ?><?= strlen($testimonial['content']) > 150 ? '...' : '' ?>"
            </p>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- FORM SECTION -->
  <section class="section section-bg">
    <div style="max-width: 900px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 2rem;">
        <div class="section-subtitle">SHARE YOUR STORY</div>
        <h2 class="section-title">Leave Your Testimonial</h2>
        <p style="color: var(--gray); font-size: 1rem; margin-top: 1rem;">
          Your story matters. Help inspire others by sharing how we've made a difference in your life.
        </p>
      </div>

      <div style="background: #fff; border-radius: 12px; padding: 2.5rem; box-shadow: var(--shadow-md);">
        <?php if ($success): ?>
          <div style="background: var(--secondary-light); border: 1px solid var(--secondary); border-left: 4px solid var(--secondary); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: var(--secondary); font-weight: 600;">
            ✓ <?= htmlspecialchars($success) ?>
          </div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div style="background: var(--primary-light); border: 1px solid var(--primary); border-left: 4px solid var(--primary); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: var(--primary); font-weight: 600;">
            ✕ <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="">
          <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Your Name *</label>
            <input type="text" name="name" required style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem;" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" placeholder="Full Name">
          </div>

          <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Email Address *</label>
            <input type="email" name="email" required style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem;" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" placeholder="your.email@example.com">
          </div>

          <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 0.5rem;">Your Testimonial *</label>
            <textarea name="comment" required style="width: 100%; padding: 0.9rem; border: 1px solid var(--border-gray); border-radius: 8px; font-family: inherit; font-size: 0.95rem; min-height: 150px; resize: vertical;" placeholder="Share your experience and how we've made a difference in your life..."><?= isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '' ?></textarea>
            <p style="color: var(--gray); font-size: 0.8rem; margin: 0.5rem 0 0;">Minimum 10 characters</p>
          </div>

          <button type="submit" name="submit_testimonial" class="btn btn-primary" style="width: 100%;">Submit Testimonial →</button>
          <p style="color: var(--gray); font-size: 0.8rem; margin: 1rem 0 0; text-align: center;">Your testimonial will appear after moderation by our team.</p>
        </form>
      </div>
    </div>
  </section>

  <!-- IMPACT SECTION -->
  <section class="section">
    <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
      <h2 class="section-title" style="margin-bottom: 2rem;">Real Impact, Real Stories</h2>
      
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
        <div style="background: var(--primary-light); padding: 2rem; border-radius: 12px; border-top: 4px solid var(--primary);">
          <div style="font-size: 3rem; margin-bottom: 0.5rem;">🎓</div>
          <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Education Success</h4>
          <p style="color: var(--gray); margin: 0;">Students getting scholarships and achieving academic excellence</p>
        </div>

        <div style="background: var(--secondary-light); padding: 2rem; border-radius: 12px; border-top: 4px solid var(--secondary);">
          <div style="font-size: 3rem; margin-bottom: 0.5rem;">💼</div>
          <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Job Placement</h4>
          <p style="color: var(--gray); margin: 0;">ICT graduates finding employment and building careers</p>
        </div>

        <div style="background: linear-gradient(135deg, #FEF3DC 0%, #FFF0E6 100%); padding: 2rem; border-radius: 12px; border-top: 4px solid #F5A623;">
          <div style="font-size: 3rem; margin-bottom: 0.5rem;">🏥</div>
          <h4 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">Health Improved</h4>
          <p style="color: var(--gray); margin: 0;">Communities accessing quality healthcare for the first time</p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include './includes/footer.php'; ?>
</body>
</html>