<?php
// deze header wordt op elke pagina ingeladen
// hier start ook de sessie, zo is bekend of iemand ingelogd is
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// klein variabeltje dat aangeeft of de bezoeker ingelogd is of niet
$ingelogd = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Portfolio Website'; ?></title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom mb-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">Portfolio</a>
        <div class="d-flex align-items-center">
            <a class="btn btn-sm btn-outline-secondary me-2" href="index.php">Projecten</a>
            <?php if ($ingelogd): ?>
                <a class="btn btn-sm btn-primary me-2" href="add.php">+ Project toevoegen</a>
                <span class="me-2 text-muted">Ingelogd als <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                <a class="btn btn-sm btn-outline-danger" href="logout.php">Uitloggen</a>
            <?php else: ?>
                <a class="btn btn-sm btn-outline-primary" href="login.php">Inloggen</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<main>
    <div class="container">
