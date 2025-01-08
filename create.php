<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['nombre'];
   
   
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    

    $sql = "INSERT INTO clientes ( nombre, dni, telefono) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([ $nombre, $dni, $telefono])) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Enlazando el archivo CSS -->
</head>
<body>
    <h2>Agregar Cliente</h2>
    <form method="POST">
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        
        
        
        
        <label for="dni">DNI:</label>
        <input type="text" name="dni" required>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required>
        
        
        
        <button type="submit">Agregar</button>
    </form>
    <a href="index.php">Volver</a>
</body>
</html>