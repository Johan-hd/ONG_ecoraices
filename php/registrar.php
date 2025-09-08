<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lista de campos que son obligatorios (ya no incluye 'userType')
    $campos_obligatorios = ['nombre', 'apellido', 'username', 'email', 'password'];
    
    foreach ($campos_obligatorios as $campo) {
        if (empty(trim($_POST[$campo]))) {
            header("Location: ../registro.html?error=campos_vacios");
            exit();
        }
    }

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $username = $_POST['username'];
    $telefono = $_POST['telefono']; 
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Asignamos el tipo de usuario directamente aquí, en el servidor.
    // De esta forma, ignoramos cualquier dato que el usuario intente enviar.
    $tipo_usuario = 'cliente';

    // --- El resto del código para verificar duplicados e insertar sigue exactamente igual ---

    // Comprobamos si el email ya existe
    $sql_check_email = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check_email = $conexion->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_email->num_rows > 0) {
        header("Location: ../registro.html?error=email_existe");
        exit();
    }
    $stmt_check_email->close();

    // Comprobamos si el nombre de usuario ya existe
    $sql_check_username = "SELECT id FROM usuarios WHERE username = ?";
    $stmt_check_username = $conexion->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $stmt_check_username->store_result();

    if ($stmt_check_username->num_rows > 0) {
        header("Location: ../registro.html?error=usuario_existe");
        exit();
    }
    $stmt_check_username->close();

    // Procedemos con el registro
    $password_hasheada = password_hash($password, PASSWORD_DEFAULT);
    $sql_insert = "INSERT INTO usuarios (nombre, apellido, username, telefono, email, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    // La 's' final corresponde a $tipo_usuario
    $stmt_insert->bind_param("sssssss", $nombre, $apellido, $username, $telefono, $email, $password_hasheada, $tipo_usuario);

    if ($stmt_insert->execute()) {
        header("Location: ../index.html?registro=exitoso");
        exit();
    } else {
        header("Location: ../registro.html?error=desconocido");
        exit();
    }
    
    $stmt_insert->close();
    $conexion->close();
}
?>