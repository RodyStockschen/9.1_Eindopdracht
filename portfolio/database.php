<?php
// verbinding met de database via PDO
// dit bestand wordt in de andere bestanden aangeroepen met require_once

// project draait in Docker, macbook data  
$host     = 'mysql_db';
$dbname   = 'portfolio_db';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    // zo komt er een foutmelding als er iets mis gaat
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // zo komt de data terug als een array met kolomnamen erbij
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // als er geen verbinding is, een simpele melding tonen
    die("Kan geen verbinding maken met de database. HELAAAAS " . $e->getMessage());
}
