<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio Social</title>

    <!-- 🎨 Estilos CSS incrustados -->
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #0bcf5dff, #000000ff);
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0px 3px 6px rgba(0,0,0,0.4);
        }

        h3 {
            font-size: 1.3rem;
            font-weight: normal;
            color: #cbd5e1;
            margin-bottom: 30px;
        }

        /* Estilo base para todos los botones */
        a button {
            border: none;
            padding: 12px 24px;
            margin: 10px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            color: white;
        }

        /* Colores por botón */
        .btn-admin {
            background: #308a24ff;
        }
        .btn-admin:hover {
            background: #226305ff;
        }

        .btn-acudiente {
            background: #b8860b;
        }
        .btn-acudiente:hover {
            background: #9c6e09;
        }

        .btn-estudiante {
            background: #2563eb;
        }
        .btn-estudiante:hover {
            background: #1d4ed8;
        }

        .btn-supervisor {
            background: #800000;
        }
        .btn-supervisor:hover {
            background: #660000;
        }

        /* Efecto de hover general */
        a button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.4);
        }

        a button:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
        }
    </style>

    <center>
        <h1>Bienvenido a servicio social <h1>
        <h3>Inicio de sesión</h3>
        <br><br>
        <a href="modelo/login_admin.php">
            <button type="submit" class="btn-admin">Admin</button>
        </a>

        <a href="modelo/login_acudiente.php">
            <button type="submit" class="btn-acudiente">Acudiente</button>
        </a>
        
        <a href="modelo/login_estudiante.php">
            <button type="submit" class="btn-estudiante">Estudiante</button>
        </a>

        <a href="modelo/login_supervisor.php">
            <button type="submit" class="btn-supervisor">Supervisor</button>
        </a>
    </center>
    <h1></h1>
</head>
<body>
    
</body>
</html>
