<?php
include 'db.php';

// Verificar si se ha pasado un ID de cliente
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Consultar vehículos asociados al cliente
    $stmt = $pdo->prepare("SELECT * FROM vehiculos WHERE cliente_id = :cliente_id");
    $stmt->execute(['cliente_id' => $cliente_id]);
    $vehiculos = $stmt->fetchAll();
} else {
    // Redirigir si no se proporciona un ID
    header("Location: index.php"); // Cambia 'index.php' por el nombre de tu archivo principal
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Vehículos</title>
    <link rel="stylesheet" href="style.css"> <!-- Enlazando el archivo CSS -->
</head>
<body>
    <h1>Vehículos del Cliente</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Año</th>
            <th>Acciones</th> <!-- Nueva columna para acciones -->
        </tr>
        <?php if (!empty($vehiculos)): ?>
            <?php foreach ($vehiculos as $vehiculo): ?>
            <tr>
                <td><?php echo $vehiculo['id']; ?></td>
                <td><?php echo $vehiculo['placa']; ?></td>
                <td><?php echo $vehiculo['modelo']; ?></td>
                <td><?php echo $vehiculo['marca']; ?></td>
                <td><?php echo $vehiculo['anio']; ?></td>
                <td>
                    <a href="consultar_pagos.php?placa=<?php echo $vehiculo['id']; ?>">Consultar Pagos</a> <!-- Enlace para consultar pagos -->
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No se encontraron vehículos para este cliente.</td>
            </tr>
        <?php endif; ?>
    </table>
    <a href="index.php">Volver a la lista de clientes</a> <!-- Cambia 'index.php' por el nombre de tu archivo principal -->
</body>
</html>