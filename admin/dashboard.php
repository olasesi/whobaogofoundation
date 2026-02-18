<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/config.php';



// Guard — must be logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$adminName = $_SESSION['admin_name'] ?? 'Admin';
$adminRole = $_SESSION['admin_role'] ?? 'author';

// ── Stat queries ──────────────────────────────────────────────

$totalPosts = $pdo->query(
    "SELECT COUNT(*) FROM posts WHERE post_type = 'post'"
)->fetchColumn();

$totalPrograms = $pdo->query(
    "SELECT COUNT(*) FROM posts WHERE post_type = 'program'"
)->fetchColumn();

$pendingComments = $pdo->query(
    "SELECT COUNT(*) FROM comments WHERE status = 'pending'"
)->fetchColumn();

$totalSubscribers = $pdo->query(
    "SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'confirmed'"
)->fetchColumn();

// ── Recent posts (last 8) ─────────────────────────────────────

$recentPosts = $pdo->query(
    "SELECT p.id, p.title, p.status, p.post_type, p.views,
            p.created_at, a.name AS author_name
     FROM   posts p
     LEFT JOIN admins a ON a.id = p.author_id
     ORDER  BY p.created_at DESC
     LIMIT  8"
)->fetchAll();

// ── Recent comments (last 6) ──────────────────────────────────

$recentComments = $pdo->query(
    "SELECT c.id, c.author_name, c.author_email,
            c.content, c.status, c.created_at,
            p.title AS post_title
     FROM   comments c
     LEFT JOIN posts p ON p.id = c.post_id
     ORDER  BY c.created_at DESC
     LIMIT  6"
)->fetchAll();

