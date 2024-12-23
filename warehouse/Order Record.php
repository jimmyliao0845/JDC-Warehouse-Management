<?php
session_start();
include_once 'fetchOrderlist.php'; 

if (!isset($_SESSION['AccountId'])) {
    die("Error: User not logged in. Please log in to access this page.");
}

$loggedInAccountId = $_SESSION['AccountId'];

$orderList = fetchOrderList($loggedInAccountId);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <title>Order Record</title>
        <style>
            html, body {
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }
            .banner {
                width: 100%;
                height: 100vh;
                background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('warehouse-rental.jpeg');
                background-size: cover;
                background-position: center;
                position: absolute;
                top: 0;
                left: 0;
                z-index: -1;
            }
            .bg-blue {
                background-color: #00008B; 
                color: white; 
                position: relative;
                width: 100%;
                height: 50px;
            }
            .bg-darkblue {
                background-color: #1B2452; 
                color: white; 
                position: relative;
            }
            .tab-container {
                margin: 20px auto;
                max-width: 90%;
            }
        </style>
    </head>
    <body>
        <div class="banner"></div>
        <div class="d-flex">
            <!-- Vertical Navbar -->
            <nav class="navbar bg-darkblue navbar-expand-lg navbar-light flex-column vh-100">
                <div class="container-fluid flex-column">
                    <a href="managerpage.php" class="mb-3" style="text-decoration: none; color: white;">
                        <img src="JDC Logo-Darkblue.png" alt="Dashboard" style="width: 100px; height: auto;">
                    </a>
                    <ul class="navbar-nav flex-column w-100">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="ManagersManagement.php">Managers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="Product Introduction.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="Order Record.php">Order Records</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="Employee Application.php">Employee Application</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="Account Profile.php">Account Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="Admin Messaging Platform.php">Messaging Platform</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="flex-grow-1">
                <!-- Top Bar -->
                <div class="bg-blue p-2">
                    <div class="container-fluid d-flex justify-content-between align-items-center">
                        <span class="fs-5">Order Record</span>
                        <a href="#" class="text-white text-decoration-none">Logout</a>
                    </div>
                </div>

                <div class="tab-container">
                    <h2 style="color: white">Organizational Order List</h2>
                    <table class="table table-striped table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Process ID</th>
                                <th>Order ID</th>
                                <th>Process Identity</th>
                                <th>Processed Quantity</th>
                                <th>Employee ID</th>
                                <th>Account ID</th>
                                <th>Process State</th>
                                <th>Date</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Manager Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($orderList)) {
                                echo "<p>No orders found for this user.</p>";
                            } else {
                                foreach ($orderList as $order) {
                                    $managerName = "{$order['FirstName']} {$order['LastName']}";
                                    $formattedDate = date("Y-m-d", strtotime($order['DateTime']));
                                    $formattedTimeStart = date("g:i A", strtotime($order['TimeStart']));
                                    $formattedTimeEnd = date("g:i A", strtotime($order['TimeEnd'])); 
                                    echo "<tr>
                                        <td>{$order['ProductId']}</td>
                                        <td>{$order['ProductName']}</td>
                                        <td>{$order['ProcessId']}</td>
                                        <td>{$order['OrderId']}</td>
                                        <td>{$order['Process_Identity']}</td>
                                        <td>{$order['ProcessedQuantity']}</td>
                                        <td>{$order['EmployeeId']}</td>
                                        <td>{$order['AccountId']}</td>
                                        <td>{$order['ProcessState']}</td>
                                        <td>{$formattedDate}</td>
                                        <td>{$formattedTimeStart}</td>
                                        <td>{$formattedTimeEnd}</td>
                                        <td>{$managerName}</td>
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
