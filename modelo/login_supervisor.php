
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Supervisor</title>

    <!-- 🎨 Estilos adaptados -->
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

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 0px 3px 6px rgba(0,0,0,0.4);
        }

        label {
            font-size: 1rem;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 250px;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-top: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        button {
            background: #a00000;
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
            background: #c00000;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.4);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
        }

        form {
            text-align: center;
        }
    </style>
</head>
<body>
    <form action="loguearse_supervisor.php" method="POST">
        <h1>Iniciar sesión para supervisor</h1>
        
        <label for="supervisor_correo">Ingrese su correo electrónico:</label>
        <br><br>
        <input type="email" name="correo" id="supervisor_correo" required>
        <br><br>
        
        <label for="supervisor_password">Ingrese su contraseña:</label>
        <br><br>
        <input type="password" name="password" id="supervisor_password" required>
        <br><br>
        
        <button type="submit">Ingresar</button>    
    </form>
</body>
</html>