<?php
// startpagina, hier komen alle projecten te staan
require_once 'database.php';

$pageTitle = 'Portfolio - Overzicht';

// zoekwoord uit de URL pakken (als die er staat)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// jaar uit de URL pakken, leeg = alle jaren
$filterYear = isset($_GET['year']) ? trim($_GET['year']) : '';

// kijken op welke pagina de bezoeker zit, standaard 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$perPage = 5; // 5 projecten per pagina laten zien
$offset  = ($page - 1) * $perPage;

// lijstje met voorwaarden voor de database bouwen
$where  = [];
$params = [];

if ($search !== '') {
    $where[]        = "title LIKE ?";
    $params[]       = "%" . $search . "%";
}

if ($filterYear !== '') {
    $where[]  = "year = ?";
    $params[] = $filterYear;
}

$whereSql = '';
if (count($where) > 0) {
    $whereSql = "WHERE " . implode(" AND ", $where);
}

// eerst totaal aantal projecten tellen, nodig voor de paginering
$countSql  = "SELECT COUNT(*) FROM projects $whereSql";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalProjects = (int) $countStmt->fetchColumn();
$totalPages    = (int) ceil($totalProjects / $perPage);
if ($totalPages < 1) {
    $totalPages = 1;
}

// nu de projecten voor deze pagina ophalen
$sql = "SELECT * FROM projects $whereSql ORDER BY year DESC, id DESC LIMIT $perPage OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$projects = $stmt->fetchAll();

// alle jaren ophalen voor het dropdown menu
$yearsStmt = $pdo->query("SELECT DISTINCT year FROM projects ORDER BY year DESC");
$years = $yearsStmt->fetchAll();

// klein functietje dat een URL bouwt met zoekwoord en jaar erbij, zodat die blijven staan na klikken
function buildUrl($page, $search, $year) {
    $params = [];
    if ($search !== '') $params['search'] = $search;
    if ($year !== '')   $params['year']   = $year;
    $params['page'] = $page;
    return 'index.php?' . http_build_query($params);
}

include 'includes/header.php';
?>

<!-- zoekbalk en filter op jaar -->
<form method="get" action="index.php" class="d-flex justify-content-center align-items-center m-4 flex-wrap gap-2">
    <input
        type="search"
        name="search"
        class="form-control"
        style="max-width: 300px;"
        placeholder="Zoek op titel..."
        value="<?php echo htmlspecialchars($search); ?>">

    <select name="year" class="form-select" style="max-width: 180px;">
        <option value="">Alle jaren</option>
        <?php foreach ($years as $y): ?>
            <option value="<?php echo htmlspecialchars($y['year']); ?>"
                <?php echo ($filterYear == $y['year']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($y['year']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="btn btn-primary">Zoeken</button>
    <a href="index.php" class="btn btn-outline-secondary">Reset</a>
</form>

<!-- lijst met projecten -->
<?php if (count($projects) === 0): ?>
    <div class="alert alert-info text-center">
        Geen projecten gevonden.
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
        <?php foreach ($projects as $project): ?>
            <div class="project card shadow-sm card-body m-2">
                <div class="d-flex gap-3">
                    <?php if (!empty($project['image']) && file_exists('uploads/' . $project['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($project['image']); ?>"
                             alt="<?php echo htmlspecialchars($project['title']); ?>"
                             class="project-thumb">
                    <?php endif; ?>
                    <div class="card-text flex-grow-1">
                        <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                        <div class="text-muted mb-1">
                            <?php echo htmlspecialchars($project['type']); ?> &middot;
                            <?php echo htmlspecialchars($project['year']); ?>
                        </div>
                        <div><?php echo htmlspecialchars($project['short_description']); ?></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="btn-group">
                        <a class="btn btn-sm btn-outline-secondary"
                           href="detail.php?id=<?php echo (int) $project['id']; ?>">View</a>
                           <!-- zit in de include header maar maakt niet uit  -->
                        <?php if ($ingelogd): ?>
                            <a class="btn btn-sm btn-outline-secondary"
                               href="edit.php?id=<?php echo (int) $project['id']; ?>">Edit</a>
                            <a class="btn btn-sm btn-outline-danger"
                               href="delete.php?id=<?php echo (int) $project['id']; ?>"
                               onclick="return confirm('Weet je zeker dat je dit project wil verwijderen?');">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- paginering onderaan -->
<?php if ($totalPages > 1): ?>
<div class="d-flex justify-content-center align-items-center m-4">
    <nav aria-label="Paginering">
        <ul class="pagination">
            <!-- knop om een pagina terug te gaan -->
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo buildUrl($page - 1, $search, $filterYear); ?>">Vorige</a>
            </li>

            <!-- paginanummers om op te klikken -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo buildUrl($i, $search, $filterYear); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- knop om een pagina verder te gaan -->
            <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo buildUrl($page + 1, $search, $filterYear); ?>">Volgende</a>
            </li>
        </ul>
    </nav>
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
