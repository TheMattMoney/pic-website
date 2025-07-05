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
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Custom Theme CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap-theme.css">
  
  <!-- Preload fonts -->
  <link rel="preload" href="assets/fonts/atkinson-bold.woff" as="font" type="font/woff" crossorigin>
  <link rel="preload" href="assets/fonts/atkinson-regular.woff" as="font" type="font/woff" crossorigin>
</head>
<body>
  <div class="parallax-background"></div>
  
  <!-- Bootstrap Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="assets/images/logo-xprnt.png" alt="Plastic Instruments Logo" height="48">
      </a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="archive/index.html">Archive</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container" style="padding-top: 120px;">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">
        <?php if ($error): ?>
          <div class="alert alert-danger" role="alert"><?=htmlspecialchars($error)?></div>
        <?php elseif ($video): ?>
          <h1 class="text-center mb-4" style="text-shadow: 2px 2px 8px #222;"><?=htmlspecialchars($video['title'])?></h1>
          
          <div class="ratio ratio-16x9 mb-4">
            <iframe src="https://www.youtube.com/embed/<?=htmlspecialchars($video['id'])?>"
                    allowfullscreen
                    title="YouTube video player for <?=htmlspecialchars($video['title'])?>"
                    aria-label="YouTube video player for <?=htmlspecialchars($video['title'])?>"></iframe>
          </div>
          
          <div class="text-center mb-3" style="color: #ffd700;">
            <small>
              Published: <?=htmlspecialchars($video['published_at'])?>
              <?php if (!empty($video['channel_title'])): ?>
                &nbsp;|&nbsp; Channel: <?=htmlspecialchars($video['channel_title'])?>
              <?php endif; ?>
            </small>
          </div>
          
          <div class="card mb-4">
            <div class="card-body">
              <div style="white-space: pre-line;"><?=nl2br(htmlspecialchars($video['description']))?></div>
            </div>
          </div>
          
          <div class="text-center">
            <a href="index.php" class="btn btn-outline-primary" aria-label="Back to Home">&larr; Back to Home</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  </div>
  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Vanilla JS Tiled Parallax -->
  <script src="assets/js/parallax-tiled.js"></script>
</body>
</html> 