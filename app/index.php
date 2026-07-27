<?php
session_start();

$warning = 'WARNING: Intentionally Vulnerable Cybersecurity Lab. Run only on localhost or an isolated test network. Never expose this application to the public internet.';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === 'lab' && $password === 'labpass') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    }

    $message = 'Invalid credentials. Hint: use lab / labpass.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="warning-banner"><?php echo htmlspecialchars($warning, ENT_QUOTES, 'UTF-8'); ?></div>
    <main class="container">
        <h1>Comparative Security Assessment Lab</h1>
        <p>This intentionally vulnerable local lab demonstrates how an unrestricted file-upload issue behaves in PM2 and Docker environments.</p>

        <?php if ($message !== ''): ?>
            <div class="message error"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form method="post" class="card">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>
