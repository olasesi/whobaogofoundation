<?php
require_once __DIR__ .'/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

// Already logged in — go to dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Please enter your email and password.';

    } else {
        $stmt = $pdo->prepare(
            "SELECT id, name, email, password, role, is_active
             FROM   admins
             WHERE  email = :email
             LIMIT  1"
        );
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($password, $admin['password'])) {
            $error = 'Invalid email or password.';

        } elseif ((int) $admin['is_active'] === 0) {
            $error = 'Your account has been deactivated. Contact the super admin.';

        } else {
            // Successful login — set session
            session_regenerate_id(true);
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_role'] = $admin['role'];

            // Update last login timestamp
            $pdo->prepare("UPDATE admins SET last_login_at = NOW() WHERE id = :id")
                ->execute([':id' => $admin['id']]);

            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login — Whoba Ogo Foundation</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
  <style>
    :root {
      --red:       #E03535;
      --red-dark:  #B52020;
      --red-soft:  #FDE8E8;
      --teal:      #0D9B7E;
      --teal-soft: #E0F7F2;
      --ink:       #111713;
      --ink-mid:   #3B4840;
      --ink-light: #7A8C85;
      --border:    #E2E8E4;
      --white:     #FFFFFF;
      --surface:   #F7F7F4;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--ink);
      min-height: 100vh;
      display: flex;
      -webkit-font-smoothing: antialiased;
      overflow: hidden;
    }

    /* ── LEFT PANEL ─────────────────────────────── */
    .left-panel {
      flex: 1;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3rem;
      background: linear-gradient(155deg, #3A0808 0%, #1A0404 60%, #0A1A14 100%);
      overflow: hidden;
    }

    /* Decorative glows */
    .left-panel::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(ellipse at 20% 30%,  rgba(224,53,53,0.22) 0%, transparent 55%),
        radial-gradient(ellipse at 80% 80%,  rgba(13,155,126,0.15) 0%, transparent 50%),
        radial-gradient(ellipse at 60% 10%,  rgba(245,166,35,0.08) 0%, transparent 40%);
      pointer-events: none;
    }

    /* Dot grid texture */
    .left-panel::after {
      content: '';
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
      background-size: 28px 28px;
      pointer-events: none;
    }

    .panel-top, .panel-mid, .panel-bottom {
      position: relative; z-index: 1;
    }

    .panel-logo {
      display: flex; align-items: center; gap: 0.75rem;
    }
    .logo-orb {
      width: 42px; height: 42px; border-radius: 12px;
      background: linear-gradient(135deg, var(--red), var(--red-dark));
      display: flex; align-items: center; justify-content: center;
      font-size: 1.15rem; color: #fff;
      box-shadow: 0 6px 18px rgba(224,53,53,0.45);
      flex-shrink: 0;
    }
    .logo-text strong {
      display: block; font-size: 0.9rem; font-weight: 800; color: #fff;
    }
    .logo-text small {
      font-size: 0.6rem; color: rgba(255,255,255,0.4);
      letter-spacing: 0.05em;
    }

    .panel-mid h2 {
      font-family: 'Fraunces', serif;
      font-size: clamp(2rem, 3.5vw, 3.2rem);
      font-weight: 900;
      color: #fff;
      line-height: 1.1;
      letter-spacing: -0.03em;
      margin-bottom: 1rem;
    }
    .panel-mid h2 em {
      font-style: italic;
      color: #FF8A8A;
    }
    .panel-mid p {
      font-size: 0.9rem;
      color: rgba(255,255,255,0.45);
      line-height: 1.7;
      max-width: 320px;
    }

    .panel-stats {
      display: flex; gap: 2rem;
    }
    .pstat-num {
      font-family: 'Fraunces', serif;
      font-size: 1.8rem; font-weight: 900;
      color: var(--red); line-height: 1;
    }
    .pstat-label {
      font-size: 0.7rem; color: rgba(255,255,255,0.4);
      margin-top: 0.25rem; font-weight: 500;
    }
    .pstat-divider {
      width: 1px; background: rgba(255,255,255,0.08); align-self: stretch;
    }

    /* ── RIGHT PANEL ─────────────────────────────── */
    .right-panel {
      width: 480px;
      flex-shrink: 0;
      background: var(--white);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 3rem 3.5rem;
      position: relative;
    }

    .right-panel::before {
      content: '';
      position: absolute; top: 0; left: 0; bottom: 0;
      width: 1px;
      background: linear-gradient(
        to bottom,
        transparent,
        var(--border) 20%,
        var(--border) 80%,
        transparent
      );
    }

    .form-header { margin-bottom: 2.2rem; }
    .form-eyebrow {
      display: inline-flex; align-items: center; gap: 0.4rem;
      font-size: 0.68rem; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.14em;
      color: var(--red); margin-bottom: 0.6rem;
    }
    .form-eyebrow::before {
      content: ''; width: 14px; height: 2.5px;
      background: var(--red); border-radius: 2px;
    }
    .form-header h1 {
      font-family: 'Fraunces', serif;
      font-size: 1.9rem; font-weight: 900;
      color: var(--ink); letter-spacing: -0.02em;
      line-height: 1.15;
    }
    .form-header p {
      font-size: 0.84rem; color: var(--ink-light);
      margin-top: 0.4rem; line-height: 1.6;
    }

    /* Error alert */
    .alert-error {
      background: var(--red-soft);
      border: 1px solid rgba(224,53,53,0.25);
      border-left: 3px solid var(--red);
      border-radius: 8px;
      padding: 0.75rem 1rem;
      margin-bottom: 1.5rem;
      display: flex; align-items: flex-start; gap: 0.6rem;
      font-size: 0.83rem; color: var(--red-dark);
      font-weight: 500;
      animation: shake 0.4s ease;
    }
    .alert-error span { font-size: 1rem; flex-shrink: 0; }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%       { transform: translateX(-5px); }
      40%       { transform: translateX(5px); }
      60%       { transform: translateX(-3px); }
      80%       { transform: translateX(3px); }
    }

    /* Form fields */
    .field { margin-bottom: 1.2rem; }
    .field label {
      display: block;
      font-size: 0.76rem; font-weight: 700;
      color: var(--ink-mid);
      margin-bottom: 0.45rem;
      letter-spacing: 0.02em;
    }

    .input-wrap {
      position: relative;
    }
    .input-icon {
      position: absolute; left: 0.95rem; top: 50%; transform: translateY(-50%);
      font-size: 0.95rem; opacity: 0.4; pointer-events: none;
      transition: opacity 0.2s;
    }
    .input-wrap:focus-within .input-icon { opacity: 0.8; }

    .field input {
      width: 100%;
      padding: 0.78rem 1rem 0.78rem 2.6rem;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 0.88rem;
      font-family: inherit;
      color: var(--ink);
      background: var(--surface);
      transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
      outline: none;
    }
    .field input::placeholder { color: var(--ink-light); opacity: 0.7; }
    .field input:focus {
      border-color: var(--red);
      background: var(--white);
      box-shadow: 0 0 0 3px rgba(224,53,53,0.1);
    }

    /* Password toggle */
    .toggle-pw {
      position: absolute; right: 0.95rem; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      font-size: 0.9rem; opacity: 0.4;
      transition: opacity 0.2s; padding: 0.2rem;
    }
    .toggle-pw:hover { opacity: 0.8; }

    /* Remember me row */
    .form-row {
      display: flex; align-items: center;
      justify-content: space-between;
      margin-bottom: 1.6rem; flex-wrap: wrap; gap: 0.5rem;
    }
    .checkbox-label {
      display: flex; align-items: center; gap: 0.5rem;
      font-size: 0.8rem; color: var(--ink-mid); cursor: pointer;
      user-select: none;
    }
    .checkbox-label input[type="checkbox"] {
      width: 16px; height: 16px;
      accent-color: var(--red);
      cursor: pointer;
    }
    .forgot-link {
      font-size: 0.78rem; font-weight: 600;
      color: var(--red); text-decoration: none;
      transition: color 0.2s;
    }
    .forgot-link:hover { color: var(--red-dark); }

    /* Submit button */
    .btn-login {
      width: 100%;
      padding: 0.88rem;
      background: var(--red);
      color: #fff;
      border: none; border-radius: 10px;
      font-size: 0.9rem; font-weight: 800;
      font-family: inherit;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 0.5rem;
      box-shadow: 0 6px 20px rgba(224,53,53,0.35);
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      letter-spacing: 0.01em;
    }
    .btn-login:hover {
      background: var(--red-dark);
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(224,53,53,0.45);
    }
    .btn-login:active { transform: translateY(0); }
    .btn-login .arrow {
      width: 22px; height: 22px; border-radius: 50%;
      background: rgba(255,255,255,0.2);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.78rem;
    }

    .form-footer {
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--border);
      text-align: center;
      font-size: 0.76rem; color: var(--ink-light);
    }
    .form-footer a {
      color: var(--teal); font-weight: 600; text-decoration: none;
      transition: color 0.2s;
    }
    .form-footer a:hover { color: var(--ink); }

    /* Page load animation */
    .right-panel { animation: slideIn 0.5s 0.1s cubic-bezier(.25,.46,.45,.94) both; }
    @keyframes slideIn {
      from { opacity: 0; transform: translateX(20px); }
      to   { opacity: 1; transform: translateX(0); }
    }
    .left-panel .panel-mid { animation: fadeUp 0.7s 0.2s ease both; }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── RESPONSIVE ─────────────────────────────── */
    @media (max-width: 860px) {
      body { flex-direction: column; overflow: auto; }
      .left-panel { flex: none; padding: 2rem 1.5rem; min-height: 220px; }
      .panel-mid h2 { font-size: 1.7rem; }
      .panel-mid p, .panel-stats { display: none; }
      .right-panel { width: 100%; padding: 2rem 1.5rem 3rem; }
      .right-panel::before { display: none; }
    }

    @media (max-width: 480px) {
      .right-panel { padding: 1.5rem 1.25rem 2.5rem; }
      .form-header h1 { font-size: 1.55rem; }
    }
  </style>
