<?php

include 'connectionmysql2.php';

header('Content-Type: application/json');

try {
    $query = "SELECT category, COUNT(*) AS total_count FROM product GROUP BY category";
    $result = $conn->query($query);

    
    if ($result) {
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row; 
        }
        
        echo json_encode($categories);
    } else {
        echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>