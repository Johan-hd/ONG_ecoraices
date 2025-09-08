document.addEventListener('DOMContentLoaded', function () {
    // Este evento asegura que el código se ejecute solo cuando el DOM esté completamente cargado
    const form = document.getElementById('profileForm');
    const messageDiv = document.getElementById('form-message');

    // Solicita los datos del usuario al servidor y los coloca en el formulario
    fetch('php/get_user_data.php')
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                // Asigna los valores recibidos a los campos correspondientes del formulario
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('apellido').value = data.apellido;
                document.getElementById('username').value = data.username;
                document.getElementById('telefono').value = data.telefono || '';
                document.getElementById('email').value = data.email;
            }
        });

    // Maneja el evento de envío del formulario de perfil
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        // Obtiene los datos del formulario y los convierte en un objeto
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Envía los datos actualizados al servidor para modificar el perfil
        fetch('php/update_profile.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            // Muestra un mensaje de éxito o error según la respuesta del servidor
            messageDiv.className = result.success ? 'alert alert-success' : 'alert alert-danger';
            messageDiv.textContent = result.message;

            // Limpia los campos de contraseña después de intentar actualizar el perfil
            document.getElementById('current_password').value = '';
            document.getElementById('new_password').value = '';
        });
    });
});