<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Responsive Navbar</title>
  <link rel="stylesheet" href="sidebar_style.css" />
  <!-- <style>
    
  </style> -->
</head>
<body>
  <nav class="menubar" id="menubar">
    <a href="about.php" class="menubar-item">SECMUN Club</a>
    <ul class="menubar-menu">
      <li><a href="secretariat.php">Secretariat</a></li>
      <li><a href="learn_mun.php">Learn MUN</a></li>
      <li><a href="gazette.php">The SECMUN Gazette</a></li>
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
