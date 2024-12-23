<?php
require_once 'connectionmysql2.php';

session_start(); 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['AccountId'])) {
        echo json_encode(['error' => 'User not logged in.']);
        exit();
    }

    $accountId = $_SESSION['AccountId']; 

   
    $sql = "
           SELECT ManagerFirstName, ManagerLastName, EmployeeId, FirstName, LastName, Birthday, Age, Gender, Role, Salary, EmployeeState, Attendance, Task_Complete, AccountId, DateCreated, DateUpdated 
           FROM manageremployeelist 
           WHERE AccountId = :accountId"; 

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
    $stmt->execute();

    
    $employees = [];

   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['EmployeeName'] = $row['FirstName'] . ' ' . $row['LastName'];

        $row['Position'] = $row['Role'];

        $hireDate = new DateTime($row['DateCreated']);
        $row['HireDate'] = $hireDate->format('F j, Y'); 
       
        if ($row['Attendance'] === NULL) {
            $row['AttendanceButtons'] = '<button class="btn btn-success" onclick="markAttendance(\'' . $row['EmployeeId'] . '\', \'present\')">Present</button>
                                         <button class="btn btn-danger" onclick="markAttendance(\'' . $row['EmployeeId'] . '\', \'absent\')">Absent</button>';
        } else {
            $row['AttendanceButtons'] = $row['Attendance']; 
        }

        
        $employees[] = $row;
    }

    
    if (count($employees) > 0) {
        echo json_encode($employees); 
    } else {
        echo json_encode(['error' => 'No employees found for this manager.']);  
    }
} catch (PDOException $e) {
    
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>