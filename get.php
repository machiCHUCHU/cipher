<?php
require("dbconnection.php");

date_default_timezone_set('Asia/Manila');
if (isset($_GET['stud_id'])) {
    $studentId = $_GET['stud_id'];

    // Define multiple time ranges for login
    $loginTimeRanges = array(
        array('start' => '07:00:00', 'end' => '09:00:00'),   // 7:00 AM - 9:00 AM
        array('start' => '13:00:00', 'end' => '14:00:00')    // 1:00 PM - 2:00 PM
        // Add more time ranges as needed
    );

    // Get current time
    $currentTime = date('H:i:s');

    // Check if current time falls within any login time range
    $loginAllowed = false;
    foreach ($loginTimeRanges as $range) {
        if ($currentTime >= $range['start'] && $currentTime <= $range['end']) {
            $loginAllowed = true;
            break;
        }
    }

    if ($loginAllowed) {
        // Check if the student has already recorded time-in for today
        $currentDate = date('Y-m-d');
        $query = "SELECT * FROM tblattendance WHERE userid = :id AND dated = :dated";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $studentId);
        $stmt->bindParam(':dated', $currentDate);
        $stmt->execute();
        $attendance = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($attendance) {
            // Student has already logged in, display a warning
            echo "You have already logged in today.";
        } else {
            // Student is logging in, insert a new record with time-in
            $query = "SELECT * FROM tblstudents WHERE stud_id = :stud_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':stud_id', $studentId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $id = $row["id"];
                $currentTime = date('h:i:s A');
                $query = "INSERT INTO tblattendance (userid, dated, in_AM) VALUES (:id, :dated, :in_AM)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':dated', $currentDate);
                $stmt->bindParam(':in_AM', $currentTime);
                $stmt->execute();
                echo "Time-IN recorded for " . $row['name'];
            } else {
                echo "Student not found";
            }
        }
    } else {
        echo "You are not allowed to log in at this time.";
    }
} else {
    echo "Invalid request";
}
?>
