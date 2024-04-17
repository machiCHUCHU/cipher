<?php
include('dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['stud_id'])) {
        $studentId = $_POST['stud_id'];
        
        // Insert attendance record into tblattendance
        $currentTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO tblattendance (userid, dated, in_AM) VALUES (:userid, :dated, :in_AM)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userid', $studentId);
        $stmt->bindParam(':dated', date('Y-m-d'));
        $stmt->bindParam(':in_AM', $currentTime);
        if ($stmt->execute()) {
            echo "Attendance recorded successfully";
        } else {
            echo "Error recording attendance";
        }
    } else {
        echo "Invalid request";
    }
}
?>
