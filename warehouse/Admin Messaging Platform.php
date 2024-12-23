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
            .main-content {
                flex-grow: 1;
                padding: 20px;
                background-color: #f8f9fa; /* Light gray for contrast */
            }
            .card {
                margin-bottom: 1rem; /* Add spacing between cards */
                width: 80%;
                border: none; /* Optional: Remove border for cleaner look */
            }
            .card-body {
                text-align: left; /* Align text to the left */
                padding: 10px 15px; /* Adjust padding for better spacing */
            }
            .tab-content {
                padding-top: 20px;
            }
            .received-messages {
                max-height: 62vh;  /* Adjust height to show 4 messages */
                overflow-y: auto;   /* Enables scrolling */
                border: 1px solid #ccc; /* Optional: add a border for better visibility */
                padding: 10px;
            }
</style>
            
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
            
            <div class="d-flex flex-column w-100">
                <div class="bg-blue p-2">
                    <div class="container-fluid d-flex justify-content-between align-items-center">
                        <span class="fs-5">Send Message</span>
                        <a href="logout.php" class="text-white text-decoration-none">Logout</a>
                    </div>
                </div>

                <div style="padding: 20px; width:80%; background-color: #f8f9fa; position: relative; left: 10%; top: 5%">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="messageTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="sendTab" data-bs-toggle="tab" href="#sendMessage" role="tab" aria-controls="sendMessage" aria-selected="true">Send Message</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="receiveTab" data-bs-toggle="tab" href="#receiveMessage" role="tab" aria-controls="receiveMessage" aria-selected="false">Received Messages</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="messageTabsContent">
                        <!-- Send Message Tab -->
                        <div class="tab-pane fade show active" id="sendMessage" role="tabpanel" aria-labelledby="sendTab">
                            <h1>Send a Message</h1>
                            <form action="AdminCompany.php" method="post">
                                <div class="mb-3">
                                    <label for="AccountId" class="form-label">Send to:</label>
                                    <select id="AccountId" name="AccountId" class="form-select" onchange="checkFields()">
                                        <option value="">Select Sender</option>
                                        <?php foreach ($accountIds as $id): ?>
                                            <option value="<?php echo $id; ?>"><?php echo $id; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="Message" class="form-label">Message:</label>
                                    <textarea class="form-control" id="Message" name="Message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                        <!-- Received Messages Tab -->
                        <div class="tab-pane fade" id="receiveMessage" role="tabpanel" aria-labelledby="receiveTab">
                        <h1>Received Messages</h1>
                        <div class="received-messages" id="receivedMessages">
                                
                            </div>
                        </div>
                    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        const loggedInAccountId = "<?php echo $loggedInAccountId; ?>"; 
        document.addEventListener("DOMContentLoaded", () => {
    const fetchMessages = () => {
        fetch(`FetchMessages.php?AccountId=${loggedInAccountId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Fetched data:", data); // Log the data for debugging
                const messageContainer = document.querySelector('.received-messages');
                messageContainer.innerHTML = ''; // Clear previous messages

                if (data.error) {
                    messageContainer.innerHTML = `<p>Error: ${data.error}</p>`;
                } else if (data.length === 0) {
                    messageContainer.innerHTML = '<p>No messages found.</p>';
                } else {
                    data.forEach(message => {
                        const messageCard = document.createElement('div');
                        messageCard.classList.add('card');
                        messageCard.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title">${message.SenderFirstName} ${message.SenderLastName}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${message.DateTime}</h6>
                                <p class="card-text">${message.Message}</p>
                            </div>
                        `;
                        messageContainer.appendChild(messageCard);
                    });
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                const messageContainer = document.querySelector('.received-messages');
                messageContainer.innerHTML = '<p>Failed to load messages. Please try again later.</p>';
            });
    };

    // Fetch messages when the page loads
    fetchMessages();
});


</script>
</body>
</html>