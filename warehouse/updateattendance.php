<?php
require_once 'connectionmysql2.php';

session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['EmployeeId']) && isset($_POST['Attendance'])) {
        $employeeId = $_POST['EmployeeId'];
        $attendance = $_POST['Attendance'];

        if ($attendance !== 'present' && $attendance !== 'absent') {
            echo json_encode(['error' => 'Invalid attendance value.']);
            exit();
        }

        // Log employeeId and attendance for debugging
        error_log("EmployeeId: $employeeId, Attendance: $attendance");

        $sql = "CALL updateattendance(:employeeId, :attendance)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_STR);
        $stmt->bindParam(':attendance', $attendance, PDO::PARAM_STR);
    
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => 'Attendance updated successfully.']);
        } else {
            // Provide debugging information in case no changes are made
            echo json_encode([
                'error' => 'Failed to update attendance or no changes were made.',
                'debug' => [
                    'EmployeeId' => $employeeId,
                    'Attendance' => $attendance
                ]
            ]);
        }
    } else {
        echo json_encode(['error' => 'EmployeeId or Attendance not provided.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
