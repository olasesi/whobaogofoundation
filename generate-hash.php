<?php
/**
 * TEMPORARY FILE — DELETE AFTER USE
 *
 * 1. Open this in your browser: http://localhost/generate-hash.php
 * 2. Copy the hash it outputs
 * 3. Run the UPDATE query shown below in your database
 * 4. DELETE this file immediately
 */

$password = 'P@$sword1';  // <-- change this to whatever password you want
$hash     = password_hash($password, PASSWORD_BCRYPT);
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: monospace; padding: 2rem; background: #111; color: #eee; }
    .box { background: #1e1e1e; border: 1px solid #333; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; }
    .hash { color: #4ade80; word-break: break-all; font-size: 0.95rem; }
    .sql  { color: #60a5fa; word-break: break-all; font-size: 0.9rem; }
    h2    { color: #f87171; margin-bottom: 0.5rem; }
    label { color: #aaa; font-size: 0.8rem; display: block; margin-bottom: 0.4rem; }
  </style>
</head>
<body>
  <h1>🔑 Hash Generator</h1>

  <div class="box">
    <label>PASSWORD USED:</label>
    <span><?= htmlspecialchars($password) ?></span>
  </div>

  <div class="box">
    <label>BCRYPT HASH (copy this):</label>
    <div class="hash"><?= $hash ?></div>
  </div>

  <div class="box">
    <label>RUN THIS IN YOUR DATABASE:</label>
    <div class="sql">
      UPDATE admins SET password = '<?= $hash ?>' WHERE email = 'admin@whobaogofoundation.org';
    </div>
  </div>

  <h2>⚠ DELETE THIS FILE NOW</h2>
</body>
</html>