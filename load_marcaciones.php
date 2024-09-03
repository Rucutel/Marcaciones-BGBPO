<?php
include 'db_connect.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$dni = $input['dni'];

$query = $conn->prepare("SELECT fecha, ingreso, inicio_break, retorno_break, salida FROM marcaciones WHERE dni = ? ORDER BY fecha ASC");
$query->bind_param("s", $dni);
$query->execute();
$result = $query->get_result();

$marcaciones = [];
while ($row = $result->fetch_assoc()) {
    $marcaciones[] = $row;
}

echo json_encode(['success' => true, 'marcaciones' => $marcaciones]);

$query->close();
$conn->close();
?>
