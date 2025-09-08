<?php
// --- IMPORTANTE ---
// Coloca aquí la contraseña que deseas para tu superadministrador
$password_plana = 'super123';

// Generamos el hash usando el mismo método que en tu script de registro
$hash_generado = password_hash($password_plana, PASSWORD_DEFAULT);

// Imprimimos el hash en pantalla para que puedas copiarlo
echo "<h3>Hash Generado</h3>";
echo "<p>Copia la siguiente línea de texto y pégala en tu consulta SQL:</p>";
echo "<textarea rows='3' cols='70' readonly>" . htmlspecialchars($hash_generado) . "</textarea>";
?>