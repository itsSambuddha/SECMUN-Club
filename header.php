<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>The SECMUN Club</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<header style="display: flex; justify-content: space-between; align-items: center; padding: 20px 100px;">
  <div style="display: flex; flex-direction: column; align-items: center; flex-grow: 1;">
    <h1 class="site-title">The SECMUN Club</h1>
    <nav>
      <a href="index.php" class="nav-link">Home</a>
      <a href="about.php" class="nav-link">About</a>
      <a href="achievements.php" class="nav-link">Achievements</a>
      <!-- <a href="gazette.php" class="nav-link">The SECMUN Gazette</a> -->
      <a href="contact.php" class ="nav-link"> Connect with Us </a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php" class="nav-link">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
        <?php if (!empty($_SESSION['is_admin'])): ?>
          <a href="dashboard_topadmin.php"><button class="log">Admin Dashboard</button></a>
        <?php endif; ?>
      <?php else: ?>
        <a href="login_signup.php?mode=login&role=user"><button class="log">Login / Sign Up</button></a>
      <?php endif; ?>
    </nav>
  </div>
  <img src="secmyn.png" alt="SECMUN Club Logo" class="site-logo" />
</header>
