<?php
require_once 'connectionmysql2.php';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $accountId = isset($_GET['AccountId']) ? $_GET['AccountId'] : null;
    if ($accountId) {
    $sql = "SELECT ProductName, Description, Quantity, Status, AccountId, DateUpdated 
            FROM inventorysummary 
            WHERE AccountId = :accountId";  
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
    $stmt->execute();

    $inventory = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dateUpdated = new DateTime($row['DateUpdated']);
        $row['DateUpdated'] = $dateUpdated->format('F j, Y h:i A'); 
        
        $inventory[] = $row;
    }
    echo json_encode($inventory);
    }else {
        echo json_encode(['error' => 'AccountId not provided.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
