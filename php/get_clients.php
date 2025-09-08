<?php
session_start();
header('Content-Type: application/json');

// Medida de seguridad: solo admins y superAdmins pueden ver la lista
if (!isset($_SESSION['loggedin']) || ($_SESSION['tipo_usuario'] !== 'admin' && $_SESSION['tipo_usuario'] !== 'superAdmin')) {
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

// misma logica que se usa con los admins pero para clientes
include 'conexion.php';
$clients = [];
$sql = "SELECT id, nombre, apellido, username, email, fecha_registro FROM usuarios WHERE tipo_usuario = 'cliente'";
$resultado = $conexion->query($sql);

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $clients[] = $fila;
    }
}

echo json_encode($clients);
$conexion->close();
?>