// ── Helper: format date ───────────────────────────────────────
function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)     return $diff . 's ago';
    if ($diff < 3600)   return floor($diff / 60) . 'm ago';
    if ($diff < 86400)  return floor($diff / 3600) . 'h ago';
    return floor($diff / 86400) . 'd ago';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — WOF Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/stylesheets/dashboard.css"/>

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

    <a href="dashboard.php" class="nav-item active">
      <span class="ni-icon">🏠</span> Dashboard
    </a>
    <a href="posts.php" class="nav-item">
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
      <?php if ($pendingComments > 0): ?>
        <span class="nav-badge"><?= (int)$pendingComments ?></span>
      <?php endif; ?>
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
        <?= strtoupper(substr($adminName, 0, 2)) ?>
      </div>
      <div class="admin-info">
        <strong><?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?></strong>
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
    <span class="page-title">Dashboard</span>
    <div class="topbar-right">
      <span class="topbar-greeting">
        Good <?= (date('H') < 12 ? 'morning' : (date('H') < 17 ? 'afternoon' : 'evening')) ?>,
        <strong><?= htmlspecialchars(explode(' ', $adminName)[0], ENT_QUOTES, 'UTF-8') ?></strong>
      </span>
      <span class="topbar-date"><?= date('D, d M Y') ?></span>
      <div class="notif-btn" title="Notifications">
        🔔
        <?php if ($pendingComments > 0): ?>
          <span class="notif-dot"></span>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Content -->
  <div class="content">

    <!-- Quick actions -->
    <div class="quick-actions">
      <a href="posts.php?action=new" class="qa-btn">
        <span class="qa-icon">✍</span> New Post
      </a>
      <a href="programs.php?action=new" class="qa-btn">
        <span class="qa-icon">➕</span> New Program
      </a>
      <a href="gallery.php?action=new" class="qa-btn">
        <span class="qa-icon">📷</span> Add Gallery
      </a>
      <a href="settings.php" class="qa-btn">
        <span class="qa-icon">⚙</span> Settings
      </a>
    </div>

    <!-- Stat cards -->
    <div class="stats-grid">
      <div class="stat-card red">
        <div class="stat-top">
          <span class="stat-label">Posts &amp; News</span>
          <span class="stat-icon">📝</span>
        </div>
        <div class="stat-num"><?= (int)$totalPosts ?></div>
        <div class="stat-sub">Total articles published</div>
      </div>

      <div class="stat-card teal">
        <div class="stat-top">
          <span class="stat-label">Programs</span>
          <span class="stat-icon">📋</span>
        </div>
        <div class="stat-num"><?= (int)$totalPrograms ?></div>
        <div class="stat-sub">Active program pages</div>
      </div>

      <div class="stat-card sun">
        <div class="stat-top">
          <span class="stat-label">Pending Comments</span>
          <span class="stat-icon">🗨</span>
        </div>
        <div class="stat-num"><?= (int)$pendingComments ?></div>
        <div class="stat-sub">
          <?php if ($pendingComments > 0): ?>
            <span class="warn">Needs your review</span>
          <?php else: ?>
            All comments reviewed
          <?php endif; ?>
        </div>
      </div>

      <div class="stat-card green">
        <div class="stat-top">
          <span class="stat-label">Subscribers</span>
          <span class="stat-icon">✉</span>
        </div>
        <div class="stat-num"><?= (int)$totalSubscribers ?></div>
        <div class="stat-sub">Confirmed newsletter signups</div>
      </div>
    </div>

    <!-- Main grid -->
    <div class="main-grid">

      <!-- Recent Posts -->
      <div class="panel">
        <div class="panel-head">
          <h3>Recent Posts</h3>
          <a href="posts.php">View all →</a>
        </div>
        <?php if (empty($recentPosts)): ?>
          <div class="empty-state">
            <span>📝</span>No posts yet. <a href="posts.php?action=new" style="color:var(--red);">Create one →</a>
          </div>
        <?php else: ?>
          <table class="posts-table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Status</th>
                <th>Views</th>
                <th>Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentPosts as $post): ?>
              <tr>
                <td class="post-title-cell">
                  <strong><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                  <span>by <?= htmlspecialchars($post['author_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></span>
                </td>
                <td>
                  <span class="type-badge <?= htmlspecialchars($post['post_type'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($post['post_type'], ENT_QUOTES, 'UTF-8') ?>
                  </span>
                </td>
                <td>
                  <span class="status-dot <?= htmlspecialchars($post['status'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars(ucfirst($post['status']), ENT_QUOTES, 'UTF-8') ?>
                  </span>
                </td>
                <td><?= number_format((int)$post['views']) ?></td>
                <td><?= timeAgo($post['created_at']) ?></td>
                <td>
                  <div class="row-actions">
                    <a href="posts.php?action=edit&id=<?= (int)$post['id'] ?>">
                      <button class="act-btn edit" title="Edit">✏</button>
                    </a>
                    <a href="posts.php?action=delete&id=<?= (int)$post['id'] ?>"
                       onclick="return confirm('Delete this post?')">
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

      <!-- Recent Comments -->
      <div class="panel">
        <div class="panel-head">
          <h3>Recent Comments</h3>
          <a href="comments.php">View all →</a>
        </div>
        <?php if (empty($recentComments)): ?>
          <div class="empty-state">
            <span>🗨</span>No comments yet.
          </div>
        <?php else: ?>
          <ul class="comment-list">
            <?php foreach ($recentComments as $comment): ?>
            <li class="comment-item">
              <div class="comment-top">
                <div class="comment-author">
                  <div class="comment-avatar">
                    <?= strtoupper(substr($comment['author_name'], 0, 2)) ?>
                  </div>
                  <span class="comment-name">
                    <?= htmlspecialchars($comment['author_name'], ENT_QUOTES, 'UTF-8') ?>
                  </span>
                </div>
                <span class="comment-status-badge <?= htmlspecialchars($comment['status'], ENT_QUOTES, 'UTF-8') ?>">
                  <?= htmlspecialchars(ucfirst($comment['status']), ENT_QUOTES, 'UTF-8') ?>
                </span>
              </div>

              <div class="comment-post">
                On: <strong><?= htmlspecialchars($comment['post_title'] ?? 'Unknown post', ENT_QUOTES, 'UTF-8') ?></strong>
              </div>

              <div class="comment-body">
                <?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?>
              </div>

              <div style="display:flex;justify-content:space-between;align-items:center;">
                <div class="comment-actions">
                  <?php if ($comment['status'] !== 'approved'): ?>
                    <a href="comments.php?action=approve&id=<?= (int)$comment['id'] ?>">
                      <button class="c-act approve">✓ Approve</button>
                    </a>
                  <?php endif; ?>
                  <a href="comments.php?action=spam&id=<?= (int)$comment['id'] ?>">
                    <button class="c-act spam">Spam</button>
                  </a>
                  <a href="comments.php?action=trash&id=<?= (int)$comment['id'] ?>"
                     onclick="return confirm('Move to trash?')">
                    <button class="c-act trash">Trash</button>
                  </a>
                </div>
                <span class="comment-time"><?= timeAgo($comment['created_at']) ?></span>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

    </div><!-- /.main-grid -->
  </div><!-- /.content -->
</div><!-- /.main -->

<script>
  // Sidebar toggle (mobile)
  const sidebar   = document.getElementById('sidebar');
  const hamburger = document.getElementById('hamburger');

  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });

  // Close sidebar when clicking outside on mobile
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
  document.getElementById('logoutForm').addEventListener('submit', (e) => {
    e.preventDefault();
    if (confirm('Are you sure you want to sign out?')) {
      e.target.submit();
    }
  });
</script>

</body>
</html>