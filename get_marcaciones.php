<?php
include 'db_connect.php';

if (isset($_GET['dni']) && isset($_GET['fecha'])) {
    $dni = $_GET['dni'];
    $fecha = $_GET['fecha'];

    $query = "SELECT * FROM marcaciones WHERE dni = '$dni' AND fecha = '$fecha'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'marcaciones' => [
                'fecha' => $row['fecha'],
                'ingreso' => $row['ingreso'],
                'inicio_break' => $row['inicio_break'],
                'retorno_break' => $row['retorno_break'],
                'salida' => $row['salida']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No hay marcaciones para hoy.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parámetros incompletos.']);
}

$conn->close();
?>