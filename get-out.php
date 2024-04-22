<?php
require("dbconnection.php");

date_default_timezone_set('Asia/Manila');

// Define time ranges for login (AM and PM)
$LogoutimeRangeAM = array(
    'start' => '23:30:00',
    'end' => '24:30:00'
);

$LogoutimeRangePM = array(
    'start' => '16:00:00',
    'end' => '17:30:00'
);

if (isset($_GET['stud_id'])) {
    $studentId = $_GET['stud_id'];
    $currentTime = date('H:i:s');
    $currentDate = date('Y-m-d');

    // Check if current time falls within AM or PM login time range
    if (($currentTime >= $LogoutimeRangeAM['start'] && $currentTime <= $LogoutimeRangeAM['end']) ||
        ($currentTime >= $LogoutimeRangePM['start'] && $currentTime <= $LogoutimeRangePM['end'])) {

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

            if ($currentTime >= $LogoutimeRangeAM['start'] && $currentTime <= $LogoutimeRangeAM['end']) {
                // Insert time-in record into tblattendance for AM
                $currentTime12 = date('h:i:s A');
                $query = "UPDATE tblattendance SET out_AM = :currentTime, dated = :dated WHERE userid = :id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':dated', $currentDate);
                $stmt->bindParam(':currentTime', $currentTime12);
                $stmt->execute();
                echo $studentInfo;
            } elseif ($currentTime >= $LogoutimeRangePM['start'] && $currentTime <= $LogoutimeRangePM['end']) {
                // Insert time-in record into tblattendance for PM
                $currentTime12 = date('h:i:s A');
                $query = "UPDATE tblattendance SET out_PM = :currentTime, dated = :dated WHERE userid = :id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':dated', $currentDate);
                $stmt->bindParam(':currentTime', $currentTime12);
                $stmt->execute();
                echo $studentInfo;
            }
        } else {
            echo "Student not found";
        }
    } else {
        echo "Time out not allowed at this time.";
    }
} else {
    echo "Invalid request";
}
?>
