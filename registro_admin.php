<?php 
require_once 'php/auth.php'; 
check_authentication(['superAdmin']); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRaíces | Registrar Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
    <!-- Script para manejar sesión y mostrar enlaces según el tipo de usuario -->
    <script src="assets/js/sessionManager.js"></script>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.html">EcoRaíces</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Inicio</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Conócenos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="nosotros.html"
                                    >Sobre Nosotros</a
                                >
                            </li>
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="proyectos.html"
                                    >Nuestros Proyectos</a
                                >
                            </li>
                            <li>
                                <a class="dropdown-item" href="galeria.html"
                                    >Galería</a
                                >
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Aprende
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="./restauracionEcologica_learn.php"
                                    >Restauración Ecológica</a
                                >
                            </li>
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="./rehabilitacionDeFauna.php"
                                    >Rehabilitación de Fauna</a
                                >
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contacto.html"
                            >Contacto</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container my-5 py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold">Registrar Nuevo Administrador</h1>
                        <p class="lead text-muted">Crea una cuenta para un nuevo miembro del equipo administrativo.</p>
                    </div>

                    <form id="registerForm" action="./php/registrar_admin_proceso.php" method="POST" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre*</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required />
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido*</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required />
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Nombre de usuario*</label>
                                <input type="text" class="form-control" id="username" name="username" required />
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" />
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Correo electrónico*</label>
                                <input type="email" class="form-control" id="email" name="email" required />
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Contraseña*</label>
                                <input type="password" class="form-control" id="password" name="password" required />
                            </div>
                            
                            <input type="hidden" name="userType" value="admin">
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

        <!-- Modal de Error -->
        <div
            class="modal fade"
            id="errorModal"
            tabindex="-1"
            aria-labelledby="errorModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">
                            Error en el Registro
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Script de validación del formulario -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get("error");

            if (error) {
                const errorModal = new bootstrap.Modal(
                    document.getElementById("errorModal")
                );
                const errorMessageElement =
                    document.getElementById("errorMessage");
                let message = "";

                switch (error) {
                    case "campos_vacios":
                        message =
                            "Por favor, completa todos los campos obligatorios.";
                        break;
                    case "email_existe":
                        message =
                            "El correo electrónico que ingresaste ya está registrado. Por favor, intenta con otro.";
                        break;
                    case "usuario_existe":
                        message =
                            "El nombre de usuario que elegiste ya está en uso. Por favor, elige otro.";
                        break;
                    default:
                        message =
                            "Ocurrió un error inesperado. Por favor, intenta de nuevo.";
                        break;
                }

                errorMessageElement.textContent = message;
                errorModal.show();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/session-manager.js"></script>


    </body>
</html>