<?php
// Datos de conexión a la base de datos
$servidor = "localhost"; // El servidor que aloja la BD (usualmente localhost en XAMPP)
$usuario_bd = "root";    // El usuario de la BD (por defecto 'root' en XAMPP)
$password_bd = "";       // La contraseña de la BD (por defecto vacía en XAMPP)
$nombre_bd = "eco_raices"; 

// Crear la conexión
$conexion = new mysqli($servidor, $usuario_bd, $password_bd, $nombre_bd);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Opcional: Establecer el juego de caracteres a UTF-8 para evitar problemas con tildes y ñ
$conexion->set_charset("utf8");
?>