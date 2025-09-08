<?php
// Iniciamos la sesión
session_start();

// Destruimos todas las variables de sesión
$_SESSION = array();
session_destroy();

// Redirigimos al usuario a la página de inicio
header("location: ../index.html");
exit;
?>