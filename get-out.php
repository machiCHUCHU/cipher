<?php
require("dbconnection.php");

date_default_timezone_set('Asia/Manila');

// Define time ranges for logout (AM and PM)
$logoutTimeRangesAM = array(
    'start' => '11:30:00',
    'end' => '12:30:00'
);

$logoutTimeRangesPM = array(
    'start' => '16:30:00',
    'end' => '17:30:00'
);

if (isset($_GET['stud_id'])) {
    $studentId = $_GET['stud_id'];
    $currentTime = date('H:i:s');

    // Check if current time falls within AM or PM logout time range
    if (($currentTime >= $logoutTimeRangesAM['start'] && $currentTime <= $logoutTimeRangesAM['end']) ||
        ($currentTime >= $logoutTimeRangesPM['start'] && $currentTime <= $logoutTimeRangesPM['end'])) {

        // Fetch student information from the database
        $query = "SELECT * FROM tblstudents WHERE stud_id = :stud_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':stud_id', $studentId);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $studentInfo = "Name: " . $row['name'] . "\n";
            $studentInfo .= "Student ID: " . $row['stud_id'] . "\n";
            $studentInfo .= "Section: " . $row['section'] . "\n";
            $studentInfo .= "Time_OUT: " . date('h:i:s A');

            // Determine whether to insert into out_AM or out_PM column
            $currentDate = date('Y-m-d');
            if ($currentTime >= $logoutTimeRangesAM['start'] && $currentTime <= $logoutTimeRangesAM['end']) {
                // Check if the user has already logged out during AM
                $checkQuery = "SELECT * FROM tblattendance WHERE userid = :id AND dated = :dated AND out_AM IS NOT NULL";
                $stmtCheck = $conn->prepare($checkQuery);
                $stmtCheck->bindParam(':id', $id);
                $stmtCheck->bindParam(':dated', $currentDate);
                $stmtCheck->execute();

                if ($stmtCheck->rowCount() > 0) {
                    echo "Student has already timed out.";
                } else {
                    // Insert time-out record into tblattendance for AM
                    $currentTime12 = date('h:i:s A');
                    $query = "UPDATE tblattendance SET out_AM = :currentTime WHERE userid = :id AND dated = :dated";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':dated', $currentDate);
                    $stmt->bindParam(':currentTime', $currentTime12);
                    $stmt->execute();
                    echo $studentInfo;
                }
            } elseif ($currentTime >= $logoutTimeRangesPM['start'] && $currentTime <= $logoutTimeRangesPM['end']) {
                // Check if the user has already logged out during PM
                $checkQuery = "SELECT * FROM tblattendance WHERE userid = :id AND dated = :dated AND out_PM IS NOT NULL";
                $stmtCheck = $conn->prepare($checkQuery);
                $stmtCheck->bindParam(':id', $id);
                $stmtCheck->bindParam(':dated', $currentDate);
                $stmtCheck->execute();

                if ($stmtCheck->rowCount() > 0) {
                    echo "Student has already timed out.";
                } else {
                    // Insert time-out record into tblattendance for PM
                    $currentTime12 = date('h:i:s A');
                    $query = "UPDATE tblattendance SET out_PM = :currentTime WHERE userid = :id AND dated = :dated";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':dated', $currentDate);
                    $stmt->bindParam(':currentTime', $currentTime12);
                    $stmt->execute();
                    echo $studentInfo;
                }
            }
        } else {
            echo "Student not found";
        }
    } else {
        echo "Timeout not allowed at this time.";
    }
} else {
    echo "Invalid request";
}
?>
