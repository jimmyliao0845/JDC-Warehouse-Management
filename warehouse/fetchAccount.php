<?php
require_once 'connectionmysql2.php';

session_start(); // Start the session


if (!isset($_SESSION['AccountId'])) {
    die("Error: User not logged in. Please log in to access this page.");
}

$loggedInAccountId = $_SESSION['AccountId'];

// Fetch account data
$sql = "SELECT * FROM accountcategory WHERE AccountId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInAccountId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $accountData = $result->fetch_assoc();
} else {
    die("Error: Account not found.");
}

$stmt->close();
$conn->close();
?>