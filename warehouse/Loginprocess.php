<?php
session_start();
require_once 'connectionmysql2.php';

try {
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Retrieve username and password from the POST request
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and password are required.";
        header('Location: WareHouseLogin.php');
        exit;
    }

    
    $query = "SELECT AccountId, Password, AccountRole FROM accountcategory WHERE AccountId = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        throw new Exception("SQL statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['Password'];

        if ($password === $storedPassword) {
            
            $_SESSION['logged_in'] = true;
            $_SESSION['AccountId'] = $row['AccountId'];
            $_SESSION['role'] = $row['AccountRole'];

            if ($row['AccountRole'] === 'Manager') {
                header('Location: managerpage.php');
            } elseif ($row['AccountRole'] === 'Admin') {
                header('Location: adminpage.php');
            } else {
                $_SESSION['error'] = "Invalid role detected.";
                header('Location: WareHouseLogin.php');
            }
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header('Location: WareHouseLogin.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header('Location: WareHouseLogin.php');
        exit;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = "An error occurred. Please try again later.";
    header('Location: WareHouseLogin.php');
    exit();
}
?>
