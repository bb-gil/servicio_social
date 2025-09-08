<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
?>

<?php
    require 'modelo/conexion.php';

    session_start();

    if(isset($_SESSION['username']))
    {
        $nombre_usuario = $_SESSION['username'];
        
        $query = "SELECT nombre, apellidos FROM administrador WHERE correo = '$nombre_usuario'";
        $resultado = mysqli_query($conexion, $query);
        $datos = mysqli_fetch_array($resultado);
    }
    else
    {
        header("location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #013220, #025939);
            color: white;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1, h2 {
            text-align: center;
            text-shadow: 0px 2px 5px rgba(0,0,0,0.4);
        }

        ul {
            list-style: none;
            padding: 0;
            max-width: 400px;
            width: 90%;
        }

        ul li {
            margin: 10px 0;
        }

        ul li a {
            display: block;
            background: rgba(0, 50, 32, 0.9);
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0px 3px 6px rgba(0,0,0,0.4);
            transition: all 0.2s ease;
        }

        ul li a:hover {
            background: #038c5a;
            transform: translateY(-2px);
        }

        a {
            color: #a3ffcc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            border: 1px solid rgba(255,255,255,0.2);
            margin: 20px 0;
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <h1>Panel de Administrador</h1>
    <hr>
    <?php
        if(isset($datos['nombre']) && isset($datos['apellidos'])) {
            echo '<p>Bienvenido/a: ' . $datos['nombre'] . ' ' . $datos['apellidos'] . ' (' . $nombre_usuario . ')</p>';
        } else {
            echo '<p>Usuario: ' . $nombre_usuario . '</p>';
        }
    ?>
    <hr>
    <h2>Opciones de Administrador</h2>
    <ul>
        <li><a href="gestionar_estudientes.php">Gestionar Estudiantes</a></li>
        <li><a href="gestionar_acudientes.php">Gestionar Acudientes</a></li>
        <li><a href="gestionar_administradores.php">Gestionar Administradores</a></li>
        <li><a href="gestionar_supervisores.php">Gestionar Supervisores</a></li>
        <li><a href="gestionar_grupos.php">Gestionar Grupos</a></li>
        <li><a href="#">Soporte PDF</a></li>
    </ul>
    <hr>
    <a href="modelo/cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>
