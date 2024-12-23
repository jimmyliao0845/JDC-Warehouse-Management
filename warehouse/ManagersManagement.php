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
        <title>Manager Management</title>
        <style>
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
                width: 200px;
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
            .scrollable-content {
                max-height: 62vh; 
                overflow-y: auto;
                padding: 15px;
                background-color: #f8f9fa; 
                border: 1px solid #ccc; 
                border-radius: 5px;
            }

        </style>
        <script>
            function generateAccountID() {
                const year = new Date().getFullYear();
                const randomDigits = Math.floor(1000s + Math.random() * 9999);
                const firstName = document.getElementById('first-name').value;
                const firstLetter = firstName.charAt(0).toUpperCase() || 'X';
                const lastName = document.getElementById('last-name').value;
                const firstLLetter = lastName.charAt(0).toUpperCase() || 'X'; 
            document.getElementById('account-id').value = `${firstLetter}${firstLLetter}-${year}${randomDigits}`;
            }

            function calculateAge() {
                const birthDate = new Date(document.getElementById("birthday").value);
                const today = new Date();
                const age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.getElementById("age").value = age > 0 ? age : "Invalid Date";
            }
        </script>
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
                <span class="fs-5">Manager Management</span>
                <a href="logout.php" class="text-white text-decoration-none">Logout</a>
            </div>
        </div>

        <!-- Tabs Container -->
        <div class="tab-container mx-auto my-3 p-4 " style="max-width: 1050px;">
            <h1 style="color:white">Manager Management</h1>
            <ul class="nav nav-tabs" id="managerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">Manager List</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="false">Add Manager Account</button>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <!-- Manager List Tab -->
                <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                    <table class="table table-striped table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Account ID</th>
                                <th>Account Type</th>
                                <th>First Name, Last Name</th>
                                <th>Birthday</th>
                                <th>Email</th>
                                <th>Contact no,</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                                <!-- Add Manager Account Tab -->
                <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="add-tab">
                    <div class="scrollable-content">
                        <form class="mt-3">
                            <!-- Account ID and Password -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="account-id" class="form-label">Account ID</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="account-id" placeholder="Generate Account ID" readonly>
                                        <button type="button" class="btn btn-primary" onclick="generateAccountID()">Generate</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter your password">
                                </div>
                            </div>

                            <!-- First Name and Last Name -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first-name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first-name" placeholder="Enter your first name">
                                </div>
                                <div class="col-md-6">
                                    <label for="last-name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last-name" placeholder="Enter your last name">
                                </div>
                            </div>

                            <!-- Birthday and Age -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" class="form-control" id="birthday" onchange="calculateAge()">
                                </div>
                                <div class="col-md-6">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" class="form-control" id="age" placeholder="Age will be calculated" readonly>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email">
                            </div>

                            <!-- Contact Number -->
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact No.</label>
                                <input type="text" class="form-control" id="contact" placeholder="Enter your contact number">
                            </div>

                            <button type="submit" class="btn btn-success">Add Manager</button>
                        </form>
                    </div>
                </div>

        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
