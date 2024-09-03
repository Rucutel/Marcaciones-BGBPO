<?php
include 'db_connect.php';
date_default_timezone_set('America/Lima');  // Ajustar según la zona horaria correcta

// Obtener datos enviados desde el frontend
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['dni'], $data['tipo'], $data['fecha'])) {
    $dni = $data['dni'];
    $tipo_marcacion = $data['tipo'];
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    // Verificar si ya existe una fila para el DNI y la fecha actual
    $query = $conn->prepare("SELECT * FROM marcaciones WHERE dni = ? AND fecha = ?");
    $query->bind_param("ss", $dni, $fecha);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Actualizar la fila existente
        $updateQuery = $conn->prepare("UPDATE marcaciones SET $tipo_marcacion = ? WHERE dni = ? AND fecha = ?");
        $updateQuery->bind_param("sss", $hora, $dni, $fecha);
        
        if ($updateQuery->execute()) {
            echo json_encode(['success' => true, 'message' => 'Marcación actualizada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la marcación.']);
        }
    } else {
        // Insertar una nueva fila
        $insertQuery = $conn->prepare("INSERT INTO marcaciones (dni, fecha, $tipo_marcacion) VALUES (?, ?, ?)");
        $insertQuery->bind_param("sss", $dni, $fecha, $hora);
        
        if ($insertQuery->execute()) {
            echo json_encode(['success' => true, 'message' => 'Marcación guardada correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar la marcación.']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
}

$conn->close();
?>
