<?php
$code = isset($_GET['code']) ? (int)$_GET['code'] : 404;

$errors = [
    403 => [
        'title' => 'Access Forbidden',
        'message' => 'You don\'t have permission to access this resource.',
        'emoji' => '🚫',
        'color' => '#E03535',
    ],
    404 => [
        'title' => 'Page Not Found',
        'message' => 'The page you\'re looking for doesn\'t exist or has been moved.',
        'emoji' => '🔍',
        'color' => '#0D9B7E',
    ],
    500 => [
        'title' => 'Internal Server Error',
        'message' => 'Something went wrong on our end. We\'re working to fix it.',
        'emoji' => '⚠️',
        'color' => '#F5A623',
    ],
];

$error = $errors[$code] ?? $errors[404];

http_response_code($code);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $code ?> — <?= htmlspecialchars($error['title'], ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Fraunces:wght@900&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: linear-gradient(160deg, #1A0404 0%, #0A1A14 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }

    /* Decorative glows */
    body::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(ellipse at 20% 30%, rgba(224,53,53,0.18) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 70%, rgba(13,155,126,0.12) 0%, transparent 50%);
      pointer-events: none;
    }

    /* Dot grid */
    body::after {
      content: '';
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
      background-size: 30px 30px;
      pointer-events: none;
    }

    .container {
      text-align: center;
      max-width: 560px;
      position: relative;
      z-index: 1;
      animation: fadeUp 0.6s ease;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .logo {
      display: inline-flex;
      align-items: center;
      gap: 0.65rem;
      margin-bottom: 2rem;
      opacity: 0.7;
    }
    .logo-orb {
      width: 36px; height: 36px;
      border-radius: 10px;
      background: linear-gradient(135deg, #E03535, #B52020);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      box-shadow: 0 4px 12px rgba(224,53,53,0.4);
    }
    .logo-text {
      font-size: 0.82rem;
      font-weight: 800;
      line-height: 1.2;
    }

    .error-code {
      font-family: 'Fraunces', serif;
      font-size: clamp(5rem, 15vw, 9rem);
      font-weight: 900;
      line-height: 1;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, #FF8A8A, <?= $error['color'] ?>);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.04em;
    }

    .error-emoji {
      font-size: clamp(3rem, 8vw, 4.5rem);
      display: block;
      margin-bottom: 1.5rem;
      animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .error-title {
      font-family: 'Fraunces', serif;
      font-size: clamp(1.6rem, 4vw, 2.2rem);
      font-weight: 900;
      line-height: 1.2;
      margin-bottom: 0.75rem;
      letter-spacing: -0.02em;
    }

    .error-message {
      font-size: clamp(0.95rem, 2vw, 1.05rem);
      line-height: 1.7;
      color: rgba(255,255,255,0.6);
      margin-bottom: 2.5rem;
    }

    .btn-home {
      display: inline-flex;
      align-items: center;
      gap: 0.55rem;
      background: #E03535;
      color: #fff;
      padding: 0.85rem 1.6rem;
      border-radius: 100px;
      font-size: 0.9rem;
      font-weight: 800;
      text-decoration: none;
      box-shadow: 0 6px 20px rgba(224,53,53,0.35);
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .btn-home:hover {
      background: #B52020;
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(224,53,53,0.45);
    }
    .btn-home .ico {
      width: 22px; height: 22px;
      border-radius: 50%;
      background: rgba(255,255,255,0.22);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
    }

    .error-meta {
      margin-top: 3rem;
      padding-top: 1.5rem;
      border-top: 1px solid rgba(255,255,255,0.08);
      font-size: 0.75rem;
      color: rgba(255,255,255,0.3);
    }

    @media (max-width: 480px) {
      body { padding: 1.5rem; }
      .error-code { font-size: 4rem; }
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="/" class="logo">
      <div class="logo-orb">♥</div>
      <div class="logo-text">Whoba Ogo Foundation</div>
    </a>

    <div class="error-emoji"><?= $error['emoji'] ?></div>
    <div class="error-code"><?= $code ?></div>
    <h1 class="error-title"><?= htmlspecialchars($error['title'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="error-message"><?= htmlspecialchars($error['message'], ENT_QUOTES, 'UTF-8') ?></p>

    <a href="/" class="btn-home">
      <span class="ico">←</span>
      Back to Home
    </a>

    <div class="error-meta">
      If you believe this is a mistake, please <a href="/contact" style="color:#7DFFD9;">contact us</a>.
    </div>
  </div>
</body>
</html>