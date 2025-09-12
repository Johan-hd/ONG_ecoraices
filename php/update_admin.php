<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'superAdmin') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit();
}

include 'conexion.php';
$data = json_decode(file_get_contents('php://input'), true);

// Recoger datos del formulario
$id = $data['id'];
$nombre = $data['nombre'];
$apellido = $data['apellido'];
$username = $data['username'];
$telefono = $data['telefono'];
$email = $data['email'];
$new_password = $data['new_password'];

if (empty($id) || empty($nombre) || empty($apellido) || empty($username) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
    exit();
}

if (!empty($new_password)) {
    $password_hasheada = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET nombre=?, apellido=?, username=?, telefono=?, email=?, password=? WHERE id=? AND tipo_usuario='admin'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssssi", $nombre, $apellido, $username, $telefono, $email, $password_hasheada, $id);
} else {
    $sql = "UPDATE usuarios SET nombre=?, apellido=?, username=?, telefono=?, email=? WHERE id=? AND tipo_usuario='admin'";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $apellido, $username, $telefono, $email, $id);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Administrador actualizado correctamente.']);
} else {
    if ($conexion->errno == 1062) {
        echo json_encode(['success' => false, 'message' => 'El nombre de usuario o el email ya están en uso por otra cuenta.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el administrador.']);
    }
}

$stmt->close();
$conexion->close();
?>