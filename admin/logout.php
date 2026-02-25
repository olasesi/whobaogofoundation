<?php
session_start();

// Only allow POST requests — prevents logout via direct URL visit
 if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
     header('Location: dashboard.php');
     exit;
 }

session_unset();
session_destroy();

header('Location: index.php');
exit;