<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
?>

<?php
    require 'modelo/conexion.php';

    session_start();

    if(!isset($_SESSION['username']))
    {
        header("location: index.php");
        exit();
    }

    $nombre_usuario = $_SESSION['username'];
    
    $query = "SELECT nombre, apellidos FROM administrador WHERE correo = '$nombre_usuario'";
    $resultado = mysqli_query($conexion, $query);
    $datos = mysqli_fetch_array($resultado);

    $mensaje = '';

    $query_grados = "SELECT id_grado, nombre FROM grado ORDER BY nombre";
    $resultado_grados = mysqli_query($conexion, $query_grados);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
        $id_grupo = mysqli_real_escape_string($conexion, $_POST['id_grupo']);
        $nombre_grupo = mysqli_real_escape_string($conexion, $_POST['nombre_grupo']);
        $id_grado = mysqli_real_escape_string($conexion, $_POST['id_grado']);
        
        $verificar = "SELECT * FROM grupo WHERE id_grupo = '$id_grupo'";
        $resultado_verificar = mysqli_query($conexion, $verificar);
        
        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "El ID del grupo ya está registrado";
        } else {
            $insertar = "INSERT INTO grupo (id_grupo, nombre, id_grado) VALUES ('$id_grupo', '$nombre_grupo', '$id_grado')";
            
            if (mysqli_query($conexion, $insertar)) {
                $mensaje = "Grupo agregado correctamente";
            } else {
                $mensaje = "Error al agregar grupo: " . mysqli_error($conexion);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Grupo</title>
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

        form {
            background-color: rgba(0, 50, 32, 0.9);
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.4);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: none;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }

        button {
            background: #025939;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
        }

        button:hover {
            background: #038c5a;
            transform: translateY(-2px);
        }

        .mensaje {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
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
    <h1>Agregar Grupo</h1>
    <hr>
    <?php
        if(isset($datos['nombre']) && isset($datos['apellidos'])) {
            echo '<p>Administrador: ' . $datos['nombre'] . ' ' . $datos['apellidos'] . ' (' . $nombre_usuario . ')</p>';
        } else {
            echo '<p>Usuario: ' . $nombre_usuario . '</p>';
        }
    ?>
    <hr>

    <?php if(!empty($mensaje)): ?>
        <div class="mensaje">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <h2>Agregar Nuevo Grupo</h2>
    <form method="POST" action="">
        <label for="id_grupo">ID del Grupo:</label>
        <input type="text" id="id_grupo" name="id_grupo" required>

        <label for="nombre_grupo">Nombre del Grupo:</label>
        <input type="text" id="nombre_grupo" name="nombre_grupo" placeholder="pon el nombre aquí" required>

        <label for="id_grado">Grado:</label>
        <select id="id_grado" name="id_grado" required>
            <option value="">Seleccione un grado</option>
            <?php while($grado = mysqli_fetch_assoc($resultado_grados)): ?>
                <option value="<?php echo $grado['id_grado']; ?>">
                    <?php echo $grado['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="agregar">Agregar Grupo</button>
    </form>
    
    <hr>
    <a href="ver_grupos.php">Ver Lista de Grupos</a>
    <br>
    <a href="pagina_administrador.php">Volver al Panel de Administrador</a>
</body>
</html>
