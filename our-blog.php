<?php
require_once './includes/config.php';
require_once './includes/db.php';
require_once './includes/markdown-parser.php';
include './includes/header.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;
$offset = ($page - 1) * $perPage;

// Search
$search = isset($_GET['s']) ? trim($_GET['s']) : '';

// Build query
$whereClause = "p.post_type = 'post' AND p.status = 'published'";
$params = [];

if ($search) {
    $whereClause .= " AND (p.title LIKE :search OR p.content LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

// Get total count
$countQuery = "SELECT COUNT(*) FROM posts p WHERE $whereClause";
$stmt = $pdo->prepare($countQuery);
$stmt->execute($params);
$totalPosts = $stmt->fetchColumn();
$totalPages = ceil($totalPosts / $perPage);

// Get posts
$query = "SELECT p.*, a.name AS author_name, c.name AS category_name
          FROM posts p
          LEFT JOIN admins a ON a.id = p.author_id
          LEFT JOIN categories c ON c.id = p.category_id
          WHERE $whereClause
          ORDER BY p.published_at DESC
          LIMIT $perPage OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$posts = $stmt->fetchAll();

// Get recent posts for sidebar
$recentPosts = $pdo->query(
    "SELECT id, title, published_at, slug
     FROM posts 
     WHERE post_type = 'post' AND status = 'published'
     ORDER BY published_at DESC 
     LIMIT 5"
)->fetchAll();

// Get archives (months with posts)
$archives = $pdo->query(
    "SELECT DATE_FORMAT(published_at, '%Y-%m') as month_year,
            DATE_FORMAT(published_at, '%M %Y') as month_name,
            COUNT(*) as count
     FROM posts
     WHERE post_type = 'post' AND status = 'published'
     GROUP BY month_year
     ORDER BY month_year DESC
     LIMIT 10"
)->fetchAll();
?>

<style>
  /* ── WRAP UTILITY ──────────────────────────────── */
  .blog-wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
  }

  /* ── BLOG LAYOUT ───────────────────────────────── */
  .blog-container {
    padding: 4rem 0;
    background: #fff;
  }
  .blog-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 3rem;
  }

  /* ── BLOG POSTS ────────────────────────────────── */
  .blog-posts-grid {
    display: grid;
    gap: 2.5rem;
  }
  .blog-post-card {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 0;
    background: #fff;
    border: 1px solid var(--border-gray);
    border-radius: 12px;
    overflow: hidden;
    transition: box-shadow 0.3s, transform 0.2s;
  }
  .blog-post-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transform: translateY(-2px);
  }

  .post-thumbnail {
    position: relative;
    overflow: hidden;
    min-height: 220px;
  }
  .post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
    display: block;
  }
  .blog-post-card:hover .post-thumbnail img {
    transform: scale(1.05);
  }
  .post-date-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #fff;
    border-radius: 8px;
    padding: 0.5rem 0.7rem;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  .post-date-day {
    display: block;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--secondary);
    line-height: 1;
  }
  .post-date-month {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.2rem;
  }

  .post-card-body {
    padding: 1.8rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .post-card-meta {
    display: flex;
    align-items: center;
    gap: 1.2rem;
    margin-bottom: 0.8rem;
    font-size: 0.75rem;
    color: var(--gray);
  }
  .post-card-meta strong {
    color: var(--primary);
    font-weight: 700;
  }

  .post-card-body h2 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.35;
    margin-bottom: 0.8rem;
    transition: color 0.2s;
  }
  .post-card-body h2 a {
    color: inherit;
    text-decoration: none;
  }
  .blog-post-card:hover .post-card-body h2 {
    color: var(--secondary);
  }

  .post-card-excerpt {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--gray);
    margin-bottom: 1.2rem;
  }

  .post-read-more {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--primary);
    color: #fff;
    font-weight: 700;
    font-size: 0.78rem;
    padding: 0.55rem 1.2rem;
    border-radius: 100px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-decoration: none;
    transition: background 0.2s;
    align-self: flex-start;
  }
  .post-read-more:hover {
    background: var(--primary-dark);
  }

  /* ── SIDEBAR ───────────────────────────────────── */
  .blog-sidebar-widget {
    background: #fff;
    border: 1px solid var(--border-gray);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .blog-widget-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1rem;
    padding-bottom: 0.8rem;
    border-bottom: 2px solid var(--primary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  /* Search Widget */
  .blog-search-form {
    display: flex;
    gap: 0.5rem;
  }
  .blog-search-input {
    flex: 1;
    padding: 0.7rem 1rem;
    border: 1.5px solid var(--border-gray);
    border-radius: 6px;
    font-size: 0.85rem;
    font-family: inherit;
    color: var(--dark);
    transition: border-color 0.2s;
    outline: none;
  }
  .blog-search-input:focus {
    border-color: var(--primary);
  }
  .blog-search-btn {
    padding: 0.7rem 1.1rem;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: background 0.2s;
  }
  .blog-search-btn:hover {
    background: var(--primary-dark);
  }

  /* Recent Posts */
  .blog-recent-list {
    list-style: none;
  }
  .blog-recent-item {
    padding: 0.8rem 0;
    border-bottom: 1px solid var(--border-gray);
  }
  .blog-recent-item:last-child {
    border-bottom: none;
  }
  .blog-recent-item a {
    display: block;
    color: var(--dark-gray);
    font-weight: 600;
    font-size: 0.88rem;
    line-height: 1.4;
    text-decoration: none;
    transition: color 0.2s;
  }
  .blog-recent-item a:hover {
    color: var(--primary);
  }
  .blog-recent-date {
    font-size: 0.72rem;
    color: var(--gray);
    margin-top: 0.3rem;
  }

  /* Archives */
  .blog-archives-list {
    list-style: none;
  }
  .blog-archives-list li {
    padding: 0.6rem 0;
    border-bottom: 1px solid var(--border-gray);
  }
  .blog-archives-list li:last-child {
    border-bottom: none;
  }
  .blog-archives-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: var(--dark-gray);
    font-size: 0.85rem;
    text-decoration: none;
    transition: color 0.2s;
  }
  .blog-archives-list a:hover {
    color: var(--primary);
  }
  .blog-archive-count {
    background: var(--light-gray);
    padding: 0.2rem 0.6rem;
    border-radius: 100px;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--gray);
  }

  /* Meta */
  .blog-meta-list {
    list-style: none;
  }
  .blog-meta-list li {
    padding: 0.6rem 0;
    border-bottom: 1px solid var(--border-gray);
  }
  .blog-meta-list li:last-child {
    border-bottom: none;
  }
  .blog-meta-list a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--dark-gray);
    font-size: 0.85rem;
    text-decoration: none;
    transition: color 0.2s;
  }
  .blog-meta-list a:hover {
    color: var(--primary);
  }

  /* ── PAGINATION ────────────────────────────────── */
  .blog-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-top: 3rem;
  }
  .blog-page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    background: #fff;
    border: 1.5px solid var(--border-gray);
    border-radius: 6px;
    color: var(--dark-gray);
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: background 0.2s, border-color 0.2s, color 0.2s;
  }
  .blog-page-link:hover {
    background: var(--primary-light);
    border-color: var(--primary);
    color: var(--primary);
  }
  .blog-page-link.active {
    background: var(--secondary);
    border-color: var(--secondary);
    color: #fff;
  }
  .blog-page-link.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
  }

  /* ── EMPTY STATE ───────────────────────────────── */
  .blog-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border: 1px solid var(--border-gray);
    border-radius: 12px;
  }
  .blog-empty-icon { font-size: 4rem; margin-bottom: 1rem; }
  .blog-empty h3 { font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; }
  .blog-empty p { color: var(--gray); margin-bottom: 1.5rem; }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 1024px) {
    .blog-layout { grid-template-columns: 1fr; }
    .blog-post-card { grid-template-columns: 1fr; }
    .post-thumbnail { min-height: 240px; aspect-ratio: 16/9; }
    .post-card-body { padding: 1.5rem; }
  }
  @media (max-width: 768px) {
    .blog-container { padding: 2.5rem 0; }
    .blog-wrap { padding: 0 1.25rem; }
  }
