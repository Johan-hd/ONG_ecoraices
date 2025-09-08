<?php
session_start();
header('Content-Type: application/json');

// Medida de seguridad: solo los superAdmin pueden ver la lista
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'superAdmin') {
    // http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

include 'conexion.php';

// Preparamos un array para guardar los resultados
$admins = [];

// Consulta para seleccionar solo a los usuarios con el rol 'admin'
$sql = "SELECT id, nombre, apellido, username, email, fecha_registro FROM usuarios WHERE tipo_usuario = 'admin'";

$resultado = $conexion->query($sql);

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $admins[] = $fila;
    }
}

// Devolvemos la lista de administradores en formato JSON
echo json_encode($admins);

$conexion->close();
?>