<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

require 'modelo/conexion.php';
session_start();

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

// Procesar eliminar supervisor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $id_supervisor = mysqli_real_escape_string($conexion, $_POST['id_supervisor']);
    $eliminar = "DELETE FROM supervisor WHERE id_supervisor = $id_supervisor";
    if (mysqli_query($conexion, $eliminar)) {
        $mensaje = "Supervisor eliminado correctamente";
    } else {
        $mensaje = "Error al eliminar supervisor: " . mysqli_error($conexion);
    }
}

// Obtener lista de supervisores
$query_supervisores = "SELECT * FROM supervisor";
if (!empty($busqueda)) {
    $query_supervisores .= " WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%' OR correo LIKE '%$busqueda%'";
}
$query_supervisores .= " ORDER BY nombre, apellidos";
$resultado_supervisores = mysqli_query($conexion, $query_supervisores);

// Total supervisores
$query_total = "SELECT COUNT(*) as total FROM supervisor";
$resultado_total = mysqli_query($conexion, $query_total);
$datos_total = mysqli_fetch_assoc($resultado_total);
$total_supervisores = $datos_total['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Supervisores</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #800000, #a00000);
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
            background: white;
            color: black;
            margin-top: 20px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.4);
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background: #800000;
            color: white;
        }
        button {
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[name="eliminar"] {
            background: #e74c3c;
            color: white;
        }
        form {
            display: inline;
        }
        .mensaje {
            background: rgba(255,255,255,0.15);
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }
        a {
            color: white;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .acciones-finales {
            margin-top: 20px;
            text-align: center;
        }
        input[type="text"] {
            padding: 6px;
            border-radius: 5px;
            border: none;
        }
        button[name="buscar"] {
            background: #800000;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        button[name="buscar"]:hover {
            background: #a00000;
        }
    </style>
</head>
<body>
    <h1>Lista de Supervisores</h1>
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
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <p>Total de supervisores: <?php echo $total_supervisores; ?></p>

    <h2>Buscar Supervisores</h2>
    <form method="GET" action="">
        <label for="busqueda">Buscar:</label>
        <input type="text" id="busqueda" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" name="buscar">Buscar</button>
        <?php if (!empty($busqueda)): ?>
            <a href="ver_supervisor.php">Limpiar búsqueda</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID Supervisor</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Documento</th>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Sede</th>
                <th>Dependencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($resultado_supervisores) > 0) {
                while($supervisor = mysqli_fetch_assoc($resultado_supervisores)): 
            ?>
            <tr>
                <td><?php echo $supervisor['id_supervisor']; ?></td>
                <td><?php echo $supervisor['nombre']; ?></td>
                <td><?php echo $supervisor['apellidos']; ?></td>
                <td><?php echo $supervisor['doc_identidad']; ?></td>
                <td><?php echo $supervisor['correo']; ?></td>
                <td><?php echo $supervisor['contraseña']; ?></td>
                <td><?php echo $supervisor['id_sede']; ?></td>
                <td><?php echo $supervisor['dependencia']; ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id_supervisor" value="<?php echo $supervisor['id_supervisor']; ?>">
                        <button type="submit" name="eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php 
                endwhile; 
            } else {
                echo "<tr><td colspan='9'>No se encontraron supervisores</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="acciones-finales">
        <a href="agregar_supervisor.php">Agregar Nuevo Supervisor</a>
        <br>
        <a href="pagina_administrador.php">Volver al Panel de Administrador</a>
    </div>
</body>
</html>
