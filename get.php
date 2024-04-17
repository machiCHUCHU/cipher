<?php
require("dbconnection.php");

date_default_timezone_set('Asia/Manila');

// Define time ranges for login (AM and PM)
$loginTimeRangesAM = array(
    'start' => '07:00:00',
    'end' => '09:00:00'
);

$loginTimeRangesPM = array(
    'start' => '13:00:00',
    'end' => '14:00:00'
);

if (isset($_GET['stud_id'])) {
    $studentId = $_GET['stud_id'];
    $currentTime = date('H:i:s');

    // Check if current time falls within AM login time range
    if (($currentTime >= $loginTimeRangesAM['start'] && $currentTime <= $loginTimeRangesAM['end']) ||
        ($currentTime >= $loginTimeRangesPM['start'] && $currentTime <= $loginTimeRangesPM['end'])) {

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
            $studentInfo .= "Time_IN: " . date('h:i:s A');

            // Determine whether to insert into AM or PM column
            $currentTime = date('H:i:s');
            $currentDate = date('Y-m-d');
            if ($currentTime >= $loginTimeRangesAM['start'] && $currentTime <= $loginTimeRangesAM['end']) {
                // Insert time-in record into tblattendance for AM
                $query = "UPDATE tblattendance SET in_AM = :currentTime WHERE userid = :id AND dated = :dated";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':dated', $currentDate);
                $stmt->bindParam(':currentTime', $currentTime);
                $stmt->execute();
            } elseif ($currentTime >= $loginTimeRangesPM['start'] && $currentTime <= $loginTimeRangesPM['end']) {
                // Insert time-in record into tblattendance for PM
                $query = "UPDATE tblattendance SET in_PM = :currentTime WHERE userid = :id AND dated = :dated";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':dated', $currentDate);
                $stmt->bindParam(':currentTime', $currentTime);
                $stmt->execute();
            }

            echo $studentInfo;
        } else {
            echo "Student not found";
        }
    } else {
        echo "Log IN not allowed.";
    }
} else {
    echo "Invalid request";
}
?>
