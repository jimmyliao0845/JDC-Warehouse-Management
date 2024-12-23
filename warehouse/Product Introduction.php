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
        <title>Admin</title>
        <style>
            html, body {
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }
            .banner {
                width: 100%;
                height: 100%;
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
            
    </style>
            <script>
                function generateProductId() {
                    const accountId = document.getElementById('AccountId').value;
                    const productName = document.getElementById('ProductName').value;
                    const description = document.getElementById('Description').value;
                    const location = document.getElementById('Location').value;

                    if (accountId && productName && description && location) {
                        const year = new Date().getFullYear();
                        const randomDigits = Math.floor(1000 + Math.random() * 9000);
                        document.getElementById('ProductId').value = `PRD-${year}-${randomDigits}`;
                    } else {
                        alert("Please fill out all fields before generating a Product ID.");
                    }
                }

                function checkFields() {
                    const accountId = document.getElementById('AccountId').value;
                    const productId = document.getElementById('ProductId').value;
                    const productName = document.getElementById('ProductName').value;
                    const description = document.getElementById('Description').value;
                    const location = document.getElementById('Location').value;
                    const proceedButton = document.getElementById('ProceedButton');

                    proceedButton.disabled = !(
                        accountId && productId && productName && description && location
                    );
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
                    <span class="fs-5">Product Entry</span>
                    <a href="logout.php" class="text-white text-decoration-none">Logout</a>
                </div>
            </div>

            <!-- Product Entry Form -->
            <div class="container mt-4" style="position: relative; left: 5%;">
                <h2 style="color: white;">Product Entry</h2>
                <div style="flex-grow: 1; padding: 10px; width:1000px; background-color: #f8f9fa;">
                    <form class="mt-3" action="save_product.php" method="POST" style="position: relative; left: 5%;">
                        <!-- Account ID -->
                        <div class="mb-3" style="width: 90%;">
                            <label for="AccountId" class="form-label">Account ID</label>
                            <select id="AccountId" name="AccountId" class="form-select" onchange="checkFields()">
                                <option value="">Select Account ID</option>
                                <?php foreach ($accountIds as $id): ?>
                                    <option value="<?php echo $id; ?>"><?php echo $id; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Product ID -->
                        <div class="mb-3" style="width: 90%;">
                            <label for="ProductId" class="form-label">Product ID</label>
                            <div class="input-group">
                                <input type="text" id="ProductId" name="ProductId" class="form-control" readonly>
                                <button type="button" class="btn btn-primary" onclick="generateProductId()">Generate</button>
                            </div>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3" style="width: 90%;">
                            <label for="ProductName" class="form-label">Product Name</label>
                            <input type="text" id="ProductName" name="ProductName" class="form-control" oninput="checkFields()">
                        </div>

                        <!-- Description -->
                        <div class="mb-3" style="width: 90%;">
                            <label for="Description" class="form-label">Description</label>
                            <textarea id="Description" name="Description" class="form-control" style="max-height: 50px; font-size: 12px" oninput="checkFields()"></textarea>
                        </div>

                        <!-- Location -->
                        <div class="mb-3" style="width: 90%;">
                            <label for="Location" class="form-label">Location</label>
                            <input type="text" id="Location" name="Location" class="form-control" oninput="checkFields()">
                        </div>

                        <!-- Proceed Button -->
                        <button type="submit" id="ProceedButton" class="btn btn-success" disabled>Proceed</button>
                    </form>
                </div>
            </div>


</body>
</html>