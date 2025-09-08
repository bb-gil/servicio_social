<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- 🎨 Estilos basados en el index.php -->
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
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 0px 3px 6px rgba(0,0,0,0.4);
        }

        label {
            font-size: 1rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 250px;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-top: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        button {
            background: #308a24ff;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 15px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.4);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <center>
        <h1>Iniciar sesión para administradores</h1>
        <form action="loguearse_admin.php" method="POST">
            <label for="">Ingrese su correo electrónico:</label>
            <br><br>
            <input type="text" name="email" id="" required>
            <br><br>
            <label for="">Ingrese su contraseña:</label>
            <br><br>
            <input type="text" name="contraseña" id="" required>
            <br><br>
            <button type="submit">Ingresar</button>
        </form>
    </center>
</body>
</html>
