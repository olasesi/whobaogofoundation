<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Whoba Ogo Foundation — Touching Lives</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,300;0,700;0,900;1,300;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/stylesheets/main.css"/>
  <style>
    /* Dropdown menu styles */
    .nav-menu li {
      position: relative;
    }
    .nav-menu .has-dropdown {
      position: relative;
    }
    .nav-menu .has-dropdown > a {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }
    .nav-menu .dropdown-arrow {
      font-size: 0.7rem;
      transition: transform 0.2s;
    }
    .nav-menu .has-dropdown:hover .dropdown-arrow {
      transform: rotate(180deg);
    }
    .dropdown-menu {
      position: absolute;
      top: 100%;
      left: 0;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.12);
      min-width: 200px;
      padding: 0.5rem 0;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: opacity 0.2s, transform 0.2s, visibility 0.2s;
      z-index: 1000;
    }
    .has-dropdown:hover .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .dropdown-menu a {
      display: block;
      padding: 0.6rem 1.2rem;
      font-size: 0.82rem;
      color: var(--ink-mid);
      border-radius: 0;
      transition: background 0.15s, color 0.15s;
    }
    .dropdown-menu a:hover {
      background: var(--red-soft);
      color: var(--red);
    }

    /* Mobile dropdown */
    .mobile-nav .has-dropdown {
      display: flex;
      flex-direction: column;
    }
    .mobile-nav .dropdown-toggle {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
    }
    .mobile-nav .mobile-dropdown-arrow {
      font-size: 0.8rem;
      transition: transform 0.2s;
    }
    .mobile-nav .has-dropdown.open .mobile-dropdown-arrow {
      transform: rotate(180deg);
    }
    .mobile-nav .mobile-dropdown-menu {
      display: none;
      padding-left: 1.2rem;
      margin-top: 0.5rem;
      border-left: 2px solid var(--red-soft);
    }
    .mobile-nav .has-dropdown.open .mobile-dropdown-menu {
      display: block;
    }
    .mobile-nav .mobile-dropdown-menu a {
      padding: 0.6rem 0;
      font-size: 0.88rem;
      border-bottom: none;
      color: var(--ink-light);
    }
    .mobile-nav .mobile-dropdown-menu a:hover {
      color: var(--red);
    }
  </style>
</head>
<body>

<!-- ── TOPBAR ──────────────────────────────────── -->
<div class="topbar">
  <div class="topbar-contact">
    <a href="/cdn-cgi/l/email-protection#630a0d050c23140b0c01020c040c050c160d0702170a0c0d4d0c1104">✉ <span class="__cf_email__" data-cfemail="ddb4b3bbb29daab5b2bfbcb2bab2bbb2a8b3b9bca9b4b2b3f3b2afba">info@whobaogofoundation.org

</span></a>
    <a href="tel:08180452165">📞 08180452165 · 014538555</a>
  </div>
  <div class="topbar-socials">
    <a href="#" title="Facebook">f</a>
    <a href="#" title="Twitter">𝕏</a>
    <a href="#" title="Google+">G+</a>
    <a href="#" title="LinkedIn">in</a>
  </div>
</div>

<!-- ── NAVBAR ──────────────────────────────────── -->
<header class="navbar" id="navbar">
  <a href="index.php" class="logo">
    <img src="./assets/images/logo.png" alt="Whoba Ogo Foundation" style="height: 48px; width: auto;">
  </a>

  <ul class="nav-menu">
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="about-us.php">About Us</a></li>
    
    <!-- Our Work with dropdown -->
    <li class="has-dropdown">
      <a href="our-work.php">
        Our Work
        <span class="dropdown-arrow">▼</span>
      </a>
      <div class="dropdown-menu">
        <a href="my-gallery.php">Gallery</a>
        <a href="our-blog.php">Our Latest News</a>
        
      </div>
    </li>
    
    <li><a href="icthub.php">ICT Hub</a></li>
    <li><a href="testimonials.php">Testimonials</a></li>
    <li><a href="contact.php">Contact Us</a></li>
    <li><a href="donate.php" class="nav-cta">Donate ♥</a></li>
  </ul>

  <button class="hamburger" id="hamburger" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>
</header>

<!-- Mobile nav drawer -->
<nav class="mobile-nav" id="mobileNav">
  <a href="index.php" class="active">Home</a>
  <a href="about.php">About Us</a>
  
  <!-- Our Work with mobile dropdown -->
  <div class="has-dropdown">
    <a href="our-work.php" class="dropdown-toggle">
      <span>Our Work</span>
      <span class="mobile-dropdown-arrow">▼</span>
    </a>
    <div class="mobile-dropdown-menu">
      <a href="my-gallery.php">Gallery</a>
      <a href="our-blog.php">Our Latest News</a>
      
    </div>
  </div>
  
  <a href="ict-hub.php">ICT Hub</a>
  <a href="testimonials.php">Testimonials</a>
  <a href="contact.php">Contact Us</a>
  <a href="donate.php" class="mobile-cta">Donate ♥</a>
</nav>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
  // Mobile nav toggle
  const hamburger = document.getElementById('hamburger');
  const mobileNav = document.getElementById('mobileNav');
  
  hamburger.addEventListener('click', () => {
    const open = hamburger.classList.toggle('open');
    mobileNav.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
  });
  
  // Close mobile nav on link click (except dropdown toggles)
  mobileNav.querySelectorAll('a:not(.dropdown-toggle)').forEach(a => {
    a.addEventListener('click', () => {
      hamburger.classList.remove('open');
      mobileNav.classList.remove('open');
      document.body.style.overflow = '';
    });
  });
  
  // Mobile dropdown toggle
  mobileNav.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', (e) => {
      e.preventDefault();
      const parent = toggle.closest('.has-dropdown');
      
      // Close other dropdowns
      mobileNav.querySelectorAll('.has-dropdown').forEach(item => {
        if (item !== parent) item.classList.remove('open');
      });
      
      // Toggle current
      parent.classList.toggle('open');
    });
  });
  
  // Sticky nav
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  }, { passive: true });
</script>