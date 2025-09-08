<?php
// Iniciamos la sesión solo una vez al principio.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica la autenticación y los permisos del usuario.
 *
 * @param array|null $allowed_roles Los roles permitidos para acceder a la página.
 * Si es null, solo se requiere que el usuario esté logueado.
 * @param bool $login_required Si es true, la página requiere inicio de sesión.
 */
function check_authentication($allowed_roles = null, $login_required = true) {

    $is_loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

    // Si la página requiere login y el usuario no está logueado
    if ($login_required && !$is_loggedin) {
        header('Location: index.html?error=login_required');
        exit();
    }

    // Si el usuario está logueado y se necesita un rol específico
    if ($is_loggedin && $allowed_roles !== null) {
        $user_type = $_SESSION['tipo_usuario'];
        // Si el rol del usuario no está en la lista de roles permitidos
        if (!in_array($user_type, $allowed_roles)) {
            // No tiene permisos, redirigir a 403
            header('Location: 403.html');
            exit();
        }
    }
}
?>