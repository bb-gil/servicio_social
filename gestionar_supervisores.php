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

    $query_sedes = "SELECT id_sede, nombre_sede FROM sede ORDER BY nombre_sede";
    $resultado_sedes = mysqli_query($conexion, $query_sedes);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
        $doc_identidad = mysqli_real_escape_string($conexion, $_POST['doc_identidad']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
        $id_sede = mysqli_real_escape_string($conexion, $_POST['id_sede']);
        $dependencia = mysqli_real_escape_string($conexion, $_POST['dependencia']);
        
        $verificar = "SELECT * FROM supervisor WHERE correo = '$correo'";
        $resultado_verificar = mysqli_query($conexion, $verificar);
        
        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "El correo electrónico ya está registrado";
        } else {
            $insertar = "INSERT INTO supervisor (nombre, apellidos, doc_identidad, telefono, correo, contraseña, id_sede, dependencia) 
                        VALUES ('$nombre', '$apellidos', '$doc_identidad', '$telefono', '$correo', '$contrasena', '$id_sede', '$dependencia')";
            
            if (mysqli_query($conexion, $insertar)) {
                $mensaje = "Supervisor agregado correctamente";
            } else {
                $mensaje = "Error al agregar supervisor: " . mysqli_error($conexion);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Supervisor</title>
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
    <h1>Agregar Supervisor</h1>
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

    <h2>Agregar Nuevo Supervisor</h2>
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

        <label for="id_sede">Sede:</label>
        <select id="id_sede" name="id_sede" required>
            <option value="">Seleccione una sede</option>
            <?php while($sede = mysqli_fetch_assoc($resultado_sedes)): ?>
                <option value="<?php echo $sede['id_sede']; ?>">
                    <?php echo $sede['nombre_sede']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="dependencia">Dependencia:</label>
        <input type="text" id="dependencia" name="dependencia" required>

        <button type="submit" name="agregar">Agregar Supervisor</button>
    </form>
    
    <hr>
    <a href="ver_supervisor.php">Ver Lista de Supervisores</a>
    <br>
    <a href="pagina_administrador.php">Volver al Panel de Administrador</a>
</body>
</html>
