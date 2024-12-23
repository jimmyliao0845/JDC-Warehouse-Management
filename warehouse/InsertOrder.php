<?php
session_start();
require_once 'connectionmysql2.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['AccountId'])) {
        die("Error: AccountId is not set. Please log in.");
    }

    $loggedInAccountId = $_SESSION['AccountId'];

    $tab_type = $_POST['tab_type'] ?? null;
    $product_id = $_POST['product_id'] ?? null;
    $employee_id = $_POST['employee_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $time_start = $_POST['time_start'] ?? null;
    $time_end = $_POST['time_end'] ?? null;

    if (!$tab_type || !$product_id || !$employee_id || !$quantity) {
        die("Error: Required fields are missing.");
    }

    $datetime_now = date('Y-m-d H:i:s');
    $process_identity = ($tab_type === "release") ? "Release" : "Resupply";
    $order_id = ($tab_type === "release" ? "RL" : "RS") . substr($loggedInAccountId, 0, 2) . $product_id;
    $process_state = "In Progress";

    try {
        $stmt = $conn->prepare("CALL InsertProcessOrder(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssssssssss",
            $order_id,
            $process_identity,
            $quantity,
            $product_id,
            $employee_id,
            $loggedInAccountId,
            $datetime_now,
            $time_start,
            $time_end,
            $process_state
        );
        $stmt->execute();

        header("Location: Process Management.php");
        exit();
    } catch (Exception $e) {
        $errorMessage = "Error: " . $e->getMessage();
        echo $errorMessage;
    } finally {
        $stmt->close();
        $conn->close();
    }
}
?>