</head>
<body>

  <!-- ── LEFT PANEL ──────────────────────────────────── -->
  <div class="left-panel">
    <div class="panel-top">
      <div class="panel-logo">
        <div class="logo-text">
          <a href="index.php" class="logo"> <img src="./../assets/images/logo.png" alt="Whoba Ogo Foundation" style="height: 48px; width: auto;"></a>
        </div>
      </div>
    </div>

    <div class="panel-mid">
      <h2>Welcome<br>back to the<br><em>Admin Panel</em></h2>
      <p>Manage posts, programs, gallery, comments and site settings all in one place.</p>
    </div>

    <div class="panel-bottom">
      <div class="panel-stats">
        <div>
          <div class="pstat-num">3K+</div>
          <div class="pstat-label">Lives Touched</div>
        </div>
        <div class="pstat-divider"></div>
        <div>
          <div class="pstat-num">450+</div>
          <div class="pstat-label">ICT Graduates</div>
        </div>
        <div class="pstat-divider"></div>
        <div>
          <div class="pstat-num">2018</div>
          <div class="pstat-label">Founded</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── RIGHT PANEL ─────────────────────────────────── -->
  <div class="right-panel">
    <div class="form-header">
      <div class="form-eyebrow">Admin Access</div>
      <h1>Sign in to your account</h1>
      <p>Enter your credentials to access the dashboard.</p>
    </div>

    <?php if ($error): ?>
      <div class="alert-error" role="alert">
        <span>⚠</span>
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" novalidate>

      <div class="field">
        <label for="email">Email Address</label>
        <div class="input-wrap">
          <span class="input-icon">✉</span>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="admin@whobaogofoundation.org"
            value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            required
            autocomplete="email"
            autofocus
          >
        </div>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <span class="input-icon">🔒</span>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
            autocomplete="current-password"
          >
          <button type="button" class="toggle-pw" id="togglePw" aria-label="Show password">
            👁
          </button>
        </div>
      </div>

      <div class="form-row">
        <label class="checkbox-label">
          <input type="checkbox" name="remember" value="1">
          Remember me
        </label>
        <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" class="btn-login">
        Sign In
        <span class="arrow">→</span>
      </button>

    </form>

    <div class="form-footer">
      <a href="../index.php">← Back to main website</a>
    </div>
  </div>

  <script>
    // Password show/hide toggle
    const pwInput  = document.getElementById('password');
    const togglePw = document.getElementById('togglePw');

    togglePw.addEventListener('click', () => {
      const isText = pwInput.type === 'text';
      pwInput.type       = isText ? 'password' : 'text';
      togglePw.textContent = isText ? '👁' : '🙈';
    });
  </script>

</body>
</html>