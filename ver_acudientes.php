<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
require 'modelo/conexion.php';
session_start();

// Verificar sesión
if(!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$nombre_usuario = $_SESSION['username'];

// Obtener datos del administrador
$query = "SELECT nombre, apellidos FROM administrador WHERE correo = '$nombre_usuario'";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_array($resultado);

// Variables
$mensaje = '';
$busqueda = '';

// Búsqueda
if(isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['busqueda']);
}

// Eliminar o actualizar acudiente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['eliminar'])) {
        $id_acudiente = mysqli_real_escape_string($conexion, $_POST['id_acudiente']);
        $verificar = "SELECT * FROM estudiante WHERE id_acudiente = $id_acudiente";
        $resultado_verificar = mysqli_query($conexion, $verificar);

        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "No se puede eliminar este acudiente porque tiene estudiantes asociados";
        } else {
            $eliminar = "DELETE FROM acudiente WHERE id_acudiente = $id_acudiente";
            $mensaje = mysqli_query($conexion, $eliminar) 
                ? "Acudiente eliminado correctamente" 
                : "Error al eliminar acudiente: " . mysqli_error($conexion);
        }
    }

    if (isset($_POST['actualizar'])) {
        $id_acudiente = mysqli_real_escape_string($conexion, $_POST['id_acudiente']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
        $cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

        $verificar = "SELECT * FROM acudiente WHERE correo = '$correo' AND id_acudiente != $id_acudiente";
        $resultado_verificar = mysqli_query($conexion, $verificar);

        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "El correo electrónico ya está registrado con otro acudiente";
        } else {
            $actualizar = "UPDATE acudiente SET 
                          nombre = '$nombre', 
                          apellidos = '$apellidos', 
                          doc_identidad = '$cedula', 
                          correo = '$correo', 
                          telefono = '$telefono'";

            if (!empty($contrasena)) {
                $actualizar .= ", contraseña = '$contrasena'";
            }

            $actualizar .= " WHERE id_acudiente = $id_acudiente";
            $mensaje = mysqli_query($conexion, $actualizar) 
                ? "Acudiente actualizado correctamente" 
                : "Error al actualizar acudiente: " . mysqli_error($conexion);
        }
    }
}

// Consulta de acudientes
$query_acudientes = "SELECT * FROM acudiente";
if (!empty($busqueda)) {
    $query_acudientes .= " WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
}
$query_acudientes .= " ORDER BY nombre, apellidos";
$resultado_acudientes = mysqli_query($conexion, $query_acudientes);

$query_total = "SELECT COUNT(*) as total FROM acudiente";
$resultado_total = mysqli_query($conexion, $query_total);
$datos_total = mysqli_fetch_assoc($resultado_total);
$total_acudientes = $datos_total['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Acudientes</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #B8860B, #e0a835);
            background-size: 200% 200%;
            animation: gradientBG 8s ease infinite;
            color: white;
            min-height: 100vh;
            padding: 20px;
        }
        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        h1, h2 {
            text-align: center;
            text-shadow: 0px 3px 6px rgba(0,0,0,0.4);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background: rgba(0,0,0,0.3);
        }
        tr:nth-child(even) {
            background: rgba(255,255,255,0.05);
        }
        input, button {
            padding: 6px;
            border-radius: 6px;
            border: none;
            margin: 3px;
        }
        button {
            cursor: pointer;
            background: #000000;
            color: white;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #6d1010;
        }
        a {
            color: #fffacd;
        }
        a:hover {
            text-decoration: underline;
        }
        .mensaje {
            text-align: center;
            padding: 10px;
            background: rgba(0,0,0,0.3);
            margin: 10px auto;
            border-radius: 6px;
            width: fit-content;
        }
    </style>
</head>
<body>
    <h1>Lista de Acudientes</h1>
    <hr>
    <p style="text-align:center;">
        <?php
            if(isset($datos['nombre']) && isset($datos['apellidos'])) {
                echo 'Administrador: ' . $datos['nombre'] . ' ' . $datos['apellidos'] . ' (' . $nombre_usuario . ')';
            } else {
                echo 'Usuario: ' . $nombre_usuario;
            }
        ?>
    </p>
    <hr>

    <?php if(!empty($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <p style="text-align:center;">Total de acudientes: <?php echo $total_acudientes; ?></p>

    <h2>Buscar Acudientes</h2>
    <form method="GET" style="text-align:center;">
        <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" name="buscar">Buscar</button>
        <?php if (!empty($busqueda)): ?>
            <a href="ver_acudientes.php">Limpiar</a>
        <?php endif; ?>
    </form>

    <h2>Lista</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Apellidos</th><th>Documento</th>
                <th>Correo</th><th>Teléfono</th><th>Contraseña</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($resultado_acudientes) > 0) {
                while($acudiente = mysqli_fetch_assoc($resultado_acudientes)): ?>
                <tr>
                    <td><?php echo $acudiente['id_acudiente']; ?></td>
                    <td><?php echo $acudiente['nombre']; ?></td>
                    <td><?php echo $acudiente['apellidos']; ?></td>
                    <td><?php echo $acudiente['doc_identidad']; ?></td>
                    <td><?php echo $acudiente['correo']; ?></td>
                    <td><?php echo $acudiente['telefono']; ?></td>
                    <td><?php echo $acudiente['contraseña']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_acudiente" value="<?php echo $acudiente['id_acudiente']; ?>">
                            <button type="submit" name="eliminar">Eliminar</button>
                        </form>
                        <button onclick="mostrarFormularioEdicion(<?php echo $acudiente['id_acudiente']; ?>)">Editar</button>
                        <div id="editar-<?php echo $acudiente['id_acudiente']; ?>" style="display:none; margin-top:10px;">
                            <form method="POST">
                                <input type="hidden" name="id_acudiente" value="<?php echo $acudiente['id_acudiente']; ?>">
                                <input type="text" name="nombre" value="<?php echo $acudiente['nombre']; ?>" required>
                                <input type="text" name="apellidos" value="<?php echo $acudiente['apellidos']; ?>" required>
                                <input type="text" name="cedula" value="<?php echo $acudiente['doc_identidad']; ?>" required>
                                <input type="email" name="correo" value="<?php echo $acudiente['correo']; ?>" required>
                                <input type="text" name="telefono" value="<?php echo $acudiente['telefono']; ?>" required>
                                <input type="text" name="contrasena" placeholder="Nueva contraseña">
                                <button type="submit" name="actualizar">Guardar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; 
            } else {
                echo "<tr><td colspan='8'>No se encontraron acudientes</td></tr>";
            } ?>
        </tbody>
    </table>
    
    <hr>
    <p style="text-align:center;">
        <a href="gestionar_acudientes.php">Agregar Nuevo Acudiente</a> |
        <a href="pagina_administrador.php">Volver al Panel</a>
    </p>

    <script>
        function mostrarFormularioEdicion(id) {
            var formulario = document.getElementById('editar-' + id);
            formulario.style.display = (formulario.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>
