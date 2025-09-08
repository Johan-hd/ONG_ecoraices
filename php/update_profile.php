<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit();
}

include 'conexion.php';
$user_id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);

// --- 1. Verificar la contraseña actual ---
$current_password = $data['current_password'];
if (empty($current_password)) {
    echo json_encode(['success' => false, 'message' => 'Debes ingresar tu contraseña actual para guardar los cambios.']);
    exit();
}

$sql_pass = "SELECT password FROM usuarios WHERE id = ?";
$stmt_pass = $conexion->prepare($sql_pass);
$stmt_pass->bind_param("i", $user_id);
$stmt_pass->execute();
$result_pass = $stmt_pass->get_result()->fetch_assoc();

if (!password_verify($current_password, $result_pass['password'])) {
    echo json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta.']);
    exit();
}

// --- 2. Preparar los datos a actualizar ---
$nombre = $data['nombre'];
$apellido = $data['apellido'];
$username = $data['username'];
$telefono = $data['telefono'];
$email = $data['email'];
$new_password = $data['new_password'];

// Lógica para actualizar contraseña SOLO si se proporcionó una nueva
if (!empty($new_password)) {
    $password_hasheada = password_hash($new_password, PASSWORD_DEFAULT);
    $sql_update = "UPDATE usuarios SET nombre = ?, apellido = ?, username = ?, telefono = ?, email = ?, password = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("ssssssi", $nombre, $apellido, $username, $telefono, $email, $password_hasheada, $user_id);
} else {
    // Si no hay contraseña nueva, no se actualiza ese campo
    $sql_update = "UPDATE usuarios SET nombre = ?, apellido = ?, username = ?, telefono = ?, email = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("sssssi", $nombre, $apellido, $username, $telefono, $email, $user_id);
}

// --- 3. Ejecutar la actualización ---
if ($stmt_update->execute()) {
    // Actualizamos el nombre de usuario en la sesión si cambió
    $_SESSION['username'] = $username;
    echo json_encode(['success' => true, 'message' => '¡Perfil actualizado correctamente!']);
} else {
    // Manejo de error para username/email duplicado
    if ($conexion->errno == 1062) {
        echo json_encode(['success' => false, 'message' => 'El nombre de usuario o el email ya están en uso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ocurrió un error al actualizar el perfil.']);
    }
}

$stmt_update->close();
$conexion->close();
?>