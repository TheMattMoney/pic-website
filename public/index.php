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
  <div class="container-fluid" style="padding-top: 120px;">
    <div class="row justify-content-center">
      <div class="col-12">
        <h1 class="text-center mb-4" style="text-shadow: 2px 2px 8px #222;">Plastic Instruments Community Videos</h1>
      </div>
    </div>
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php foreach ($videos as $video): ?>
        <div class="col">
          <a href="video.php?id=<?=urlencode($video['id'])?>" class="text-decoration-none">
            <div class="card h-100">
              <img src="<?=htmlspecialchars($video['thumbnail_url'])?>" 
                   class="card-img-top" 
                   alt="Thumbnail for <?=htmlspecialchars($video['title'])?>"
                   style="aspect-ratio: 16/9; object-fit: cover;">
              <div class="card-body d-flex align-items-center justify-content-center text-center">
                <h5 class="card-title mb-0" style="color: #ffd700; font-size: 1.1rem; min-height: 3em; display: flex; align-items: center;">
                  <?=htmlspecialchars($video['title'])?>
                </h5>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Vanilla JS Tiled Parallax -->
  <script src="assets/js/parallax-tiled.js"></script>
</body>
</html> 