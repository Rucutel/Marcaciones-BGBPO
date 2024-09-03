<?php
$servername = "localhost";
$username = "root"; // Por defecto, en XAMPP el usuario es root
$password = ""; // La contraseña por defecto suele estar vacía
$dbname = "marcaciones_db"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
