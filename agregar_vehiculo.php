<?php
include 'db.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

// Verificar si se ha pasado un ID de cliente
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Obtener el nombre del cliente
    $stmt = $pdo->prepare("SELECT nombre FROM clientes WHERE id = :id");
    $stmt->execute(['id' => $cliente_id]);
    $cliente = $stmt->fetch();

    if (!$cliente) {
        // Si no se encuentra el cliente, redirigir a la lista de clientes
        header("Location: index.php"); // Cambia 'index.php' por el nombre de tu archivo principal
        exit();
    }
} else {
    header("Location: index.php"); // Cambia 'index.php' por el nombre de tu archivo principal
    exit();
}

// Procesar el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $anio = $_POST['anio'];

    // Insertar el vehículo en la base de datos
    $stmt = $pdo->prepare("INSERT INTO vehiculos (placa, modelo, marca, anio, cliente_id) VALUES (:placa, :modelo, :marca, :anio, :cliente_id)");
    $stmt->execute([
        'placa' => $placa,
        'modelo' => $modelo,
        'marca' => $marca,
        'anio' => $anio,
        'cliente_id' => $cliente_id
    ]);

    // Redirigir después de agregar el vehículo
    header("Location: consultar_vehiculos.php?id=" . $cliente_id); // Cambia a la página que desees
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"> <!-- Enlazando el archivo CSS -->
    <title>Agregar Vehículo</title>
</head>
<body>
    <h1>Agregar Vehículo para el Cliente: <?php echo htmlspecialchars($cliente['nombre']); ?></h1>
    <form action="" method="POST">
        <label for="placa">Placa:</label>
        <input type="text" name="placa" required>
        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" required>
        <label for="marca">Marca:</label>
        <input type="text" name="marca" required>
        <label for="anio">Año:</label>
        <input type="number" name="anio" required>
        <button type="submit">Agregar Vehículo</button>
    </form>
    <a href="index.php">Volver a la lista de clientes</a> <!-- Cambia 'index.php' por el nombre de tu archivo principal -->
</body>
</html>