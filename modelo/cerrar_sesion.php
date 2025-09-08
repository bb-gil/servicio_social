<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Siempre iniciar la sesión antes de destruirla

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la cookie de sesión, se debe hacer también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente destruir la sesión
session_destroy();

// Redirigir al index
header("Location: ../index.php");
exit;
?>
