<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$id]);
$clientes = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $nombre = $_POST['nombre'];
    $tecnico = $_POST['Tecnico'];
    $chip = $_POST['chip'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $monto = $_POST['monto'];

    $stmt = $pdo->prepare("UPDATE clientes SET placa = ?, nombre = ?, tecnico = ?, chip = ?, dni = ?, telefono = ?, monto = ? WHERE id = ?");
    $stmt->execute([$placa, $nombre, $tecnico, $chip, $dni, $telefono, $monto, $id]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Clientes</title>
    <link rel="stylesheet" href="style.css"> <!-- Enlazando el archivo CSS -->
</head>
<body>
    <h1>Editar Clientes</h1>
    <form action="" method="POST">
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $clientes['nombre']; ?>" required>
       
        
        <label for="dni">DNI:</label>
        <input type="text" name="dni" value="<?php echo $clientes['dni']; ?>" required>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $clientes['telefono']; ?>" required>
       
        <button type="submit">Actualizar</button>
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>