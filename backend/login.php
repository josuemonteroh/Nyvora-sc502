<?php
require 'config.php';
 
// Si ya hay sesión activa, redirigir directo al dashboard
if (!empty($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit;
}
 
$error = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
 
    if (empty($email) || empty($password)) {
        $error = 'Completa todos los campos.';
    } else {
        // Buscar usuario por correo, junto con el nombre de su rol
        $stmt = $pdo->prepare(
            'SELECT users.id, users.name, users.password_hash, roles.name AS rol
             FROM users
             JOIN roles ON roles.id = users.role_id
             WHERE users.email = ?'
        );
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
 
        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            // Contraseña correcta: crear sesión
            session_regenerate_id(true); // previene fijación de sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['name'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
 
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Correo o contraseña incorrectos.';
        }
    }
}
?>