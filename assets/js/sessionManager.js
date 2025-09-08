document.addEventListener("DOMContentLoaded", function () {
    // Seleccionamos los elementos clave de la barra de navegación
    const navbarNav = document.querySelector("#navbarNav .navbar-nav");
    const navbarCollapseDiv = document.getElementById("navbarNav");

    // Hacemos la llamada al script que nos dice el estado de la sesión
    fetch("php/check_session.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            // Limpiamos el botón de "Acceder" que viene por defecto en el HTML
            const staticLoginButton = document.querySelector('button[data-bs-target="#loginModal"]');
            if (staticLoginButton) {
                staticLoginButton.remove();
            }

            if (data.loggedin) {
                // --- El usuario SÍ ha iniciado sesión ---

                // 1. Si es 'superAdmin', añadimos el botón de Administración
                if (data.userType === 'superAdmin') {
                    const adminLink = document.createElement('li');
                    adminLink.className = 'nav-item';
                    adminLink.innerHTML = '<a class="nav-link fw-bold text-warning" href="superAdminPanel.html">Administración</a>';
                    // Lo insertamos dentro de la lista de navegación (<ul>)
                    navbarNav.appendChild(adminLink);
                }

                // 2. Creamos el saludo y el botón de "Salir"
                const userActionsHTML = `
                    <div class="d-flex align-items-center ms-lg-3">
                        <span class="navbar-text me-3 text-white">Hola, <strong>${data.username}</strong></span>
                        <a href="php/logout.php" class="btn btn-outline-light btn-sm">Salir</a>
                    </div>
                `;
                // Lo insertamos al final del div principal del navbar
                navbarCollapseDiv.insertAdjacentHTML('beforeend', userActionsHTML);

            } else {
                // --- El usuario NO ha iniciado sesión ---
                
                // Añadimos el botón de "Acceder"
                const loginButtonHTML = `
                    <button class="btn btn-outline-light ms-lg-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Acceder
                    </button>
                `;
                navbarCollapseDiv.insertAdjacentHTML('beforeend', loginButtonHTML);
            }
        })
        .catch(error => {
            console.error('Error al verificar la sesión:', error);
            // Si hay un error, por seguridad, mostramos el botón de Acceder
            const loginButtonHTML = `
                <button class="btn btn-outline-light ms-lg-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Acceder
                </button>
            `;
            navbarCollapseDiv.insertAdjacentHTML('beforeend', loginButtonHTML);
        });
});