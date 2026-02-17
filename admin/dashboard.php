<?php
require_once __DIR__ . '/../includes/db.php';

session_start();

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
  <style>
    :root {
      --red:        #E03535;
      --red-dark:   #B52020;
      --red-soft:   #FDE8E8;
      --teal:       #0D9B7E;
      --teal-dark:  #076E58;
      --teal-soft:  #E0F7F2;
      --sun:        #F5A623;
      --sun-soft:   #FEF3DC;
      --ink:        #111713;
      --ink-mid:    #3B4840;
      --ink-light:  #7A8C85;
      --border:     #E4EAE6;
      --white:      #FFFFFF;
      --surface:    #F7F8F5;
      --sidebar-w:  248px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--surface);
      color: var(--ink);
      min-height: 100vh;
      display: flex;
      -webkit-font-smoothing: antialiased;
    }

    a { text-decoration: none; color: inherit; }

    /* ── SIDEBAR ──────────────────────────────────── */
    .sidebar {
      width: var(--sidebar-w);
      flex-shrink: 0;
      background: var(--ink);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
      transition: transform 0.3s ease;
    }

    .sidebar-logo {
      padding: 1.5rem 1.4rem 1.2rem;
      display: flex; align-items: center; gap: 0.7rem;
      border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .logo-orb {
      width: 36px; height: 36px; border-radius: 10px;
      background: linear-gradient(135deg, var(--red), var(--red-dark));
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem; color: #fff; flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(224,53,53,0.4);
    }
    .logo-text strong {
      display: block; font-size: 0.8rem; font-weight: 800; color: #fff; line-height: 1.2;
    }
    .logo-text small { font-size: 0.58rem; color: rgba(255,255,255,0.35); letter-spacing: 0.04em; }

    /* Nav sections */
    .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
    .nav-section-label {
      font-size: 0.6rem; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.14em;
      color: rgba(255,255,255,0.25);
      padding: 0.8rem 1.4rem 0.4rem;
    }

    .nav-item {
      display: flex; align-items: center; gap: 0.7rem;
      padding: 0.62rem 1.4rem;
      font-size: 0.82rem; font-weight: 600;
      color: rgba(255,255,255,0.5);
      border-left: 3px solid transparent;
      transition: color 0.2s, background 0.2s, border-color 0.2s;
      cursor: pointer;
    }
    .nav-item:hover {
      color: #fff;
      background: rgba(255,255,255,0.05);
    }
    .nav-item.active {
      color: #fff;
      background: rgba(224,53,53,0.12);
      border-left-color: var(--red);
    }
    .nav-item .ni-icon {
      width: 28px; height: 28px; border-radius: 7px;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem; flex-shrink: 0;
      background: rgba(255,255,255,0.06);
      transition: background 0.2s;
    }
    .nav-item.active .ni-icon { background: rgba(224,53,53,0.2); }
    .nav-item:hover .ni-icon  { background: rgba(255,255,255,0.1); }
    .nav-badge {
      margin-left: auto;
      background: var(--red);
      color: #fff; font-size: 0.58rem; font-weight: 800;
      padding: 0.15rem 0.45rem; border-radius: 100px;
      min-width: 18px; text-align: center;
    }

    /* Sidebar footer */
    .sidebar-footer {
      padding: 1rem 1.4rem;
      border-top: 1px solid rgba(255,255,255,0.07);
    }
    .admin-chip {
      display: flex; align-items: center; gap: 0.65rem;
      padding: 0.65rem 0.8rem;
      background: rgba(255,255,255,0.05);
      border-radius: 10px;
      margin-bottom: 0.75rem;
    }
    .admin-avatar {
      width: 32px; height: 32px; border-radius: 50%;
      background: linear-gradient(135deg, var(--red-soft), var(--red));
      display: flex; align-items: center; justify-content: center;
      font-size: 0.75rem; font-weight: 800; color: var(--red-dark);
      flex-shrink: 0;
    }
    .admin-info strong { display: block; font-size: 0.76rem; font-weight: 700; color: #fff; line-height: 1.2; }
    .admin-info small  { font-size: 0.62rem; color: rgba(255,255,255,0.35); text-transform: capitalize; }
    .btn-logout {
      width: 100%; padding: 0.55rem;
      background: rgba(224,53,53,0.12);
      border: 1px solid rgba(224,53,53,0.2);
      border-radius: 8px;
      color: #FF8A8A; font-size: 0.76rem; font-weight: 700;
      font-family: inherit; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 0.4rem;
      transition: background 0.2s, border-color 0.2s;
    }
    .btn-logout:hover { background: rgba(224,53,53,0.22); border-color: rgba(224,53,53,0.4); }

    /* ── MAIN ─────────────────────────────────────── */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Top bar */
    .topbar {
      background: var(--white);
      border-bottom: 1px solid var(--border);
      padding: 0 2rem;
      height: 60px;
      display: flex; align-items: center;
      gap: 1rem;
      position: sticky; top: 0; z-index: 50;
    }
    .topbar-hamburger {
      display: none; background: none; border: none;
      cursor: pointer; padding: 0.3rem;
      flex-direction: column; gap: 4px;
    }
    .topbar-hamburger span {
      display: block; width: 20px; height: 2px;
      background: var(--ink); border-radius: 2px;
    }
    .page-title {
      font-family: 'Fraunces', serif;
      font-size: 1.1rem; font-weight: 700; color: var(--ink);
    }
    .topbar-right {
      margin-left: auto;
      display: flex; align-items: center; gap: 0.75rem;
    }
    .topbar-greeting {
      font-size: 0.8rem; color: var(--ink-light); font-weight: 500;
    }
    .topbar-greeting strong { color: var(--ink); }
    .topbar-date {
      font-size: 0.72rem; color: var(--ink-light);
      padding: 0.3rem 0.75rem;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 100px;
    }
    .notif-btn {
      width: 34px; height: 34px; border-radius: 9px;
      background: var(--surface); border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.9rem; cursor: pointer; position: relative;
      transition: background 0.2s;
    }
    .notif-btn:hover { background: var(--red-soft); }
    .notif-dot {
      position: absolute; top: 6px; right: 6px;
      width: 7px; height: 7px; border-radius: 50%;
      background: var(--red);
      border: 1.5px solid var(--white);
    }

    /* Content area */
    .content { padding: 2rem; flex: 1; }

    /* ── STAT CARDS ───────────────────────────────── */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.2rem;
      margin-bottom: 2rem;
    }
    .stat-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 1.4rem 1.6rem;
      position: relative; overflow: hidden;
      transition: box-shadow 0.25s, transform 0.2s;
    }
    .stat-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.07); transform: translateY(-2px); }
    .stat-card::before {
      content: ''; position: absolute;
      top: 0; left: 0; right: 0; height: 3px;
      border-radius: 16px 16px 0 0;
    }
    .stat-card.red::before   { background: var(--red); }
    .stat-card.teal::before  { background: var(--teal); }
    .stat-card.sun::before   { background: var(--sun); }
    .stat-card.green::before { background: #27AE60; }

    .stat-top {
      display: flex; align-items: center;
      justify-content: space-between; margin-bottom: 1rem;
    }
    .stat-label {
      font-size: 0.72rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.09em;
      color: var(--ink-light);
    }
    .stat-icon {
      width: 36px; height: 36px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem;
    }
    .stat-card.red  .stat-icon { background: var(--red-soft);  }
    .stat-card.teal .stat-icon { background: var(--teal-soft); }
    .stat-card.sun  .stat-icon { background: var(--sun-soft);  }
    .stat-card.green .stat-icon { background: #EAFAF1; }

    .stat-num {
      font-family: 'Fraunces', serif;
      font-size: 2.2rem; font-weight: 900;
      color: var(--ink); line-height: 1;
      margin-bottom: 0.3rem;
    }
    .stat-sub {
      font-size: 0.72rem; color: var(--ink-light); font-weight: 500;
    }
    .stat-sub .up   { color: #27AE60; font-weight: 700; }
    .stat-sub .warn { color: var(--red); font-weight: 700; }

    /* ── MAIN GRID ────────────────────────────────── */
    .main-grid {
      display: grid;
      grid-template-columns: 1fr 380px;
      gap: 1.5rem;
    }

    /* Shared panel style */
    .panel {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
    }
    .panel-head {
      padding: 1.1rem 1.5rem;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      gap: 1rem;
    }
    .panel-head h3 {
      font-family: 'Fraunces', serif;
      font-size: 1rem; font-weight: 700; color: var(--ink);
    }
    .panel-head a {
      font-size: 0.74rem; font-weight: 700; color: var(--red);
      transition: color 0.2s;
    }
    .panel-head a:hover { color: var(--red-dark); }

    /* ── POSTS TABLE ──────────────────────────────── */
    .posts-table { width: 100%; border-collapse: collapse; }
    .posts-table thead th {
      padding: 0.7rem 1.2rem;
      font-size: 0.66rem; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.1em;
      color: var(--ink-light);
      text-align: left;
      background: var(--surface);
      border-bottom: 1px solid var(--border);
    }
    .posts-table tbody tr {
      border-bottom: 1px solid var(--border);
      transition: background 0.15s;
    }
    .posts-table tbody tr:last-child { border-bottom: none; }
    .posts-table tbody tr:hover { background: var(--surface); }
    .posts-table td {
      padding: 0.8rem 1.2rem;
      font-size: 0.82rem; color: var(--ink-mid);
      vertical-align: middle;
    }

    .post-title-cell { max-width: 260px; }
    .post-title-cell strong {
      display: block; font-weight: 700; color: var(--ink);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .post-title-cell span {
      font-size: 0.7rem; color: var(--ink-light); margin-top: 0.1rem; display: block;
    }

    .type-badge {
      display: inline-block;
      font-size: 0.62rem; font-weight: 700;
      padding: 0.2rem 0.55rem; border-radius: 100px;
      text-transform: capitalize;
    }
    .type-badge.post       { background: var(--red-soft);  color: var(--red-dark); }
    .type-badge.program    { background: var(--teal-soft); color: var(--teal-dark); }
    .type-badge.gallery    { background: var(--sun-soft);  color: #8A5A00; }
    .type-badge.testimonial{ background: #EEF2FF;          color: #3730A3; }

    .status-dot {
      display: inline-flex; align-items: center; gap: 0.35rem;
      font-size: 0.7rem; font-weight: 600;
    }
    .status-dot::before {
      content: ''; width: 6px; height: 6px; border-radius: 50%;
    }
    .status-dot.published::before { background: #27AE60; }
    .status-dot.published         { color: #27AE60; }
    .status-dot.draft::before     { background: var(--ink-light); }
    .status-dot.draft             { color: var(--ink-light); }
    .status-dot.scheduled::before { background: var(--sun); }
    .status-dot.scheduled         { color: #8A5A00; }
    .status-dot.archived::before  { background: #CBD5E0; }
    .status-dot.archived          { color: #718096; }

    .row-actions {
      display: flex; gap: 0.35rem; opacity: 0;
      transition: opacity 0.15s;
    }
    .posts-table tbody tr:hover .row-actions { opacity: 1; }
    .act-btn {
      width: 26px; height: 26px; border-radius: 6px;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.8rem; border: none; cursor: pointer;
      transition: background 0.15s;
    }
    .act-btn.edit   { background: var(--teal-soft); color: var(--teal-dark); }
    .act-btn.delete { background: var(--red-soft);  color: var(--red-dark); }
    .act-btn:hover  { filter: brightness(0.92); }

    /* Empty state */
    .empty-state {
      padding: 3rem; text-align: center;
      color: var(--ink-light); font-size: 0.85rem;
    }
    .empty-state span { display: block; font-size: 2rem; margin-bottom: 0.5rem; }

    /* ── COMMENTS PANEL ───────────────────────────── */
    .comment-list { list-style: none; }
    .comment-item {
      padding: 1rem 1.4rem;
      border-bottom: 1px solid var(--border);
      transition: background 0.15s;
    }
    .comment-item:last-child { border-bottom: none; }
    .comment-item:hover { background: var(--surface); }

    .comment-top {
      display: flex; align-items: center;
      justify-content: space-between; margin-bottom: 0.35rem;
      gap: 0.5rem;
    }
    .comment-author {
      display: flex; align-items: center; gap: 0.5rem;
    }
    .comment-avatar {
      width: 28px; height: 28px; border-radius: 50%;
      background: var(--red-soft);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.68rem; font-weight: 800; color: var(--red-dark);
      flex-shrink: 0;
    }
    .comment-name { font-size: 0.8rem; font-weight: 700; color: var(--ink); }
    .comment-time { font-size: 0.68rem; color: var(--ink-light); white-space: nowrap; }

    .comment-post {
      font-size: 0.7rem; color: var(--ink-light);
      margin-bottom: 0.3rem;
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .comment-post strong { color: var(--ink-mid); }

    .comment-body {
      font-size: 0.78rem; color: var(--ink-mid);
      line-height: 1.5;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      margin-bottom: 0.55rem;
    }

    .comment-actions { display: flex; gap: 0.4rem; }
    .c-act {
      font-size: 0.65rem; font-weight: 700;
      padding: 0.22rem 0.6rem; border-radius: 6px;
      border: none; cursor: pointer; font-family: inherit;
      transition: filter 0.15s;
    }
    .c-act:hover { filter: brightness(0.9); }
    .c-act.approve { background: var(--teal-soft); color: var(--teal-dark); }
    .c-act.spam    { background: var(--sun-soft);  color: #8A5A00; }
    .c-act.trash   { background: var(--red-soft);  color: var(--red-dark); }

    .comment-status-badge {
      font-size: 0.6rem; font-weight: 800;
      padding: 0.18rem 0.5rem; border-radius: 100px;
      text-transform: uppercase; letter-spacing: 0.06em;
      white-space: nowrap;
    }
    .comment-status-badge.pending  { background: var(--sun-soft);  color: #8A5A00; }
    .comment-status-badge.approved { background: var(--teal-soft); color: var(--teal-dark); }
    .comment-status-badge.spam     { background: var(--red-soft);  color: var(--red-dark); }

    /* ── QUICK ACTIONS ────────────────────────────── */
    .quick-actions {
      display: grid; grid-template-columns: repeat(4,1fr);
      gap: 0.9rem; margin-bottom: 2rem;
    }
    .qa-btn {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 1rem;
      display: flex; flex-direction: column;
      align-items: center; gap: 0.5rem;
      font-size: 0.76rem; font-weight: 700;
      color: var(--ink-mid);
      cursor: pointer; text-align: center;
      transition: box-shadow 0.2s, transform 0.15s, border-color 0.2s;
    }
    .qa-btn:hover {
      box-shadow: 0 4px 16px rgba(0,0,0,0.07);
      transform: translateY(-2px);
      border-color: var(--red);
      color: var(--red);
    }
    .qa-btn .qa-icon {
      width: 38px; height: 38px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
      background: var(--surface);
      transition: background 0.2s;
    }
    .qa-btn:hover .qa-icon { background: var(--red-soft); }

    /* ── ANIMATIONS ───────────────────────────────── */
    .stat-card { animation: fadeUp 0.5s ease both; }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.10s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.20s; }
    .panel { animation: fadeUp 0.5s 0.25s ease both; }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── RESPONSIVE ───────────────────────────────── */
    @media (max-width: 1200px) {
      .stats-grid { grid-template-columns: repeat(2,1fr); }
      .main-grid  { grid-template-columns: 1fr; }
      .quick-actions { grid-template-columns: repeat(4,1fr); }
    }
    @media (max-width: 900px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
      .main { margin-left: 0; }
      .topbar-hamburger { display: flex; }
      .topbar-greeting { display: none; }
    }
    @media (max-width: 600px) {
      .stats-grid { grid-template-columns: 1fr 1fr; }
      .quick-actions { grid-template-columns: repeat(2,1fr); }
      .content { padding: 1.25rem; }
      .topbar { padding: 0 1.25rem; }
    }
    @media (max-width: 420px) {
      .stats-grid { grid-template-columns: 1fr; }
      .stat-num { font-size: 1.8rem; }
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