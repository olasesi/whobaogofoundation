<?php
require_once './includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Whoba Ogo Foundation — Touching Lives</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,300;0,700;0,900;1,300;1,700&display=swap" rel="stylesheet">
  <style>
    /* ── TOKENS ───────────────────────────────── */
    :root {
      --red:        #E03535;
      --red-dark:   #B52020;
      --red-soft:   #FDE8E8;
      --red-pale:   #FFF5F5;
      --teal:       #0D9B7E;
      --teal-dark:  #076E58;
      --teal-soft:  #E0F7F2;
      --sun:        #F5A623;
      --white:      #FFFFFF;
      --off-white:  #FAFAF8;
      --surface:    #F3F3F0;
      --ink:        #131511;
      --ink-mid:    #3B4840;
      --ink-light:  #7A8C85;
      --border:     #E2E8E4;
      --r-sm: 10px; --r-md: 16px; --r-lg: 22px; --r-xl: 32px; --r-2xl: 44px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--off-white);
      color: var(--ink);
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }
    img { display: block; max-width: 100%; }
    a { text-decoration: none; color: inherit; }

    /* ── TOPBAR ───────────────────────────────── */
    .topbar {
      background: var(--ink);
      padding: 0.55rem 2rem;
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 0.5rem;
    }
    .topbar-contact {
      display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
    }
    .topbar-contact a {
      color: rgba(255,255,255,0.75); font-size: 0.75rem;
      display: flex; align-items: center; gap: 0.4rem;
      transition: color 0.2s;
    }
    .topbar-contact a:hover { color: #fff; }
    .topbar-socials { display: flex; gap: 0.5rem; }
    .topbar-socials a {
      width: 26px; height: 26px; border-radius: 6px;
      background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
      display: flex; align-items: center; justify-content: center;
      color: rgba(255,255,255,0.5); font-size: 0.72rem;
      transition: background 0.2s, color 0.2s;
    }
    .topbar-socials a:hover { background: var(--red); color: #fff; border-color: var(--red); }

    /* ── NAVBAR ───────────────────────────────── */
    .navbar {
      position: sticky; top: 0; z-index: 300;
      background: rgba(250,250,248,0.95);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      padding: 0 2rem;
      height: 64px;
      display: flex; align-items: center; gap: 1rem;
      transition: box-shadow 0.3s;
    }
    .navbar.scrolled { box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

    .logo {
      display: flex; align-items: center; gap: 0.65rem;
      flex-shrink: 0;
    }
    .logo-orb {
      width: 38px; height: 38px; border-radius: 11px;
      background: linear-gradient(135deg, var(--red), var(--red-dark));
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 12px rgba(224,53,53,0.4);
      color: #fff; font-size: 1.1rem; flex-shrink: 0;
    }
    .logo-text { line-height: 1.2; }
    .logo-text strong {
      display: block; font-size: 0.9rem; font-weight: 800; color: var(--ink);
    }
    .logo-text small {
      font-size: 0.6rem; color: var(--ink-light); font-weight: 500; letter-spacing: 0.04em;
    }

    /* Desktop nav */
    .nav-menu {
      list-style: none;
      display: flex; align-items: center; gap: 0.1rem;
      margin-left: auto;
    }
    .nav-menu a {
      font-size: 0.82rem; font-weight: 600; color: var(--ink-mid);
      padding: 0.4rem 0.75rem; border-radius: 8px;
      transition: color 0.2s, background 0.2s; white-space: nowrap;
    }
    .nav-menu a:hover, .nav-menu a.active { color: var(--red); background: var(--red-soft); }
    .nav-cta {
      margin-left: 0.6rem;
      background: var(--red) !important; color: #fff !important;
      padding: 0.48rem 1.1rem !important; border-radius: 100px !important;
      font-weight: 700 !important;
      box-shadow: 0 4px 14px rgba(224,53,53,0.35);
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s !important;
    }
    .nav-cta:hover {
      background: var(--red-dark) !important;
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(224,53,53,0.45) !important;
    }

    /* Hamburger */
    .hamburger {
      display: none; margin-left: auto;
      background: none; border: none; cursor: pointer;
      padding: 0.4rem; flex-direction: column; gap: 5px;
    }
    .hamburger span {
      display: block; width: 22px; height: 2px;
      background: var(--ink); border-radius: 2px;
      transition: transform 0.3s, opacity 0.3s;
    }
    .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .hamburger.open span:nth-child(2) { opacity: 0; }
    .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* Mobile nav drawer */
    .mobile-nav {
      display: none;
      position: fixed; top: 64px; left: 0; right: 0; bottom: 0;
      background: var(--white); z-index: 200;
      flex-direction: column; padding: 1.5rem 1.5rem 2rem;
      overflow-y: auto;
      border-top: 1px solid var(--border);
      transform: translateX(100%);
      transition: transform 0.3s ease;
    }
    .mobile-nav.open { transform: translateX(0); }
    .mobile-nav a {
      display: block; font-size: 1rem; font-weight: 700;
      color: var(--ink); padding: 0.85rem 0;
      border-bottom: 1px solid var(--border);
      transition: color 0.2s;
    }
    .mobile-nav a:last-child { border-bottom: none; }
    .mobile-nav a:hover, .mobile-nav a.active { color: var(--red); }
    .mobile-nav .mobile-cta {
      margin-top: 1.5rem;
      background: var(--red); color: #fff !important;
      text-align: center; padding: 0.9rem !important;
      border-radius: var(--r-md); font-size: 1rem !important;
      border-bottom: none !important;
    }

    /* ── HERO ─────────────────────────────────── */
    .hero {
      max-width: 1260px; margin: 0 auto;
      padding: 3.5rem 2rem 3rem;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem; align-items: center;
    }

    .hero-badge {
      display: inline-flex; align-items: center; gap: 0.55rem;
      background: var(--red-soft); border: 1px solid rgba(224,53,53,0.25);
      color: var(--red-dark); font-size: 0.74rem; font-weight: 700;
      padding: 0.35rem 0.85rem 0.35rem 0.4rem;
      border-radius: 100px; margin-bottom: 1.3rem;
    }
    .hero-badge-dot {
      width: 22px; height: 22px; border-radius: 50%;
      background: var(--red); color: #fff;
      display: flex; align-items: center; justify-content: center; font-size: 0.7rem;
    }

    .hero h1 {
      font-family: 'Fraunces', serif;
      font-size: clamp(2.6rem, 4.5vw, 4.8rem);
      font-weight: 900; line-height: 1.02;
      letter-spacing: -0.03em; color: var(--ink);
      margin-bottom: 1.2rem;
    }
    .hero h1 .hl {
      color: var(--red); font-style: italic;
      position: relative; display: inline-block;
    }
    .hero h1 .hl::after {
      content: '';
      position: absolute; bottom: 3px; left: 0; right: 0;
      height: 6px; background: var(--sun);
      border-radius: 3px; z-index: -1; opacity: 0.5;
    }
    .hero h1 .tc { color: var(--teal); }

    .hero-desc {
      font-size: 1rem; line-height: 1.75;
      color: var(--ink-mid); margin-bottom: 1.8rem; max-width: 480px;
    }

    .hero-btns {
      display: flex; align-items: center; gap: 0.9rem;
      flex-wrap: wrap; margin-bottom: 2.5rem;
    }
    .btn-fill {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: var(--red); color: #fff;
      font-weight: 700; font-size: 0.88rem;
      padding: 0.75rem 1.5rem; border-radius: 100px;
      box-shadow: 0 6px 18px rgba(224,53,53,0.32);
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      border: none; cursor: pointer; white-space: nowrap;
    }
    .btn-fill:hover { background: var(--red-dark); transform: translateY(-2px); box-shadow: 0 10px 26px rgba(224,53,53,0.42); }
    .btn-fill .ico { width: 22px; height: 22px; border-radius: 50%; background: rgba(255,255,255,0.22); display: flex; align-items: center; justify-content: center; font-size: 0.78rem; }
    .btn-fill.teal { background: var(--teal); box-shadow: 0 6px 18px rgba(13,155,126,0.3); }
    .btn-fill.teal:hover { background: var(--teal-dark); box-shadow: 0 10px 26px rgba(13,155,126,0.4); }
    .btn-outline {
      display: inline-flex; align-items: center; gap: 0.4rem;
      font-weight: 700; font-size: 0.88rem; color: var(--ink);
      padding: 0.75rem 1.4rem; border-radius: 100px;
      border: 1.5px solid var(--border);
      transition: border-color 0.2s, background 0.2s; white-space: nowrap;
    }
    .btn-outline:hover { border-color: var(--ink-mid); background: rgba(0,0,0,0.03); }

    .hero-trust {
      display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap;
    }
    .trust-avatars { display: flex; }
    .trust-avatars span {
      width: 32px; height: 32px; border-radius: 50%;
      border: 2px solid var(--off-white);
      background: var(--red-soft);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.8rem; margin-left: -8px;
    }
    .trust-avatars span:first-child { margin-left: 0; }
    .trust-text { font-size: 0.78rem; color: var(--ink-light); line-height: 1.4; }
    .trust-text strong { color: var(--ink); }

    /* Hero visual */
    .hero-visual { position: relative; }
    .hv-card {
      border-radius: var(--r-2xl); overflow: hidden;
      aspect-ratio: 4/5;
      background: linear-gradient(160deg, #4A0C0C 0%, #1C0505 100%);
      position: relative;
      box-shadow: 0 28px 64px rgba(224,53,53,0.28);
    }
    .hv-glow {
      position: absolute; inset: 0;
      background:
        radial-gradient(ellipse at 25% 80%, rgba(245,166,35,0.28) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 20%, rgba(13,155,126,0.18) 0%, transparent 45%);
    }
    .hv-body {
      position: absolute; bottom: 0; left: 0; right: 0;
      padding: 1.8rem;
      background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, transparent 100%);
    }
    .hv-body h3 {
      font-family: 'Fraunces', serif;
      font-size: 1.35rem; font-weight: 700; color: #fff;
      line-height: 1.25; margin-bottom: 0.5rem;
    }
    .hv-body p { font-size: 0.8rem; color: rgba(255,255,255,0.65); line-height: 1.55; }
    .hv-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-top: 0.9rem; }
    .chip {
      background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18);
      color: rgba(255,255,255,0.88); font-size: 0.68rem; font-weight: 600;
      padding: 0.28rem 0.7rem; border-radius: 100px;
    }

    /* Floating cards */
    .fc {
      position: absolute; background: #fff;
      border-radius: var(--r-md); padding: 0.9rem 1rem;
      box-shadow: 0 12px 36px rgba(0,0,0,0.12);
      animation: bob 5s ease-in-out infinite;
    }
    .fc.a { top: -1rem; right: -1.5rem; min-width: 140px; animation-delay: 0s; }
    .fc.b { bottom: 5rem; left: -1.5rem; min-width: 138px; animation-delay: 2.2s; }
    .fc-label { font-size: 0.6rem; font-weight: 700; color: var(--ink-light); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.25rem; }
    .fc-val { font-family: 'Fraunces', serif; font-size: 1.7rem; font-weight: 900; color: var(--ink); line-height: 1; }
    .fc-sub { font-size: 0.65rem; color: var(--ink-light); margin-top: 0.2rem; }
    .fc-ico { font-size: 1.2rem; margin-bottom: 0.3rem; }
    .hv-ring {
      position: absolute; border-radius: 50%; border: 2px dashed;
      pointer-events: none; z-index: -1;
    }
    .hv-ring.r1 { width: 240px; height: 240px; border-color: rgba(224,53,53,0.15); bottom: -2.5rem; right: -2.5rem; animation: spin 38s linear infinite; }
    .hv-ring.r2 { width: 120px; height: 120px; border-color: rgba(13,155,126,0.18); top: 1.5rem; left: -1.5rem; animation: spin 24s linear infinite reverse; }
    @keyframes bob  { 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-9px); } }
    @keyframes spin { from{ transform:rotate(0deg); } to{ transform:rotate(360deg); } }

    /* ── TICKER ───────────────────────────────── */
    .ticker {
      background: var(--red); overflow: hidden;
      padding: 0.75rem 0; border-top: 3px solid var(--sun);
    }
    .ticker-track {
      display: flex; gap: 3rem; width: max-content;
      animation: scroll-left 24s linear infinite;
    }
    .ticker-item {
      display: flex; align-items: center; gap: 0.55rem;
      white-space: nowrap; color: #fff; font-size: 0.78rem; font-weight: 700;
    }
    .tdot { width: 7px; height: 7px; border-radius: 50%; background: var(--sun); flex-shrink: 0; }
    @keyframes scroll-left { from{ transform:translateX(0); } to{ transform:translateX(-50%); } }

    /* ── LAYOUT HELPERS ───────────────────────── */
    .wrap { max-width: 1260px; margin: 0 auto; padding: 0 2rem; }
    .sec  { padding: 5rem 0; }

    .eyebrow {
      display: inline-flex; align-items: center; gap: 0.4rem;
      font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
      letter-spacing: 0.12em; color: var(--red); margin-bottom: 0.75rem;
    }
    .eyebrow::before { content: ''; width: 16px; height: 3px; background: currentColor; border-radius: 2px; }
    .eyebrow.teal { color: var(--teal); }
    h2.hdg {
      font-family: 'Fraunces', serif;
      font-size: clamp(1.9rem, 3vw, 2.8rem);
      font-weight: 900; line-height: 1.1;
      letter-spacing: -0.025em; color: var(--ink);
    }

    /* ── STATS BANNER ─────────────────────────── */
    .stats-banner {
      background: var(--ink); border-radius: var(--r-xl);
      margin: 0 2rem;
      padding: 2.5rem 3rem;
      display: grid; grid-template-columns: repeat(4,1fr); gap: 1.5rem;
      position: relative; overflow: hidden;
    }
    .stats-banner::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, var(--red), var(--sun), var(--teal));
    }
    .sb-item { text-align: center; position: relative; }
    .sb-item + .sb-item::before {
      content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
      width: 1px; height: 40px; background: rgba(255,255,255,0.08);
    }
    .sb-num {
      font-family: 'Fraunces', serif; font-size: 2.6rem; font-weight: 900; line-height: 1;
      background: linear-gradient(135deg, #FFB3B3, var(--red));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
      margin-bottom: 0.3rem;
    }
    .sb-num.t { background: linear-gradient(135deg, #7DFFD9, var(--teal)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .sb-num.s { background: linear-gradient(135deg, #FFE6AA, var(--sun)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .sb-lbl { font-size: 0.73rem; color: rgba(255,255,255,0.45); font-weight: 500; line-height: 1.4; }

    /* ── ABOUT ────────────────────────────────── */
    .about-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 4.5rem; align-items: center;
    }
    .about-vis { position: relative; }
    .about-blob {
      border-radius: var(--r-2xl) var(--r-2xl) 100px var(--r-2xl);
      background: linear-gradient(155deg, var(--red-soft) 0%, #F7C5C5 100%);
      aspect-ratio: 1; overflow: visible; position: relative;
      display: flex; align-items: center; justify-content: center;
      min-height: 340px;
    }
    .about-blob-inner {
      font-size: 6rem; line-height: 1;
    }
    .about-quote-card {
      position: absolute; bottom: -2rem; right: -1.8rem;
      background: var(--red); color: #fff;
      border-radius: var(--r-md); padding: 1.2rem 1.4rem;
      max-width: 215px;
      box-shadow: 0 14px 36px rgba(224,53,53,0.3);
    }
    .about-quote-card p {
      font-family: 'Fraunces', serif; font-size: 0.9rem;
      font-style: italic; line-height: 1.5;
    }
    .about-quote-card span {
      display: block; margin-top: 0.55rem;
      font-size: 0.65rem; opacity: 0.72; font-weight: 600;
    }
    .about-dots {
      position: absolute; top: -1rem; left: -1.5rem;
      display: grid; grid-template-columns: repeat(6,1fr); gap: 7px; opacity: 0.25;
    }
    .about-dots i { display: block; width: 5px; height: 5px; border-radius: 50%; background: var(--red); }

    .about-copy .hdg { margin-bottom: 1rem; }
    .about-copy p { font-size: 0.95rem; line-height: 1.8; color: var(--ink-mid); margin-bottom: 0.9rem; }
    .about-copy p strong { color: var(--ink); }

    /* ── THREE PILLARS ───────────────────────── */
    .pillars-bg { background: var(--surface); }
    .pillars-grid {
      display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem;
      margin-top: 2.5rem;
    }
    .pillar-card {
      background: var(--white); border: 1px solid var(--border);
      border-radius: var(--r-lg); padding: 2rem;
      transition: box-shadow 0.3s, transform 0.3s;
    }
    .pillar-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.08); transform: translateY(-4px); }
    .pillar-ico {
      width: 52px; height: 52px; border-radius: var(--r-sm);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem; margin-bottom: 1.2rem;
    }
    .pillar-ico.red  { background: var(--red-soft); }
    .pillar-ico.teal { background: var(--teal-soft); }
    .pillar-ico.sun  { background: #FEF3DC; }
    .pillar-card h3 {
      font-family: 'Fraunces', serif; font-size: 1.1rem; font-weight: 700;
      color: var(--ink); margin-bottom: 0.5rem;
    }
    .pillar-card p { font-size: 0.85rem; color: var(--ink-light); line-height: 1.65; }
    .pillar-arrow {
      display: inline-flex; align-items: center; gap: 0.3rem;
      font-size: 0.76rem; font-weight: 700; color: var(--red);
      margin-top: 1rem; transition: gap 0.2s;
    }
    .pillar-arrow:hover { gap: 0.55rem; }

    /* ── PROGRAMS ────────────────────────────── */
    .progs-grid {
      display: grid; grid-template-columns: repeat(3,1fr);
      gap: 1.25rem; margin-top: 2.5rem;
    }
    .prog-card {
      border-radius: var(--r-lg); overflow: hidden; cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .prog-card:hover { transform: translateY(-6px); box-shadow: 0 22px 50px rgba(0,0,0,0.14); }
    .prog-body { padding: 2rem; display: flex; flex-direction: column; height: 100%; }
    .prog-card.red-card  { background: linear-gradient(145deg, var(--red), var(--red-dark)); }
    .prog-card.teal-card { background: linear-gradient(145deg, var(--teal), var(--teal-dark)); }
    .prog-card.sun-card  { background: linear-gradient(145deg, #F9AE32, #B57510); }
    .prog-ico {
      width: 50px; height: 50px; border-radius: var(--r-sm);
      background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.22);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.35rem; margin-bottom: 1.3rem;
    }
    .prog-card h3 { font-family: 'Fraunces', serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 0.55rem; }
    .prog-card p  { font-size: 0.84rem; color: rgba(255,255,255,0.72); line-height: 1.65; flex: 1; }
    .prog-link {
      margin-top: 1.3rem; display: inline-flex; align-items: center; gap: 0.35rem;
      background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.28);
      color: #fff; font-size: 0.76rem; font-weight: 700;
      padding: 0.45rem 0.95rem; border-radius: 100px; width: fit-content;
      transition: background 0.2s;
    }
    .prog-link:hover { background: rgba(255,255,255,0.3); }

    /* ── MISSION BANNER ──────────────────────── */
    .mission-wrap {
      background: var(--ink); border-radius: var(--r-2xl);
      margin: 0 2rem; padding: 4.5rem 4rem;
      position: relative; overflow: hidden;
    }
    .mission-wrap::before {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(ellipse at 15% 50%, rgba(224,53,53,0.25) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 50%, rgba(13,155,126,0.18) 0%, transparent 55%),
        radial-gradient(ellipse at 50% 95%, rgba(245,166,35,0.12) 0%, transparent 40%);
    }
    .mission-wrap > * { position: relative; z-index: 1; }
    .mission-grid {
      display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;
    }
    .mission-badge {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: rgba(224,53,53,0.18); border: 1px solid rgba(224,53,53,0.3);
      color: #FFB3B3; font-size: 0.68rem; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.12em;
      padding: 0.35rem 0.9rem; border-radius: 100px; margin-bottom: 1.3rem;
    }
    .mission-hdg {
      font-family: 'Fraunces', serif;
      font-size: clamp(1.8rem, 3.2vw, 3rem);
      font-weight: 900; color: #fff;
      line-height: 1.15; letter-spacing: -0.02em;
      margin-bottom: 0.5rem;
    }
    .mission-hdg .rc { color: #FF7A7A; }
    .mission-hdg .tc { color: var(--teal); }
    .mission-sub {
      font-size: 0.95rem; color: rgba(255,255,255,0.5);
      line-height: 1.75; margin-bottom: 2rem;
    }
    .mission-facts { display: flex; flex-direction: column; gap: 1.1rem; }
    .mfact {
      display: flex; align-items: flex-start; gap: 0.75rem;
      color: rgba(255,255,255,0.7); font-size: 0.88rem; line-height: 1.6;
    }
    .mfact-dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--red); flex-shrink: 0; margin-top: 0.4rem;
    }

    /* ── TEAM ─────────────────────────────────── */
    .team-grid {
      display: grid; grid-template-columns: repeat(2,1fr);
      gap: 1.5rem; max-width: 620px; margin: 2.5rem auto 0;
    }
    .team-card {
      background: var(--white); border: 1px solid var(--border);
      border-radius: var(--r-lg); padding: 2rem; text-align: center;
      transition: box-shadow 0.3s, transform 0.3s;
    }
    .team-card:hover { box-shadow: 0 14px 42px rgba(0,0,0,0.08); transform: translateY(-4px); }
    .team-avatar {
      width: 88px; height: 88px; border-radius: 50%;
      margin: 0 auto 1rem; overflow: hidden;
      background: var(--red-soft);
      display: flex; align-items: center; justify-content: center;
      border: 3px solid var(--off-white);
      box-shadow: 0 0 0 2.5px var(--red), 0 6px 18px rgba(224,53,53,0.18);
    }
    .team-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .team-init {
      font-family: 'Fraunces', serif; font-size: 2rem; font-weight: 900; color: var(--red-dark);
    }
    .team-name { font-family: 'Fraunces', serif; font-size: 1.05rem; font-weight: 700; color: var(--ink); margin-bottom: 0.4rem; }
    .team-role {
      display: inline-block;
      background: var(--red-soft); color: var(--red-dark);
      font-size: 0.68rem; font-weight: 700;
      padding: 0.28rem 0.75rem; border-radius: 100px;
    }

    /* ── NEWS ─────────────────────────────────── */
    .news-bg { background: var(--surface); }
    .news-hdr { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .news-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 1.2rem; }

    .nc {
      background: var(--white); border: 1px solid var(--border);
      border-radius: var(--r-lg); overflow: hidden;
      transition: box-shadow 0.3s, transform 0.3s;
    }
    .nc:hover { box-shadow: 0 14px 40px rgba(0,0,0,0.08); transform: translateY(-4px); }
    .nc-img { position: relative; overflow: hidden; }
    .nc-img-inner {
      width: 100%; aspect-ratio: 16/9;
      display: flex; align-items: center; justify-content: center; font-size: 2.8rem;
      transition: transform 0.4s;
    }
    .nc.feat .nc-img-inner { aspect-ratio: 16/8; font-size: 3.5rem; }
    .nc:hover .nc-img-inner { transform: scale(1.05); }
    .nc-date {
      position: absolute; top: 0.8rem; left: 0.8rem;
      background: var(--red); color: #fff;
      font-size: 0.68rem; font-weight: 800;
      padding: 0.28rem 0.6rem; border-radius: 6px;
    }
    .nc-body { padding: 1.2rem; }
    .nc-cat { font-size: 0.64rem; font-weight: 700; color: var(--teal); text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 0.4rem; }
    .nc h4 { font-family: 'Fraunces', serif; font-size: 0.95rem; font-weight: 700; color: var(--ink); line-height: 1.3; }
    .nc.feat h4 { font-size: 1.2rem; }
    .nc p { font-size: 0.8rem; color: var(--ink-light); line-height: 1.6; margin-top: 0.4rem; }
    .nc-link {
      display: inline-flex; align-items: center; gap: 0.3rem;
      font-size: 0.74rem; font-weight: 700; color: var(--red);
      margin-top: 0.8rem; transition: gap 0.2s;
    }
    .nc-link:hover { gap: 0.55rem; }

    /* ── CTA ROW ─────────────────────────────── */
    .cta-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin: 0 2rem; }
    .cta-card {
      border-radius: var(--r-2xl); padding: 3rem 2.5rem;
      position: relative; overflow: hidden;
    }
    .cta-card.red  { background: linear-gradient(145deg, var(--red), var(--red-dark)); }
    .cta-card.teal { background: linear-gradient(145deg, var(--teal), var(--teal-dark)); }
    .cta-card::before {
      content: ''; position: absolute; top: -50px; right: -50px;
      width: 200px; height: 200px; border-radius: 50%;
      background: rgba(255,255,255,0.06); pointer-events: none;
    }
    .cta-card::after {
      content: ''; position: absolute; bottom: -60px; left: -30px;
      width: 240px; height: 240px; border-radius: 50%;
      background: rgba(255,255,255,0.04); pointer-events: none;
    }
    .cta-card > * { position: relative; z-index: 1; }
    .cta-card h3 {
      font-family: 'Fraunces', serif; font-size: 1.75rem; font-weight: 900;
      color: #fff; line-height: 1.15; margin-bottom: 0.7rem; letter-spacing: -0.02em;
    }
    .cta-card p { color: rgba(255,255,255,0.62); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.6rem; }
    .btn-white {
      display: inline-flex; align-items: center; gap: 0.45rem;
      background: #fff; font-weight: 800; font-size: 0.85rem;
      padding: 0.72rem 1.4rem; border-radius: 100px; border: none; cursor: pointer;
      transition: transform 0.15s, box-shadow 0.2s;
    }
    .btn-white.red-text  { color: var(--red-dark); }
    .btn-white.teal-text { color: var(--teal-dark); }
    .btn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(0,0,0,0.16); }
    .contact-items { display: flex; flex-direction: column; gap: 0.8rem; margin-top: 1.4rem; }
    .ci {
      display: flex; align-items: center; gap: 0.65rem;
      color: rgba(255,255,255,0.72); font-size: 0.85rem;
    }
    .ci-ico {
      width: 30px; height: 30px; border-radius: 8px;
      background: rgba(255,255,255,0.14); display: flex; align-items: center; justify-content: center;
      font-size: 0.82rem; flex-shrink: 0;
    }

    /* ── NEWSLETTER STRIP ────────────────────── */
    .newsletter {
      background: var(--red-soft); border-top: 1px solid rgba(224,53,53,0.15);
      border-bottom: 1px solid rgba(224,53,53,0.15);
      padding: 2.5rem 2rem;
    }
    .newsletter-inner {
      max-width: 1260px; margin: 0 auto;
      display: flex; align-items: center; justify-content: space-between;
      gap: 2rem; flex-wrap: wrap;
    }
    .newsletter h4 {
      font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 700;
      color: var(--ink); margin-bottom: 0.3rem;
    }
    .newsletter p { font-size: 0.85rem; color: var(--ink-light); }
    .newsletter-form {
      display: flex; gap: 0.6rem; flex-wrap: wrap;
    }
    .newsletter-form input {
      padding: 0.72rem 1.2rem; border-radius: 100px;
      border: 1.5px solid rgba(224,53,53,0.3); background: #fff;
      font-size: 0.85rem; font-family: inherit; min-width: 240px;
      outline: none; transition: border-color 0.2s;
    }
    .newsletter-form input:focus { border-color: var(--red); }
    .newsletter-form button {
      padding: 0.72rem 1.4rem; border-radius: 100px;
      background: var(--red); color: #fff; border: none;
      font-size: 0.85rem; font-weight: 700; font-family: inherit;
      cursor: pointer; transition: background 0.2s;
    }
    .newsletter-form button:hover { background: var(--red-dark); }

    /* ── FOOTER ──────────────────────────────── */
    .footer-main {
      background: var(--ink); padding: 3.5rem 2rem 0;
      display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 2.5rem;
    }
    .f-about p { font-size: 0.8rem; color: rgba(255,255,255,0.4); line-height: 1.7; margin: 1rem 0 1.3rem; }
    .f-socials { display: flex; gap: 0.5rem; }
    .f-soc {
      width: 32px; height: 32px; border-radius: 9px;
      background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
      display: flex; align-items: center; justify-content: center;
      color: rgba(255,255,255,0.4); font-size: 0.78rem;
      transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .f-soc:hover { background: var(--red); color: #fff; border-color: var(--red); }
    .f-col h5 {
      font-size: 0.72rem; font-weight: 800; color: rgba(255,255,255,0.8);
      text-transform: uppercase; letter-spacing: 0.09em; margin-bottom: 1.1rem;
    }
    .f-col ul { list-style: none; display: flex; flex-direction: column; gap: 0.55rem; }
    .f-col ul a { font-size: 0.82rem; color: rgba(255,255,255,0.4); transition: color 0.2s; }
    .f-col ul a:hover { color: var(--red); }
    .footer-bar {
      background: #0C0F0D; padding: 1.1rem 2rem; margin-top: 2rem;
      display: flex; justify-content: space-between; flex-wrap: wrap; gap: 0.8rem; align-items: center;
    }
    .footer-bar p { font-size: 0.72rem; color: rgba(255,255,255,0.28); }
    .footer-bar a { color: var(--red); }

    /* ── REVEAL ANIMATIONS ───────────────────── */
    .rev { opacity: 0; transform: translateY(24px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .rev.in { opacity: 1; transform: none; }
    .d1 { transition-delay: 0.1s; } .d2 { transition-delay: 0.2s; } .d3 { transition-delay: 0.3s; }

    /* ── RESPONSIVE — TABLET (≤1024px) ───────── */
    @media (max-width: 1024px) {
      .topbar { display: none; }
      .stats-banner { grid-template-columns: 1fr 1fr; margin: 0 1.5rem; }
      .sb-item + .sb-item::before { display: none; }
      .progs-grid { grid-template-columns: 1fr 1fr; }
      .pillars-grid { grid-template-columns: 1fr 1fr; }
      .news-grid { grid-template-columns: 1fr 1fr; }
      .nc.feat { grid-column: span 2; }
      .footer-main { grid-template-columns: 1fr 1fr; }
      .mission-wrap { margin: 0 1.5rem; padding: 3.5rem 3rem; }
      .cta-row { margin: 0 1.5rem; }
    }

    /* ── RESPONSIVE — MOBILE (≤768px) ────────── */
    @media (max-width: 768px) {
      .navbar { padding: 0 1.25rem; }
      .nav-menu { display: none; }
      .hamburger { display: flex; }
      .mobile-nav { display: flex; }

      .hero {
        grid-template-columns: 1fr;
        padding: 2rem 1.25rem 2rem;
        gap: 2rem;
      }
      .hero-visual { order: -1; max-width: 360px; margin: 0 auto; width: 100%; }
      .hv-card { aspect-ratio: 4/4.5; }
      .fc.a { top: -0.8rem; right: -0.8rem; min-width: 120px; padding: 0.7rem 0.85rem; }
      .fc.b { bottom: 4rem; left: -0.8rem; min-width: 118px; padding: 0.7rem 0.85rem; }
      .fc-val { font-size: 1.4rem; }

      .hero h1 { font-size: 2.4rem; }
      .hero-desc { font-size: 0.95rem; }

      .stats-banner { grid-template-columns: 1fr 1fr; margin: 0 1.25rem; padding: 2rem 1.5rem; }
      .sb-num { font-size: 2rem; }

      .about-grid { grid-template-columns: 1fr; gap: 3rem; }
      .about-vis { order: -1; max-width: 380px; margin: 0 auto; width: 100%; }
      .about-quote-card { bottom: -1.5rem; right: -0.8rem; max-width: 185px; padding: 1rem 1.1rem; }
      .about-dots { display: none; }

      .pillars-grid { grid-template-columns: 1fr; }
      .progs-grid { grid-template-columns: 1fr; }

      .mission-wrap { margin: 0 1.25rem; padding: 2.5rem 1.5rem; }
      .mission-grid { grid-template-columns: 1fr; gap: 2.5rem; }

      .team-grid { max-width: 380px; margin: 2rem auto 0; }

      .news-grid { grid-template-columns: 1fr; }
      .nc.feat { grid-column: span 1; }

      .cta-row { grid-template-columns: 1fr; margin: 0 1.25rem; }

      .newsletter-inner { flex-direction: column; align-items: flex-start; }
      .newsletter-form { width: 100%; }
      .newsletter-form input { min-width: 0; flex: 1; width: 100%; }

      .footer-main { grid-template-columns: 1fr; padding: 2.5rem 1.25rem 0; }
      .footer-bar { padding: 1rem 1.25rem; }

      .wrap { padding: 0 1.25rem; }
      .sec { padding: 3.5rem 0; }
    }

    /* ── RESPONSIVE — SMALL MOBILE (≤480px) ─── */
    @media (max-width: 480px) {
      .hero h1 { font-size: 2rem; }
      .hero-btns { flex-direction: column; align-items: flex-start; }
      .btn-fill, .btn-outline { width: 100%; justify-content: center; }
      .stats-banner { grid-template-columns: 1fr 1fr; }
      .team-grid { grid-template-columns: 1fr; max-width: 240px; }
      .mission-hdg { font-size: 1.6rem; }
      .cta-card { padding: 2rem 1.5rem; }
      .cta-card h3 { font-size: 1.4rem; }
      .btn-white { width: 100%; justify-content: center; }
    }
  </style>
</head>
<body>

<!-- ── TOPBAR ──────────────────────────────────── -->
<div class="topbar">
  <div class="topbar-contact">
    <a href="mailto:info@whobaogofoundation.org">✉ info@whobaogofoundation.org</a>
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
    <div class="logo-orb">♥</div>
    <div class="logo-text">
      <strong>Whoba Ogo Foundation</strong>
      <small>...touching lives</small>
    </div>
  </a>

  <ul class="nav-menu">
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="about.php">About Us</a></li>
    <li><a href="our-work.php">Our Work</a></li>
    <li><a href="ict-hub.php">ICT Hub</a></li>
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
  <a href="our-work.php">Our Work</a>
  <a href="ict-hub.php">ICT Hub</a>
  <a href="testimonials.php">Testimonials</a>
  <a href="contact.php">Contact Us</a>
  <a href="donate.php" class="mobile-cta">Donate ♥</a>
</nav>

<main>

<!-- ── HERO ────────────────────────────────────── -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot">♥</span>
      African Social Impact Organization
    </div>
    <h1>
      Giving Back<br>
      to <span class="hl">Humanity</span><br>
      Every <span class="tc">Day</span>
    </h1>
    <p class="hero-desc">
      We are an African based social impact organization committed to touching lives of rural community dwellers through medical and educational support.
    </p>
    <div class="hero-btns">
      <a href="about.php" class="btn-fill">
        Read More Details <span class="ico">→</span>
      </a>
      <a href="our-work.php" class="btn-outline">Our Work</a>
    </div>
    <div class="hero-trust">
      <div class="trust-avatars">
        <span>🧑</span><span>👩</span><span>🧒</span><span>👨</span>
      </div>
      <div class="trust-text">
        <strong>3,000+ lives touched</strong><br>
        across rural communities in Nigeria
      </div>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hv-ring r1"></div>
    <div class="hv-ring r2"></div>
    <div class="hv-card">
      <div class="hv-glow"></div>
      <div class="hv-body">
        <h3>Touching Lives Across Nigeria's Rural Communities</h3>
        <p>Propelled by passion, we ease the burdens of the unfortunate many weighed down by poverty.</p>
        <div class="hv-chips">
          <span class="chip">💻 Skill Development</span>
          <span class="chip">📚 Education Support</span>
          <span class="chip">🏥 Health Support</span>
        </div>
      </div>
    </div>
    <div class="fc a">
      <div class="fc-label">ICT Graduates</div>
      <div class="fc-val">450+</div>
      <div class="fc-sub">Free tuition training</div>
    </div>
    <div class="fc b">
      <div class="fc-ico">🎓</div>
      <div class="fc-label">Programs Active</div>
      <div class="fc-val">5+</div>
      <div class="fc-sub">Nationwide impact</div>
    </div>
  </div>
</section>

<!-- ── TICKER ───────────────────────────────────── -->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <span class="ticker-item"><span class="tdot"></span>Skill Development Program</span>
    <span class="ticker-item"><span class="tdot"></span>Education Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Health Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Free ICT Training Hub</span>
    <span class="ticker-item"><span class="tdot"></span>SS3 Mock Examination Support</span>
    <span class="ticker-item"><span class="tdot"></span>Community Outreach</span>
    <span class="ticker-item"><span class="tdot"></span>Skill Development Program</span>
    <span class="ticker-item"><span class="tdot"></span>Education Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Health Support Program</span>
    <span class="ticker-item"><span class="tdot"></span>Free ICT Training Hub</span>
    <span class="ticker-item"><span class="tdot"></span>SS3 Mock Examination Support</span>
    <span class="ticker-item"><span class="tdot"></span>Community Outreach</span>
  </div>
</div>

<!-- ── STATS ────────────────────────────────────── -->
<div style="padding: 3rem 0 0;">
  <div class="stats-banner rev">
    <div class="sb-item">
      <div class="sb-num">3K+</div>
      <div class="sb-lbl">Lives Touched Across Rural Communities</div>
    </div>
    <div class="sb-item">
      <div class="sb-num t">450+</div>
      <div class="sb-lbl">ICT Graduates from Free Training Cohorts</div>
    </div>
    <div class="sb-item">
      <div class="sb-num s">3</div>
      <div class="sb-lbl">ICT Cohorts Successfully Completed</div>
    </div>
    <div class="sb-item">
      <div class="sb-num">2018</div>
      <div class="sb-lbl">Founded &amp; Serving Nigeria Since</div>
    </div>
  </div>
</div>

<!-- ── ABOUT ─────────────────────────────────────── -->
<section class="sec">
  <div class="wrap">
    <div class="about-grid">
      <div class="about-vis rev">
        <div class="about-dots"><?php for($i=0;$i<30;$i++) echo '<i></i>'; ?></div>
        <div class="about-blob">
          <div class="about-blob-inner">🤝</div>
        </div>
        <div class="about-quote-card">
          <p>"We hear their cry; we are here to stretch a hand to help."</p>
          <span>— Whoba Ogo Foundation</span>
        </div>
      </div>

      <div class="about-copy rev d2">
        <div class="eyebrow">Want to Know About Us</div>
        <h2 class="hdg">Giving Back to Humanity</h2>
        <p style="margin-top:0.8rem;">
          We are an African based social impact organization committed to touching lives of rural community dwellers through <strong>medical and educational support</strong>.
        </p>
        <p>
          We are propelled by a passion to ease the burdens of these unfortunate many, especially in rural communities of third world nations, who are being weighed down by the burdens of poverty. We do this by narrowing our gaze to what we believe forms the core of the issue.
        </p>
        <p>
          There is a very loud outcry by this multitude of voiceless underprivileged Africans who are bewildered by the hopelessness of their situation. All they are asking for is a listening ear and helping hand.
        </p>
        <div style="margin-top: 1.5rem;">
          <a href="about.php" class="btn-fill">Read More Details <span class="ico">→</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── THREE PILLARS (Mission / Program / Help) ─── -->
<section class="sec pillars-bg">
  <div class="wrap">
    <div style="text-align:center;" class="rev">
      <div class="eyebrow" style="justify-content:center;">To Humanity</div>
      <h2 class="hdg">How We Serve</h2>
    </div>
    <div class="pillars-grid">
      <div class="pillar-card rev d1">
        <div class="pillar-ico red">🎯</div>
        <h3>Our Mission</h3>
        <p>Committed to enhancing the quality of life by supporting initiatives that bring tangible change to rural communities across Nigeria.</p>
        <a href="about.php" class="pillar-arrow">Learn More →</a>
      </div>
      <div class="pillar-card rev d2">
        <div class="pillar-ico teal">📋</div>
        <h3>Our Program</h3>
        <p>Our work is focused on providing health and educational support to the most vulnerable — children, the elderly, and rural families.</p>
        <a href="our-work.php" class="pillar-arrow">Learn More →</a>
      </div>
      <div class="pillar-card rev d3">
        <div class="pillar-ico sun">🤲</div>
        <h3>Help &amp; Support</h3>
        <p>Our work has gotten to another height through your generosity. Partner with us to stretch the helping hand even further.</p>
        <a href="donate.php" class="pillar-arrow">Get Involved →</a>
      </div>
    </div>
  </div>
</section>

<!-- ── PROGRAMS ──────────────────────────────────── -->
<section class="sec">
  <div class="wrap">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;margin-bottom:0.5rem;" class="rev">
      <div>
        <div class="eyebrow">Our Work</div>
        <h2 class="hdg">Our Programs</h2>
      </div>
      <a href="our-work.php" class="btn-outline">View All →</a>
    </div>
    <div class="progs-grid">
      <div class="prog-card red-card rev">
        <div class="prog-body">
          <div class="prog-ico">💻</div>
          <h3>Skill Development Program</h3>
          <p>Empowering youth with in-demand digital and vocational skills through our fully-equipped ICT Hub — completely tuition-free of charge.</p>
          <a href="ict-hub.php" class="prog-link">Explore the Hub →</a>
        </div>
      </div>
      <div class="prog-card teal-card rev d1">
        <div class="prog-body">
          <div class="prog-ico">📚</div>
          <h3>Education Support Program</h3>
          <p>Supporting underprivileged SS3 students with mock examinations, study resources, and mentorship ahead of critical WAEC examinations.</p>
          <a href="our-work.php" class="prog-link">Learn More →</a>
        </div>
      </div>
      <div class="prog-card sun-card rev d2">
        <div class="prog-body">
          <div class="prog-ico">🏥</div>
          <h3>Health Support Program</h3>
          <p>Bringing affordable, quality healthcare directly to rural communities where over 35% of Nigerians lack access to basic health services.</p>
          <a href="our-work.php" class="prog-link">Learn More →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── MISSION ────────────────────────────────────── -->
<section style="padding: 4rem 0;">
  <div class="mission-wrap rev">
    <div class="mission-grid">
      <div>
        <div class="mission-badge">✦ It Starts With The Passion</div>
        <h2 class="mission-hdg">
          Let's Make the<br>
          World <span class="rc">Better</span> —<br>
          It Starts With <span class="tc">You</span>
        </h2>
        <p class="mission-sub">
          There is a very loud outcry by this multitude of voiceless underprivileged Africans who are bewildered by the hopelessness of their situation. All they are asking for is a listening ear and helping hand.
        </p>
        <a href="donate.php" class="btn-fill">Join Our Mission <span class="ico">♥</span></a>
      </div>
      <div class="mission-facts">
        <div class="mfact">
          <span class="mfact-dot"></span>
          <span>Approximately 1 out of every 3 children in Nigeria is either out of school or is in a school where they are unable to acquire basic literary and numeracy skills.</span>
        </div>
        <div class="mfact">
          <span class="mfact-dot" style="background:var(--teal);"></span>
          <span>Over 35% of Nigerians lack access to affordable health care. The most victimized of these are the children and the elderly. This is because they are most susceptible to health challenges.</span>
        </div>
        <div class="mfact">
          <span class="mfact-dot" style="background:var(--sun);"></span>
          <span><strong style="color:rgba(255,255,255,0.85);">We hear their cry; we are here to stretch a hand to help.</strong></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── TEAM ───────────────────────────────────────── -->
<section class="sec" style="text-align:center;">
  <div class="wrap">
    <div class="rev">
      <div class="eyebrow" style="justify-content:center;">To Humanity</div>
      <h2 class="hdg">Our Awesome Team</h2>
    </div>
    <div class="team-grid">
      <div class="team-card rev d1">
        <div class="team-avatar">
          <img src="assets/images/safiya.jpg" alt="Safiya Whoba"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">SW</div>
        </div>
        <div class="team-name">Safiya Whoba</div>
        <span class="team-role">Trustee</span>
      </div>
      <div class="team-card rev d2">
        <div class="team-avatar">
          <img src="assets/images/whoba-ogo.jpg" alt="Whoba Ogo"
            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="team-init" style="display:none;">WO</div>
        </div>
        <div class="team-name">Whoba Ogo</div>
        <span class="team-role">Chairman, Board of Trustee</span>
      </div>
    </div>
  </div>
</section>

<!-- ── NEWS ───────────────────────────────────────── -->
<section class="sec news-bg">
  <div class="wrap">
    <div class="news-hdr rev">
      <div>
        <div class="eyebrow">To Humanity</div>
        <h2 class="hdg">Our Recent News</h2>
      </div>
      <a href="news.php" class="btn-outline">All News →</a>
    </div>
    <div class="news-grid">
      <div class="nc feat rev">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#0D9B7E,#044030);">📋</div>
          <div class="nc-date">10 DEC</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">Education</div>
          <h4>Whoba Ogo Foundation SS3 Mock Examination Exercise</h4>
          <p>Students across rural communities participated in our comprehensive mock examination programme, gaining crucial preparation ahead of their WAEC examinations.</p>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d1">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#B8861B,#6A4700);">🏆</div>
          <div class="nc-date">19 SEP</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>Outstanding Participant (Whoba Ogo Foundation Free ICT Training)</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d2">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#E03535,#7A1010);">🎓</div>
          <div class="nc-date">24 SEP</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">Graduation</div>
          <h4>WOF Graduation Ceremony of Cohort 1 and Orientation</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#076E58,#021A13);">💻</div>
          <div class="nc-date">04 MAR</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>WOF ICT Cohort 3 Tuition-Free Training Kicks Off With Over 100 Students</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d1">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#3B5998,#1A2D5A);">📋</div>
          <div class="nc-date">15 FEB</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>WOF ICT Cohort 3 Screening Exercise: Over 450 Applicants</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
      <div class="nc rev d2">
        <div class="nc-img">
          <div class="nc-img-inner" style="background:linear-gradient(135deg,#7B3F00,#3D1F00);">🏅</div>
          <div class="nc-date">01 APR</div>
        </div>
        <div class="nc-body">
          <div class="nc-cat">ICT Hub</div>
          <h4>Whoba Ogo Foundation (WOF) ICT Center — Empowering the Next Generation</h4>
          <a href="#" class="nc-link">Read More →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA ────────────────────────────────────────── -->
<section class="sec">
  <div class="cta-row">
    <div class="cta-card red rev">
      <h3>Help Us Touch More Lives</h3>
      <p>Your contribution — big or small — funds free ICT training, educational support, and healthcare access for those who need it most in Nigeria.</p>
      <a href="donate.php" class="btn-white red-text">Donate Today ♥</a>
    </div>
    <div class="cta-card teal rev d1">
      <h3>Get in Touch With Us</h3>
      <p>Ready to partner, volunteer, or learn more about our work? We'd love to hear from you.</p>
      <a href="contact.php" class="btn-white teal-text">Contact Us →</a>
      <div class="contact-items">
        <div class="ci">
          <span class="ci-ico">📍</span>
          No. 1 Tafawa Balewa Crescent, Surulere, Lagos
        </div>
        <div class="ci">
          <span class="ci-ico">✉</span>
          inquiry@whobaogofoundation.org
        </div>
        <div class="ci">
          <span class="ci-ico">📞</span>
          08180452165
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── NEWSLETTER ─────────────────────────────────── -->
<div class="newsletter">
  <div class="newsletter-inner">
    <div>
      <h4>Newsletter</h4>
      <p>Sign up for our mailing list to get latest updates and offers</p>
    </div>
    <form class="newsletter-form" onsubmit="return false;">
      <input type="email" placeholder="Enter your email address" aria-label="Email address">
      <button type="submit">Subscribe</button>
    </form>
  </div>
</div>

</main>

<!-- ── FOOTER ─────────────────────────────────────── -->
<footer>
  <div class="footer-main">
    <div class="f-about">
      <a href="index.php" class="logo" style="margin-bottom:0.2rem;">
        <div class="logo-orb">♥</div>
        <div class="logo-text">
          <strong style="color:#fff;">Whoba Ogo Foundation</strong>
          <small style="color:rgba(255,255,255,0.35);">...touching lives</small>
        </div>
      </a>
      <p>We are a social impact organization committed to bringing about enhanced education and better health care for people in Nigeria.</p>
      <div style="display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1.3rem;">
        <span style="font-size:0.8rem;color:rgba(255,255,255,0.45);display:flex;gap:0.5rem;align-items:center;">
          <span style="opacity:0.6;">📍</span> No. 1 Tafawa Balewa Crescent, Surulere Lagos
        </span>
        <a href="mailto:inquiry@whobaogofoundation.org" style="font-size:0.8rem;color:rgba(255,255,255,0.45);display:flex;gap:0.5rem;align-items:center;transition:color 0.2s;" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">
          <span style="opacity:0.6;">✉</span> inquiry@whobaogofoundation.org
        </a>
        <a href="tel:08180452165" style="font-size:0.8rem;color:rgba(255,255,255,0.45);display:flex;gap:0.5rem;align-items:center;transition:color 0.2s;" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">
          <span style="opacity:0.6;">📞</span> 08180452165
        </a>
      </div>
      <div class="f-socials">
        <a href="#" class="f-soc" title="Facebook">f</a>
        <a href="#" class="f-soc" title="Twitter">𝕏</a>
        <a href="#" class="f-soc" title="Google+">G+</a>
        <a href="#" class="f-soc" title="LinkedIn">in</a>
      </div>
    </div>

    <div class="f-col">
      <h5>Quick Links</h5>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="our-work.php">Our Work</a></li>
        <li><a href="ict-hub.php">ICT Hub</a></li>
        <li><a href="testimonials.php">Testimonials</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
    </div>

    <div class="f-col">
      <h5>Programs</h5>
      <ul>
        <li><a href="our-work.php">Skill Development</a></li>
        <li><a href="our-work.php">Education Support</a></li>
        <li><a href="our-work.php">Health Support</a></li>
        <li><a href="ict-hub.php">ICT Training Hub</a></li>
      </ul>
    </div>

    <div class="f-col">
      <h5>Get Involved</h5>
      <ul>
        <li><a href="donate.php">Donate Now</a></li>
        <li><a href="contact.php">Volunteer</a></li>
        <li><a href="contact.php">Partner With Us</a></li>
        <li><a href="testimonials.php">Testimonials</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bar">
    <p>
      <a href="index.php">Whoba Ogo Foundation</a> · Copyright <?php echo date('Y'); ?>. All Rights Reserved.
    </p>
    <p>Built with ♥ for the communities of Nigeria</p>
  </div>
</footer>

<script>
  // Sticky nav shadow
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  }, { passive: true });

  // Hamburger / mobile nav
  const hamburger = document.getElementById('hamburger');
  const mobileNav = document.getElementById('mobileNav');
  hamburger.addEventListener('click', () => {
    const open = hamburger.classList.toggle('open');
    mobileNav.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
  });
  // Close on link click
  mobileNav.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      hamburger.classList.remove('open');
      mobileNav.classList.remove('open');
      document.body.style.overflow = '';
    });
  });

  // Scroll reveal
  const revEls = document.querySelectorAll('.rev');
  const ro = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('in'); ro.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  revEls.forEach(el => ro.observe(el));
</script>
</body>
</html>