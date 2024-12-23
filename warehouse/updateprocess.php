<?php
header('Content-Type: application/json');
require_once 'connectionmysql2.php';

$inputData = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $inputData) {
    $process_id = $inputData['processId'];  
    $process_status = $inputData['processStatus'];

    try {
        $stmt = $conn->prepare("CALL UpdateProcessStatus(?, ?)");
        $stmt->bind_param("ss", $process_id, $process_status); 
        $stmt->execute();
        if ($stmt->execute()) {
            echo json_encode(["message" => "Process updated successfully!"]);
        } else {
            echo json_encode(["error" => "An error occurred while updating the process."]);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    } finally {
        $stmt->close();
        $conn->close();
    }
} else {
    echo json_encode(["error" => "Invalid request or missing data."]);
}
?>
