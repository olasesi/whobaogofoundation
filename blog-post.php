<?php
require_once './includes/config.php';
require_once './includes/db.php';

// Get the slug from the URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (!$slug) {
    header('Location: /');
    exit;
}

// Fetch the post from database
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

// If post not found, redirect to blog
if (!$post) {
    header('HTTP/1.0 404 Not Found');
    include 'error.php';
    exit;
}

// Increment view count
$updateStmt = $pdo->prepare("UPDATE posts SET views = views + 1 WHERE id = :id");
$updateStmt->execute([':id' => $post['id']]);

// Get related posts (same category, excluding current)
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
        ':current_id' => $post['id']
    ]);
    $relatedPosts = $relatedStmt->fetchAll();
}

// Get recent posts for sidebar
$recentStmt = $pdo->query("
    SELECT id, title, slug, published_at
    FROM posts
    WHERE post_type = 'post' AND status = 'published'
    ORDER BY published_at DESC
    LIMIT 5
");
$recentPosts = $recentStmt->fetchAll();

// Get comments for this post
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
        $author_name = isset($_POST['author_name']) ? trim($_POST['author_name']) : '';
        $author_email = isset($_POST['author_email']) ? trim($_POST['author_email']) : '';
        $content = isset($_POST['comment_content']) ? trim($_POST['comment_content']) : '';

        // Validation
        if (!$author_name) {
            $commentError = 'Please enter your name.';
        } elseif (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
            $commentError = 'Please enter a valid email address.';
        } elseif (strlen($content) < 10) {
            $commentError = 'Comment must be at least 10 characters long.';
        } else {
            // Insert comment
            $insertStmt = $pdo->prepare("
                INSERT INTO comments 
                (post_id, author_name, author_email, content, author_ip, status)
                VALUES (:post_id, :author_name, :author_email, :content, :author_ip, 'pending')
            ");

            try {
                $insertStmt->execute([
                    ':post_id' => $post['id'],
                    ':author_name' => $author_name,
                    ':author_email' => $author_email,
                    ':content' => $content,
                    ':author_ip' => $_SERVER['REMOTE_ADDR'] ?? null,
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
    /* ── PAGE HERO ─────────────────────────────────── */
    .page-hero {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                    url('/assets/images/about-hero-bg.jpg') center/cover;
        min-height: 280px;
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
        border-radius: 8px;
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

    /* ── POST DETAIL LAYOUT ────────────────────────── */
    .post-detail-container {
        padding: 4rem 0;
    }

    .post-detail-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 3rem;
    }

    /* ── POST HEADER ───────────────────────────────── */
    .post-header {
        margin-bottom: 2.5rem;
    }

    .post-category {
        display: inline-block;
        background: #FFE6E6;
        color: #E03535;
        padding: 0.5rem 1rem;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }

    .post-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 900;
        color: #1a1a1a;
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    .post-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1.5px solid #e0e0e0;
        color: #666;
        font-size: 0.9rem;
    }

    .post-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .post-meta-item strong {
        color: #1a1a1a;
        font-weight: 600;
    }

    .post-meta-item .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #E03535;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
    }

    /* ── POST FEATURED IMAGE ───────────────────────── */
    .post-featured-image {
        width: 100%;
        max-height: 500px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 2.5rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .post-featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ── POST IMAGES (5 slots) ─────────────────────── */
    .post-images {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }

    .post-image-item {
        border-radius: 8px;
        overflow: hidden;
        background: #f5f5f5;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .post-image-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .post-image-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        display: block;
    }

    /* ── POST CONTENT ──────────────────────────────── */
    .post-body {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
    }

    .post-body h1,
    .post-body h2,
    .post-body h3,
    .post-body h4,
    .post-body h5,
    .post-body h6 {
        font-family: 'Fraunces', serif;
        font-weight: 900;
        color: #1a1a1a;
        margin: 1.5rem 0 1rem;
        line-height: 1.3;
    }

    .post-body h1 { font-size: 2rem; }
    .post-body h2 { font-size: 1.6rem; }
    .post-body h3 { font-size: 1.3rem; }

    .post-body p {
        margin-bottom: 1.2rem;
    }

    .post-body strong {
        color: #1a1a1a;
        font-weight: 700;
    }

    .post-body em {
        font-style: italic;
    }

    .post-body a {
        color: #E03535;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 2px solid #FFE6E6;
        transition: border-color 0.2s;
    }

    .post-body a:hover {
        border-bottom-color: #E03535;
    }

    .post-body figure {
        margin: 2rem 0;
        max-width: 100%;
    }

    .post-body img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        display: block;
        margin: 1.5rem 0;
    }

    .post-body ul,
    .post-body ol {
        margin: 1.2rem 0 1.2rem 2rem;
    }

    .post-body li {
        margin-bottom: 0.6rem;
    }

    .post-body code {
        background: #f5f5f5;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: #E03535;
        font-size: 0.9rem;
    }

    .post-body pre {
        background: #f5f5f5;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1.5rem 0;
        border-left: 4px solid #E03535;
    }

    .post-body pre code {
        background: none;
        padding: 0;
        color: inherit;
    }

    .post-body blockquote {
        border-left: 4px solid #E03535;
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        color: #888;
        font-style: italic;
    }

    /* ── POST FOOTER ───────────────────────────────– */
    .post-footer {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1.5px solid #e0e0e0;
    }

    .post-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-bottom: 2rem;
    }

    .post-tag {
        display: inline-block;
        background: #f5f5f5;
        color: #666;
        padding: 0.5rem 1rem;
        border-radius: 100px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, color 0.2s;
    }

    .post-tag:hover {
        background: #E03535;
        color: #fff;
    }

    /* ── COMMENTS SECTION ──────────────────────────– */
    .comments-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1.5px solid #e0e0e0;
    }

    .comments-title {
        font-family: 'Fraunces', serif;
        font-size: 1.5rem;
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 2rem;
    }

    .comments-list {
        list-style: none;
        margin-bottom: 2rem;
    }

    .comment-item {
        background: #f9f9f9;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .comment-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #E03535;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .comment-info {
        flex: 1;
    }

    .comment-author {
        font-weight: 700;
        color: #1a1a1a;
    }

    .comment-date {
        font-size: 0.8rem;
        color: #888;
    }

    .comment-body {
        color: #555;
        line-height: 1.6;
    }

    /* ── RELATED POSTS ────────────────────────────── */
    .related-posts {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1.5px solid #e0e0e0;
    }

    .related-title {
        font-family: 'Fraunces', serif;
        font-size: 1.5rem;
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .related-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s, transform 0.2s;
    }

    .related-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        transform: translateY(-4px);
    }

    .related-image {
        width: 100%;
        height: 180px;
        overflow: hidden;
        background: #f5f5f5;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .related-card:hover .related-image img {
        transform: scale(1.05);
    }

    .related-content {
        padding: 1.2rem;
    }

    .related-card h4 {
        font-family: 'Fraunces', serif;
        font-size: 0.95rem;
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 0.6rem;
        line-height: 1.3;
    }

    .related-card a {
        display: block;
        text-decoration: none;
        color: inherit;
        transition: color 0.2s;
    }

    .related-card:hover h4 {
        color: #E03535;
    }

    .related-date {
        font-size: 0.75rem;
        color: #888;
    }

    /* ── SIDEBAR ───────────────────────────────────– */
    .post-sidebar {
        display: flex;
        flex-direction: column;
    }

    .sidebar-widget {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .widget-title {
        font-family: 'Fraunces', serif;
        font-size: 1rem;
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid #E03535;
    }

    .recent-posts-list {
        list-style: none;
    }

    .recent-post-item {
        padding: 0.8rem 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .recent-post-item:last-child {
        border-bottom: none;
    }

    .recent-post-item a {
        display: block;
        color: #1a1a1a;
        font-weight: 600;
        font-size: 0.85rem;
        line-height: 1.4;
        text-decoration: none;
        transition: color 0.2s;
    }

    .recent-post-item a:hover {
        color: #E03535;
    }

    .recent-post-date {
        font-size: 0.7rem;
        color: #888;
        margin-top: 0.3rem;
    }

    .share-buttons {
        display: flex;
        gap: 0.8rem;
        margin-top: 1rem;
    }

    .share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1.5px solid #e0e0e0;
        border-radius: 4px;
        background: #fff;
        color: #666;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
        text-decoration: none;
    }

    .share-btn:hover {
        background: #E03535;
        border-color: #E03535;
        color: #fff;
    }

    /* ── RESPONSIVE ────────────────────────────────– */
    @media (max-width: 1024px) {
        .post-detail-layout {
            grid-template-columns: 1fr;
        }

        .post-meta {
            gap: 1rem;
        }

        .related-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .post-detail-container {
            padding: 2rem 0;
        }

        .post-title {
            font-size: 1.8rem;
        }

        .post-body {
            font-size: 0.95rem;
        }

        .post-images {
            grid-template-columns: 1fr;
        }
    }
</style>

<main>

<!-- ── PAGE HERO ───────────────────────────────── -->
<section class="page-hero">
    <div class="page-hero-content">
        <h1><?= htmlspecialchars($post['title']) ?></h1>
    </div>
    <div class="breadcrumb">
        <a href="/">HOME</a>
        <span>/</span>
        <span><?= htmlspecialchars(strtoupper(substr($post['title'], 0, 30))) ?>...</span>
    </div>
</section>

<!-- ── POST DETAIL ─────────────────────────────── -->
<section class="post-detail-container">
    <div class="wrap">
        <div class="post-detail-layout">

            <!-- Main Content -->
            <article class="post-main">

                <!-- Post Header -->
                <div class="post-header">
                    <?php if ($post['category_name']): ?>
                        <span class="post-category"><?= htmlspecialchars($post['category_name']) ?></span>
                    <?php endif; ?>

                    <h1 class="post-title">
                        <?= htmlspecialchars($post['title']) ?>
                    </h1>

                    <div class="post-meta">
                        <div class="post-meta-item">
                            <div class="avatar">
                                <?= strtoupper(substr($post['author_name'] ?? 'A', 0, 1)) ?>
                            </div>
                            <div>
                                <strong><?= htmlspecialchars($post['author_name'] ?? 'Admin') ?></strong><br>
                                <span><?= $publishedDate->format('M d, Y') ?></span>
                            </div>
                        </div>
                        <div class="post-meta-item">
                            👁 <?= number_format($post['views']) ?> views
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <?php if ($post['featured_image']): ?>
                    <div class="post-featured-image">
                        <img src="<?= htmlspecialchars($post['featured_image']) ?>" 
                             alt="<?= htmlspecialchars($post['title']) ?>"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%221200%22 height=%22600%22%3E%3Crect fill=%22%23E0F7F2%22 width=%221200%22 height=%22600%22/%3E%3C/svg%3E'">
                    </div>
                <?php endif; ?>

                <!-- Post Body (HTML content) -->
                <div class="post-body">
                    <?= $post['content']; ?>
                </div>

                <!-- Post Footer -->
                <div class="post-footer">
                    <!-- Share Buttons -->
                    <div class="share-buttons">
                        <a href="https://facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                           target="_blank" class="share-btn" title="Share on Facebook">f</a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($post['title']) ?>" 
                           target="_blank" class="share-btn" title="Share on Twitter">𝕏</a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                           target="_blank" class="share-btn" title="Share on LinkedIn">in</a>
                    </div>
                </div>

                <!-- Comments Section -->
                <?php if ($post['allow_comments']): ?>
                <div class="comments-section">
                    <h2 class="comments-title">Comments (<?= count($comments) ?>)</h2>

                    <?php if ($commentMessage): ?>
                        <div style="background: #E6F7F2; border: 1.5px solid #0D9B7E; border-left: 4px solid #0D9B7E; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: #0D9B7E;">
                            ✓ <?= htmlspecialchars($commentMessage) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($commentError): ?>
                        <div style="background: #FFE6E6; border: 1.5px solid #E03535; border-left: 4px solid #E03535; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: #E03535;">
                            ✕ <?= htmlspecialchars($commentError) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($comments)): ?>
                        <ul class="comments-list">
                            <?php foreach ($comments as $comment): 
                                $commentDate = new DateTime($comment['created_at']);
                            ?>
                            <li class="comment-item">
                                <div class="comment-header">
                                    <div class="comment-avatar">
                                        <?= strtoupper(substr($comment['author_name'], 0, 1)) ?>
                                    </div>
                                    <div class="comment-info">
                                        <div class="comment-author">
                                            <?= htmlspecialchars($comment['author_name']) ?>
                                        </div>
                                        <div class="comment-date">
                                            <?= $commentDate->format('M d, Y \a\t g:i A') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <?= htmlspecialchars($comment['content']) ?>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p style="color: #888; padding: 1rem 0;">No comments yet. Be the first to comment!</p>
                    <?php endif; ?>

                    <!-- Comment Form -->
                    <form method="POST" style="margin-top: 2rem; padding-top: 2rem; border-top: 1.5px solid #e0e0e0;">
                        <h3 style="font-family: 'Fraunces', serif; font-size: 1.2rem; font-weight: 900; color: #1a1a1a; margin-bottom: 1.5rem;">Leave a Comment</h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <input type="text" name="author_name" placeholder="Your Name" required
                                   style="padding: 0.8rem; border: 1.5px solid #e0e0e0; border-radius: 4px; font-family: inherit; font-size: 0.95rem;">
                            <input type="email" name="author_email" placeholder="Your Email" required
                                   style="padding: 0.8rem; border: 1.5px solid #e0e0e0; border-radius: 4px; font-family: inherit; font-size: 0.95rem;">
                        </div>

                        <textarea name="comment_content" placeholder="Your comment..." required rows="4"
                                  style="width: 100%; padding: 0.8rem; border: 1.5px solid #e0e0e0; border-radius: 4px; font-family: inherit; margin-bottom: 1rem; font-size: 0.95rem; resize: vertical;"></textarea>

                        <button type="submit" style="background: #E03535; color: #fff; padding: 0.9rem 2rem; border: none; border-radius: 4px; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: background 0.2s;">
                            Post Comment
                        </button>

                        <p style="font-size: 0.8rem; color: #888; margin-top: 0.8rem;">
                            💬 Your comment will appear after moderation by our team.
                        </p>

                        <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                    </form>
                </div>
                <?php endif; ?>

                <!-- Related Posts -->
                <?php if (!empty($relatedPosts)): ?>
                <div class="related-posts">
                    <h2 class="related-title">Related Articles</h2>
                    <div class="related-grid">
                        <?php foreach ($relatedPosts as $related): 
                            $relatedDate = new DateTime($related['published_at']);
                        ?>
                        <div class="related-card">
                            <div class="related-image">
                                <img src="<?= htmlspecialchars($related['featured_image'] ?? '/assets/images/placeholder.jpg') ?>" 
                                     alt="<?= htmlspecialchars($related['title']) ?>"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22250%22 height=%22180%22%3E%3Crect fill=%22%23E0F7F2%22 width=%22250%22 height=%22180%22/%3E%3C/svg%3E'">
                            </div>
                            <div class="related-content">
                                <a href="/<?= htmlspecialchars($related['slug']) ?>">
                                    <h4><?= htmlspecialchars($related['title']) ?></h4>
                                </a>
                                <div class="related-date"><?= $relatedDate->format('M d, Y') ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </article>

            <!-- Sidebar -->
            <aside class="post-sidebar">

                <!-- Recent Posts Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Recent Posts</h3>
                    <ul class="recent-posts-list">
                        <?php foreach ($recentPosts as $recent): 
                            $recentDate = new DateTime($recent['published_at']);
                        ?>
                        <li class="recent-post-item">
                            <a href="/<?= htmlspecialchars($recent['slug']) ?>">
                                <?= htmlspecialchars($recent['title']) ?>
                            </a>
                            <div class="recent-post-date"><?= $recentDate->format('M d, Y') ?></div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- About Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">About</h3>
                    <p style="font-size: 0.9rem; line-height: 1.6; color: #555; margin: 0;">
                        Whoba Ogo Foundation is an African social impact organization committed to touching lives 
                        of rural community dwellers through medical and educational support.
                    </p>
                </div>

                <!-- Share Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Share This Post</h3>
                    <div class="share-buttons" style="margin: 0;">
                        <a href="https://facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                           target="_blank" class="share-btn" title="Share on Facebook" style="flex: 1; width: auto; text-decoration: none;">Facebook</a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                           target="_blank" class="share-btn" title="Share on Twitter" style="flex: 1; width: auto; text-decoration: none;">Twitter</a>
                    </div>
                </div>

            </aside>

        </div>
    </div>
</section>

</main>

<?php include './includes/footer.php'; ?>