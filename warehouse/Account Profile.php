<?php
session_start(); // Start the session

// Check if the AccountId is set in the session
if (!isset($_SESSION['AccountId'])) {
    die("Error: User not logged in. Please log in to access this page.");
}

$loggedInAccountId = $_SESSION['AccountId'];

require_once 'connectionmysql2.php';
$sql = "SELECT * FROM accountcategory WHERE AccountId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInAccountId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $accountData = $result->fetch_assoc();
    $userRole = isset($accountData['AccountRole']) ? $accountData['AccountRole'] : 'No Role Assigned'; 
} else {
    die("Error: Account not found.");
}
$stmt->close();
$conn->close();
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
                background-color: #00008B; /* Sky blue color */
                color: white; /* Ensure text is readable */
                position: relative;
                width: 100%;
                height: 50px;
            }
            .bg-darkblue {
                background-color: #1B2452; /* Sky blue color */
                color: white; /* Ensure text is readable */
                position: relative;
            }
            
            
        </style>
        <script>
            function generateAdminID() {
                const year = new Date().getFullYear();
                const randomDigits = Math.floor(100s + Math.random() * 900);
                const firstName = document.getElementById('first-name').value;
                const firstLetter = firstName.charAt(0).toUpperCase() || 'X';
                const lastName = document.getElementById('last-name').value;
                const firstLLetter = lastName.charAt(0).toUpperCase() || 'X'; 
            document.getElementById('Admin-id').value = `${firstLetter}${firstLLetter}-${year}${randomDigits}`;
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

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

            <!-- Main Content -->
            <div class="flex-grow-1">
                <!-- Top Bar -->
                <div class="bg-blue p-2">
                    <div class="container-fluid d-flex justify-content-between align-items-center">
                        <span class="fs-5">Administrator Account</span>
                        <a href="logout.php" class="text-white text-decoration-none">Logout</a>
                    </div>
                </div>

                <div class="container mt-4" style="position: relative; left:5%">
                    <h2 style="color: white;">Administrator Account</h2>
                    <div style="flex-grow: 1; padding: 10px; width:1000px; background-color: #f8f9fa;">
                    <form class="mt-3" method="POST" action="UpdateAccount.php">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="update-account-id" class="form-label">Account ID</label>
                            <input type="text" class="form-control" id="update-account-id" name="account-id" value="<?php echo htmlspecialchars($accountData['AccountId']); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="update-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="update-password" name="password" value="<?php echo htmlspecialchars($accountData['Password']); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first-name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first-name" name="first-name" value="<?php echo htmlspecialchars($accountData['FirstName']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="last-name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last-name" name="last-name" value="<?php echo htmlspecialchars($accountData['LastName']); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($accountData['Birthday']); ?>" onchange="calculateAge()">
                        </div>
                        <div class="col-md-6">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($accountData['Age']); ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($accountData['Email']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact No.</label>
                        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($accountData['ContactNo']); ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
                </div>
        </div>

           

    </body>
</html>