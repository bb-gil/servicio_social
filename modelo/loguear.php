<?php
require 'conexion.php';
session_start();

$usuario = $_POST['email'];
$password = $_POST['password'];
$rol = $_POST['rol'];

// Consulta segura con prepared statements
$query_1 = "SELECT email, COUNT(*) AS contar FROM Usuario WHERE email = '$usuario' AND password = '$password'";

$consulta = mysqli_query($conexion, $query_1) or trigger_error("Error en la consulta MySQL:  " + mysqli_error($conexion));

$resultado = mysqli_fetch_array($consulta);

if ($resultado->num_rows > 0) 
{
    $datos = $resultado->fetch_assoc();
    $_SESSION['username'] = $datos['email'];
    $_SESSION['rol'] = $datos['rol'];

    // Redirección según rol
    switch ($datos['rol']) {
        case 'administrador':
            header("Location: ../admin_panel.php");
            break;
        case 'docente':
            header("Location: ../docente_panel.php");
            break;
        case 'digitador':
            header("Location: ../digitador_panel.php");
            break;
        case 'estudiante':
            header("Location: ../estudiante_panel.php");
            break;
        default:
            echo "Rol no reconocido.";
            break;
    }
} else {
    echo "Credenciales incorrectas o rol no coincide.";
}
?>
