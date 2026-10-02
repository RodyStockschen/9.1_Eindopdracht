<?php
// nieuw project toevoegen, alleen als je ingelogd bent
require_once 'includes/check_login.php';
require_once 'database.php';

$pageTitle = 'Project toevoegen';
$errors = [];

// lege waardes, komen in het formulier te staan
$title             = '';
$short_description = '';
$description       = '';
$type              = '';
$year              = date('Y');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // pakken wat er is ingevuld
    $title             = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $description       = trim($_POST['description'] ?? '');
    $type              = trim($_POST['type'] ?? '');
    $year              = trim($_POST['year'] ?? '');

    // checken of alles is ingevuld
    if ($title === '')             $errors[] = 'Titel is verplicht.';
    if ($short_description === '') $errors[] = 'Korte omschrijving is verplicht.';
    if ($description === '')       $errors[] = 'Lange omschrijving is verplicht.';
    if ($type === '')              $errors[] = 'Type is verplicht.';
    if ($year === '' || !ctype_digit($year)) $errors[] = 'Vul een geldig jaar in (bv. 2026).';

    // een plaatje uploaden 
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $errors[] = 'Alleen jpg, jpeg, png of webp afbeeldingen zijn toegestaan.';
        } else {
            // bestand een eigen naam geven, zo kunnen er geen twee bestanden hetzelfde heten
            $imageName = uniqid('project_', true) . '.' . $ext;
            $target    = 'uploads/' . $imageName;
            // zet het tijdelijk in temp, dan over naar bestand folder
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $errors[] = 'Afbeelding kon niet worden opgeslagen.';
                $imageName = null;
            }
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Er ging iets mis met het uploaden van de afbeelding.';
    }

    // als er niks fout ging, project opslaan in de database
    if (count($errors) === 0) {
        $stmt = $pdo->prepare(
            "INSERT INTO projects (title, short_description, description, type, year, image)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$title, $short_description, $description, $type, $year, $imageName]);

        // daarna terug naar de startpagina
        header("Location: index.php");
        exit;
    }
}

include 'includes/header.php';
?>

<h1 class="mb-3">Nieuw project toevoegen</h1>

<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
                <li><?php echo htmlspecialchars($e); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="add.php" enctype="multipart/form-data" class="card card-body shadow-sm">
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
            <label class="form-label">Type (bijv. website, webapp, blog)</label>
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
        <label class="form-label">Afbeelding (optioneel)</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Toegestaan: jpg, jpeg, png, webp</small>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Opslaan</button>
        <a href="index.php" class="btn btn-outline-secondary">Annuleren</a>
    </div>
</form>

<?php include 'includes/footer.php'; ?>
