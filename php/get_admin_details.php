<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'superAdmin') {
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

include 'conexion.php';

$admin_id = $_GET['id'] ?? null;
if (!$admin_id) {
    echo json_encode(['error' => 'ID no proporcionado.']);
    exit();
}

$sql = "SELECT nombre, apellido, username, telefono, email FROM usuarios WHERE id = ? AND tipo_usuario = 'admin'";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$resultado = $stmt->get_result();
$adminData = $resultado->fetch_assoc();

if ($adminData) {
    echo json_encode($adminData);
} else {
    echo json_encode(['error' => 'Administrador no encontrado.']);
}

$stmt->close();
$conexion->close();
?>