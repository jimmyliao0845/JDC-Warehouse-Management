<?php
session_start(); // Start the session

if (!isset($_SESSION['AccountId'])) {
    die("Error: User not logged in. Please log in to access this page.");
}

$loggedInAccountId = $_SESSION['AccountId']; 

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <title>Account</title>
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
                max-width: 85%;
            }
            .scrollable-table {
                max-height: 70vh; 
                overflow-y: auto; 
                overflow-x: auto; 
            }

            
            .table thead th {
                background-color: #343a40; 
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="banner"></div>
        <div class="d-flex">
            <!-- Vertical Navbar -->
            <nav class="navbar bg-darkblue navbar-expand-lg navbar-light flex-column vh-100">
                <div class="container-fluid flex-column">
                <a href="adminpage.php" class="mb-3" style="text-decoration: none; color: white;">
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
                        <a href="logout.php" class="text-white text-decoration-none">Logout</a>
                    </div>
                </div>

                <!-- Release Tab -->
                <div class="tab-container">
                <h2 style="color: white">Employee Application</h2>
                <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                    <div class="scrollable-table">
                        <table class="table table-striped table-hover mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Role</th>
                                    <th>Salary</th>
                                    <th>Accomplished Tasks</th>
                                    <th>Manager Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Row -->
                                <?php
                                    echo "<tr>
                                        <td>JM-20240825</td>
                                        <td>Jimmy</td>
                                        <td>Montoya</td>
                                        <td>General Laborer</td>
                                        <td>$8000</td>
                                        <td>10</td>
                                        <td>Jimmy Liao</td>
                                        <td>
                                            <button class='btn btn-success' style='width:80px; text-align: center;'>Approve</button>
                                            <h1></h1>
                                            <button class='btn btn-success' style='width:80px; text-align: center;'>Deny</button>
                                        </td>
                                    </tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </body>
</html>
