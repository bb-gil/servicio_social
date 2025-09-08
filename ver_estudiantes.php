<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

require 'modelo/conexion.php';
session_start();

// Verificar si existe una sesión de administrador
if(!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$nombre_usuario = $_SESSION['username'];

// Obtener datos del administrador
$query = "SELECT nombre, apellidos FROM administrador WHERE correo = '$nombre_usuario'";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_array($resultado);

$mensaje = '';
$busqueda = '';

// Procesar búsqueda
if(isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['busqueda']);
}

// Procesar acciones POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eliminar estudiante
    if (isset($_POST['eliminar'])) {
        $id_estudiante = mysqli_real_escape_string($conexion, $_POST['id_estudiante']);
        $eliminar = "DELETE FROM estudiante WHERE id_estudiante = $id_estudiante";
        if (mysqli_query($conexion, $eliminar)) {
            $mensaje = "Estudiante eliminado correctamente";
        } else {
            $mensaje = "Error al eliminar estudiante: " . mysqli_error($conexion);
        }
    }

    // Actualizar estudiante
    if (isset($_POST['actualizar'])) {
        $id_estudiante = mysqli_real_escape_string($conexion, $_POST['id_estudiante']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
        $cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

        // Validar correo único
        $verificar = "SELECT * FROM estudiante WHERE correo = '$correo' AND id_estudiante != $id_estudiante";
        $resultado_verificar = mysqli_query($conexion, $verificar);

        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "El correo electrónico ya está registrado con otro estudiante";
        } else {
            $actualizar = "UPDATE estudiante SET 
                            nombre = '$nombre', 
                            apellidos = '$apellidos', 
                            doc_identidad = '$cedula', 
                            correo = '$correo', 
                            telefono = '$telefono'";

            if (!empty($contrasena)) {
                $actualizar .= ", contraseña = '$contrasena'";
            }

            $actualizar .= " WHERE id_estudiante = $id_estudiante";

            if (mysqli_query($conexion, $actualizar)) {
                $mensaje = "Estudiante actualizado correctamente";
            } else {
                $mensaje = "Error al actualizar estudiante: " . mysqli_error($conexion);
            }
        }
    }
}

// Consulta principal
$query_estudiante = "SELECT * FROM estudiante";
if (!empty($busqueda)) {
    $query_estudiante .= " WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
}
$query_estudiante .= " ORDER BY nombre, apellidos";
$resultado_estudiante = mysqli_query($conexion, $query_estudiante);

// Total estudiantes
$query_total = "SELECT COUNT(*) as total FROM estudiante";
$resultado_total = mysqli_query($conexion, $query_total);
$total_estudiantes = mysqli_fetch_assoc($resultado_total)['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ver Estudiantes</title>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: white;
        margin: 0;
        padding: 20px;
    }
    h1, h2 {
        text-align: center;
        text-shadow: 0px 2px 5px rgba(0,0,0,0.4);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    table th, table td {
        padding: 10px;
        border: 1px solid rgba(255,255,255,0.2);
        text-align: center;
    }
    table th {
        background: rgba(0,0,0,0.3);
    }
    input, button {
        padding: 8px;
        border: none;
        border-radius: 5px;
    }
    button {
        background: #1d4ed8;
        color: white;
        cursor: pointer;
    }
    button:hover {
        background: #153eab;
    }
    a {
        color: #93c5fd;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    .mensaje {
        text-align: center;
        background: rgba(0,0,0,0.3);
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
</style>
</head>
<body>
    <h1>Lista de Estudiantes</h1>
    <p style="text-align:center;">Administrador: <?php echo $datos['nombre']." ".$datos['apellidos']." (".$nombre_usuario.")"; ?></p>

    <?php if(!empty($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <p style="text-align:center;">Total de estudiantes en la base de datos: <?php echo $total_estudiantes; ?></p>

    <h2>Buscar estudiantes</h2>
    <form method="GET" action="" style="text-align:center;">
        <input type="text" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Nombre o apellido">
        <button type="submit" name="buscar">Buscar</button>
        <?php if (!empty($busqueda)): ?>
            <a href="ver_estudiante.php">Limpiar búsqueda</a>
        <?php endif; ?>
    </form>

    <h2>Lista</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Documento ID</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado_estudiante) > 0): ?>
                <?php while($estudiante = mysqli_fetch_assoc($resultado_estudiante)): ?>
                    <tr>
                        <td><?php echo $estudiante['id_estudiante']; ?></td>
                        <td><?php echo $estudiante['nombre']; ?></td>
                        <td><?php echo $estudiante['apellidos']; ?></td>
                        <td><?php echo $estudiante['doc_identidad']; ?></td>
                        <td><?php echo $estudiante['correo']; ?></td>
                        <td><?php echo $estudiante['telefono']; ?></td>
                        <td><?php echo $estudiante['contraseña']; ?></td>
                        <td>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="id_estudiante" value="<?php echo $estudiante['id_estudiante']; ?>">
                                <button type="submit" name="eliminar">Eliminar</button>
                            </form>
                            <button onclick="document.getElementById('editar-<?php echo $estudiante['id_estudiante']; ?>').style.display='block'">Editar</button>
                            <div id="editar-<?php echo $estudiante['id_estudiante']; ?>" style="display:none; background:rgba(255,255,255,0.1); padding:10px; margin-top:10px;">
                                <form method="POST" action="">
                                    <input type="hidden" name="id_estudiante" value="<?php echo $estudiante['id_estudiante']; ?>">
                                    <input type="text" name="nombre" value="<?php echo $estudiante['nombre']; ?>" required>
                                    <input type="text" name="apellidos" value="<?php echo $estudiante['apellidos']; ?>" required>
                                    <input type="text" name="cedula" value="<?php echo $estudiante['doc_identidad']; ?>" required>
                                    <input type="email" name="correo" value="<?php echo $estudiante['correo']; ?>" required>
                                    <input type="text" name="telefono" value="<?php echo $estudiante['telefono']; ?>" required>
                                    <input type="text" name="contrasena" placeholder="Nueva contraseña">
                                    <button type="submit" name="actualizar">Guardar Cambios</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No se encontraron estudiantes</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="gestionar_estudiante.php">Agregar Nuevo Estudiante</a></p>
    <p><a href="pagina_administrador.php">Volver al Panel de Administrador</a></p>
</body>
</html>
