<?php
/*
   Admin
   Test gebruiker
   Email:    admin@portfolio.nl
   Wachtwoord: admin123
   (Dit is een password_hash van 'admin123')

   INSERT INTO users (email, password) VALUES
   ('admin@portfolio.nl', '$2y$12$Qxm/ew9gGIXt33amTLgIbeWTjy67qHz0Yab.F4KftajU7LkDwuyYe');
*/

// loginpagina
session_start();
require_once 'database.php';

$pageTitle = 'Inloggen';
$error = '';

// al ingelogd? dan direct door naar de startpagina
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// kijken of het formulier is verstuurd
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email === '' || $password === '') {
        $error = 'Vul alle verplichte velden in.';
    } else {
        // zoeken of deze gebruiker in de database staat
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // en kijken of het wachtwoord ook klopt
        if ($user && password_verify($password, $user['password'])) {
            // inloggen gelukt, de sessie onthoudt wat er is ingelogd
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: index.php");
            exit;
        } else {
            $error = 'E-mailadres of wachtwoord klopt niet.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <!-- kant en klare containers en rijen containers -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
<main class="form-signin w-100 m-auto" style="max-width: 360px;">
    <form method="post" action="login.php">
        <h1 class="h3 mb-3 fw-normal text-center">Even inloggen</h1>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="form-floating mb-2">
            <input type="email" name="email" class="form-control" id="floatingInput"
                   placeholder="name@example.com" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <label for="floatingInput">E-mailadres</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="floatingPassword"
                   placeholder="Password" required>
            <label for="floatingPassword">Wachtwoord</label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Inloggen</button>

        <div class="text-center mt-3">
            <a href="index.php" class="text-muted small">&larr; Terug naar overzicht</a>
        </div>
    </form>
</main>
</body>
</html>
