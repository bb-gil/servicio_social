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

// Obtener datos del administrador actual
$query = "SELECT nombre, apellidos FROM administrador WHERE correo = '$nombre_usuario'";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_array($resultado);

$mensaje = '';
$busqueda = '';

// Procesar búsqueda
if(isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['busqueda']);
}

// Procesar POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eliminar administrador
    if (isset($_POST['eliminar'])) {
        $id_administrador = mysqli_real_escape_string($conexion, $_POST['id_administrador']);

        $query_verificar = "SELECT correo FROM administrador WHERE id_administrador = $id_administrador";
        $resultado_verificar = mysqli_query($conexion, $query_verificar);
        $admin_a_eliminar = mysqli_fetch_assoc($resultado_verificar);

        if ($admin_a_eliminar['correo'] == $nombre_usuario) {
            $mensaje = "No puedes eliminar tu propia cuenta";
        } else {
            $eliminar = "DELETE FROM administrador WHERE id_administrador = $id_administrador";
            if (mysqli_query($conexion, $eliminar)) {
                $mensaje = "Administrador eliminado correctamente";
            } else {
                $mensaje = "Error al eliminar administrador: " . mysqli_error($conexion);
            }
        }
    }

    // Actualizar administrador
    if (isset($_POST['actualizar'])) {
        $id_administrador = mysqli_real_escape_string($conexion, $_POST['id_administrador']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
        $doc_identidad = mysqli_real_escape_string($conexion, $_POST['doc_identidad']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

        $verificar = "SELECT * FROM administrador WHERE correo = '$correo' AND id_administrador != $id_administrador";
        $resultado_verificar = mysqli_query($conexion, $verificar);

        if (mysqli_num_rows($resultado_verificar) > 0) {
            $mensaje = "El correo electrónico ya está registrado con otro administrador";
        } else {
            $actualizar = "UPDATE administrador SET 
                          nombre = '$nombre', 
                          apellidos = '$apellidos', 
                          doc_identidad = '$doc_identidad', 
                          correo = '$correo', 
                          telefono = '$telefono'";
            if (!empty($contrasena)) {
                $actualizar .= ", contraseña = '$contrasena'";
            }
            $actualizar .= " WHERE id_administrador = $id_administrador";

            if (mysqli_query($conexion, $actualizar)) {
                $mensaje = "Administrador actualizado correctamente";
            } else {
                $mensaje = "Error al actualizar administrador: " . mysqli_error($conexion);
            }
        }
    }
}

// Obtener lista de administradores
$query_administradores = "SELECT * FROM administrador";
if (!empty($busqueda)) {
    $query_administradores .= " WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
}
$query_administradores .= " ORDER BY nombre, apellidos";
$resultado_administradores = mysqli_query($conexion, $query_administradores);

// Total administradores
$query_total = "SELECT COUNT(*) as total FROM administrador";
$resultado_total = mysqli_query($conexion, $query_total);
$datos_total = mysqli_fetch_assoc($resultado_total);
$total_administradores = $datos_total['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ver Administradores</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4fdf4;
        margin: 0;
        padding: 20px;
    }
    h1, h2 {
        color: #308a24ff;
    }
    hr {
        border: 1px solid #308a24ff;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background: #ffffff;
        box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
    }
    table th {
        background-color: #308a24ff;
        color: white;
        padding: 10px;
        text-align: left;
    }
    table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    tr:hover {
        background-color: #eaf9ea;
    }
    form {
        margin: 0;
    }
    input, button {
        padding: 5px;
        margin: 2px;
    }
    button {
        background-color: #308a24ff;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    button:hover {
        background-color: #256b1b;
    }
    a {
        color: #308a24ff;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    .mensaje {
        background-color: #d4edda;
        padding: 10px;
        border: 1px solid #308a24ff;
        margin: 10px 0;
        border-radius: 4px;
        color: #155724;
    }
</style>
</head>
<body>
    <h1>Lista de Administradores</h1>
    <hr>
    <p>
        <?php
        if(isset($datos['nombre']) && isset($datos['apellidos'])) {
            echo 'Administrador: <strong>' . $datos['nombre'] . ' ' . $datos['apellidos'] . '</strong> (' . $nombre_usuario . ')';
        } else {
            echo 'Usuario: ' . $nombre_usuario;
        }
        ?>
    </p>
    <hr>

    <?php if(!empty($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <p>Total de administradores en la base de datos: <?php echo $total_administradores; ?></p>

    <h2>Buscar Administradores</h2>
    <form method="GET" action="">
        <input type="text" id="busqueda" name="busqueda" placeholder="Nombre o apellido" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" name="buscar">Buscar</button>
        <?php if (!empty($busqueda)): ?>
            <a href="ver_administradores.php">Limpiar búsqueda</a>
        <?php endif; ?>
    </form>

    <h2>Lista de Administradores</h2>
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
            <?php 
            if (mysqli_num_rows($resultado_administradores) > 0) {
                while($administrador = mysqli_fetch_assoc($resultado_administradores)): 
            ?>
            <tr>
                <td><?php echo $administrador['id_administrador']; ?></td>
                <td><?php echo $administrador['nombre']; ?></td>
                <td><?php echo $administrador['apellidos']; ?></td>
                <td><?php echo $administrador['doc_identidad']; ?></td>
                <td><?php echo $administrador['correo']; ?></td>
                <td><?php echo $administrador['telefono']; ?></td>
                <td><?php echo $administrador['contraseña']; ?></td>
                <td>
                    <?php if($administrador['correo'] != $nombre_usuario): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="id_administrador" value="<?php echo $administrador['id_administrador']; ?>">
                        <button type="submit" name="eliminar">Eliminar</button>
                    </form>
                    <?php endif; ?>
                    <button onclick="mostrarFormularioEdicion(<?php echo $administrador['id_administrador']; ?>)">Editar</button>
                    <div id="editar-<?php echo $administrador['id_administrador']; ?>" style="display: none; margin-top:10px;">
                        <form method="POST" action="">
                            <input type="hidden" name="id_administrador" value="<?php echo $administrador['id_administrador']; ?>">
                            <input type="text" name="nombre" value="<?php echo $administrador['nombre']; ?>" required>
                            <input type="text" name="apellidos" value="<?php echo $administrador['apellidos']; ?>" required>
                            <input type="text" name="doc_identidad" value="<?php echo $administrador['doc_identidad']; ?>" required>
                            <input type="email" name="correo" value="<?php echo $administrador['correo']; ?>" required>
                            <input type="text" name="telefono" value="<?php echo $administrador['telefono']; ?>" required>
                            <input type="text" name="contrasena" placeholder="Nueva contraseña">
                            <button type="submit" name="actualizar">Guardar Cambios</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php 
                endwhile; 
            } else {
                echo "<tr><td colspan='8'>No se encontraron administradores</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <hr>
    <a href="gestionar_administradores.php">Agregar Nuevo Administrador</a> | 
    <a href="pagina_administrador.php">Volver al Panel de Administrador</a>

    <script>
        function mostrarFormularioEdicion(id) {
            var formulario = document.getElementById('editar-' + id);
            formulario.style.display = (formulario.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>
