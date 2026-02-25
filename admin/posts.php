<?php
require_once __DIR__ .'/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/includes/featured-image-uploader.php';

// Guard — must be logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$adminId = $_SESSION['admin_id'];
$adminRole = $_SESSION['admin_role'] ?? 'author';

// ── HELPER FUNCTIONS ──────────────────────────────────────

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = preg_replace('~-+~', '-', $text);
    return trim($text, '-');
}

function isSlugUnique(PDO $pdo, string $slug, string $postType, ?int $excludeId = null): bool {
    $query = "SELECT COUNT(*) FROM posts 
              WHERE slug = :slug AND post_type = :type";
    $params = [':slug' => $slug, ':type' => $postType];
    
    if ($excludeId) {
        $query .= " AND id != :id";
        $params[':id'] = $excludeId;
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchColumn() === 0;
}

function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)     return $diff . 's ago';
    if ($diff < 3600)   return floor($diff / 60) . 'm ago';
    if ($diff < 86400)  return floor($diff / 3600) . 'h ago';
    return floor($diff / 86400) . 'd ago';
}

// ── ACTIONS ────────────────────────────────────────────────

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$message = '';
$error = '';

// Get categories
$categories = $pdo->query(
    "SELECT id, name FROM categories WHERE post_type = 'post' ORDER BY name"
)->fetchAll();

