<?php
session_start();

$warning = 'WARNING: Intentionally Vulnerable Cybersecurity Lab. Run only on localhost or an isolated test network. Never expose this application to the public internet.';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$runtime = PHP_SAPI;
$phpVersion = PHP_VERSION;
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'unknown';
$documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? 'unknown';
$appDirectory = __DIR__;
$uploadDirectory = $appDirectory . '/uploads';
$currentUser = get_current_user();
$workingDirectory = getcwd();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
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
            <h1>Environment and Status</h1>
            <ul class="status-list">
                <li><strong>PHP SAPI:</strong> <?php echo htmlspecialchars($runtime, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>PHP Version:</strong> <?php echo htmlspecialchars($phpVersion, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Server Software:</strong> <?php echo htmlspecialchars($serverSoftware, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Document Root:</strong> <?php echo htmlspecialchars($documentRoot, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Application Directory:</strong> <?php echo htmlspecialchars($appDirectory, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Upload Directory:</strong> <?php echo htmlspecialchars($uploadDirectory, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Execution User:</strong> <?php echo htmlspecialchars($currentUser, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Working Directory:</strong> <?php echo htmlspecialchars($workingDirectory, ENT_QUOTES, 'UTF-8'); ?></li>
            </ul>
        </section>
    </main>
</body>
</html>
