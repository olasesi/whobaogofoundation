<?php
require_once './includes/db.php';
require_once './includes/markdown-parser.php';  // Include the markdown parser
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

  /* ── BLOG LAYOUT ───────────────────────────────── */
  .blog-container {
    padding: 4rem 0;
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
    grid-template-columns: 340px 1fr;
    gap: 2rem;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    transition: box-shadow 0.3s, transform 0.2s;
  }
  .blog-post-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transform: translateY(-2px);
  }
  
  .post-thumbnail {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
  }
  .post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
  }
  .blog-post-card:hover .post-thumbnail img {
    transform: scale(1.05);
  }
  .post-date-badge {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: var(--white);
    border-radius: var(--r-sm);
    padding: 0.6rem 0.8rem;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  .post-date-day {
    display: block;
    font-family: 'Fraunces', serif;
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--teal);
    line-height: 1;
  }
  .post-date-month {
    display: block;
    font-size: 0.65rem;
    font-weight: 800;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.2rem;
  }

  .post-content {
    padding: 2rem 2rem 2rem 0;
  }
  .post-meta {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 0.8rem;
    font-size: 0.75rem;
    color: var(--ink-light);
  }
  .post-meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
  }
  .post-meta-item strong {
    color: var(--red);
    font-weight: 700;
  }

  .post-content h2 {
    font-family: 'Fraunces', serif;
    font-size: 1.4rem;
    font-weight: 900;
    color: var(--ink);
    line-height: 1.3;
    margin-bottom: 0.8rem;
    transition: color 0.2s;
  }
  .blog-post-card:hover .post-content h2 {
    color: var(--teal);
  }
  
  .post-excerpt {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
  }
  
  .post-read-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--red);
    color: #fff;
    font-weight: 700;
    font-size: 0.8rem;
    padding: 0.6rem 1.3rem;
    border-radius: 100px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: background 0.2s;
  }
  .post-read-more:hover {
    background: var(--red-dark);
  }

  /* ── MARKDOWN CONTENT STYLING ────────────────────── */
  .post-excerpt,
  .post-content p {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--ink-mid);
  }

  .post-excerpt figure,
  .post-content figure {
    margin: 1.5rem 0;
    max-width: 100%;
  }

  .post-excerpt img,
  .post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    display: block;
  }

  .post-excerpt code,
  .post-content code {
    background: var(--surface);
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    color: var(--red);
  }

  .post-excerpt pre,
  .post-content pre {
    background: var(--surface);
    padding: 1rem;
    border-radius: var(--r-sm);
    overflow-x: auto;
    margin: 1rem 0;
  }

  .post-excerpt strong,
  .post-content strong {
    font-weight: 700;
    color: var(--ink);
  }

  .post-excerpt em,
  .post-content em {
    font-style: italic;
  }

  /* ── SIDEBAR ───────────────────────────────────── */
  .sidebar-widget {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-md);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .widget-title {
    font-family: 'Fraunces', serif;
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--ink);
    margin-bottom: 1.2rem;
    padding-bottom: 0.8rem;
    border-bottom: 2px solid var(--red);
  }

  /* Search Widget */
  .search-form {
    display: flex;
    gap: 0.5rem;
  }
  .search-input {
    flex: 1;
    padding: 0.7rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: var(--r-sm);
    font-size: 0.85rem;
    font-family: inherit;
    color: var(--ink);
    transition: border-color 0.2s;
  }
  .search-input:focus {
    outline: none;
    border-color: var(--red);
  }
  .search-btn {
    padding: 0.7rem 1.2rem;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: var(--r-sm);
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: background 0.2s;
  }
  .search-btn:hover {
    background: var(--red-dark);
  }

  /* Recent Posts Widget */
  .recent-posts-list {
    list-style: none;
  }
  .recent-post-item {
    padding: 0.8rem 0;
    border-bottom: 1px solid var(--border);
  }
  .recent-post-item:last-child {
    border-bottom: none;
  }
  .recent-post-item a {
    display: block;
    color: var(--ink);
    font-weight: 600;
    font-size: 0.88rem;
    line-height: 1.4;
    transition: color 0.2s;
  }
  .recent-post-item a:hover {
    color: var(--red);
  }
  .recent-post-date {
    font-size: 0.72rem;
    color: var(--ink-light);
    margin-top: 0.3rem;
  }

  /* Archives Widget */
  .archives-list {
    list-style: none;
  }
  .archives-list li {
    padding: 0.6rem 0;
    border-bottom: 1px solid var(--border);
  }
  .archives-list li:last-child {
    border-bottom: none;
  }
  .archives-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: var(--ink-mid);
    font-size: 0.85rem;
    transition: color 0.2s;
  }
  .archives-list a:hover {
    color: var(--red);
  }
  .archive-count {
    background: var(--surface);
    padding: 0.2rem 0.6rem;
    border-radius: 100px;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--ink-light);
  }

  /* Meta Widget */
  .meta-list {
    list-style: none;
  }
  .meta-list li {
    padding: 0.6rem 0;
    border-bottom: 1px solid var(--border);
  }
  .meta-list li:last-child {
    border-bottom: none;
  }
  .meta-list a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--ink-mid);
    font-size: 0.85rem;
    transition: color 0.2s;
  }
  .meta-list a:hover {
    color: var(--red);
  }

  /* ── PAGINATION ────────────────────────────────── */
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-top: 3rem;
  }
  .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--r-sm);
    color: var(--ink-mid);
    font-weight: 600;
    font-size: 0.9rem;
    transition: background 0.2s, border-color 0.2s, color 0.2s;
  }
  .page-link:hover {
    background: var(--red-soft);
    border-color: var(--red);
    color: var(--red);
  }
  .page-link.active {
    background: var(--teal);
    border-color: var(--teal);
    color: #fff;
  }
  .page-link.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
  }

  /* ── EMPTY STATE ───────────────────────────────── */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
  }
  .empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
  }
  .empty-state h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--ink);
    margin-bottom: 0.5rem;
  }
  .empty-state p {
    color: var(--ink-light);
    margin-bottom: 1.5rem;
  }

  /* ── RESPONSIVE ────────────────────────────────── */
  @media (max-width: 1024px) {
    .blog-layout {
      grid-template-columns: 1fr;
    }
    .blog-post-card {
      grid-template-columns: 1fr;
    }
    .post-thumbnail {
      aspect-ratio: 16/9;
    }
    .post-content {
      padding: 1.5rem;
    }
  }

  @media (max-width: 768px) {
    .blog-container {
      padding: 2.5rem 0;
    }
  }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
  <div class="page-hero-content">
    <h1>Our Blog</h1>
  </div>
  <div class="breadcrumb">
    <a href="/">HOME</a>
    <span>/</span>
    <span>OUR BLOG</span>
  </div>
