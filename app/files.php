<?php
session_start();

$warning = 'WARNING: Intentionally Vulnerable Cybersecurity Lab. Run only on localhost or an isolated test network. Never expose this application to the public internet.';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$uploadDir = __DIR__ . '/uploads';
$files = [];
if (is_dir($uploadDir)) {
    $items = scandir($uploadDir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $fullPath = $uploadDir . '/' . $item;
        $files[] = [
            'name' => $item,
            'size' => filesize($fullPath),
            'modified' => date('Y-m-d H:i:s', filemtime($fullPath)),
            'url' => 'uploads/' . rawurlencode($item),
        ];
    }
}

usort($files, function ($a, $b) {
    return strcmp($a['name'], $b['name']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="warning-banner"><?php echo htmlspecialchars($warning, ENT_QUOTES, 'UTF-8'); ?></div>
    <main class="container">
        <nav class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="upload.php">Upload</a>
            <a href="files.php">Files</a>
            <a href="status.php">Status</a>
            <a href="logout.php">Logout</a>
        </nav>

        <section class="card">
            <h1>Uploaded Files</h1>
            <?php if (empty($files)): ?>
                <p>No files have been uploaded yet.</p>
            <?php else: ?>
                <ul class="file-list">
                    <?php foreach ($files as $file): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            <span><?php echo number_format($file['size']); ?> bytes</span>
                            <span>Modified: <?php echo htmlspecialchars($file['modified'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <a href="<?php echo htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">Open</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
