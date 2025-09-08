<?php 
require_once 'php/auth.php'; 
check_authentication(['admin', 'superAdmin']); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EcoRaíces | Gestionar Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
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
        <div class="mb-5">
            <h1 class="display-5 fw-bold">Gestionar Clientes</h1>
            <p class="lead text-muted">Visualiza y elimina las cuentas de los clientes.</p>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Usuario</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="client-list">
                    </tbody>
            </table>
        </div>
    </main>

    <div class="modal fade" id="confirmDeleteClientModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirmar Eliminación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>¿Estás seguro de que deseas eliminar al cliente <strong id="clientNameToDelete"></strong>? Esta acción es irreversible.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteClientBtn">Eliminar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sessionManager.js"></script>
    <script src="assets/js/manage-clients.js"></script>
</body>
</html>