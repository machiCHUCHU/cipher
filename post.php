<?php
require "dbconnection.php";

date_default_timezone_set('Asia/Manila');

// Define time ranges for login (AM)

if (isset($_GET['stud_id']) && isset($_GET['activity_id'])) {
    $studentId = $_GET['stud_id'];
    $activity_id = $_GET['activity_id'];

    $currentTime = date('H:i:s A');
    $currentDate = date('Y-m-d');

    switch ($activity_id) {
        case '1':
            $activity_name = "Campus Talk & Software Engineering";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '08:30:00',
            );

            break;
        case '2':
            $activity_name = "The sexiest Job of 21st Century - Data Science and Analytics";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '23:59:00',
            );

            break;
        case '3':
            $activity_name = "Aws/Campus Talk";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '08:30:00',
            );

            break;
        case '4':
            $activity_name = "Artificial Intelligence";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '08:30:00',
            );

            break;
        case '5':
            $activity_name = "Cloud-Based Application";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '08:30:00',
            );

            break;
        case '6':
            $activity_name = "Cyber Security 2";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '08:30:00',
            );

            break;
        case '7':
            $activity_name = "Web 3 and Blockchain";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '08:30:00',
            );

            break;
        default:
            $activity_name = "Unknown Activity";
            $loginTimeRangesAM = array(
                'start' => '07:30:00',
                'end' => '08:30:00',
            );

            break;
    }

    if ($currentTime >= $loginTimeRangesAM['start'] && $currentTime <= $loginTimeRangesAM['end']) {

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

            // Prepare the time in a 12-hour format
            $currentTime12 = date('h:i:s A');

            // Insert query to record the attendance
            $query = "INSERT INTO seminar (student_id, date_in, time_in, activity_name)
                      VALUES (:id, :dated, :currentTime, :activity)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':dated', $currentDate);
            $stmt->bindParam(':currentTime', $currentTime12);
            $stmt->bindParam(':activity', $activity_name);

            if ($stmt->execute()) {
                echo $studentInfo;
            } else {
                echo "Error inserting attendance record.";
            }
        } else {
            echo "Student not found";
        }
    } else {
        echo "Time in not allowed at this time.";
    }
} else {
    echo "Invalid request";
}
