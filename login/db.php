<?php

// Definir las constantes para la conexión a la base de datos
define('DB_SERVER', 'localhost');  // Servidor de base de datos (XAMPP usa localhost por defecto)
define('DB_USERNAME', 'root');     // Usuario de MySQL (en XAMPP es 'root' por defecto)
define('DB_PASSWORD', '');         // Contraseña de MySQL (en XAMPP es vacía por defecto)
define('DB_NAME', 'mi_base_de_datos');  // Nombre de la base de datos que usarás (reemplaza 'mi_base_de_datos' por tu base de datos real)

// Establecer la conexión a la base de datos
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Comprobar si la conexión fue exitosa
if ($link === false) {
    // Si falla, muestra el error de conexión
    die("ERROR: No se pudo conectar a la base de datos. " . mysqli_connect_error());
}

// Establecer la codificación de caracteres en UTF-8
mysqli_set_charset($link, "utf8");

?>
