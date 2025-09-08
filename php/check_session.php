<?php
// Iniciamos la sesión para poder acceder a las variables de sesión
session_start();

// Preparamos un array para la respuesta
$response = [
    'loggedin' => false,
    'username' => '',
    'userType' => ''
];

// Verificamos si el usuario ha iniciado sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $response['loggedin'] = true;
    $response['username'] = $_SESSION['username'];
    $response['userType'] = $_SESSION['tipo_usuario'];
}

// Enviamos la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>