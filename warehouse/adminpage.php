<?php
session_start(); // Start the session

// Check if the AccountId is set in the session
if (!isset($_SESSION['AccountId'])) {
    // Handle the error, e.g., redirect to login or show an error message
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
            .bg-blue {
                background-color: #00008B; /* Sky blue color */
                color: white; /* Ensure text is readable */
                position: relative;
                width: 1540px;
                height: 50px;
            }
            .bg-skyblue {
                background-color: #87CEEB; /* Sky blue color */
                color: white; /* Ensure text is readable */
                position: relative;
                width: 100%;
                left: 170px;
            }
            .bg-darkblue {
                background-color: #1B2452; /* Sky blue color */
                color: white; /* Ensure text is readable */
                position:relative;
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
            .custom-card1 {
                position: absolute; /* Allows movement using top/left */
                top: 90px; /* Adjust this value to move vertically */
                left: 250px; /* Adjust this value to move horizontally */
                width: 300px; /* Smaller width */
                cursor: move; /* Optional: Shows move cursor */
            }

            .custom-card1 img {
                max-height: 100px; /* Limit the image height */
                object-fit: cover; /* Ensures it fits within the space */
            }
            .custom-card2 {
                position: absolute; /* Allows movement using top/left */
                top: 90px; /* Adjust this value to move vertically */
                left: 570px; /* Adjust this value to move horizontally */
                width: 300px; /* Smaller width */
                cursor: move; /* Optional: Shows move cursor */
            }

            .custom-card2 img {
                max-height: 100px; /* Limit the image height */
                object-fit: cover; /* Ensures it fits within the space */
            }
            .custom-card3 {
                position: absolute; /* Allows movement using top/left */
                top: 90px; /* Adjust this value to move vertically */
                left: 890px; /* Adjust this value to move horizontally */
                width: 300px; /* Smaller width */
                cursor: move; /* Optional: Shows move cursor */
            }

            .custom-card3 img {
                max-height: 100px; /* Limit the image height */
                object-fit: cover; /* Ensures it fits within the space */
            }
</style>
            
        </style>
    </head>
    <body>
        <div class="banner"></div>
            <!-- Main Content -->
            <div class="card mb-3 custom-card1" style="max-width: 18rem; max-height:14rem">
            <div class="row g-0">
            <div class="col-4">
                <img src="https://via.placeholder.com/100" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-8">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a card with a shorter description.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>

</div>      
            <div class="card mb-3 custom-card2" style="max-width: 18rem; max-height:14rem">
            <div class="row g-0">
            <div class="col-4">
                <img src="https://via.placeholder.com/100" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-8">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a card with a shorter description.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>
</div>  
            <div class="card mb-3 custom-card3" style="max-width: 18rem; max-height:14rem">
            <div class="row g-0">
            <div class="col-4">
                <img src="https://via.placeholder.com/100" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-8">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
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
 <!-- Top Bar -->
        <div class="bg-blue p-2">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <span class="fs-5">Test</span>
                <a href="logout.php" class="text-white text-decoration-none">Logout</a>
            </div>
        </div>
</body>
</html>