<?php 
require_once 'php/auth.php'; 
check_authentication(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EcoRaíces | Mi Perfil</title>
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

    <main class="container my-5 py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-5 fw-bold mb-4">Mi Perfil</h1>
                <form id="profileForm" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6"><label for="nombre" class="form-label">Nombre</label><input type="text" class="form-control" id="nombre" name="nombre" required></div>
                        <div class="col-md-6"><label for="apellido" class="form-label">Apellido</label><input type="text" class="form-control" id="apellido" name="apellido" required></div>
                        <div class="col-md-6"><label for="username" class="form-label">Nombre de usuario</label><input type="text" class="form-control" id="username" name="username" required></div>
                        <div class="col-md-6"><label for="telefono" class="form-label">Teléfono</label><input type="tel" class="form-control" id="telefono" name="telefono"></div>
                        <div class="col-12"><label for="email" class="form-label">Correo electrónico</label><input type="email" class="form-control" id="email" name="email" required></div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Cambiar Contraseña (Opcional)</h5>
                    <div class="mb-3"><label for="new_password" class="form-label">Nueva Contraseña</label><input type="password" class="form-control" id="new_password" name="new_password"></div>

                    <hr class="my-4">
                    <h5 class="mb-3">Confirmar Cambios</h5>
                    <div class="mb-3"><label for="current_password" class="form-label">Contraseña Actual*</label><input type="password" class="form-control" id="current_password" name="current_password" required><small class="form-text text-muted">Ingresa tu contraseña actual para guardar cualquier cambio.</small></div>

                    <button type="submit" class="btn btn-primary btn-lg mt-3">Guardar Cambios</button>
                </form>
                <div id="form-message" class="mt-3"></div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/session-manager.js"></script>
    <script src="assets/js/profile-manager.js"></script>
</body>
</html>