<?php
session_start();
header('Content-Type: application/json');

// Medida de seguridad: solo un usuario logueado puede pedir sus datos
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

include 'conexion.php';

// misma logica que se usa con los admins pero para clientes

$user_id = $_SESSION['id'];
$sql = "SELECT nombre, apellido, username, telefono, email FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultado = $stmt->get_result();
$userData = $resultado->fetch_assoc();

echo json_encode($userData);

$stmt->close();
$conexion->close();
?>