<?php
// dit bestand kijkt of de bezoeker ingelogd is
// bovenaan de pagina's zetten waar je alleen bij mag als je ingelogd bent
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // niet ingelogd? dan terug naar de login pagina
    header("Location: login.php");
    exit;
}
