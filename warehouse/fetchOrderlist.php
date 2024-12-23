<?php
require_once 'connectionmysql2.php';

function fetchOrderList($loggedInAccountId) {
    global $conn;
    $roleQuery = "SELECT AccountRole FROM accountcategory WHERE AccountId = ?";
    $stmt = $conn->prepare($roleQuery);
    $stmt->bind_param("i", $loggedInAccountId);

    if (!$stmt->execute()) {
        die("Error: Unable to fetch user role: " . $stmt->error);
    }

    $roleResult = $stmt->get_result();

    if ($roleResult->num_rows > 0) {
        $roleRow = $roleResult->fetch_assoc();
        $accountRole = $roleRow['AccountRole'];

        if ($accountRole === 'Manager') {
            $query = "SELECT FirstName, LastName, ProductId, ProductName, ProcessId, OrderId, Process_Identity, ProcessedQuantity, EmployeeId, AccountId, ProcessState, DateTime, TimeStart, TimeEnd FROM orderlist WHERE AccountId = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $loggedInAccountId);
        } elseif ($accountRole === 'Admin') {
            $query = "SELECT * FROM orderlist";
            $stmt = $conn->prepare($query);
        } else {
            return [];
        }

        if (!$stmt->execute()) {
            die("Error executing order query: " . $stmt->error);
        }

        $result = $stmt->get_result();

        $orderList = [];
        while ($row = $result->fetch_assoc()) {
            $orderList[] = $row;
        }

        error_log(print_r($orderList, true)); // Log the results

        return $orderList;
    } else {
        return [];
    }
}

if (isset($_GET['AccountId'])) {
    $loggedInAccountId = $_GET['AccountId'];
    $orderList = fetchOrderList($loggedInAccountId);

    echo json_encode($orderList);  
} else {
}

?>