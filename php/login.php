<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ===== INICIO DE LA LÓGICA DE REDIRECCIÓN DINÁMICA =====

    // 1. Establecemos una URL por defecto como fallback seguro.
    $redirect_url = "../index.html";

    // 2. Verificamos si recibimos la página actual desde el formulario.
    if (isset($_POST['current_page']) && !empty($_POST['current_page'])) {
        // 3. (Opcional pero recomendado) Una pequeña validación de seguridad
        // para asegurar que solo redirigimos a páginas locales.
        $allowed_pages = [
            '../index.html', '../contacto.html', '../galeria.html', 
            '../nosotros.html', '../proyectos.html', '../registro.html',
            '../restauracionEcologica_learn.html', '../rehabilitacionDeFauna.html'
        ];
        if (in_array($_POST['current_page'], $allowed_pages)) {
            $redirect_url = $_POST['current_page'];
        }
    }
    
    // ===== FIN DE LA LÓGICA DE REDIRECCIÓN DINÁMICA =====

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty(trim($username)) || empty(trim($password))) {
        // Ahora todas las redirecciones usarán la URL dinámica
        header("Location: " . $redirect_url . "?error=campos_vacios");
        exit();
    }

    $sql = "SELECT id, password, tipo_usuario FROM usuarios WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        
        if (password_verify($password, $usuario['password'])) {
            // Éxito: iniciamos sesión y redirigimos a la página de origen (sin errores)
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['username'] = $username;
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            header("location: " . $redirect_url);
            exit;
        } else {
            // Error de contraseña: redirigimos a la página de origen con el error
            header("Location: " . $redirect_url . "?error=password_invalido&username=" . urlencode($username));
            exit();
        }
    } else {
        // Error de usuario: redirigimos a la página de origen con el error
        header("Location: " . $redirect_url . "?error=usuario_invalido&username=" . urlencode($username));
        exit();
    }

    $stmt->close();
    $conexion->close();
}
?>