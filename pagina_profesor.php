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
        
        // Obtener datos del supervisor/profesor
        $query = "SELECT nombre, apellidos FROM supervisor WHERE correo = '$nombre_usuario'";
        $resultado = mysqli_query($conexion, $query);
        $datos = mysqli_fetch_array($resultado);
    }
    else
    {
        // Si no hay sesión, redirigir al index
        header("location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Profesor/Supervisor</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #800000, #000000);
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.08);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 90%;
            text-align: center;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            text-shadow: 0px 3px 6px rgba(0,0,0,0.4);
        }

        hr {
            border: none;
            height: 2px;
            background: #b22222;
            margin: 15px 0;
        }

        h2 {
            color: #ffd7d7;
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }

        li {
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 8px 0;
            transition: background 0.2s ease;
        }

        li:hover {
            background: rgba(255,255,255,0.2);
        }

        a {
            color: #ffcccc;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout {
            display: inline-block;
            margin-top: 15px;
            background: #a00000;
            padding: 10px 15px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            transition: background 0.2s ease;
        }

        .logout:hover {
            background: #c00000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Portal de Profesor/Supervisor</h1>
        <hr>
        <?php
            if(isset($datos['nombre']) && isset($datos['apellidos'])) {
                echo 'Bienvenido/a: <strong>' . $datos['nombre'] . ' ' . $datos['apellidos'] . '</strong> (' . $nombre_usuario . ')';
            } else {
                echo 'Usuario: <strong>' . $nombre_usuario . '</strong>';
            }
        ?>
        <hr>
        <h2>Opciones para Supervisores</h2>
        <ul>
            <li><a href="#">Gestionar Estudiantes a Cargo</a></li>
            <li><a href="#">Validar Horas de Servicio</a></li>
            <li><a href="#">Registrar Actividades</a></li>
            <li><a href="#">Comunicación con Acudientes</a></li>
        </ul>
        <hr>
        <a class="logout" href="modelo/cerrar_sesion.php">Cerrar Sesión</a>
    </div>
</body>
</html>
