<?php
session_start();

$warning = 'WARNING: Intentionally Vulnerable Cybersecurity Lab. Run only on localhost or an isolated test network. Never expose this application to the public internet.';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$message = '';
$uploadDir = __DIR__ . '/uploads';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!isset($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
        $message = 'Upload failed.';
    } else {
        $originalName = basename($_FILES['upload']['name']);
        $targetPath = $uploadDir . '/' . $originalName;

        // INTENTIONALLY INSECURE: this lab accepts any file extension, MIME type, or content.
        // No allowlist, no MIME validation, and no content inspection are applied.
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $targetPath)) {
            $message = 'Uploaded file stored at ' . htmlspecialchars($originalName, ENT_QUOTES, 'UTF-8');
        } else {
            $message = 'Upload move failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
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
            <h1>Unrestricted File Upload</h1>
            <?php if ($message !== ''): ?>
                <div class="message success"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data" class="card">
                <label for="upload">Choose a file</label>
                <input type="file" id="upload" name="upload" required>
                <button type="submit">Upload</button>
            </form>

            <p>Files are stored in the web-accessible uploads directory. This makes uploaded PHP files reachable through the web server.</p>
        </section>
    </main>
</body>
</html>
