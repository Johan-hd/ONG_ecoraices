<?php
session_start();
header('Content-Type: application/json');

// Medida de seguridad: solo los superAdmin pueden eliminar
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'superAdmin') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit();
}

include 'conexion.php';

// Leemos el ID del administrador a eliminar que nos envían por POST
$data = json_decode(file_get_contents('php://input'), true);
$admin_id = $data['id'] ?? null;

if (!$admin_id) {
    echo json_encode(['success' => false, 'message' => 'No se proporcionó un ID.']);
    exit();
}

// No permitimos que un superAdmin se elimine a sí mismo
if ($admin_id == $_SESSION['id']) {
    echo json_encode(['success' => false, 'message' => 'No puedes eliminar tu propia cuenta.']);
    exit();
}

// Preparamos y ejecutamos la consulta para eliminar
$sql = "DELETE FROM usuarios WHERE id = ? AND tipo_usuario = 'admin'";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $admin_id); // 'i' -> integer -> significa que el ID es un entero

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Administrador eliminado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró el administrador o no tienes permiso para eliminarlo.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta.']);
}

$stmt->close();
$conexion->close();
?>