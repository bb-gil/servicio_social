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

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg,
                        #B8860B 20%,
                        #308A24 30%,
                        #2563EB 50%,
                        #800000 60%,
                        #B8860B 100%);
            background-size: 200% 200%;
            animation: gradientBG 12s ease infinite;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        @keyframes gradientBG {
            0%   { background-position: 0% 50%; }
            25%  { background-position: 50% 50%; }
            50%  { background-position: 100% 50%; }
            75%  { background-position: 50% 50%; }
            100% { background-position: 0% 50%; }
        }

        h1 {
            font-size: 2.2rem;
            margin: 0 0 18px 0;
            text-shadow: 0px 3px 6px rgba(0, 0, 0, 0.45);
        }

        h3 {
            font-size: 1.3rem;
            font-weight: normal;
            color: #cbd5e1;
            margin-bottom: 30px;
        }

        /* Estilo general de botones */
        a button {
            border: none;
            padding: 12px 24px;
            margin: 10px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            color: white;
            position: relative;
            overflow: hidden;
        }

        /* Brillo animado */
        a button::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: skewX(-20deg);
            transition: 0.5s;
        }

        a button:hover::after {
            left: 100%;
        }

        /* Botón Admin */
        .btn-admin {
            background: #308a24ff;
        }
        .btn-admin:hover {
            background: #226305ff;
        }

        /* Botón Acudiente */
        .btn-acudiente {
            background: #b8860b;
        }
        .btn-acudiente:hover {
            background: #9c6e09;
        }

        /* Botón Estudiante */
        .btn-estudiante {
            background: #2563eb;
        }
        .btn-estudiante:hover {
            background: #1d4ed8;
        }

        /* Botón Supervisor */
        .btn-supervisor {
            background: #800000;
        }
        .btn-supervisor:hover {
            background: #660000;
        }

        /* Hover general */
        a button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.4);
        }

        a button:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <center>
        <h1>Bienvenido a servicio social</h1>
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
</body>
</html>
