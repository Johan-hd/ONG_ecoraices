<?php
session_start();
header('Content-Type: application/json');

// Medida de seguridad: solo admins y superAdmins pueden eliminar
if (!isset($_SESSION['loggedin']) || ($_SESSION['tipo_usuario'] !== 'admin' && $_SESSION['tipo_usuario'] !== 'superAdmin')) {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit();
}

include 'conexion.php';

// misma logica que se usa con los admins pero para clientes

$data = json_decode(file_get_contents('php://input'), true);
$client_id = $data['id'] ?? null;

if (!$client_id) {
    echo json_encode(['success' => false, 'message' => 'No se proporcionó un ID.']);
    exit();
}

$sql = "DELETE FROM usuarios WHERE id = ? AND tipo_usuario = 'cliente'";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $client_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Cliente eliminado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró el cliente.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta.']);
}

$stmt->close();
$conexion->close();
?>