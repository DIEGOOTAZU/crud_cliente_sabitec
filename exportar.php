<?php
include 'db.php';

// Consulta para obtener solo la columna de teléfono
$stmt = $pdo->prepare("SELECT telefono FROM clientes");
$stmt->execute();
$telefonos = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Nombre del archivo
$filename = "telefonos.csv";

// Configurar las cabeceras para la descarga
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$filename\"");

// Abrir el flujo de salida
$output = fopen('php://output', 'w');

// Escribir los encabezados
fputcsv($output, ['Teléfono']);

// Escribir los datos
foreach ($telefonos as $telefono) {
    fputcsv($output, [$telefono]);
}

// Cerrar el flujo
fclose($output);
exit();
?>