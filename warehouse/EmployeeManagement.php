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
        <title>EmployeeManagement</title>
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
            .tab-pane {
                overflow-y: auto; 
                overflow-x: hidden; 
                max-height: 500px; 
                padding: 15px; 
                border: 1px solid #ddd; 
                box-sizing: border-box; 
            }

        </style>
        <script>
             function updateSalary() {
                const role = document.getElementById('Role').value;
                const baseSalaries = {
                    'Warehouse Clerk': 2000,
                    'Logistics Coordinator': 2500,
                    'General Laborer': 1800,
                    'Safety Officer': 2200,
                    'Maintenance Technician': 2400,
                    'Quality Control Inspector': 2300,
                    'Picker/Packer': 1900,
                    'Shipping Clerk': 2100,
                    'Receiving Clerk': 2100,
                    'Inventory Specialist': 2600,
                    'Team Leader/Supervisor': 3000
                };

                const achievementFactor = 1.2; 
                const salary = baseSalaries[role] ? baseSalaries[role] * achievementFactor : 0;
                document.getElementById('Salary').value = salary.toFixed(2);
            }

            function generateEmployeeID() {
                const year = new Date().getFullYear();
                const randomDigits = Math.floor(10000 + Math.random() * 9999);
                const firstName = document.getElementById('first-name').value;
                const firstLetter = firstName.charAt(0).toUpperCase() || 'X';
                const lastName = document.getElementById('last-name').value;
                const firstLLetter = lastName.charAt(0).toUpperCase() || 'X'; 
            document.getElementById('Employee-id').value = `${firstLetter}${firstLLetter}-${year}${randomDigits}`;
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
                <span class="fs-5"></span>
                <a href="logout.php" class="text-white text-decoration-none">Logout</a>
            </div>
            <!-- Tabs Container -->
            <div class="tab-container">
                <h2 style="color: white">Employee Management</h2>
                <ul class="nav nav-tabs" id="employeeTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">Employee List</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="false">Add Employee</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="update-tab" data-bs-toggle="tab" data-bs-target="#update" type="button" role="tab" aria-controls="update" aria-selected="false">Update/Remove Employee</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <table class="table table-striped table-hover mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Position</th>
                                    <th>Hire Date</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody id="employeetablebody">
                              
                            </tbody>
                        </table>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="add-tab">
                    <form class="mt-3">
                        <div class="mb-3">
                            <label for="Employee-id" class="form-label">Employee ID</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="Employee-id" placeholder="Generate Employee ID" readonly>
                                <button type="button" class="btn btn-primary" onclick="generateEmployeeID()">Generate</button>
                            </div>
                        </div>
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="Gender" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="Gender" placeholder="Enter Employee's Gender">
                            </div>
                            <div class="col-md-6">
                                <label for="Role" class="form-label">Role</label>
                                <select class="form-select" id="Role" onchange="updateSalary()">
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="Warehouse Clerk">Warehouse Clerk</option>
                                    <option value="Logistics Coordinator">Logistics Coordinator</option>
                                    <option value="General Laborer">General Laborer</option>
                                    <option value="Safety Officer">Safety Officer</option>
                                    <option value="Maintenance Technician">Maintenance Technician</option>
                                    <option value="Quality Control Inspector">Quality Control Inspector</option>
                                    <option value="Picker/Packer">Picker/Packer</option>
                                    <option value="Shipping Clerk">Shipping Clerk</option>
                                    <option value="Receiving Clerk">Receiving Clerk</option>
                                    <option value="Inventory Specialist">Inventory Specialist</option>
                                    <option value="Team Leader/Supervisor">Team Leader/Supervisor</option>
                                </select>
                            </div>
                        </div>
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="Salary" class="form-label">Salary per Month</label>
                        <input type="text" class="form-control" id="Salary" placeholder="Salary will be calculated" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="Schedule" class="form-label">Schedule</label>
                        <input type="text" class="form-control" id="Schedule">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Employee</button>
            </form>
        </div>


                    <!-- Tab 3: Update/Remove Employee -->
                    <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
                        <form class="mt-3">
                            <div class="mb-3">
                                <label for="employeeId" class="form-label">Employee ID</label>
                                <input type="text" class="form-control" id="employeeId" placeholder="Enter employee ID">
                            </div>
                            <button type="button" class="btn btn-secondary">Fetch Data</button>
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="Gender" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="Gender">
                            </div>
                            <div class="col-md-6">
                                <label for="Role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="Role" >
                            </div>
                        </div>
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="Salary" class="form-label">Salary per Month</label>
                        <input type="text" class="form-control" id="Salary" placeholder="Salary will be calculated" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="Schedule" class="form-label">Schedule</label>
                        <input type="text" class="form-control" id="Schedule">
                    </div>
                    <div class="row md-3">
                    <div class="col-md-6">
                            <button type="submit" class="btn btn-primary mt-3">Update Employee</button>
                            <br>
                            <button type="button" class="btn btn-danger mt-3">Remove Employee</button>
                    </div>
                    </div>
        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            fetch('Fetchemployees.php')
                .then(response => response.json())
                .then(data => {
                    const employeeTableBody = document.querySelector('#employeetablebody');

                    if (data.error) {
                        // Fix the error display by wrapping in backticks
                        employeeTableBody.innerHTML = `<tr><td colspan="5" class="text-center">Error: ${data.error}</td></tr>`;
                    } else {
                        employeeTableBody.innerHTML = '';

                        data.forEach(employee => {
                            const employeeRow = document.createElement('tr');
                            let attendanceContent;
                            if (employee.Attendance === null || employee.Attendance === '') {
                                // Fix the attendance buttons using backticks
                                attendanceContent = `
                                    <button class="btn btn-success" onclick="markAttendance('${employee.EmployeeId}', 'present')">Present</button>
                                    <button class="btn btn-danger" onclick="markAttendance('${employee.EmployeeId}', 'absent')">Absent</button>
                                `;
                            } else {
                                // Fix the span tag using backticks
                                attendanceContent = `<span>${employee.Attendance}</span>`;
                            }
                            // Fix the row content to use backticks properly
                            employeeRow.innerHTML = `
                                <td>${employee.EmployeeName}</td>
                                <td>${employee.Position}</td>
                                <td>${employee.HireDate}</td>
                                <td class="attendance-cell">${attendanceContent}</td>
                            `;

                            employeeRow.id = `employee-${employee.EmployeeId}`; // Set unique ID for row
                            employeeTableBody.appendChild(employeeRow);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching employees:', error.message || error);
                    // Fix the error display for failed fetch
                    document.querySelector('#employeetablebody').innerHTML = `<tr><td colspan="5" class="text-center">Error loading employees.</td></tr>`;
                });

            function markAttendance(employeeId, status) {
                console.log('Sending data:', { employeeId, status });

                fetch('updateattendance.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    // Corrected the body formatting
                    body: `EmployeeId=${encodeURIComponent(employeeId)}&Attendance=${encodeURIComponent(status)}`
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response from server:', data);
                    if (data.success) {
                        alert('Attendance updated successfully.');
                        updateAttendanceInTable(employeeId, status);
                    } else {
                        alert(`Error updating attendance: ${data.error}`);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Error updating attendance.');
                });
            }

            function updateAttendanceInTable(employeeId, status) {
                const employeeRow = document.querySelector(`#employee-${employeeId}`);
                if (employeeRow) {
                    const attendanceCell = employeeRow.querySelector('.attendance-cell');
                    attendanceCell.innerHTML = `<span>${status}</span>`; // Fix the innerHTML update
                }
            }
        </script>

    </body>
</html>