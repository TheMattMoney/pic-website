<?php
// index.php - Home page: Video grid
$db_path = realpath(__DIR__ . '/../db/videos.db');
if (!file_exists($db_path)) {
    die('<h1>Database not found.</h1>');
}
$videos = [];
try {
    $db = new SQLite3($db_path, SQLITE3_OPEN_READONLY);
    $result = $db->query('SELECT id, title, thumbnail_url FROM videos ORDER BY published_at DESC');
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $videos[] = $row;
    }
    $db->close();
} catch (Exception $e) {
    die('<h1>Database error: ' . htmlspecialchars($e->getMessage()) . '</h1>');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plastic Instruments Video Grid</title>
  <link rel="preload" href="assets/fonts/atkinson-bold.woff" as="font" type="font/woff" crossorigin>
  <link rel="preload" href="assets/fonts/atkinson-regular.woff" as="font" type="font/woff" crossorigin>
  <style>
    @font-face {
      font-family: 'Atkinson Bold';
      src: url('assets/fonts/atkinson-bold.woff') format('woff');
      font-weight: bold;
      font-style: normal;
    }
    @font-face {
      font-family: 'Atkinson Regular';
      src: url('assets/fonts/atkinson-regular.woff') format('woff');
      font-weight: normal;
      font-style: normal;
    }
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: 'Atkinson Regular', Arial, sans-serif;
      color: #222;
      background: url('images/bk-one.png') no-repeat center center fixed;
      background-size: cover;
      background-attachment: fixed;
      background-position: center 0;
    }
    .navbar {
      width: 100%;
      background: rgba(0,0,0,0.85);
      display: flex;
      align-items: center;
      padding: 0.5rem 2rem;
      box-sizing: border-box;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }
    .navbar-logo {
      height: 48px;
      margin-right: 2rem;
    }
    .navbar-links {
      display: flex;
      gap: 2rem;
    }
    .navbar-link {
      color: #fff;
      text-decoration: none;
      font-family: 'Atkinson Bold', Arial, sans-serif;
      font-size: 1.1rem;
      letter-spacing: 1px;
      transition: color 0.2s;
    }
    .navbar-link:hover {
      color: #ffd700;
    }
    .main-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 120px 2vw 2vw 2vw;
    }
    h1 {
      font-family: 'Atkinson Bold', Arial, sans-serif;
      font-size: 2.2rem;
      color: #fff;
      text-shadow: 2px 2px 8px #222;
      margin-bottom: 2rem;
      text-align: center;
    }
    .video-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 2rem;
    }
    .video-card {
      background: rgba(0,0,0,0.7);
      border-radius: 10px;
      box-shadow: 0 2px 16px #2228;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.15s;
    }
    .video-card:hover {
      transform: translateY(-4px) scale(1.03);
      box-shadow: 0 4px 24px #222b;
    }
    .video-thumb {
      width: 100%;
      aspect-ratio: 16/9;
      object-fit: cover;
      background: #222;
      border-bottom: 1px solid #333;
    }
    .video-title {
      font-family: 'Atkinson Bold', Arial, sans-serif;
      color: #ffd700;
      font-size: 1.1rem;
      padding: 1rem;
      text-align: center;
      flex: 1 1 auto;
      text-decoration: none;
      min-height: 3em;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    @media (max-width: 600px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
        padding: 0.5rem 1rem;
      }
      .navbar-logo {
        height: 36px;
        margin-bottom: 0.5rem;
      }
      .navbar-links {
        gap: 1rem;
      }
      .main-content {
        padding-top: 80px;
      }
      h1 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <img src="images/logo-xprnt.png" alt="Plastic Instruments Logo" class="navbar-logo">
    <div class="navbar-links">
      <a href="index.php" class="navbar-link">Home</a>
      <a href="archive/index.html" class="navbar-link">Archive</a>
      <a href="contact.html" class="navbar-link">Contact</a>
    </div>
  </nav>
  <div class="main-content">
    <h1>Plastic Instruments Community Videos</h1>
    <div class="video-grid">
      <?php foreach ($videos as $video): ?>
        <a class="video-card" href="video.php?id=<?=urlencode($video['id'])?>">
          <img class="video-thumb" src="<?=htmlspecialchars($video['thumbnail_url'])?>" alt="Thumbnail for <?=htmlspecialchars($video['title'])?>">
          <div class="video-title"><?=htmlspecialchars($video['title'])?></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <script>
    window.addEventListener('scroll', function() {
      const scrolled = window.pageYOffset;
      document.body.style.backgroundPosition = 'center ' + (scrolled * 0.5) + 'px';
    });
  </script>
</body>
</html> 