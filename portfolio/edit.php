<?php
// project aanpassen, alleen als je ingelogd bent
require_once 'includes/check_login.php';
require_once 'database.php';

$pageTitle = 'Project aanpassen';
$errors = [];

// id van het project uit de URL pakken
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// dat project ophalen uit de database
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

// bestaat het project niet? dan een melding tonen
if (!$project) {
    include 'includes/header.php';
    echo '<div class="alert alert-warning text-center">Project niet gevonden.</div>';
    echo '<div class="text-center"><a href="index.php" class="btn btn-outline-secondary">&larr; Terug</a></div>';
    include 'includes/footer.php';
    exit;
}

// oude waardes alvast in het formulier zetten
$title             = $project['title'];
$short_description = $project['short_description'];
$description       = $project['description'];
$type              = $project['type'];
$year              = $project['year'];
$currentImage      = $project['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title             = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $description       = trim($_POST['description'] ?? '');
    $type              = trim($_POST['type'] ?? '');
    $year              = trim($_POST['year'] ?? '');

    if ($title === '')             $errors[] = 'Titel is verplicht.';
    if ($short_description === '') $errors[] = 'Korte omschrijving is verplicht.';
    if ($description === '')       $errors[] = 'Lange omschrijving is verplicht.';
    if ($type === '')              $errors[] = 'Type is verplicht.';
    if ($year === '' || !ctype_digit($year)) $errors[] = 'Vul een geldig jaar in.';

    // zonder nieuwe foto blijft de oude staan
    $newImageName = $currentImage;

    // kijken of er een nieuwe foto is geüpload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $errors[] = 'Alleen jpg, jpeg, png of webp afbeeldingen zijn toegestaan.';
        } else {
            $newImageName = uniqid('project_', true) . '.' . $ext;
            $target       = 'uploads/' . $newImageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $errors[] = 'Afbeelding kon niet worden opgeslagen.';
                $newImageName = $currentImage; // dan toch weer de oude gebruiken
            } else {
                // oude foto weggooien, geen troep laten staan
                if (!empty($currentImage) && file_exists('uploads/' . $currentImage)) {
                    unlink('uploads/' . $currentImage);
                }
            }
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Er ging iets mis met het uploaden van de afbeelding.';
    }

    if (count($errors) === 0) {
        $stmt = $pdo->prepare(
            "UPDATE projects
             SET title = ?, short_description = ?, description = ?, type = ?, year = ?, image = ?
             WHERE id = ?"
        );
        $stmt->execute([$title, $short_description, $description, $type, $year, $newImageName, $id]);

        header("Location: detail.php?id=" . $id);
        exit;
    }
}

include 'includes/header.php';
?>

<h1 class="mb-3">Project aanpassen</h1>

<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
                <li><?php echo htmlspecialchars($e); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="edit.php?id=<?php echo (int)$id; ?>" enctype="multipart/form-data" class="card card-body shadow-sm">
    <div class="mb-3">
        <label class="form-label">Titel</label>
        <input type="text" name="title" class="form-control" required
               value="<?php echo htmlspecialchars($title); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Korte omschrijving</label>
        <input type="text" name="short_description" class="form-control" required
               value="<?php echo htmlspecialchars($short_description); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Lange omschrijving</label>
        <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Type</label>
            <input type="text" name="type" class="form-control" required
                   value="<?php echo htmlspecialchars($type); ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Jaar</label>
            <input type="number" name="year" class="form-control" min="2000" max="2100" required
                   value="<?php echo htmlspecialchars($year); ?>">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Afbeelding</label><br>
        <?php if (!empty($currentImage) && file_exists('uploads/' . $currentImage)): ?>
            <img src="uploads/<?php echo htmlspecialchars($currentImage); ?>"
                 alt="Huidige afbeelding"
                 class="project-thumb mb-2">
            <div class="text-muted small mb-2">Huidige afbeelding</div>
        <?php else: ?>
            <div class="text-muted small mb-2">Nog geen afbeelding.</div>
        <?php endif; ?>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Laat leeg om de huidige afbeelding te behouden.</small>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Opslaan</button>
        <a href="detail.php?id=<?php echo (int)$id; ?>" class="btn btn-outline-secondary">Annuleren</a>
    </div>
</form>

<?php include 'includes/footer.php'; ?>
