<?php
header('Content-Type: application/json');
require_once 'connectionmysql2.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['processId'])) {
        echo json_encode(['error' => 'Process ID not provided']);
        exit;
    }

    $processId = $data['processId'];

    try {
        // Assuming you're fetching order details from the database
        $stmt = $conn->prepare("SELECT OrderId, ProductId, EmployeeId, ProcessedQuantity, TimeStart, TimeEnd FROM orderlist WHERE ProcessId = ?");
        $stmt->bind_param("i", $processId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $orderDetails = $result->fetch_assoc();
            echo json_encode(['data' => $orderDetails]);
        } else {
            echo json_encode(['error' => 'No order found for the provided Process ID']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error fetching order details: ' . $e->getMessage()]);
    } finally {
        $stmt->close();
        $conn->close();
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