</section>

<!-- ── BLOG CONTENT ───────────────────────────────  -->
<section class="blog-container">
  <div class="wrap">
    <div class="blog-layout">
      
      <!-- Main Content -->
      <div class="blog-main">
        <?php if (empty($posts)): ?>
          <div class="empty-state">
            <div class="empty-state-icon">🔍</div>
            <h3>No Posts Found</h3>
            <p><?= $search ? "No results for \"" . htmlspecialchars($search) . "\"" : "No blog posts available yet." ?></p>
            <?php if ($search): ?>
              <a href="/" class="post-read-more">View All Posts</a>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div class="blog-posts-grid">
            <?php foreach ($posts as $post): 
              $date = new DateTime($post['published_at']);
            ?>
            <article class="blog-post-card">
              <div class="post-thumbnail">
                <img src="/assets/images/blog/<?= $post['id'] ?>.jpg" alt="<?= htmlspecialchars($post['title']) ?>"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22680%22 height=%22510%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22680%22 height=%22510%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2260%22 fill=%22%230D9B7E%22%3E📰%3C/text%3E%3C/svg%3E'">
                <div class="post-date-badge">
                  <span class="post-date-day"><?= $date->format('d') ?></span>
                  <span class="post-date-month"><?= strtoupper($date->format('M')) ?></span>
                </div>
              </div>
              
              <div class="post-content">
                <div class="post-meta">
                  <span class="post-meta-item">
                    👤 By <strong><?= htmlspecialchars($post['author_name'] ?? 'admin') ?></strong>
                  </span>
                  <?php if ($post['category_name']): ?>
                  <span class="post-meta-item">
                    📁 Cause in <strong><?= htmlspecialchars($post['category_name']) ?></strong>
                  </span>
                  <?php endif; ?>
                </div>
                
                <h2>
                  <a href="/<?= htmlspecialchars($post['slug']) ?>">
                    <?= htmlspecialchars($post['title']) ?>
                  </a>
                </h2>
                
                <div class="post-excerpt">
                  <?php
                    // Use excerpt if available, otherwise extract from content
                    if ($post['excerpt']) {
                        echo htmlspecialchars(substr($post['excerpt'], 0, 150));
                    } else {
                        echo htmlspecialchars(substr(strip_tags($post['content']), 0, 150));
                    }
                  ?>...
                </div>
                
                <a href="<?= htmlspecialchars($post['slug']) ?>" class="post-read-more">
                  View Detail
                </a>
              </div>
            </article>
            <?php endforeach; ?>
          </div>

          <!-- Pagination -->
          <?php if ($totalPages > 1): ?>
          <div class="pagination">
            <a href="?page=<?= max(1, $page - 1) ?><?= $search ? '&s=' . urlencode($search) : '' ?>" 
               class="page-link <?= $page <= 1 ? 'disabled' : '' ?>">
              ‹
            </a>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <a href="?page=<?= $i ?><?= $search ? '&s=' . urlencode($search) : '' ?>" 
                 class="page-link <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
              </a>
            <?php endfor; ?>
            
            <a href="?page=<?= min($totalPages, $page + 1) ?><?= $search ? '&s=' . urlencode($search) : '' ?>" 
               class="page-link <?= $page >= $totalPages ? 'disabled' : '' ?>">
              ›
            </a>
          </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <aside class="blog-sidebar">
        
        <!-- Search Widget -->
        <div class="sidebar-widget">
          <form action="" method="GET" class="search-form">
            <input type="search" name="s" class="search-input" 
                   placeholder="Search ..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="search-btn">🔍</button>
          </form>
        </div>

        <!-- Our Memories Widget -->
        <div class="sidebar-widget">
          <h3 class="widget-title">OUR MEMORIES</h3>
          <div style="padding: 1rem 0; text-align: center; color: var(--ink-light); font-size: 0.85rem;">
            Looking For A Good Place
          </div>
          <h4 style="font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 900; color: var(--ink); margin-bottom: 1.5rem;">EVENTS</h4>
          <ul class="recent-posts-list">
            <?php foreach (array_slice($recentPosts, 0, 3) as $recent): 
              $recentDate = new DateTime($recent['published_at']);
            ?>
            <li class="recent-post-item">
              <a href="/<?= htmlspecialchars($recent['slug']) ?>">
                • <?= htmlspecialchars($recent['title']) ?>
              </a>
              <div class="recent-post-date"><?= $recentDate->format('d/m/Y') ?></div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- More Blog Post Widget -->
        <div class="sidebar-widget">
          <h3 class="widget-title">READ MORE</h3>
          <h4 style="font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 900; color: var(--ink); margin-bottom: 1.5rem;">MORE BLOG POST</h4>
          <ul class="recent-posts-list">
            <?php foreach (array_slice($recentPosts, 0, 2) as $recent): ?>
            <li class="recent-post-item">
              <a href="/<?= htmlspecialchars($recent['slug']) ?>" style="color: var(--red); text-transform: uppercase;">
                <?= htmlspecialchars(strtoupper(substr($recent['title'], 0, 40))) ?>...
              </a>
              <div class="recent-post-date">
                <?php 
                  $rd = new DateTime($recent['published_at']);
                  echo $rd->format('M d, Y') . ' By admin';
                ?>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Archives Widget -->
        <div class="sidebar-widget">
          <h3 class="widget-title">Looking For A Good Place</h3>
          <h4 style="font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 900; color: var(--ink); margin-bottom: 1.5rem;">ARCHIVES BLOG</h4>
          <ul class="archives-list">
            <?php foreach ($archives as $archive): ?>
            <li>
              <a href="?month=<?= $archive['month_year'] ?>">
                <span>▸ <?= $archive['month_name'] ?></span>
                <span class="archive-count"><?= $archive['count'] ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Meta Widget -->
        <div class="sidebar-widget">
          <h3 class="widget-title">Looking For A Good Place</h3>
          <h4 style="font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 900; color: var(--ink); margin-bottom: 1.5rem;">META DATA</h4>
          <ul class="meta-list">
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