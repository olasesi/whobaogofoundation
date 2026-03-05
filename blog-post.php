<?php
require_once './includes/config.php';
require_once './includes/db.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (!$slug) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.*, a.name AS author_name, a.id AS author_id, c.name AS category_name
    FROM posts p
    LEFT JOIN admins a ON a.id = p.author_id
    LEFT JOIN categories c ON c.id = p.category_id
    WHERE p.slug = :slug AND p.post_type = 'post' AND p.status = 'published'
    LIMIT 1
");
$stmt->execute([':slug' => $slug]);
$post = $stmt->fetch();

if (!$post) {
    header('HTTP/1.0 404 Not Found');
    include 'error.php';
    exit;
}

// Increment view count
$updateStmt = $pdo->prepare("UPDATE posts SET views = views + 1 WHERE id = :id");
$updateStmt->execute([':id' => $post['id']]);

// Parse post images
$postImages = [];
if ($post['post_images']) {
    try {
        $postImages = json_decode($post['post_images'], true);
        if (!is_array($postImages)) $postImages = [];
    } catch (Exception $e) {
        $postImages = [];
    }
}

// Get related posts
$relatedPosts = [];
if ($post['category_id']) {
    $relatedStmt = $pdo->prepare("
        SELECT id, title, slug, featured_image, published_at
        FROM posts
        WHERE category_id = :category_id 
        AND id != :current_id
        AND post_type = 'post'
        AND status = 'published'
        ORDER BY published_at DESC
        LIMIT 3
    ");
    $relatedStmt->execute([
        ':category_id' => $post['category_id'],
        ':current_id'  => $post['id']
    ]);
    $relatedPosts = $relatedStmt->fetchAll();
}

// Get recent posts for sidebar
$recentPosts = $pdo->query("
    SELECT id, title, slug, published_at
    FROM posts
    WHERE post_type = 'post' AND status = 'published'
    ORDER BY published_at DESC
    LIMIT 5
")->fetchAll();

// Get comments
$commentsStmt = $pdo->prepare("
    SELECT * FROM comments
    WHERE post_id = :post_id AND status = 'approved'
    ORDER BY created_at DESC
");
$commentsStmt->execute([':post_id' => $post['id']]);
$comments = $commentsStmt->fetchAll();

// Handle comment submission
$commentMessage = '';
$commentError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    if ($post['allow_comments']) {
        $author_name  = isset($_POST['author_name'])    ? trim($_POST['author_name'])    : '';
        $author_email = isset($_POST['author_email'])   ? trim($_POST['author_email'])   : '';
        $content      = isset($_POST['comment_content']) ? trim($_POST['comment_content']) : '';

        if (!$author_name) {
            $commentError = 'Please enter your name.';
        } elseif (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
            $commentError = 'Please enter a valid email address.';
        } elseif (strlen($content) < 10) {
            $commentError = 'Comment must be at least 10 characters long.';
        } else {
            $insertStmt = $pdo->prepare("
                INSERT INTO comments 
                (post_id, author_name, author_email, content, author_ip, status)
                VALUES (:post_id, :author_name, :author_email, :content, :author_ip, 'pending')
            ");
            try {
                $insertStmt->execute([
                    ':post_id'      => $post['id'],
                    ':author_name'  => $author_name,
                    ':author_email' => $author_email,
                    ':content'      => $content,
                    ':author_ip'    => $_SERVER['REMOTE_ADDR'] ?? null,
                ]);
                $commentMessage = 'Thank you for your comment! It will appear after moderation.';
            } catch (Exception $e) {
                $commentError = 'Error submitting comment. Please try again.';
            }
        }
    }
}

$publishedDate = new DateTime($post['published_at']);
include './includes/header.php';
?>

<style>
  /* ── WRAP UTILITY ──────────────────────────────── */
  .post-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
  }

  /* ── POST DETAIL LAYOUT ────────────────────────── */
  .post-detail-container { padding: 4rem 0; background: #fff; }
  .post-detail-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 3rem;
  }

  /* ── POST HEADER ───────────────────────────────── */
  .post-header { margin-bottom: 2.5rem; }

  .post-category-badge {
    display: inline-block;
    background: var(--primary-light);
    color: var(--primary);
    padding: 0.4rem 1rem;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1rem;
  }

  .post-main-title {
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 800;
    color: var(--dark);
    line-height: 1.25;
    margin-bottom: 1.5rem;
  }

  .post-meta-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1.5px solid var(--border-gray);
    color: var(--gray);
    font-size: 0.88rem;
  }
  .post-meta-bar .meta-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: var(--primary);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.75rem; flex-shrink: 0;
  }
  .post-meta-bar strong { color: var(--dark); font-weight: 600; }

  /* ── FEATURED IMAGE ────────────────────────────── */
  .post-featured-image {
    width: 100%; max-height: 500px;
    border-radius: 10px; overflow: hidden;
    margin-bottom: 2.5rem;
    box-shadow: var(--shadow-lg);
  }
  .post-featured-image img { width: 100%; height: 100%; object-fit: cover; display: block; }

  /* ── POST BODY ─────────────────────────────────── */
  .post-body { font-size: 1rem; line-height: 1.85; color: var(--dark-gray); }
  .post-body h1,.post-body h2,.post-body h3,.post-body h4,.post-body h5,.post-body h6 {
    font-weight: 700; color: var(--dark); margin: 1.5rem 0 1rem; line-height: 1.3;
  }
  .post-body h1 { font-size: 2rem; }
  .post-body h2 { font-size: 1.6rem; }
  .post-body h3 { font-size: 1.3rem; }
  .post-body p { margin-bottom: 1.2rem; }
  .post-body strong { color: var(--dark); font-weight: 700; }
  .post-body em { font-style: italic; }
  .post-body a { color: var(--primary); font-weight: 600; border-bottom: 2px solid var(--primary-light); transition: border-color 0.2s; text-decoration: none; }
  .post-body a:hover { border-bottom-color: var(--primary); }
  .post-body img { max-width: 100%; height: auto; border-radius: 8px; display: block; margin: 1.5rem 0; }
  .post-body ul, .post-body ol { margin: 1.2rem 0 1.2rem 2rem; }
  .post-body li { margin-bottom: 0.6rem; }
  .post-body code { background: var(--light-gray); padding: 0.3rem 0.6rem; border-radius: 4px; font-family: 'Courier New', monospace; color: var(--primary); font-size: 0.9rem; }
  .post-body pre { background: var(--light-gray); padding: 1.5rem; border-radius: 8px; overflow-x: auto; margin: 1.5rem 0; border-left: 4px solid var(--primary); }
  .post-body pre code { background: none; padding: 0; color: inherit; }
  .post-body blockquote { border-left: 4px solid var(--primary); padding-left: 1.5rem; margin: 1.5rem 0; color: var(--gray); font-style: italic; }

  /* ── POST IMAGES GALLERY ───────────────────────── */
  .post-images-gallery { display: grid; gap: 1.5rem; margin: 2rem 0; }
  .post-images-gallery.layout-1 { grid-template-columns: 1fr; }
  .post-images-gallery.layout-2 { grid-template-columns: repeat(2, 1fr); }
  .post-images-gallery.layout-3 { grid-template-columns: repeat(3, 1fr); }
  .post-images-gallery.layout-4plus { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }

  .post-image-item { border-radius: 8px; overflow: hidden; background: var(--light-gray); box-shadow: var(--shadow-sm); transition: transform 0.3s, box-shadow 0.3s; }
  .post-image-item:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
  .post-image-item img { width: 100%; height: 250px; object-fit: cover; display: block; }
  .post-image-item.full-width { grid-column: 1 / -1; }
  .post-image-item.full-width img { height: 350px; }

  /* ── POST FOOTER ───────────────────────────────── */
  .post-footer { margin-top: 3rem; padding-top: 2rem; border-top: 1.5px solid var(--border-gray); }
  .share-row { display: flex; gap: 0.8rem; }
  .share-pill {
    display: inline-flex; align-items: center; justify-content: center;
    height: 40px; padding: 0 1rem;
    border: 1.5px solid var(--border-gray); border-radius: 6px;
    background: #fff; color: var(--gray); font-size: 0.85rem; font-weight: 600;
    text-decoration: none; cursor: pointer;
    transition: background 0.2s, border-color 0.2s, color 0.2s;
  }
  .share-pill:hover { background: var(--primary); border-color: var(--primary); color: #fff; }

  /* ── COMMENTS ──────────────────────────────────── */
  .comments-section { margin-top: 3rem; padding-top: 2rem; border-top: 1.5px solid var(--border-gray); }
  .comments-section h2 { font-size: 1.4rem; font-weight: 700; color: var(--dark); margin-bottom: 2rem; }
  .comments-list { list-style: none; margin-bottom: 2rem; }
  .comment-item { background: var(--light-gray); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem; }
  .comment-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.8rem; }
  .comment-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0; }
  .comment-author { font-weight: 700; color: var(--dark); }
  .comment-date { font-size: 0.78rem; color: var(--gray); }
  .comment-body { color: var(--dark-gray); line-height: 1.6; font-size: 0.95rem; }

  /* Comment form inputs */
  .comment-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
  .comment-input {
    padding: 0.8rem; border: 1.5px solid var(--border-gray); border-radius: 6px;
    font-family: inherit; font-size: 0.95rem; width: 100%; outline: none;
    transition: border-color 0.2s;
  }
  .comment-input:focus { border-color: var(--primary); }
  .comment-submit {
    background: var(--primary); color: #fff;
    padding: 0.9rem 2rem; border: none; border-radius: 6px;
    font-weight: 700; font-size: 0.9rem; cursor: pointer;
    transition: background 0.2s;
  }
  .comment-submit:hover { background: var(--primary-dark); }

  /* ── RELATED POSTS ─────────────────────────────── */
  .related-posts { margin-top: 3rem; padding-top: 2rem; border-top: 1.5px solid var(--border-gray); }
  .related-posts h2 { font-size: 1.4rem; font-weight: 700; color: var(--dark); margin-bottom: 1.5rem; }
  .related-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; }
  .related-card { background: #fff; border: 1px solid var(--border-gray); border-radius: 8px; overflow: hidden; transition: box-shadow 0.3s, transform 0.2s; }
  .related-card:hover { box-shadow: var(--shadow-md); transform: translateY(-4px); }
  .related-card-image { width: 100%; height: 160px; overflow: hidden; background: var(--light-gray); }
  .related-card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; display: block; }
  .related-card:hover .related-card-image img { transform: scale(1.05); }
  .related-card-body { padding: 1.1rem; }
  .related-card-body h4 { font-size: 0.9rem; font-weight: 700; color: var(--dark); margin-bottom: 0.4rem; line-height: 1.35; }
  .related-card-body a { text-decoration: none; color: inherit; }
  .related-card:hover h4 { color: var(--primary); }
  .related-date { font-size: 0.72rem; color: var(--gray); }

  /* ── SIDEBAR ───────────────────────────────────── */
  .post-sidebar { display: flex; flex-direction: column; }
  .post-sidebar-widget { background: #fff; border: 1px solid var(--border-gray); border-radius: 10px; padding: 1.5rem; margin-bottom: 1.5rem; }
  .post-widget-title { font-size: 0.9rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 2px solid var(--primary); text-transform: uppercase; letter-spacing: 0.05em; }

  .sidebar-recent-list { list-style: none; }
  .sidebar-recent-item { padding: 0.8rem 0; border-bottom: 1px solid var(--border-gray); }
  .sidebar-recent-item:last-child { border-bottom: none; }
  .sidebar-recent-item a { display: block; color: var(--dark-gray); font-weight: 600; font-size: 0.85rem; line-height: 1.4; text-decoration: none; transition: color 0.2s; }
  .sidebar-recent-item a:hover { color: var(--primary); }
  .sidebar-recent-date { font-size: 0.7rem; color: var(--gray); margin-top: 0.3rem; }

  .sidebar-share-row { display: flex; gap: 0.6rem; margin-top: 0.5rem; }
  .sidebar-share-btn { display: inline-flex; align-items: center; justify-content: center; flex: 1; height: 38px; border: 1.5px solid var(--border-gray); border-radius: 6px; background: #fff; color: var(--gray); font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: background 0.2s, border-color 0.2s, color 0.2s; }
  .sidebar-share-btn:hover { background: var(--primary); border-color: var(--primary); color: #fff; }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 1024px) {
    .post-detail-layout { grid-template-columns: 1fr; }
    .post-images-gallery.layout-2 { grid-template-columns: 1fr; }
    .post-images-gallery.layout-3 { grid-template-columns: repeat(2, 1fr); }
    .comment-form-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 768px) {
    .post-detail-container { padding: 2rem 0; }
    .post-wrap { padding: 0 1.25rem; }
    .post-main-title { font-size: 1.6rem; }
    .post-body { font-size: 0.95rem; }
    .post-images-gallery { grid-template-columns: 1fr !important; }
    .post-image-item.full-width { grid-column: 1; }
    .share-row { flex-wrap: wrap; }
  }
</style>

<main>

<!-- PAGE HERO -->
<section style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('./assets/images/about-hero-bg.jpg') center/cover no-repeat; min-height: 280px; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; flex-wrap: wrap; gap: 1.5rem;">
  <div style="max-width: 700px;">
    <h1 style="font-size: clamp(1.4rem, 3.5vw, 2.2rem); font-weight: 800; color: #fff; line-height: 1.25;"><?= htmlspecialchars($post['title']) ?></h1>
  </div>
  <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(224,53,53,0.9); padding: 0.8rem 1.5rem; border-radius: 100px; flex-shrink: 0;">
    <a href="index.php" style="color: #fff; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; text-decoration: none;">HOME</a>
    <span style="color: rgba(255,255,255,0.6);">/</span>
    <a href="our-blog.php" style="color: #fff; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; text-decoration: none;">BLOG</a>
    <span style="color: rgba(255,255,255,0.6);">/</span>
    <span style="color: rgba(255,255,255,0.8); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;"><?= htmlspecialchars(strtoupper(substr($post['title'], 0, 25))) ?>...</span>
  </div>
</section>

<!-- POST DETAIL -->
<section class="post-detail-container">
  <div class="post-wrap">
    <div class="post-detail-layout">

      <!-- Main Content -->
      <article>

        <!-- Post Header -->
        <div class="post-header">
          <?php if ($post['category_name']): ?>
            <span class="post-category-badge"><?= htmlspecialchars($post['category_name']) ?></span>
          <?php endif; ?>

          <h1 class="post-main-title"><?= htmlspecialchars($post['title']) ?></h1>

          <div class="post-meta-bar">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
              <div class="meta-avatar"><?= strtoupper(substr($post['author_name'] ?? 'A', 0, 1)) ?></div>
              <div>
                <strong><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></strong><br>
                <span><?= $publishedDate->format('M d, Y') ?></span>
              </div>
            </div>
            <div>👁 <?= number_format($post['views']) ?> views</div>
          </div>
        </div>

        <!-- Featured Image -->
        <?php if ($post['featured_image']): ?>
        <div class="post-featured-image">
          <img src="assets/images/<?= htmlspecialchars($post['featured_image']) ?>"
               alt="<?= htmlspecialchars($post['title']) ?>"
               onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%221200%22 height=%22600%22%3E%3Crect fill=%22%23E0F7F2%22 width=%221200%22 height=%22600%22/%3E%3C/svg%3E'">
        </div>
        <?php endif; ?>

        <!-- Post Body -->
        <div class="post-body"><?= $post['content']; ?></div>

        <!-- Post Images Gallery -->
        <?php if (!empty($postImages)):
          $imageCount = count($postImages);
          if ($imageCount === 1)      $layoutClass = 'layout-1';
          elseif ($imageCount === 2)  $layoutClass = 'layout-2';
          elseif ($imageCount === 3)  $layoutClass = 'layout-3';
          else                        $layoutClass = 'layout-4plus';
        ?>
        <div class="post-images-gallery <?= $layoutClass ?>">
          <?php foreach ($postImages as $index => $image):
            $imageUrl = $image['url'];
            if (strpos($imageUrl, '/') === 0) {
                $imageUrl = ltrim($imageUrl, '/');
            }
            $isLastOdd = ($index === count($postImages) - 1 && count($postImages) % 2 !== 0 && $layoutClass === 'layout-2');
          ?>
          <div class="post-image-item <?= $isLastOdd ? 'full-width' : '' ?>">
            <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Post image" loading="lazy">
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Post Footer / Share -->
        <div class="post-footer">
          <div class="share-row">
            <a href="https://facebook.com/sharer/sharer.php?u=<?= urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
               target="_blank" class="share-pill">f Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($post['title']) ?>"
               target="_blank" class="share-pill">𝕏 Twitter</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
               target="_blank" class="share-pill">in LinkedIn</a>
          </div>
        </div>

        <!-- Comments Section -->
        <?php if ($post['allow_comments']): ?>
        <div class="comments-section">
          <h2>Comments (<?= count($comments) ?>)</h2>

          <?php if ($commentMessage): ?>
            <div style="background: #E6F7F2; border-left: 4px solid var(--secondary); padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; color: var(--secondary-dark);">
              ✓ <?= htmlspecialchars($commentMessage) ?>
            </div>
          <?php endif; ?>
          <?php if ($commentError): ?>
            <div style="background: var(--primary-light); border-left: 4px solid var(--primary); padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; color: var(--primary-dark);">
              ✕ <?= htmlspecialchars($commentError) ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($comments)): ?>
          <ul class="comments-list">
            <?php foreach ($comments as $comment):
              $cDate = new DateTime($comment['created_at']);
            ?>
            <li class="comment-item">
              <div class="comment-header">
                <div class="comment-avatar"><?= strtoupper(substr($comment['author_name'], 0, 1)) ?></div>
                <div>
                  <div class="comment-author"><?= htmlspecialchars($comment['author_name']) ?></div>
                  <div class="comment-date"><?= $cDate->format('M d, Y \a\t g:i A') ?></div>
                </div>
              </div>
              <div class="comment-body"><?= htmlspecialchars($comment['content']) ?></div>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php else: ?>
            <p style="color: var(--gray); padding: 1rem 0;">No comments yet. Be the first to comment!</p>
          <?php endif; ?>

          <!-- Comment Form -->
          <form method="POST" style="margin-top: 2rem; padding-top: 2rem; border-top: 1.5px solid var(--border-gray);">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--dark); margin-bottom: 1.5rem;">Leave a Comment</h3>
            <div class="comment-form-grid">
              <input type="text" name="author_name" placeholder="Your Name" required class="comment-input">
              <input type="email" name="author_email" placeholder="Your Email" required class="comment-input">
            </div>
            <textarea name="comment_content" placeholder="Your comment..." required rows="4"
                      class="comment-input" style="margin-bottom: 1rem; resize: vertical;"></textarea>
            <button type="submit" class="comment-submit">Post Comment</button>
            <p style="font-size: 0.8rem; color: var(--gray); margin-top: 0.8rem;">💬 Your comment will appear after moderation.</p>
            <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
          </form>
        </div>
        <?php endif; ?>

        <!-- Related Posts -->
        <?php if (!empty($relatedPosts)): ?>
        <div class="related-posts">
          <h2>Related Articles</h2>
          <div class="related-grid">
            <?php foreach ($relatedPosts as $related):
              $rDate = new DateTime($related['published_at']);
            ?>
            <div class="related-card">
              <div class="related-card-image">
                <img src="assets/images/<?= htmlspecialchars($related['featured_image'] ?? '') ?>"
                     alt="<?= htmlspecialchars($related['title']) ?>"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22250%22 height=%22180%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22250%22 height=%22180%22/%3E%3C/svg%3E'">
              </div>
              <div class="related-card-body">
                <a href="<?= htmlspecialchars($related['slug']) ?>">
                  <h4><?= htmlspecialchars($related['title']) ?></h4>
                </a>
                <div class="related-date"><?= $rDate->format('M d, Y') ?></div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

      </article>

      <!-- Sidebar -->
      <aside class="post-sidebar">

        <div class="post-sidebar-widget">
          <h3 class="post-widget-title">Recent Posts</h3>
          <ul class="sidebar-recent-list">
            <?php foreach ($recentPosts as $recent):
              $rDate = new DateTime($recent['published_at']);
            ?>
            <li class="sidebar-recent-item">
              <a href="<?= htmlspecialchars($recent['slug']) ?>"><?= htmlspecialchars($recent['title']) ?></a>
              <div class="sidebar-recent-date"><?= $rDate->format('M d, Y') ?></div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="post-sidebar-widget">
          <h3 class="post-widget-title">About</h3>
          <p style="font-size: 0.88rem; line-height: 1.7; color: var(--gray); margin: 0;">
            Whoba Ogo Foundation is an African social impact organization committed to touching lives
            of rural community dwellers through medical and educational support.
          </p>
        </div>

        <div class="post-sidebar-widget">
          <h3 class="post-widget-title">Share This Post</h3>
          <div class="sidebar-share-row">
            <a href="https://facebook.com/sharer/sharer.php?u=<?= urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
               target="_blank" class="sidebar-share-btn">Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
               target="_blank" class="sidebar-share-btn">Twitter</a>
          </div>
        </div>

      </aside>

    </div>
  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>