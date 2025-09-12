# Proyecto EcoRaíces 🌳

Este es el repositorio del sitio web para EcoRaíces, una organización ficticia dedicada a la protección del medio ambiente. El proyecto está construido con un stack de tecnologías web estándar (HTML, CSS, Bootstrap, JavaScript, PHP y MySQL) y cuenta con un sistema completo de gestión de usuarios con diferentes roles y permisos.

## ✨ Características Principales

* **Sitio web informativo:** Páginas estáticas para presentar la organización, sus proyectos, galería y formas de contacto.
* **Sistema de Autenticación Seguro:**
    * Registro de usuarios con contraseñas encriptadas (hashed).
    * Inicio de sesión con validación en el servidor.
    * Sistema de retroalimentación de errores directamente en los formularios, sin recargar la página.
* **Gestión de Roles y Permisos:**
    * **Cliente:** Rol por defecto. Pueden ver contenido protegido y editar su propio perfil.
    * **Admin:** Pueden gestionar (ver y eliminar) a todos los usuarios de tipo `cliente`.
    * **SuperAdmin:** Tienen control total. Pueden gestionar a los `admin` (crear y eliminar) y también a los clientes.
* **Paneles de Administración Dinámicos:** Interfaces protegidas y funcionales para la gestión de usuarios según el rol.
* **Protección de Rutas:** Las páginas sensibles (paneles de administración, perfil, contenido exclusivo) son inaccesibles por URL a menos que el usuario tenga la sesión y los permisos adecuados.



## Creación de la Base de Datos

db name:  `ecoraices`.

db query: 

```sql
CREATE TABLE usuarios (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('cliente', 'admin', 'superAdmin') NOT NULL DEFAULT 'cliente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
-- 

SUPER ADMIN CREDENTIALS: 

HASHED pass to db: $2y$10$6Ox1QGAWBupBNbXo99cTlOBl4c/FODajC.wm3XGcIFZ/jFboDwuLK

pass: super123

user: superadmin

