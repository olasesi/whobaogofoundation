<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Whoba Ogo Foundation — Touching Lives</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/stylesheets/modern-corporate.css"/>
  <style>
    /* Dropdown Menu Styles */
    .nav-dropdown {
      position: relative;
    }

    .nav-dropdown > a {
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }

    .dropdown-menu {
      position: absolute;
      top: 100%;
      left: 0;
      background: #fff;
      border: 1px solid var(--border-gray);
      border-radius: 8px;
      box-shadow: var(--shadow-md);
      min-width: 200px;
      padding: 0.5rem 0;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 1000;
      margin-top: 0.5rem;
    }

    .nav-dropdown:hover .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown-menu a {
      display: block;
      padding: 0.75rem 1.2rem;
      color: var(--dark-gray);
      font-weight: 500;
      font-size: 0.95rem;
      transition: all 0.3s;
      border-radius: 0;
    }

    .dropdown-menu a:hover {
      background: var(--primary-light);
      color: var(--primary);
      padding-left: 1.5rem;
    }
  </style>
</head>
<body>

<!-- ── TOPBAR ──────────────────────────────────── -->
<div class="topbar">
  <div class="topbar-contact">
    <a href="mailto:inquiry@whobaogofoundation.org">✉ inquiry@whobaogofoundation.org</a>
    <a href="tel:08180452165">📞 08180452165</a>
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
    <img src="./assets/images/logo.png" alt="Whoba Ogo Foundation">
  </a>

  <ul class="nav-menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="about-us.php">About Us</a></li>
    <li class="nav-dropdown">
      <a href="our-work.php">Our Work ▼</a>
      <div class="dropdown-menu">
        <a href="my-gallery.php">Gallery</a>
        <a href="our-blog.php">Our Latest News</a>
      </div>
    </li>
    <li><a href="icthub.php">ICT Hub</a></li>
    <li><a href="testimonials.php">Testimonials</a></li>
    <li><a href="contact.php">Contact Us</a></li>
    <li><a href="volunteer.php" class="nav-cta">Volunteer ♥</a></li>
  </ul>

  <button class="hamburger" id="hamburger" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>
</header>

<!-- ── MOBILE NAV ──────────────────────────────── -->
<nav class="mobile-nav" id="mobileNav">
  <a href="index.php">Home</a>
  <a href="about-us.php">About Us</a>
  <a href="our-work.php">Our Work</a>
  <a href="my-gallery.php" style="padding-left: 2rem; font-size: 0.9rem;">Gallery</a>
  <a href="our-blog.php" style="padding-left: 2rem; font-size: 0.9rem;">Our Latest News</a>
  <a href="icthub.php">ICT Hub</a>
  <a href="testimonials.php">Testimonials</a>
  <a href="contact.php">Contact Us</a>
  <a href="volunteer.php" class="mobile-cta">Volunteer ♥</a>
</nav>

<script>
  const hamburger = document.getElementById('hamburger');
  const mobileNav = document.getElementById('mobileNav');
  
  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('open');
    mobileNav.classList.toggle('open');
  });

  mobileNav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      hamburger.classList.remove('open');
      mobileNav.classList.remove('open');
    });
  });

  window.addEventListener('scroll', () => {
    document.getElementById('navbar').style.boxShadow = window.scrollY > 10 
      ? '0 2px 12px rgba(0,0,0,0.08)' 
      : 'none';
  });
</script>