<?php
session_start();

// ===== PASO DE SEGURIDAD CRÍTICO =====
// Verificamos si el usuario ha iniciado sesión Y si su rol es 'superAdmin'.
// Si no cumple, se detiene la ejecución inmediatamente.
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'superAdmin') {
    // Puedes redirigir a una página de error o simplemente mostrar un mensaje.
    die("Acceso denegado. No tienes permisos para realizar esta acción.");
}

// Si la verificación pasa, continuamos con el código de registro.
include 'conexion.php';

// El resto de este script es casi idéntico a tu registrar.php original,
// pero confía en el 'userType' que le envía el formulario de admin.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $campos_obligatorios = ['nombre', 'apellido', 'username', 'email', 'password', 'userType'];
    foreach ($campos_obligatorios as $campo) {
        if (empty(trim($_POST[$campo]))) {
            // Manejar error de campos vacíos (redirigiendo de vuelta)
            header("Location: ../registro_admin.html?error=campos_vacios");
            exit();
        }
    }

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $username = $_POST['username'];
    $telefono = $_POST['telefono']; 
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tipo_usuario = $_POST['userType']; // Aquí será 'admin'

    // Aquí irían las mismas verificaciones de email/usuario duplicado que en registrar.php...
    $sql_check_email = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check_email = $conexion->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_email->num_rows > 0) {
        header("Location: ../registro_admin.html?error=email_existe");
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
        header("Location: ../registro_admin.html?error=usuario_existe");
        exit();
    }
    $stmt_check_username->close();
    
    $password_hasheada = password_hash($password, PASSWORD_DEFAULT);
    $sql_insert = "INSERT INTO usuarios (nombre, apellido, username, telefono, email, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $nombre, $apellido, $username, $telefono, $email, $password_hasheada, $tipo_usuario);

    if ($stmt_insert->execute()) {
        // Redirigir al panel de admin con un mensaje de éxito
        header("Location: ../superAdminPanel.html?registro=exitoso");
        exit();
    } else {
        header("Location: ../registro_admin.html?error=desconocido");
        exit();
    }
    
    $stmt_insert->close();
    $conexion->close();
}
?>