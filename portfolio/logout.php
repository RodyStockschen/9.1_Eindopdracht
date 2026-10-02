<?php
// uitloggen, dus de sessie leegmaken
session_start();

// alles wat in de sessie staat weggooien
$_SESSION = [];

// en de sessie helemaal beëindigen
session_destroy();

// terug naar de startpagina
header("Location: index.php");
exit;
