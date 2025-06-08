<?php
// session_start();
include 'header.php';

// Customize your presentation titles and Google Slides embed links here
$presentations = [
    'Introduction to AI' => 'https://docs.google.com/presentation/d/e/2PACX-1vQmZf8kR8Uc4N2-JxzIqG8yZhQfWdsK3OZg9zcfu0ZC9YZ-M1e7kE8I6x7TyxYdU/pub?start=false&loop=false&delayms=3000',
    'Machine Learning Basics' => 'https://docs.google.com/presentation/d/e/2PACX-1vTtMgB9EcLKoq8F7aOGmLxVGgV7uv8_UWbk-VQskT6BpAnLwMZz6Xl9bY8YPK7ivw/pub?start=false&loop=false&delayms=3000'
];

// Detect if a specific presentation is selected
$selected = isset($_GET['slide']) ? $_GET['slide'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Presentation Viewer</title>
  <link rel="stylesheet" href="style.css">
  <style>
    iframe {
      width: 1200px; /* wider width to contain ppt without issues */
      height: 675px; /* 16:9 aspect ratio */
      max-width: 100%;
      border: none;
      margin-top: 1rem;
      margin-bottom: 40px; /* space between preview and footer */
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    .learnmun-form-container {
      max-width: 1200px;
      
      margin: 0 auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-bottom: 120px;
    }
    .learnmun-menu {
      list-style: none;
      padding-left: 0;
    }
    .learnmun-menu li {
      margin: 0.5rem 0;
    }
    .learnmun-menu li a {
      text-decoration: none;
      color: #007BFF;
      font-weight: 500;
    }
    .learnmun-menu li a:hover {
      text-decoration: underline;
    }
    .learnmun-button {
      display: inline-block;
      margin-top: 1rem;
      padding: 0.5rem 1rem;
      background-color: rgb(26, 94, 176);
      color: white;
      text-decoration: none;
      border-radius: 4px;
    }
    .learnmun-button:hover {
      background-color:rgb(61, 122, 179);
    }
    .learnmun-download-link {
      margin-top: 2rem;
    }
  </style>
</head>
<body>
  <main class="learnmun-form-container">
    <?php if ($selected && isset($presentations[$selected])): ?>
      <h2><?php echo htmlspecialchars($selected); ?></h2>
      <iframe src="<?php echo $presentations[$selected]; ?>" allowfullscreen></iframe>
      <a class="learnmun-button" href="?">Go Back</a>
    <?php else: ?>
      <h2>Select a Presentation</h2>
      <ul class="learnmun-menu">
        <?php foreach ($presentations as $name => $link): ?>
          <li><a href="?slide=<?php echo urlencode($name); ?>"><?php echo htmlspecialchars($name); ?></a></li>
        <?php endforeach; ?>
      </ul>

      <div class="learnmun-download-link">
        <h3>Download Resources</h3>
        <ul class="learnmun-menu">
          <?php
          $resourceDir = __DIR__ . '/uploads/resources/';
          $files = is_dir($resourceDir) ? scandir($resourceDir) : [];
          foreach ($files as $file) {
              if ($file !== '.' && $file !== '..') {
                  echo '<li><a href="uploads/resources/' . rawurlencode($file) . '" download>' . htmlspecialchars($file) . '</a></li>';
              }
          }
          ?>
        </ul>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
<?php
include 'footer.php';
?>
