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
        <title>Manager</title>
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
            .custom-card1 {
                position: absolute; 
                top: 10%; 
                left: 15%; 
                width: 300px; 
                cursor: move; 
            }
            .custom-card1 img {
                max-height: 100px; 
                object-fit: cover; 
            }
            .custom-card2 {
                position: absolute; 
                top: 10%; 
                left: 45%; 
                width: 300px; 
                cursor: move; 
            }

            .custom-card2 img {
                max-height: 100px; 
                object-fit: cover; 
            }
            .custom-card3 {
                position: absolute; 
                top: 10%; 
                left: 75%; 
                width: 300px; 
                cursor: move; 
            }

            .custom-card3 img {
                max-height: 100px; 
                object-fit: cover; 
            }
            .custom-card4 {
                position: absolute; 
                top: 40%; 
                left: 15%; 
                width: 300px; 
                cursor: move; 
            }

            .custom-card4 img {
                max-height: 100px; 
                object-fit: cover; 
            }

            .label {
            font-size: 80px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            display: inline-block;
            position: relative;
            top:10px;
            left:30px;
        }
            
        </style>
    </head>
    <body>

        

            <!-- Main Content -->
            <div class="banner"></div>
            <div class="card mb-3 custom-card1" style="max-width: 18rem; max-height:14rem">
            <div class="row g-0">
            <div class="col-4">
                <label for="Employee" class ="label"></label>
            </div>
            <div class="col-8">
            <div class="card-body">
                <h5 class="card-title">Employees</h5>
                <p class="card-text">This is a card with a shorter description.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>
</div>  

</div>      
            <div class="card mb-3 custom-card2" style="max-width: 18rem; max-height:14rem">
            <div class="row g-0">
            <div class="col-4">
                <div id="category-container"></div>
            </div>
            <div class="col-8">
            <div class="card-body">
                <h5 class="card-title">Categories</h5>
                <p class="card-text">This is a card with a shorter description.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>
</div>  
            <div class="card mb-3 custom-card3" style="max-width: 18rem; max-height:14rem">
            <div class="row g-0">
            <div class="col-4">
            <label for="Product" class ="label"></label>
            </div>
            <div class="col-8">
            <div class="card-body">
                <h5 class="card-title">Product</h5>
                <p class="card-text">This is a card with a shorter description.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>
</div>
            <div class="card mb-3 custom-card4" style="max-width: 18rem; max-height:14rem">
            <div class="row g-0">
            <div class="col-4">
                <label for="Process" class ="label"></label>
            </div>
            <div class="col-8">
            <div class="card-body">
                <h5 class="card-title">Today's Process</h5>
                <p class="card-text">This is a card with a shorter description.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>
</div>  
<div class="d-flex">
            <!-- Vertical Navbar -->
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
      <!-- Top Bar -->
    <div class="bg-blue p-2">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <span class="fs-5">Test</span>
                <a href="logout.php" class="text-white text-decoration-none">Logout</a>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script> 
        fetch('DashboardDisplay.php')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('category-container');

        if (data.error) {
            container.innerHTML = `<p>Error: ${data.error}</p>`;
        } else {
            data.forEach(item => {
                const label = document.createElement('label');
                label.setAttribute('for', 'Category');
                label.className = 'label';
                label.textContent = `${item.total_count}`; 

                container.appendChild(label);
            });
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        document.getElementById('category-container').innerHTML = `<p>Error loading data.</p>`;
    });

            </script>
    </body>
</html>