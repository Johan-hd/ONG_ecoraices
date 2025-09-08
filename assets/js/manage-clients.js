document.addEventListener('DOMContentLoaded', function () {
    // Obtener referencias a los elementos del DOM y al modal de Bootstrap
    const clientListBody = document.getElementById('client-list');
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteClientModal'));
    const confirmBtn = document.getElementById('confirmDeleteClientBtn');
    const clientNameToDelete = document.getElementById('clientNameToDelete');
    let clientIdToDelete = null;

    // Función para cargar los clientes desde el servidor y mostrarlos en la tabla
    function loadClients() {
        fetch('php/get_clients.php')
            .then(response => response.json())
            .then(data => {
        // Limpiar la tabla antes de mostrar los nuevos datos
                clientListBody.innerHTML = ''; 
                if (data.error) {
            // Mostrar mensaje de error si ocurre un error
                    clientListBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">${data.error}</td></tr>`;
                    return;
                }
                if (data.length === 0) {
            // Mostrar mensaje si no hay clientes registrados
                    clientListBody.innerHTML = `<tr><td colspan="5" class="text-center">No hay clientes registrados.</td></tr>`;
                    return;
                }
        // Mostrar cada cliente como una fila en la tabla
                data.forEach(client => {
                    const row = `
                        <tr>
                            <td>${client.id}</td>
                            <td>${client.username}</td>
                            <td>${client.nombre} ${client.apellido}</td>
                            <td>${client.email}</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${client.id}" data-username="${client.username}">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                    clientListBody.insertAdjacentHTML('beforeend', row);
                });
            });
    }

    // Evento para detectar clics en el botón de eliminar en la lista de clientes
    clientListBody.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('delete-btn')) {
        // Guardar el ID y nombre de usuario del cliente a eliminar, mostrar el modal de confirmación
            clientIdToDelete = e.target.getAttribute('data-id');
            const username = e.target.getAttribute('data-username');
            clientNameToDelete.textContent = username;
            confirmModal.show();
        }
    });

    // Evento para confirmar la eliminación del cliente
    confirmBtn.addEventListener('click', function () {
        if (clientIdToDelete) {
        // Enviar solicitud para eliminar el cliente
            fetch('php/delete_client.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: clientIdToDelete })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
            // Ocultar el modal y recargar la lista de clientes si se elimina correctamente
                    confirmModal.hide();
                    loadClients();
                } else {
            // Mostrar mensaje de error si la eliminación falla
                    alert('Error: ' + data.message);
                }
            });
        }
    });

    // Cargar la lista de clientes al iniciar la página
    loadClients();
});