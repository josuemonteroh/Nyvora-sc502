<?php
// config.php - Conexión a la base de datos con PDO

/*
 
 * Si tú no vas a crear la base de datos, comparte este bloque (o los
 * archivos .sql del repo) con quien sí lo haga.
 */

$host = '127.0.0.1';
$db   = 'nyvora_db';
$user = 'root';      // <-- cambia esto por tu usuario de MySQL
$pass = '';           // <-- cambia esto por tu contraseña de MySQL
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

// Iniciar sesión en todas las páginas que incluyan este archivo

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}