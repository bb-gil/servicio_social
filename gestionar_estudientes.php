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

    $query_acudientes = "SELECT id_acudiente, nombre, apellidos FROM acudiente ORDER BY nombre, apellidos";
    $resultado_acudientes = mysqli_query($conexion, $query_acudientes);

    $query_grupos = "SELECT g.id_grupo, g.nombre, gr.nombre as nombre_grado 
                     FROM grupo g 
                     LEFT JOIN grado gr ON g.id_grado = gr.id_grado 
                     ORDER BY g.nombre";
    $resultado_grupos = mysqli_query($conexion, $query_grupos);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
        $doc_identidad = mysqli_real_escape_string($conexion, $_POST['doc_identidad']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
        $id_acudiente = mysqli_real_escape_string($conexion, $_POST['id_acudiente']);
        $id_grupo = mysqli_real_escape_string($conexion, $_POST['id_grupo']);

        if (empty($id_grupo)) {
            $mensaje = "Debe seleccionar un grupo.";
        } else {
            $verificar = "SELECT * FROM estudiante WHERE correo = '$correo'";
            $resultado_verificar = mysqli_query($conexion, $verificar);

            if (mysqli_num_rows($resultado_verificar) > 0) {
                $mensaje = "El correo electrónico ya está registrado";
            } else {
                $insertar = "INSERT INTO estudiante (nombre, apellidos, doc_identidad, telefono, correo, contraseña, id_acudiente) 
                             VALUES ('$nombre', '$apellidos', '$doc_identidad', '$telefono', '$correo', '$contrasena', '$id_acudiente')";

                if (mysqli_query($conexion, $insertar)) {
                    $id_estudiante = mysqli_insert_id($conexion);

                    $ano_actual = date('Y-m-d');
                    $insertar_grupo = "INSERT INTO grupo_estudiante (id_grupo, año, id_estudiante) 
                   VALUES ('$id_grupo', '$ano_actual', '$id_estudiante')";

                    mysqli_query($conexion, $insertar_grupo);

                    $mensaje = "Estudiante registrado correctamente";
                } else {
                    $mensaje = "Error al registrar el estudiante";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estudiante</title>
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

        button:active {
            transform: translateY(0);
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
    <h1>Agregar Estudiante</h1>
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

    <h2>Agregar Nuevo Estudiante</h2>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <label for="doc_identidad">Documento de Identidad:</label>
        <input type="text" id="doc_identidad" name="doc_identidad" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <label for="id_acudiente">Acudiente:</label>
        <select id="id_acudiente" name="id_acudiente" required>
            <option value="">Seleccione un acudiente</option>
            <?php while($acudiente = mysqli_fetch_assoc($resultado_acudientes)): ?>
                <option value="<?php echo $acudiente['id_acudiente']; ?>">
                    <?php echo $acudiente['nombre'] . ' ' . $acudiente['apellidos']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="id_grupo">Grupo:</label>
        <select id="id_grupo" name="id_grupo">
            <option value="">Seleccione un grupo</option>
            <?php while($grupo = mysqli_fetch_assoc($resultado_grupos)): ?>
                <option value="<?php echo $grupo['id_grupo']; ?>">
                    <?php echo $grupo['nombre'] . ' - ' . $grupo['nombre_grado']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="agregar">Agregar Estudiante</button>
    </form>
    
    <hr>
    <a href="ver_estudiantes.php">Ver Lista de Estudiantes</a>
    <br>
    <a href="pagina_administrador.php">Volver al Panel de Administrador</a>
</body>
</html>
