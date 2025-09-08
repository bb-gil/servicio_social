<?php 
error_reporting(E_ALL); 
ini_set('display_errors','1'); 
require 'modelo/conexion.php'; 

session_start(); 
if(isset($_SESSION['username'])) { 
    $nombre_usuario = $_SESSION['username']; 
    
    // Obtener datos del acudiente
    $query = "SELECT nombre, apellidos FROM acudiente WHERE correo = '$nombre_usuario'"; 
    $resultado = mysqli_query($conexion, $query); 
    $datos = mysqli_fetch_array($resultado); 
} else { 
    // Si no hay sesión, redirigir al index
    header("location: index.php"); 
} 
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acudientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdfdfd;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #B8860B;
            color: white;
            padding: 15px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        main {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        hr {
            border: none;
            height: 2px;
            background-color: #B8860B;
            margin: 20px 0;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #f7f2e1;
            margin: 10px 0;
            padding: 12px;
            border-radius: 5px;
        }
        a {
            color: #B8860B;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            padding: 15px;
            margin-top: 30px;
            background-color: #B8860B;
            color: white;
        }
        .bienvenida {
            background-color: #fff6e1;
            padding: 10px;
            border-left: 5px solid #B8860B;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Portal de Acudientes</h1>
    </header>

    <main>
        <div class="bienvenida">
            <?php
                if(isset($datos['nombre']) && isset($datos['apellidos'])) {
                    echo 'Bienvenido/a: <strong>' . $datos['nombre'] . ' ' . $datos['apellidos'] . '</strong> (' . $nombre_usuario . ')';
                } else {
                    echo 'Usuario: <strong>' . $nombre_usuario . '</strong>';
                }
            ?>
        </div>

        <h2>Opciones para Acudientes</h2>
        <ul>
            <li><a href="#">Ver Progreso de mi hijo</a></li>
            <li><a href="#">Consultar Horas de Servicio</a></li>
        </ul>

        <hr>

        <p><a href="modelo/cerrar_sesion.php">Cerrar Sesión</a></p>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Portal Acudientes
    </footer>
</body>
</html>
