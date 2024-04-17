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
    $currentTime = date('H:i:s A');

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
            $currentDate = date('Y-m-d');
            if ($currentTime >= $loginTimeRangesAM['start'] && $currentTime <= $loginTimeRangesAM['end']) {
                // Insert time-in record into tblattendance for AM
                $currentTime12 = date('h:i:s A');
                $query = "INSERT INTO tblattendance (userid, in_AM, dated) VALUES (:id, :in_AM, :dated)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':in_AM', $currentTime12);
                $stmt->bindParam(':dated', $currentDate);
                $stmt->execute();
            } elseif ($currentTime >= $loginTimeRangesPM['start'] && $currentTime <= $loginTimeRangesPM['end']) {
                // Insert time-in record into tblattendance for PM
                $currentTime12 = date('h:i:s A');
                $query = "UPDATE tblattendance SET in_PM = :currentTime WHERE userid = :id AND dated = :dated";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':dated', $currentDate);
                $stmt->bindParam(':currentTime', $currentTime12);
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
