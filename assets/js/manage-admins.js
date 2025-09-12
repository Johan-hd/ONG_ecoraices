document.addEventListener('DOMContentLoaded', function () {
    const adminListBody = document.getElementById('admin-list');
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const adminNameToDelete = document.getElementById('adminNameToDelete');
    let adminIdToDelete = null;

    // Función para cargar los administradores en la tabla
    function loadAdmins() {
        fetch('php/get_admins.php')
            .then(response => response.json())
            .then(data => {
                adminListBody.innerHTML = ''; // Limpiar la tabla antes de llenarla
                if (data.error) {
                    adminListBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">${data.error}</td></tr>`;
                    return;
                }
                if (data.length === 0) {
                    adminListBody.innerHTML = `<tr><td colspan="5" class="text-center">No hay administradores registrados.</td></tr>`;
                    return;
                }
                data.forEach(admin => {
                    const row = `
                        <tr>
                            <td>${admin.id}</td>
                            <td>${admin.username}</td>
                            <td>${admin.nombre} ${admin.apellido}</td>
                            <td>${admin.email}</td>
                            <td>
                                <a href="editar_admin_form.php?id=${admin.id}" class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${admin.id}" data-username="${admin.username}">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                    adminListBody.insertAdjacentHTML('beforeend', row);
                });
            });
    }

    // Manejar el clic en los botones de eliminar
    adminListBody.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('delete-btn')) {
            adminIdToDelete = e.target.getAttribute('data-id');
            const username = e.target.getAttribute('data-username');
            adminNameToDelete.textContent = username;
            confirmDeleteModal.show();
        }
    });

    // Manejar la confirmación de eliminación
    confirmDeleteBtn.addEventListener('click', function () {
        if (adminIdToDelete) {
            fetch('php/delete_admin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: adminIdToDelete })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    confirmDeleteModal.hide();
                    loadAdmins(); // Recargar la lista para ver los cambios
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    });

    // Cargar la lista de administradores al iniciar la página
    loadAdmins();
});