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
        <title>Order Management</title>
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
                max-height: 80vh;
                max-width: 85%;
                position: relative;
                left: 8%;
                padding: 10px;
                border-radius: 10px;
            }

            .tab-content {
                max-height: 70vh; 
                max-width: 100%;
                overflow-y: auto; 
                overflow-x: hidden;
            }

            .tab-content::-webkit-scrollbar {
                width: 4px; 
            }

            .tab-content::-webkit-scrollbar-thumb {
                background-color: #6c757d; 
                border-radius: 2px; 
            }

            .tab-content::-webkit-scrollbar-thumb:hover {
                background-color: #495057; 
            }
        </style>
    </head>
                <script>
            function generateTimeOptions(tabId) {
                const selectElement = document.getElementById(`time-start-${tabId}`);
                selectElement.innerHTML = ""; 

                const startHour = 4; 
                const endHour = 24;
                const now = new Date(); 
                const currentMinutesSinceMidnight = now.getHours() * 60 + now.getMinutes();

                for (let hour = startHour; hour < endHour; hour++) {
                    for (let minute = 0; minute < 60; minute += 30) {
                        const totalMinutes = hour * 60 + minute;

                        if (totalMinutes >= currentMinutesSinceMidnight) {
                            const timeValue = `${hour}:${minute === 0 ? "00" : minute}`;
                            const formattedTime = new Date(`1970-01-01T${timeValue}:00`).toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true,
                            });

                            const option = document.createElement("option");
                            option.value = timeValue;
                            option.textContent = formattedTime;
                            selectElement.appendChild(option);
                        }
                    }
                }
            }
            function calculateEndTime(tabId) {
                const startTime = document.getElementById(`time-start-${tabId}`).value;
                const duration = parseFloat(document.getElementById(`time-duration-${tabId}`).value);
                const unit = document.getElementById(`duration-unit-${tabId}`).value;

                if (!startTime || isNaN(duration)) {
                    document.getElementById(`time-end-${tabId}`).value = ""; 
                    return;
                }

                const [startHour, startMinute] = startTime.split(":").map(Number);
                let totalMinutes = startHour * 60 + startMinute; 

                if (unit === "minutes") {
                    totalMinutes += duration; 
                } else if (unit === "hours") {
                    totalMinutes += duration * 60; 
                }

                const endHour = Math.floor(totalMinutes / 60) % 24; 
                const endMinute = totalMinutes % 60; 
                const endDate = new Date(1970, 0, 1, endHour, endMinute);

                const formattedEndTime = endDate.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true,
                });

                document.getElementById(`time-end-${tabId}`).value = formattedEndTime;
            }
                    function fetchOrderDetails() {
                        const processId = document.getElementById("process-id").value;

                        if (!processId) {
                            alert("Please enter a Process ID.");
                            return;
                        }

                        console.log("Fetching details for Process ID:", processId);
                        fetch('fetchOrderDet.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ processId: processId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                // Display the error message from the server
                                alert("Error: " + data.error);
                            } else {
                                console.log("Fetched data:", data);  
                                const orderDetails = data.data;  
                                document.getElementById("order-id").value = orderDetails.OrderId;
                                document.getElementById("inventory-id-confirmation").value = orderDetails.ProductId;
                                document.getElementById("employee-id-confirmation").value = orderDetails.EmployeeId;
                                document.getElementById("Quantity-confirmation").value = orderDetails.ProcessedQuantity;
                                document.getElementById("time-start-confirmation").value = orderDetails.TimeStart;
                                document.getElementById("time-end-confirmation").value = orderDetails.TimeEnd;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching order details:', error);
                            alert("An error occurred while fetching order details.");
                        });
                    }
                    function updateProcessStatus(status) {
                        const processId = document.getElementById("process-id").value;
                        const orderId = document.getElementById("order-id").value;

                        if (!processId || !orderId) {
                            alert("Please enter a valid Process ID and Order ID.");
                            return;
                        }

                        console.log('processId:', processId);
                        console.log('orderId:', orderId);

                        fetch('updateprocess.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                processId: processId,
                                processStatus: status
                            })
                        })
                        .then(response => {
                            console.log('Raw Response:', response);
                            return response.text();  // Use .text() instead of .json() to see the raw content
                        })
                        .then(text => {
                            console.log('Response Text:', text);
                            try {
                                const data = JSON.parse(text);  // Manually parse the JSON to catch errors
                                console.log('Parsed Data:', data);
                                if (data.error) {
                                    alert(data.error);
                                } else {
                                    alert("Process updated successfully!");
                                    document.getElementById("process-id").value = "";
                                    document.getElementById("order-id").value = "";
                                    document.getElementById("inventory-id-confirmation").value = "";
                                    document.getElementById("employee-id-confirmation").value = "";
                                    document.getElementById("Quantity").value = "";
                                    document.getElementById("time-start-confirmation").value = "";
                                    document.getElementById("time-end-confirmation").value = "";
                                }
                            } catch (e) {
                                console.error('Error parsing response as JSON:', e);
                                alert('Failed to parse response from the server.');
                            }
                        })
                        .catch(error => {
                            console.error('Error updating process status:', error);
                            alert("An error occurred while updating the process.");
                        });

                    }
            window.onload = function () {
                generateTimeOptions("release");
                generateTimeOptions("resupply");
                document.getElementById("time-duration-release").addEventListener("input", function() {
                    calculateEndTime("release");
                });
                document.getElementById("duration-unit-release").addEventListener("change", function() {
                    calculateEndTime("release");
                });
                document.getElementById("time-start-release").addEventListener("change", function() {
                    calculateEndTime("release");
                });

                document.getElementById("time-duration-resupply").addEventListener("input", function() {
                    calculateEndTime("resupply");
                });
                document.getElementById("duration-unit-resupply").addEventListener("change", function() {
                    calculateEndTime("resupply");
                });
                document.getElementById("time-start-resupply").addEventListener("change", function() {
                    calculateEndTime("resupply");
                });
                document.querySelector(".btn-success").addEventListener("click", function () {
                    updateProcessStatus("Completed");
                });
                document.querySelector(".btn-danger").addEventListener("click", function () {
                    updateProcessStatus("Canceled");
                });

                document.getElementById("process-id").addEventListener("input", fetchOrderDetails);
            };
            </script>
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
                            <a class="nav-link text-white active" href="EmployeeManagement.php">Employee Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="InventoryManagement.php">Inventory Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="ProcessManagement.php">Process Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="Account_Setting.php">Account Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="Messaging_platform.php">Messaging Platform</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="flex-grow-1">
                <div class="bg-blue p-2">
                    <div class="container-fluid d-flex justify-content-between align-items-center">
                        <span class="fs-5">Order Management</span>
                        <a href="logout.php" class="text-white text-decoration-none">Logout</a>
                    </div>
                </div>

                <!-- Tabs Container -->
                <div class="tab-container">
                    <h1 style="color:white">Order Management</h1>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">Order List</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="release-tab" data-bs-toggle="tab" data-bs-target="#release" type="button" role="tab" aria-controls="release" aria-selected="false">Release</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="resupply-tab" data-bs-toggle="tab" data-bs-target="#resupply" type="button" role="tab" aria-controls="resupply" aria-selected="false">Resupply</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="process-confirmation-tab" data-bs-toggle="tab" data-bs-target="#process-confirmation" type="button" role="tab" aria-controls="process-confirmation" aria-selected="false">Process Confirmation</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orderList as $order) {
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
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="release" role="tabpanel" aria-labelledby="release-tab">
                            <form class="mt-3" action="InsertOrder.php" method="POST">
                                <input type="hidden" name="tab_type" value="release"> <!-- Hidden field to identify the tab type -->
                                <div class="mb-3">
                                    <label for="product-id-release" class="form-label" style="color: white">Product ID</label>
                                    <input type="text" class="form-control" id="product-id-release" name="product_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="employee-id-release" class="form-label" style="color: white">Employee ID</label>
                                    <input type="text" class="form-control" id="employee-id-release" name="employee_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Quantity" class="form-label" style="color: white">Quantity</label>
                                    <input type="text" class="form-control" id="Quantity" name="quantity" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="time-start-release" class="form-label" style="color: white">Time Start:</label>
                                        <select class="form-select" id="time-start-release" name="time_start" required>
                                            <option value="" disabled selected>Select Time</option>
                                            <!-- Add time options -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="time-duration-release" class="form-label" style="color: white">Time Duration:</label>
                                        <input type="number" class="form-control" id="time-duration-release" name="time_duration" placeholder="Enter duration" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="duration-unit-release" class="form-label" style="color: white">Unit:</label>
                                        <select class="form-select" id="duration-unit-release" name="duration_unit" required>
                                            <option value="minutes">Minutes</option>
                                            <option value="hours">Hours</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="time-end-release" class="form-label" style="color: white">Time End:</label>
                                        <input type="text" class="form-control" id="time-end-release" name="time_end" readonly>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary">Proceed</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="resupply" role="tabpanel" aria-labelledby="resupply-tab">
                            <form class="mt-3" action="InsertOrder.php" method="POST">
                                <input type="hidden" name="tab_type" value="resupply"> <!-- Hidden field to identify the tab type -->
                                <div class="mb-3">
                                    <label for="product-id-resupply" class="form-label" style="color: white">Product ID</label>
                                    <input type="text" class="form-control" id="product-id-resupply" name="product_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="employee-id-resupply" class="form-label" style="color: white">Employee ID</label>
                                    <input type="text" class="form-control" id="employee-id-resupply" name="employee_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Quantity" class="form-label" style="color: white">Quantity</label>
                                    <input type="text" class="form-control" id="Quantity" name="quantity" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="time-start-resupply" class="form-label" style="color: white">Time Start:</label>
                                        <select class="form-select" id="time-start-resupply" name="time_start" required>
                                            <option value="" disabled selected>Select Time</option>
                                            <!-- Add time options -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="time-duration-resupply" class="form-label" style="color: white">Time Duration:</label>
                                        <input type="number" class="form-control" id="time-duration-resupply" name="time_duration" placeholder="Enter duration" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="duration-unit-resupply" class="form-label" style="color: white">Unit:</label>
                                        <select class="form-select" id="duration-unit-resupply" name="duration_unit" required>
                                            <option value="minutes">Minutes</option>
                                            <option value="hours">Hours</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="time-end-resupply" class="form-label" style="color: white">Time End:</label>
                                        <input type="text" class="form-control" id="time-end-resupply" name="time_end" readonly>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary">Proceed</button>
                            </form>
                        </div>


                        <div class="tab-pane fade" id="process-confirmation" role="tabpanel" aria-labelledby="process-confirmation-tab">
                        <form class="mt-3">
                            <div class="mb-3">
                                <label for="process-id" class="form-label">Process ID</label>
                                <input type="text" class="form-control" id="process-id" placeholder="Enter Process ID">
                            </div>
                            <div class="mb-3">
                                <label for="order-id" class="form-label">Order ID</label>
                                <input type="text" class="form-control" id="order-id" placeholder="Enter Order ID">
                            </div>
                            <div class="mb-3">
                                <label for="inventory-id-confirmation" class="form-label">Inventory ID</label>
                                <input type="text" class="form-control" id="inventory-id-confirmation" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="employee-id-confirmation" class="form-label">Employee ID</label>
                                <input type="text" class="form-control" id="employee-id-confirmation">
                            </div>
                            <div class="mb-3">
                                <label for="Quantity-confirmation" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="Quantity-confirmation" readonly>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="time-start-confirmation" class="form-label">Time Start</label>
                                    <input type="text" class="form-control" id="time-start-confirmation">
                                </div>
                                <div class="col-md-6">
                                    <label for="time-end-confirmation" class="form-label">Time End</label>
                                    <input type="text" class="form-control" id="time-end-confirmation">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-success">Confirm</button>
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </div>
                        </form>
                    </div>

                    </div>
                </div>
            </div>
        </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
