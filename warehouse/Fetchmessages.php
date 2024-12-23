<?php
require_once 'connectionmysql2.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $accountId = isset($_GET['AccountId']) ? $_GET['AccountId'] : null;

    if ($accountId) {
        $sql = "
            SELECT 
                ms.MessageId, 
                ms.Message, 
                ms.DateTime, 
                ms.SenderAccountId, 
                ms.SenderFirstName, 
                ms.SenderLastName, 
                ms.ReceiverAccountId, 
                ms.ReceiverFirstName, 
                ms.ReceiverLastName
            FROM messagesummary ms
            WHERE ms.ReceiverAccountId = :accountId;
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':accountId', $accountId, PDO::PARAM_STR);
        $stmt->execute();

        
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        echo json_encode($messages);
    } else {
        echo json_encode(['error' => 'AccountId not provided.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
