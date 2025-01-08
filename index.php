<?php
include 'db.php';

// Obtener datos
$stmt = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- Para la responsividad -->
    <title>CRUD de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> <!-- Enlazando Bootstrap CSS -->
    <link rel="stylesheet" href="style.css"> <!-- Enlazando el archivo CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> <!-- Bootstrap adicional -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css"> <!-- Estilos para DataTables -->
</head>

<body>
    <div class="container mt-5">
        <h2>Agregar Clientes</h2>
        <form action="create.php" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" name="dni" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
        <a href="exportar.php" class="btn btn-secondary mb-4">Exportar a Excel</a>
        
        <h1>Lista de Clientes</h1>
        <table id="table_clientes" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo $cliente['nombre']; ?></td>
                    <td><?php echo $cliente['dni']; ?></td>
                    <td><?php echo $cliente['telefono']; ?></td>
                    <td>
                    <div class="btn-group me-2" role="group" aria-label="Second group">
    <a href="editar.php?id=<?php echo $cliente['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
    <a href="eliminar.php?id=<?php echo $cliente['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
    <a href="consultar_vehiculos.php?id=<?php echo $cliente['id']; ?>" class="btn btn-info btn-sm">Consultar Vehículos</a>
    <a href="agregar_vehiculo.php?id=<?php echo $cliente['id']; ?>" class="btn btn-success btn-sm">Agregar Vehículo</a>
</div>
</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>
</body>
</html>