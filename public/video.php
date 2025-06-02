<?php
// video.php - Video detail page

function get_video_by_id($db_path, $id) {
    if (!file_exists($db_path)) {
        return [null, 'Database not found.'];
    }
    if (!$id) {
        return [null, 'No video ID specified.'];
    }
    try {
        $db = new SQLite3($db_path, SQLITE3_OPEN_READONLY);
        $stmt = $db->prepare('SELECT * FROM videos WHERE id = :id');
        $stmt->bindValue(':id', $id, SQLITE3_TEXT);
        $result = $stmt->execute();
        $video = $result->fetchArray(SQLITE3_ASSOC);
        $db->close();
        if (!$video) {
            return [null, 'Video not found.'];
        }
        return [$video, null];
    } catch (Exception $e) {
        return [null, 'Database error: ' . htmlspecialchars($e->getMessage())];
    }
}

$db_path = realpath(__DIR__ . '/../db/videos.db');
$id = isset($_GET['id']) ? $_GET['id'] : '';
[$video, $error] = get_video_by_id($db_path, $id);
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($video) && $video ? htmlspecialchars($video['title']) . ' - ' : '' ?>Plastic Instruments</title>
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
      background: none;
    }
    .parallax-background {
      position: fixed;
      top: 0; left: 0; width: 100vw; height: 100vh;
      z-index: -1;
      background: url('images/bk-three.png') no-repeat center center, #111;
      background-size: cover;
      will-change: background-position;
      pointer-events: none;
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
      max-width: 800px;
      margin: 0 auto;
      padding: 120px 2vw 2vw 2vw;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    h1 {
      font-family: 'Atkinson Bold', Arial, sans-serif;
      font-size: 2rem;
      color: #fff;
      text-shadow: 2px 2px 8px #222;
      margin-bottom: 1rem;
      text-align: center;
    }
    .video-embed {
      width: 100%;
      max-width: 720px;
      aspect-ratio: 16/9;
      margin-bottom: 1.5rem;
      background: #222;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 16px #2228;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    iframe {
      width: 100%;
      height: 100%;
      border: none;
      display: block;
    }
    .video-meta {
      color: #ffd700;
      font-family: 'Atkinson Bold', Arial, sans-serif;
      margin-bottom: 0.5rem;
      text-align: center;
    }
    .video-desc {
      background: rgba(0,0,0,0.7);
      color: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      font-size: 1.1rem;
      box-shadow: 0 2px 16px #2228;
      white-space: pre-line;
      text-align: left;
      width: 100%;
      max-width: 720px;
    }
    .back-link {
      display: inline-block;
      margin-top: 1rem;
      color: #ffd700;
      font-family: 'Atkinson Bold', Arial, sans-serif;
      text-decoration: none;
      font-size: 1.1rem;
      transition: color 0.2s;
    }
    .back-link:hover {
      color: #fff;
      text-decoration: underline;
    }
    .error-message {
      background: rgba(255,0,0,0.1);
      color: #b00;
      border-radius: 10px;
      padding: 1.5rem;
      margin: 2rem auto;
      font-size: 1.2rem;
      box-shadow: 0 2px 16px #2224;
      text-align: center;
      max-width: 600px;
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
        font-size: 1.3rem;
      }
      .video-embed {
        max-width: 100vw;
      }
      .video-desc {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="parallax-background"></div>
  <nav class="navbar">
    <a href="index.php"><img src="images/logo-xprnt.png" alt="Plastic Instruments Logo" class="navbar-logo"></a>
    <div class="navbar-links">
      <a href="archive/index.html" class="navbar-link">Archive</a>
      <a href="contact.html" class="navbar-link">Contact</a>
    </div>
  </nav>
  <div class="main-content">
    <?php if ($error): ?>
      <div class="error-message" role="alert"><?=htmlspecialchars($error)?></div>
    <?php elseif ($video): ?>
      <h1><?=htmlspecialchars($video['title'])?></h1>
      <div class="video-embed">
        <iframe src="https://www.youtube.com/embed/<?=htmlspecialchars($video['id'])?>"
                allowfullscreen
                title="YouTube video player for <?=htmlspecialchars($video['title'])?>"
                aria-label="YouTube video player for <?=htmlspecialchars($video['title'])?>"></iframe>
      </div>
      <div class="video-meta">
        Published: <?=htmlspecialchars($video['published_at'])?>
        <?php if (!empty($video['channel_title'])): ?>
          &nbsp;|&nbsp; Channel: <?=htmlspecialchars($video['channel_title'])?>
        <?php endif; ?>
      </div>
      <div class="video-desc"><?=nl2br(htmlspecialchars($video['description']))?></div>
      <a href="index.php" class="back-link" aria-label="Back to Home">&larr; Back to Home</a>
    <?php endif; ?>
  </div>
  <script>
    window.addEventListener('scroll', function() {
      var scrolled = window.pageYOffset;
      var pos = Math.max(-500, Math.min(scrolled * 0.4, 500));
      document.querySelector('.parallax-background').style.backgroundPosition = 'center ' + pos + 'px';
    });
  </script>
</body>
</html> 