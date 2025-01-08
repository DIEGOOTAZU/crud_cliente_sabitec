<?php
session_start(); // Iniciar la sesión
include 'db.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

// Verificar si se ha pasado una placa
if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];

    // Consultar pagos asociados al vehículo
    $stmt = $pdo->prepare("SELECT mes, estado FROM pagos WHERE placa = :placa");
    $stmt->execute(['placa' => $placa]);
    $pagos = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Cambiar a FETCH_KEY_PAIR para obtener un array con mes como clave
} else {
    // Redirigir si no se proporciona una placa
    header("Location: index.php"); // Cambia 'index.php' por el nombre de tu archivo principal
    exit();
}

// Manejar la actualización del estado del pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mes'])) {
    $mes = $_POST['mes'];
    $estado = $_POST['estado'];
    $fecha_pago = $_POST['fecha_pago'];

    // Verificar si la placa existe en la tabla clientes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE placa = :placa");
    $stmt->execute(['placa' => $placa]);
    $existe = $stmt->fetchColumn();

    if ($existe) {
        // Aquí puedes agregar lógica para insertar o actualizar el estado del pago en la base de datos
        $stmt = $pdo->prepare("INSERT INTO pagos (placa, mes, estado) VALUES (:placa, :mes, :estado)
                                ON DUPLICATE KEY UPDATE estado = :estado");
        $stmt->execute(['placa' => $placa, 'mes' => $mes, 'estado' => $estado]);

        // Almacenar en la sesión
        $_SESSION['estado'][$mes] = $estado;
        $_SESSION['fecha'][$mes] = $fecha_pago;

        // Redirigir para evitar reenvío del formulario
        header("Location: consultar_pagos.php?placa=" . $placa);
        exit();
    } else {
        echo "Error: La placa '$placa' no existe en la tabla de clientes.";
    }
}

// Array de meses
$meses = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Pagos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Pagos del Vehículo</h1>
    <table>
        <tr>
            <th>Estado</th>
            <?php foreach ($meses as $mes): ?>
                <th><?php echo $mes; ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>Seleccionar Estado</td>
            <?php foreach ($meses as $mes): ?>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                        <select name="estado">
                            <option value="pagado" <?php echo (isset($pagos[$mes]) && $pagos[$mes] === 'pagado') ? 'selected' : ''; ?>>Pagado</option>
                            <option value="dado de baja" <?php echo (isset($pagos[$mes]) && $pagos[$mes] === 'dado de baja') ? 'selected' : ''; ?>>Dado de baja</option>
                            <option value="suspendido" <?php echo (isset($pagos[$mes]) && $pagos[$mes] === 'suspendido') ? 'selected' : ''; ?>>Suspendido</option>
                            <option value="debe" <?php echo (isset($pagos[$mes]) && $pagos[$mes] === 'debe') ? 'selected' : ''; ?>>Debe</option>
                        </select>
                        <br>
                        <input type="date" name="fecha_pago" placeholder="Fecha de pago" value="<?php echo (isset($pagos[$mes]) && $pagos[$mes] === 'pagado') ? date('Y-m-d') : ''; ?>">
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
            <?php endforeach; ?>
        </tr>
    </table>
    <a href="index.php">Volver a la lista de clientes</a>
</body>
</html>