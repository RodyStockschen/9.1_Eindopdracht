<?php
// detailpagina, laat één project zien, welke staat in de URL
require_once 'database.php';

$pageTitle = 'Project Detail';

// id uit de URL pakken en omzetten naar een getal, zo kan er geen tekst in zitten
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$project = null;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
}

include 'includes/header.php';
?>

<?php if (!$project): ?>
    <div class="alert alert-warning text-center">
        Project niet gevonden.
    </div>
    <div class="text-center">
        <a href="index.php" class="btn btn-outline-secondary">&larr; Terug naar overzicht</a>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
        <div class="project card shadow-sm card-body m-2">
            <?php if (!empty($project['image']) && file_exists('uploads/' . $project['image'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($project['image']); ?>"
                     alt="<?php echo htmlspecialchars($project['title']); ?>"
                     class="project-detail-image mb-3">
            <?php endif; ?>

            <div class="card-text">
                <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                <p><strong><?php echo htmlspecialchars($project['short_description']); ?></strong></p>
                <div><?php echo nl2br(htmlspecialchars($project['description'])); ?></div>
                <hr>
                <div>Type: <?php echo htmlspecialchars($project['type']); ?></div>
                <div>Jaar: <?php echo htmlspecialchars($project['year']); ?></div>
            </div>

            <div class="mt-3">
                <a href="index.php" class="btn btn-outline-secondary">&larr; Terug naar overzicht</a>
                <?php if ($ingelogd): ?>
                    <a href="edit.php?id=<?php echo (int) $project['id']; ?>"
                       class="btn btn-outline-primary">Edit</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