</style>

<main>

<!-- PAGE HERO -->
<section style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('./assets/images/about-hero-bg.jpg') center/cover no-repeat; min-height: 320px; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; flex-wrap: wrap; gap: 1.5rem;">
  <div>
    <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #fff; line-height: 1.2;">Our Blog</h1>
  </div>
  <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(224,53,53,0.9); padding: 0.8rem 1.5rem; border-radius: 100px; flex-shrink: 0;">
    <a href="index.php" style="color: #fff; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; text-decoration: none;">HOME</a>
    <span style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">/</span>
    <span style="color: rgba(255,255,255,0.8); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">OUR BLOG</span>
  </div>
</section>

<!-- BLOG CONTENT -->
<section class="blog-container">
  <div class="blog-wrap">
    <div class="blog-layout">

      <!-- Main Content -->
      <div class="blog-main">
        <?php if (empty($posts)): ?>
          <div class="blog-empty">
            <div class="blog-empty-icon">🔍</div>
            <h3>No Posts Found</h3>
            <p><?= $search ? 'No results for "' . htmlspecialchars($search) . '"' : 'No blog posts available yet.' ?></p>
            <?php if ($search): ?>
              <a href="our-blog.php" class="post-read-more">View All Posts</a>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div class="blog-posts-grid">
            <?php foreach ($posts as $post):
              $date = new DateTime($post['published_at']);
            ?>
            <article class="blog-post-card">
              <div class="post-thumbnail">
                <img src="assets/images/<?= htmlspecialchars($post['featured_image'] ?? '') ?>"
                     alt="<?= htmlspecialchars($post['title']) ?>"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22680%22 height=%22510%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22680%22 height=%22510%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%230D9B7E%22%3E%F0%9F%93%B0%3C/text%3E%3C/svg%3E'">
                <div class="post-date-badge">
                  <span class="post-date-day"><?= $date->format('d') ?></span>
                  <span class="post-date-month"><?= strtoupper($date->format('M')) ?></span>
                </div>
              </div>

              <div class="post-card-body">
                <div class="post-card-meta">
                  <span>👤 By <strong><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></strong></span>
                  <?php if ($post['category_name']): ?>
                  <span>📁 <strong><?= htmlspecialchars($post['category_name']) ?></strong></span>
                  <?php endif; ?>
                </div>

                <h2><a href="<?= htmlspecialchars($post['slug']) ?>"><?= htmlspecialchars($post['title']) ?></a></h2>

                <p class="post-card-excerpt">
                  <?php
                    if (!empty($post['excerpt'])) {
                        echo htmlspecialchars(substr($post['excerpt'], 0, 150));
                    } else {
                        echo htmlspecialchars(substr(strip_tags($post['content']), 0, 150));
                    }
                  ?>...
                </p>

                <a href="<?= htmlspecialchars($post['slug']) ?>" class="post-read-more">View Detail →</a>
              </div>
            </article>
            <?php endforeach; ?>
          </div>

          <!-- Pagination -->
          <?php if ($totalPages > 1): ?>
          <div class="blog-pagination">
            <a href="?page=<?= max(1, $page - 1) ?><?= $search ? '&s=' . urlencode($search) : '' ?>"
               class="blog-page-link <?= $page <= 1 ? 'disabled' : '' ?>">‹</a>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <a href="?page=<?= $i ?><?= $search ? '&s=' . urlencode($search) : '' ?>"
                 class="blog-page-link <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <a href="?page=<?= min($totalPages, $page + 1) ?><?= $search ? '&s=' . urlencode($search) : '' ?>"
               class="blog-page-link <?= $page >= $totalPages ? 'disabled' : '' ?>">›</a>
          </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <aside class="blog-sidebar">

        <!-- Search -->
        <div class="blog-sidebar-widget">
          <form action="" method="GET" class="blog-search-form">
            <input type="search" name="s" class="blog-search-input"
                   placeholder="Search posts..."
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="blog-search-btn">🔍</button>
          </form>
        </div>

        <!-- Our Memories -->
        <div class="blog-sidebar-widget">
          <h3 class="blog-widget-title">Our Memories</h3>
          <p style="font-size: 0.8rem; color: var(--gray); margin-bottom: 1rem;">Looking For A Good Place</p>
          <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem;">EVENTS</h4>
          <ul class="blog-recent-list">
            <?php foreach (array_slice($recentPosts, 0, 3) as $recent):
              $recentDate = new DateTime($recent['published_at']);
            ?>
            <li class="blog-recent-item">
              <a href="<?= htmlspecialchars($recent['slug']) ?>">• <?= htmlspecialchars($recent['title']) ?></a>
              <div class="blog-recent-date"><?= $recentDate->format('d/m/Y') ?></div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Read More -->
        <div class="blog-sidebar-widget">
          <h3 class="blog-widget-title">Read More</h3>
          <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem;">MORE BLOG POST</h4>
          <ul class="blog-recent-list">
            <?php foreach (array_slice($recentPosts, 0, 2) as $recent):
              $rd = new DateTime($recent['published_at']);
            ?>
            <li class="blog-recent-item">
              <a href="<?= htmlspecialchars($recent['slug']) ?>" style="color: var(--primary); text-transform: uppercase;">
                <?= htmlspecialchars(strtoupper(substr($recent['title'], 0, 40))) ?>...
              </a>
              <div class="blog-recent-date"><?= $rd->format('M d, Y') ?> By admin</div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Archives -->
        <div class="blog-sidebar-widget">
          <h3 class="blog-widget-title">Archives Blog</h3>
          <ul class="blog-archives-list">
            <?php foreach ($archives as $archive): ?>
            <li>
              <a href="?month=<?= $archive['month_year'] ?>">
                <span>▸ <?= $archive['month_name'] ?></span>
                <span class="blog-archive-count"><?= $archive['count'] ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Meta -->
        <div class="blog-sidebar-widget">
          <h3 class="blog-widget-title">Meta Data</h3>
          <ul class="blog-meta-list">
            <li><a href="#">▸ Entries feed</a></li>
            <li><a href="#">▸ Comments feed</a></li>
            <li><a href="https://wordpress.org" target="_blank">▸ WordPress.org</a></li>
          </ul>
        </div>

      </aside>
    </div>
  </div>
</section>

</main>

<?php include './includes/footer.php'; ?>