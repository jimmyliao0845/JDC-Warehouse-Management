<?php
session_start(); 


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
        <title>InventoryManagement</title>
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
            .logo{
                background-image: url('JDC Logo.png');
            }
            .bg-blue {
                background-color: #00008B; 
                color: white; 
                position: relative;
                width: 1540px;
                height: 50px;
            }
            
            .bg-darkblue {
                background-color: #1B2452; 
                color: white; 
                position: relative;

            }
            .table-container {
            margin: 20px auto;
            max-width: 90%;
            }
        </style>
    </head>
    <body>
    <div class="banner"></div>
        <div class="d-flex">
           <nav class="navbar bg-darkblue navbar-expand-lg navbar-light flex-column vh-100">
                <div class="container-fluid flex-column">
                <a href="managerpage.php" class="mb-3" style="text-decoration: none; color: white;">
                    <img src="JDC Logo-Darkblue.png" alt="Dashboard" style="width: 100px; height: auto;">
                </a>
                    <ul class="navbar-nav flex-column w-100">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="EmployeeManagement.php">Employee Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="InventoryManagement.php">Inventory Management</a>
                        </li><li class="nav-item">
                            <a class="nav-link text-white active" href="Process Management.php">Process Management</a>
                        </li><li class="nav-item">
                            <a class="nav-link text-white active" href="Account_Setting.php">Account Settings</a>
                        </li><li class="nav-item">
                            <a class="nav-link text-white active" href="Messaging_platform.php">Messaging Platform</a>
                        </li>
                    </ul>
                </div>
            </nav>

        <div class="bg-blue p-2">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <span class="fs-5">Test</span>
                <a href="logout.php" class="text-white text-decoration-none">Logout</a>
            </div>
             <!-- Table Container -->
         <div class="table-container">
            <h2 style="color: white">Inventory Management</h2>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Type</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    

        <script>
    const loggedInAccountId = "<?php echo $loggedInAccountId; ?>";

    fetch('Fetchinventory.php?AccountId=' + loggedInAccountId)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('inventoryTableBody');

            if (data.error) {
                tableBody.innerHTML = `<tr><td colspan="5">Error: ${data.error}</td></tr>`;
            } else {
                tableBody.innerHTML = ''; 
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.ProductName}</td>
                        <td>${item.Description}</td>
                        <td>${item.Quantity}</td>
                        <td>${item.Status}</td>
                        <td>${item.DateUpdated}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching inventory:', error);
            document.getElementById('inventoryTableBody').innerHTML = '<tr><td colspan="5">Error loading inventory data.</td></tr>';
        });
</script>

        
    </body>
</html>
