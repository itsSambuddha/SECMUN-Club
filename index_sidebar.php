<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Responsive Navbar</title>
  <link rel="stylesheet" href="sidebar_style.css" />
</head>
<body>
  <nav class="menubar" id="menubar">
    <a href="about.php" class="menubar-item">SECMUN Club</a>
    <ul class="menubar-menu original-menu">
      <li><a href="secretariat.php">Secretariat</a></li>
      <li><a href="learn_mun.php">Learn MUN</a></li>
      <li><a href="gazette.php">The SECMUN Gazette</a></li>
      <li><a href="event.php"> Events of SECMUN </a></li>
    </ul>
    <ul class="menubar-menu nav-links-menu">
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="logout.php" class="nav-link">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
      <?php if (!empty($_SESSION['is_admin']) || (isset($_SESSION['role']) && in_array($_SESSION['role'], ['President', 'Secretary General', 'Assistant Secretary General', 'Teacher', 'TopAdmin']))): ?>
          <li><a href="dashboard_topadmin.php"><button class="log">Admin Dashboard</button></a></li>
        <?php endif; ?>
      <?php else: ?>
        <li><a href="login_signup.php?mode=login&role=user"><button class="log">Login / Sign Up</button></a></li>
      <?php endif; ?>
      <li><a href="secretariat.php" class="nav-link">Secretariat</a></li>
      <li><a href="learn_mun.php" class="nav-link">Learn MUN</a></li>
      <li><a href="gazette.php" class="nav-link">The SECMUN Gazette</a></li>
      <li><a href="event.php" class="nav-link"> Events of SECMUN </a></li>
      <li><a href="index.php" class="nav-link">Home</a></li>
      <li><a href="about.php" class="nav-link">About</a></li>
      <li><a href="achievements.php" class="nav-link">Achievements</a></li>
      <!-- <li><a href="gazette.php" class="nav-link">The SECMUN Gazette</a></li> -->
      <li><a href="contact.php" class="nav-link">Connect with Us</a></li>
      
    </ul>
  </nav>
  <button class="menubar-toggle" id="menubar-toggle" aria-label="Toggle menu">
    <span>Our Menu</span>
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
  </button>
  <script>
    const menubarToggle = document.getElementById('menubar-toggle');
    const menubar = document.getElementById('menubar');

    menubarToggle.addEventListener('click', () => {
      menubarToggle.classList.toggle('active');
      menubar.classList.toggle('active');
    });
  </script>
</body>
</html>