// ── CREATE / EDIT POST ────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($action, ['create', 'edit'])) {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $slug = isset($_POST['slug']) ? slugify($_POST['slug']) : '';
    $excerpt = isset($_POST['excerpt']) ? trim($_POST['excerpt']) : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $status = isset($_POST['status']) && in_array($_POST['status'], ['draft', 'published', 'archived', 'scheduled']) 
              ? $_POST['status'] 
              : 'draft';
    $visibility = isset($_POST['visibility']) && in_array($_POST['visibility'], ['public', 'private']) 
                  ? $_POST['visibility'] 
                  : 'public';
    $allow_comments = isset($_POST['allow_comments']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $meta_title = isset($_POST['meta_title']) ? trim($_POST['meta_title']) : '';
    $meta_description = isset($_POST['meta_description']) ? trim($_POST['meta_description']) : '';
    $meta_keywords = isset($_POST['meta_keywords']) ? trim($_POST['meta_keywords']) : '';
    $published_at = null;
    $scheduled_at = null;

    // Handle published date
    if (isset($_POST['published_at']) && $_POST['published_at']) {
        try {
            $published_at = (new DateTime($_POST['published_at']))->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            $published_at = null;
        }
    }

    // Handle scheduled date
    if ($status === 'scheduled' && isset($_POST['scheduled_at']) && $_POST['scheduled_at']) {
        try {
            $scheduled_at = (new DateTime($_POST['scheduled_at']))->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            $scheduled_at = null;
        }
    }
    
    // Validation
    if (!$title) {
        $error = 'Post title is required.';
    } elseif (!$slug) {
        $error = 'Slug cannot be empty.';
    } elseif (!isSlugUnique($pdo, $slug, 'post', $id)) {
        $error = 'This slug is already in use. Please choose a different one.';
    } elseif ($status === 'scheduled' && !$scheduled_at) {
        $error = 'Scheduled date/time is required for scheduled posts.';
    } else {
        try {
            if ($action === 'create') {
                // Upload featured image
                $featured_image = null;
                if (isset($_FILES['featured_image']) && $_FILES['featured_image']['size'] > 0) {
                    $uploadResult = uploadFeaturedImage($_FILES['featured_image']);
                    if ($uploadResult['success']) {
                        $featured_image = $uploadResult['path'];
                    } else {
                        $error = 'Image upload failed: ' . $uploadResult['error'];
                        $featured_image = null;
                    }
                }

                if (!$error) {
                    $stmt = $pdo->prepare("
                        INSERT INTO posts 
                        (author_id, category_id, post_type, title, slug, excerpt, content, 
                         featured_image, status, visibility, allow_comments, is_featured, 
                         published_at, scheduled_at, meta_title, meta_description, meta_keywords)
                        VALUES 
                        (:author_id, :category_id, 'post', :title, :slug, :excerpt, :content,
                         :featured_image, :status, :visibility, :allow_comments, :is_featured,
                         :published_at, :scheduled_at, :meta_title, :meta_description, :meta_keywords)
                    ");

                    $stmt->execute([
                        ':author_id' => $adminId,
                        ':category_id' => $category_id ?: null,
                        ':title' => $title,
                        ':slug' => $slug,
                        ':excerpt' => $excerpt,
                        ':content' => $content,
                        ':featured_image' => $featured_image,
                        ':status' => $status,
                        ':visibility' => $visibility,
                        ':allow_comments' => $allow_comments,
                        ':is_featured' => $is_featured,
                        ':published_at' => $published_at,
                        ':scheduled_at' => $scheduled_at,
                        ':meta_title' => $meta_title,
                        ':meta_description' => $meta_description,
                        ':meta_keywords' => $meta_keywords,
                    ]);

                    $message = 'Post created successfully! Image saved to: featured-images/' . date('Y-m-d') . '/';
                    $action = 'list';
                }

            } elseif ($action === 'edit' && $id) {
                // Check ownership (authors can only edit their own posts)
                $checkStmt = $pdo->prepare("SELECT author_id, featured_image FROM posts WHERE id = :id");
                $checkStmt->execute([':id' => $id]);
                $post = $checkStmt->fetch();

                if (!$post) {
                    $error = 'Post not found.';
                } elseif ($post['author_id'] != $adminId && $adminRole !== 'super_admin' && $adminRole !== 'editor') {
                    $error = 'You do not have permission to edit this post.';
                } else {
                    // Handle featured image upload
                    $featured_image = $post['featured_image']; // Keep existing by default
                    
                    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['size'] > 0) {
                        $uploadResult = uploadFeaturedImage($_FILES['featured_image']);
                        if ($uploadResult['success']) {
                            // Delete old image if exists
                            if ($post['featured_image']) {
                                deleteFeaturedImage($post['featured_image']);
                            }
                            $featured_image = $uploadResult['path'];
                        } else {
                            $error = 'Image upload failed: ' . $uploadResult['error'];
                        }
                    }

                    if (!$error) {
                        // Handle published_at: use provided date if status is published, otherwise preserve current
                        $finalPublishedAt = $published_at;
                        if ($status === 'published' && !$published_at) {
                            // If publishing and no date provided, use current time
                            $finalPublishedAt = date('Y-m-d H:i:s');
                        } elseif ($status !== 'published') {
                            // If not publishing, clear the published_at
                            $finalPublishedAt = null;
                        }

                        $updateQuery = "
                            UPDATE posts 
                            SET category_id = :category_id,
                                title = :title,
                                slug = :slug,
                                excerpt = :excerpt,
                                content = :content,
                                featured_image = :featured_image,
                                status = :status,
                                visibility = :visibility,
                                allow_comments = :allow_comments,
                                is_featured = :is_featured,
                                published_at = :published_at,
                                scheduled_at = :scheduled_at,
                                meta_title = :meta_title,
                                meta_description = :meta_description,
                                meta_keywords = :meta_keywords
                            WHERE id = :id
                        ";

                        $updateStmt = $pdo->prepare($updateQuery);
                        $params = [
                            ':id' => $id,
                            ':category_id' => $category_id ?: null,
                            ':title' => $title,
                            ':slug' => $slug,
                            ':excerpt' => $excerpt,
                            ':content' => $content,
                            ':featured_image' => $featured_image,
                            ':status' => $status,
                            ':visibility' => $visibility,
                            ':allow_comments' => $allow_comments,
                            ':is_featured' => $is_featured,
                            ':published_at' => $finalPublishedAt,
                            ':scheduled_at' => $scheduled_at,
                            ':meta_title' => $meta_title,
                            ':meta_description' => $meta_description,
                            ':meta_keywords' => $meta_keywords,
                        ];

                        $updateStmt->execute($params);

                        $message = 'Post updated successfully!';
                        $action = 'list';
                    }
                }
            }
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ── DELETE POST ────────────────────────────────────────────

if ($action === 'delete' && $id) {
    try {
        // Check ownership
        $checkStmt = $pdo->prepare("SELECT author_id, featured_image FROM posts WHERE id = :id");
        $checkStmt->execute([':id' => $id]);
        $post = $checkStmt->fetch();

        if (!$post) {
            $error = 'Post not found.';
        } elseif ($post['author_id'] != $adminId && $adminRole !== 'super_admin' && $adminRole !== 'editor') {
            $error = 'You do not have permission to delete this post.';
        } else {
            // Delete featured image if exists
            if ($post['featured_image']) {
                deleteFeaturedImage($post['featured_image']);
            }

            $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
            $deleteStmt->execute([':id' => $id]);
            $message = 'Post and image deleted successfully!';
            $action = 'list';
        }
    } catch (Exception $e) {
        $error = 'Error deleting post: ' . $e->getMessage();
    }
}

// ── LIST POSTS ─────────────────────────────────────────────

$posts = [];
if ($action === 'list') {
    $query = "SELECT p.id, p.title, p.status, p.views, p.created_at, p.featured_image, a.name AS author_name
              FROM posts p
              LEFT JOIN admins a ON a.id = p.author_id
              WHERE p.post_type = 'post'";
    
    // Authors can only see their own posts, editors/super_admins see all
    if ($adminRole === 'author') {
        $query .= " AND p.author_id = :author_id";
    }
    
    $query .= " ORDER BY p.created_at DESC";
    
    $stmt = $pdo->prepare($query);
    
    if ($adminRole === 'author') {
        $stmt->execute([':author_id' => $adminId]);
    } else {
        $stmt->execute();
    }
    
    $posts = $stmt->fetchAll();
}

// ── GET POST FOR EDITING ───────────────────────────────────

$editPost = null;
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id AND post_type = 'post'");
    $stmt->execute([':id' => $id]);
    $editPost = $stmt->fetch();

    if ($editPost) {
        // Check permissions
        if ($editPost['author_id'] != $adminId && $adminRole !== 'super_admin' && $adminRole !== 'editor') {
            $error = 'You do not have permission to edit this post.';
            $action = 'list';
            $editPost = null;
        }
    } else {
        $error = 'Post not found.';
        $action = 'list';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $action === 'create' ? 'New Post' : ($action === 'edit' ? 'Edit Post' : 'Posts & News') ?> — WOF Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/stylesheets/dashboard.css"/>
  <style>
    /* ── FORM STYLES ────────────────────────────────── */
    .form-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--r-lg);
      padding: 2.5rem;
      max-width: 1000px;
      margin: 0 auto;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .form-grid.full {
      grid-template-columns: 1fr;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-label {
      font-weight: 700;
      font-size: 0.9rem;
      color: var(--ink);
      margin-bottom: 0.6rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .form-input,
    .form-select,
    .form-textarea {
      padding: 0.9rem 1.1rem;
      border: 1.5px solid var(--border);
      border-radius: var(--r-sm);
      font-size: 0.95rem;
      font-family: inherit;
      color: var(--ink);
      background: var(--white);
      transition: border-color 0.2s;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      outline: none;
      border-color: var(--red);
      box-shadow: 0 0 0 3px rgba(224,53,53,0.1);
    }

    .form-textarea {
      resize: vertical;
      min-height: 120px;
      font-family: 'Courier New', monospace;
    }

    .form-hint {
      font-size: 0.8rem;
      color: var(--ink-light);
      margin-top: 0.4rem;
    }

    .form-group.with-label-icon {
      position: relative;
    }

    .form-group.with-label-icon .form-input {
      padding-left: 2.5rem;
    }

    .form-group.with-label-icon .form-icon {
      position: absolute;
      left: 0.8rem;
      top: 2.3rem;
      font-size: 1.1rem;
      color: var(--ink-light);
    }

    /* Checkboxes & Toggles */
    .form-check {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      margin: 1rem 0;
    }

    .form-check input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      accent-color: var(--red);
    }

    .form-check label {
      cursor: pointer;
      font-weight: 500;
      font-size: 0.95rem;
      color: var(--ink);
    }

    /* Rich Text Editor */
    .editor-toolbar {
      display: flex;
      gap: 0.5rem;
      padding: 1rem;
      background: var(--surface);
      border-bottom: 1.5px solid var(--border);
      border-radius: var(--r-sm) var(--r-sm) 0 0;
      flex-wrap: wrap;
    }

    .editor-btn {
      padding: 0.5rem 0.8rem;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 4px;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      color: var(--ink);
      transition: background 0.2s;
    }

    .editor-btn:hover {
      background: var(--red-soft);
      border-color: var(--red);
    }

    /* Form Actions */
    .form-actions {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 1.5px solid var(--border);
    }

    .btn-primary {
      padding: 0.9rem 2rem;
      background: var(--red);
      color: #fff;
      border: none;
      border-radius: var(--r-sm);
      font-weight: 700;
      font-size: 0.9rem;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-primary:hover {
      background: var(--red-dark);
    }

    .btn-secondary {
      padding: 0.9rem 2rem;
      background: var(--surface);
      color: var(--ink);
      border: 1.5px solid var(--border);
      border-radius: var(--r-sm);
      font-weight: 700;
      font-size: 0.9rem;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-secondary:hover {
      background: var(--white);
      border-color: var(--red);
      color: var(--red);
    }

    /* Alerts */
    .alert {
      padding: 1rem 1.5rem;
      border-radius: var(--r-sm);
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }

    .alert-success {
      background: #E6F7F2;
      color: #0D9B7E;
      border-left: 4px solid #0D9B7E;
    }

    .alert-error {
      background: #FFE6E6;
      color: #E03535;
      border-left: 4px solid #E03535;
    }

    /* Table Styles */
    .posts-table {
      width: 100%;
      border-collapse: collapse;
    }

    .posts-table thead th {
      background: var(--surface);
      padding: 1rem;
      text-align: left;
      font-weight: 700;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--ink-light);
      border-bottom: 1.5px solid var(--border);
    }

    .posts-table tbody td {
      padding: 1.2rem 1rem;
      border-bottom: 1px solid var(--border);
      color: var(--ink-mid);
    }

    .posts-table tbody tr:hover {
      background: var(--surface);
    }

    .posts-table .post-title-cell {
      font-weight: 600;
      color: var(--ink);
    }

    .posts-table .post-title-cell span {
      display: block;
      font-size: 0.8rem;
      color: var(--ink-light);
      font-weight: 400;
      margin-top: 0.3rem;
    }

    .status-badge {
      display: inline-block;
      padding: 0.4rem 0.9rem;
      border-radius: 100px;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .status-badge.draft {
      background: var(--surface);
      color: var(--ink-light);
    }

    .status-badge.published {
      background: #E6F7F2;
      color: #0D9B7E;
    }

    .status-badge.archived {
      background: #F5F5F5;
      color: #999;
    }

    .status-badge.scheduled {
      background: #FFF3E0;
      color: #E0A000;
    }

    .row-actions {
      display: flex;
      gap: 0.5rem;
    }

    .act-btn {
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--white);
      border: 1.5px solid var(--border);
      border-radius: var(--r-sm);
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.2s, border-color 0.2s;
    }

    .act-btn:hover {
      background: var(--surface);
      border-color: var(--red);
    }

    .act-btn.delete:hover {
      background: #FFE6E6;
      border-color: #E03535;
    }

    @media (max-width: 900px) {
      .form-grid {
        grid-template-columns: 1fr;
      }

      .form-actions {
        flex-direction: column;
      }

      .form-card {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>

<!-- ── SIDEBAR ──────────────────────────────────── -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-orb">♥</div>
    <div class="logo-text">
      <strong>WOF Admin</strong>
      <small>...touching lives</small>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Main</div>
    <a href="dashboard.php" class="nav-item">
      <span class="ni-icon">🏠</span> Dashboard
    </a>
    <a href="posts.php" class="nav-item active">
      <span class="ni-icon">📝</span> Posts &amp; News
    </a>
    <a href="programs.php" class="nav-item">
      <span class="ni-icon">📋</span> Programs
    </a>
    <a href="gallery.php" class="nav-item">
      <span class="ni-icon">🖼</span> Gallery
    </a>
    <a href="testimonials.php" class="nav-item">
      <span class="ni-icon">💬</span> Testimonials
    </a>

    <div class="nav-section-label">Engagement</div>
    <a href="comments.php" class="nav-item">
      <span class="ni-icon">🗨</span> Comments
    </a>
    <a href="subscribers.php" class="nav-item">
      <span class="ni-icon">✉</span> Subscribers
    </a>

    <div class="nav-section-label">System</div>
    <a href="admins.php" class="nav-item">
      <span class="ni-icon">👥</span> Admins
    </a>
    <a href="settings.php" class="nav-item">
      <span class="ni-icon">⚙</span> Settings
    </a>
    <a href="media.php" class="nav-item">
      <span class="ni-icon">📁</span> Media Library
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="admin-chip">
      <div class="admin-avatar">
        <?= strtoupper(substr($_SESSION['admin_name'] ?? 'Admin', 0, 2)) ?>
      </div>
      <div class="admin-info">
        <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></strong>
        <small><?= htmlspecialchars($adminRole, ENT_QUOTES, 'UTF-8') ?></small>
      </div>
    </div>
    <form action="logout.php" method="POST" id="logoutForm">
      <button type="submit" class="btn-logout">⏻ Sign Out</button>
    </form>
  </div>
</aside>

<!-- ── MAIN ─────────────────────────────────────── -->
<div class="main">

  <!-- Top bar -->
  <header class="topbar">
    <button class="topbar-hamburger" id="hamburger" aria-label="Toggle sidebar">
      <span></span><span></span><span></span>
    </button>
    <span class="page-title">
      <?= $action === 'create' ? 'Create New Post' : ($action === 'edit' ? 'Edit Post' : 'Posts & News') ?>
    </span>
    <div class="topbar-right">
      <span class="topbar-greeting">
        <?php if ($action === 'list'): ?>
          <a href="posts.php?action=create" style="color: var(--red); font-weight: 700; text-decoration: none;">✍ New Post</a>
        <?php endif; ?>
      </span>
    </div>
  </header>

  <!-- Content -->
  <div class="content">

    <!-- ── LIST VIEW ─────────────────────────────────────── -->
    <?php if ($action === 'list'): ?>

      <?php if ($message): ?>
      <div class="alert alert-success">
        <span>✓</span> <?= htmlspecialchars($message) ?>
      </div>
      <?php endif; ?>

      <?php if ($error): ?>
      <div class="alert alert-error">
        <span>!</span> <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <div class="panel">
        <div class="panel-head">
          <h3>All Posts</h3>
          <span><?= count($posts) ?> posts total</span>
        </div>

        <?php if (empty($posts)): ?>
          <div class="empty-state">
            <span>📝</span>No posts yet. <a href="posts.php?action=create" style="color:var(--red);">Create one →</a>
          </div>
        <?php else: ?>
          <table class="posts-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Views</th>
                <th>Author</th>
                <th>Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($posts as $post): ?>
              <tr>
                <td class="post-title-cell">
                  <strong><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                  <span><?= htmlspecialchars($post['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                </td>
                <td>
                  <span class="status-badge <?= htmlspecialchars($post['status'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars(ucfirst($post['status']), ENT_QUOTES, 'UTF-8') ?>
                  </span>
                </td>
                <td><?= number_format((int)$post['views']) ?></td>
                <td><?= htmlspecialchars($post['author_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= timeAgo($post['created_at']) ?></td>
                <td>
                  <div class="row-actions">
                    <a href="posts.php?action=edit&id=<?= (int)$post['id'] ?>">
                      <button class="act-btn edit" title="Edit">✏</button>
                    </a>
                    <a href="posts.php?action=delete&id=<?= (int)$post['id'] ?>"
                       onclick="return confirm('Are you sure? This cannot be undone.')">
                      <button class="act-btn delete" title="Delete">🗑</button>
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

    <!-- ── CREATE / EDIT FORM ────────────────────────────── -->
    <?php elseif (in_array($action, ['create', 'edit'])): ?>

      <?php if ($message): ?>
      <div class="alert alert-success">
        <span>✓</span> <?= htmlspecialchars($message) ?>
      </div>
      <?php endif; ?>

      <?php if ($error): ?>
      <div class="alert alert-error">
        <span>!</span> <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="form-card">
        
        <!-- Basic Info -->
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label">Post Title *</label>
            <input type="text" name="title" class="form-input" 
                   value="<?= htmlspecialchars($editPost['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                   placeholder="e.g., Whoba Ogo Foundation Launches New Health Program"
                   onchange="updateSlug()"
                   required>
            <span class="form-hint">The main heading for your post</span>
          </div>

          <div class="form-group">
            <label class="form-label">Slug *</label>
            <div class="form-group with-label-icon">
              <span class="form-icon">🔗</span>
              <input type="text" name="slug" id="slug" class="form-input"
                     value="<?= htmlspecialchars($editPost['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                     placeholder="whoba-ogo-foundation-launches-health-program"
                     required>
            </div>
            <span class="form-hint">URL-friendly version of the title</span>
          </div>
        </div>

        <!-- Category & Status -->
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
              <option value="">— Select a category —</option>
              <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>" 
                      <?= $editPost && $editPost['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" id="status" onchange="toggleScheduledDate()">
              <option value="draft" <?= !$editPost || $editPost['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
              <option value="published" <?= $editPost && $editPost['status'] === 'published' ? 'selected' : '' ?>>Published</option>
              <option value="archived" <?= $editPost && $editPost['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
              <option value="scheduled" <?= $editPost && $editPost['status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
            </select>
          </div>
        </div>

        <!-- Published Date (custom date for when post was published) -->
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label">Published Date</label>
            <input type="datetime-local" name="published_at" class="form-input"
                   value="<?= $editPost && $editPost['published_at'] ? (new DateTime($editPost['published_at']))->format('Y-m-d\TH:i') : (new DateTime())->format('Y-m-d\TH:i') ?>">
            <span class="form-hint">Set the publication date (useful for past events)</span>
          </div>

          <div class="form-group">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" id="status" onchange="toggleScheduledDate()">
              <option value="draft" <?= !$editPost || $editPost['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
              <option value="published" <?= $editPost && $editPost['status'] === 'published' ? 'selected' : '' ?>>Published</option>
              <option value="archived" <?= $editPost && $editPost['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
              <option value="scheduled" <?= $editPost && $editPost['status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
            </select>
          </div>
        </div>

        <!-- Scheduled Date (shown only if status = scheduled) -->
        <div class="form-grid" id="scheduledDateGroup" style="display:<?= $editPost && $editPost['status'] === 'scheduled' ? 'grid' : 'none' ?>;">
          <div class="form-group full">
            <label class="form-label">Scheduled Publish Date & Time</label>
            <input type="datetime-local" name="scheduled_at" class="form-input"
                   value="<?= $editPost && $editPost['scheduled_at'] ? (new DateTime($editPost['scheduled_at']))->format('Y-m-d\TH:i') : '' ?>">
            <span class="form-hint">When to automatically publish this post</span>
          </div>
        </div>

        <!-- Excerpt -->
        <div class="form-group full">
          <label class="form-label">Excerpt / Summary</label>
          <textarea name="excerpt" class="form-textarea" 
                    placeholder="A brief summary that appears on listing pages..."><?= htmlspecialchars($editPost['excerpt'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
          <span class="form-hint">Optional: 150-160 characters recommended for SEO</span>
        </div>

        <!-- Content -->
        <div class="form-group full">
          <label class="form-label">Content *</label>
          <div class="editor-toolbar">
            <button type="button" class="editor-btn" onclick="insertMarkdown('**', '**', 'Bold text')">
              <strong>B</strong>
            </button>
            <button type="button" class="editor-btn" onclick="insertMarkdown('*', '*', 'Italic text')">
              <em>I</em>
            </button>
            <button type="button" class="editor-btn" onclick="insertMarkdown('# ', '\n', 'Heading')">
              H1
            </button>
            <button type="button" class="editor-btn" onclick="insertMarkdown('- ', '\n', 'List item')">
              ≡ List
            </button>
            <button type="button" class="editor-btn" onclick="insertMarkdown('[', '](url)', 'Link text')">
              🔗 Link
            </button>
            <button type="button" class="editor-btn" onclick="insertMarkdown('`', '`', 'Code')">
              &lt;&gt; Code
            </button>
            <button type="button" class="editor-btn" onclick="document.getElementById('imageInput').click()">
              🖼 Image
            </button>
            <input type="file" id="imageInput" accept="image/*" style="display:none;" onchange="handleImageUpload(event)">
          </div>
          <textarea name="content" id="content" class="form-textarea" 
                    placeholder="Write your post content here using Markdown format...&#10;&#10;Example inline image: ![Alt text|300x200](/path/to/image.jpg)"
                    style="border-top: none; border-radius: 0 0 var(--r-sm) var(--r-sm); min-height: 400px;"
                    required><?= htmlspecialchars($editPost['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
          <span class="form-hint">Supports Markdown. Use format: ![Alt text|width x height](image-url) for inline images with sizing. Example: ![Featured Event|600x400](/assets/images/event.jpg)</span>
        </div>

        <!-- Featured Image -->
        <div class="form-grid">
          <div class="form-group full">
            <label class="form-label">Featured Image</label>
            <input type="file" name="featured_image" class="form-input" accept="image/*">
            <span class="form-hint">Recommended: 760×510px. Formats: JPG, PNG, WebP</span>
            <?php if ($editPost && $editPost['featured_image']): ?>
            <span class="form-hint" style="color: var(--teal);">Current: <?= htmlspecialchars($editPost['featured_image']) ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- SEO Section -->
        <div style="background: var(--surface); padding: 1.5rem; border-radius: var(--r-sm); margin: 1.5rem 0;">
          <h4 style="font-weight: 700; color: var(--ink); margin-bottom: 1rem;">SEO Settings</h4>
          
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Meta Title</label>
              <input type="text" name="meta_title" class="form-input" maxlength="160"
                     value="<?= htmlspecialchars($editPost['meta_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                     placeholder="Custom page title for search results (60-70 chars)">
            </div>

            <div class="form-group">
              <label class="form-label">Meta Keywords</label>
              <input type="text" name="meta_keywords" class="form-input"
                     value="<?= htmlspecialchars($editPost['meta_keywords'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                     placeholder="keyword1, keyword2, keyword3">
            </div>
          </div>

          <div class="form-group full">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description" class="form-textarea" maxlength="320" 
                      style="min-height: 80px;"
                      placeholder="Brief description for search results (150-160 chars)..."><?= htmlspecialchars($editPost['meta_description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
          </div>
        </div>

        <!-- Options -->
        <div style="background: var(--surface); padding: 1.5rem; border-radius: var(--r-sm); margin: 1.5rem 0;">
          <h4 style="font-weight: 700; color: var(--ink); margin-bottom: 1rem;">Post Options</h4>

          <div class="form-check">
            <input type="checkbox" name="allow_comments" id="allow_comments" value="1"
                   <?= !$editPost || $editPost['allow_comments'] ? 'checked' : '' ?>>
            <label for="allow_comments">Allow comments on this post</label>
          </div>

          <div class="form-check">
            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                   <?= $editPost && $editPost['is_featured'] ? 'checked' : '' ?>>
            <label for="is_featured">Feature this post (pins to homepage)</label>
          </div>

          <div class="form-check">
            <input type="checkbox" name="visibility" id="visibility" value="private"
                   <?= $editPost && $editPost['visibility'] === 'private' ? 'checked' : '' ?>>
            <label for="visibility">Make this post private (only visible to logged-in users)</label>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
          <button type="submit" class="btn-primary">
            <?= $action === 'create' ? '✍ Create Post' : '💾 Save Changes' ?>
          </button>
          <a href="posts.php" class="btn-secondary">Cancel</a>
        </div>
      </form>

    <?php endif; ?>

  </div><!-- /.content -->
</div><!-- /.main -->
<script>
  // Sidebar toggle
  const sidebar   = document.getElementById('sidebar');
  const hamburger = document.getElementById('hamburger');

  hamburger?.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });

  document.addEventListener('click', (e) => {
    if (
      window.innerWidth <= 900 &&
      sidebar.classList.contains('open') &&
      !sidebar.contains(e.target) &&
      !hamburger.contains(e.target)
    ) {
      sidebar.classList.remove('open');
    }
  });

  // Logout confirmation
  document.getElementById('logoutForm')?.addEventListener('submit', (e) => {
    e.preventDefault();
    if (confirm('Are you sure you want to sign out?')) {
      e.target.submit();
    }
  });

  // Auto-generate slug from title
  function updateSlug() {
    const titleInput = document.querySelector('input[name="title"]');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput && !slugInput.value) {
      const slug = titleInput.value
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
      slugInput.value = slug;
    }
  }

  // Toggle scheduled date field
  function toggleScheduledDate() {
    const statusSelect = document.getElementById('status');
    const scheduledGroup = document.getElementById('scheduledDateGroup');
    if (statusSelect && scheduledGroup) {
      scheduledGroup.style.display = statusSelect.value === 'scheduled' ? 'grid' : 'none';
    }
  }

  // Markdown editor helpers
  function insertMarkdown(before, after, placeholder) {
    const textarea = document.getElementById('content');
    if (!textarea) return;

    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selected = textarea.value.substring(start, end) || placeholder;
    const text = textarea.value.substring(0, start) + before + selected + after + textarea.value.substring(end);

    textarea.value = text;
    textarea.focus();
    textarea.selectionStart = start + before.length;
    textarea.selectionEnd = start + before.length + selected.length;
  }

 // Handle inline image upload
 // Handle inline image upload
  function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Show a loading indicator
    const btn = event.target.parentElement.querySelector('.editor-btn');
    const originalText = btn.textContent;
    btn.textContent = '⏳ Uploading...';
    btn.disabled = true;

    // Create FormData for file upload
    const formData = new FormData();
    formData.append('image', file);

    // ✅ CORRECT - Auto-detects https or http
const protocol = window.location.protocol;  // 'https:' or 'http:'
const hostname = window.location.hostname;  // 'localhost'
const port = window.location.port ? ':' + window.location.port : '';

const uploadEndpoint = protocol + '//' + hostname + port + '/whobaogofoundation/admin/upload-image.php';

    // Upload to server
    fetch(uploadEndpoint, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      // Check if response status is ok
      if (!response.ok) {
        throw new Error(`Server error ${response.status}: ${response.statusText}`);
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        // Ask for dimensions
        const width = prompt('Image width (in pixels):', '600');
        if (!width) {
          // User cancelled - still show success but with default size
          const url = data.url;
          const altText = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
          const markdownImage = `![${altText}|600](${url})`;
          insertImageMarkdown(markdownImage);
          showNotification('✓ Image uploaded successfully!', 'success');
          return;
        }

        const height = prompt('Image height (in pixels):', 'auto');
        
        // Build markdown with dimensions
        const url = data.url;
        const altText = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
        const dimensions = height && height !== 'auto' ? `|${width}x${height}` : `|${width}`;
        const markdownImage = `![${altText}${dimensions}](${url})`;

        // Insert into textarea
        insertImageMarkdown(markdownImage);
        showNotification('✓ Image uploaded and inserted!', 'success');

      } else {
        showNotification('✗ Upload failed: ' + data.error, 'error');
      }
    })
    .catch(error => {
      console.error('Upload error:', error);
      showNotification('✗ Upload error: ' + error.message, 'error');
    })
    .finally(() => {
      // Reset button
      btn.textContent = originalText;
      btn.disabled = false;
      // Clear file input
      event.target.value = '';
    });
  }

  // Helper function to insert image markdown into textarea
  function insertImageMarkdown(markdownImage) {
    const textarea = document.getElementById('content');
    if (textarea) {
      const start = textarea.selectionStart;
      const end = textarea.selectionEnd;
      const text = textarea.value.substring(0, start) + '\n\n' + markdownImage + '\n\n' + textarea.value.substring(end);
      
      textarea.value = text;
      textarea.focus();
      textarea.selectionStart = start + markdownImage.length + 2;
    }
  }

  // Helper function to show notifications
  function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      font-weight: 700;
      z-index: 9999;
      animation: slideIn 0.3s ease;
      max-width: 400px;
      word-wrap: break-word;
      ${type === 'success' ? 'background: #E6F7F2; color: #0D9B7E; border: 1.5px solid #0D9B7E;' : 'background: #FFE6E6; color: #E03535; border: 1.5px solid #E03535;'}
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    // Auto-remove after 3 seconds
    setTimeout(() => {
      notification.style.animation = 'slideOut 0.3s ease';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }

  // Add CSS animation (if not already added)
  if (!document.querySelector('style[data-notifications]')) {
    const style = document.createElement('style');
    style.setAttribute('data-notifications', 'true');
    style.textContent = `
      @keyframes slideIn {
        from {
          transform: translateX(400px);
          opacity: 0;
        }
        to {
          transform: translateX(0);
          opacity: 1;
        }
      }

      @keyframes slideOut {
        from {
          transform: translateX(0);
          opacity: 1;
        }
        to {
          transform: translateX(400px);
          opacity: 0;
        }
      }
    `;
    document.head.appendChild(style);
  }
  // Helper function to insert image markdown into textarea
  function insertImageMarkdown(markdownImage) {
    const textarea = document.getElementById('content');
    if (textarea) {
      const start = textarea.selectionStart;
      const end = textarea.selectionEnd;
      const text = textarea.value.substring(0, start) + '\n\n' + markdownImage + '\n\n' + textarea.value.substring(end);
      
      textarea.value = text;
      textarea.focus();
      textarea.selectionStart = start + markdownImage.length + 2;
    }
  }

  // Helper function to show notifications
  function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      font-weight: 700;
      z-index: 9999;
      animation: slideIn 0.3s ease;
      ${type === 'success' ? 'background: #E6F7F2; color: #0D9B7E; border: 1.5px solid #0D9B7E;' : 'background: #FFE6E6; color: #E03535; border: 1.5px solid #E03535;'}
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    // Auto-remove after 3 seconds
    setTimeout(() => {
      notification.style.animation = 'slideOut 0.3s ease';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }

  // Add CSS animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes slideIn {
      from {
        transform: translateX(400px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideOut {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(400px);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);

</script>

</body>
</html>