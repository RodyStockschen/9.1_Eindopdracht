<?php
// project verwijderen, alleen als je ingelogd bent
require_once 'includes/check_login.php';
require_once 'database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // eerst het project ophalen, want de foto moet ook weg
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if ($project) {
        // hoort er een foto bij? die van de server weggooien
        if (!empty($project['image']) && file_exists('uploads/' . $project['image'])) {
            unlink('uploads/' . $project['image']);
        }

        // nu het project uit de database halen
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// terug naar de startpagina
header("Location: index.php");
exit;
