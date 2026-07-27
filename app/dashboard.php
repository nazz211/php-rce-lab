<?php
session_start();

$warning = 'WARNING: Intentionally Vulnerable Cybersecurity Lab. Run only on localhost or an isolated test network. Never expose this application to the public internet.';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'] ?? 'lab';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            <h1>Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>.</p>
            <p>This lab intentionally allows uploaded PHP files to be placed under the web root so they can be executed by the PHP runtime.</p>
        </section>
    </main>
</body>
</html>
