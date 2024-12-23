<?php
session_start();

// Check if the AccountId is set in the session
if (!isset($_SESSION['AccountId'])) {
    die("Error: User not logged in. Please log in to access this page.");
}

$loggedInAccountId = $_SESSION['AccountId'];

require_once 'connectionmysql2.php';

// Get the user's role from the database
$sql = "SELECT AccountRole FROM accountcategory WHERE AccountId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInAccountId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $accountData = $result->fetch_assoc();
    $userRole = $accountData['AccountRole']; 
} else {
    die("Error: Account not found.");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated account details from the form
    $accountId1 = $_POST['account-id'];  // Account ID to update
    $password = $_POST['password'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Prepare the stored procedure call
    $stmt = $conn->prepare("CALL updateaccount(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $accountId1, $loggedInAccountId, $password, $firstName, $lastName, $birthday, $email, $contact);

    if ($stmt->execute()) {
        // Redirect based on user role
        if ($userRole === 'Manager') {
            header("Location: Account_Setting.php");  // Redirect to account settings for Manager
        } elseif ($userRole === 'Admin') {
            header("Location: Account Profile.php");  // Redirect to account profile for Admin
        }
        exit(); // Always call exit after a header redirection
    } else {
        echo "Error updating account: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
