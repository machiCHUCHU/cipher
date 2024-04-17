<?php
require("dbconnection.php");


if (isset($_GET['stud_id'])) {
    $studentId = $_GET['stud_id'];


    $query = "SELECT * FROM tblstudents WHERE stud_id = :stud_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':stud_id', $studentId);
    $stmt->execute();
    
   
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id=$row["id"];
        $studentInfo = "Name: " . $row['name'] . "\n";
        $studentInfo .= "Student ID: " . $row['stud_id'] . "\n";
        $studentInfo .= "Section: " . $row['section'];
        
        $currentTime = date('H:i:s');
        $currentDate = date('Y-m-d');
        $query = "INSERT INTO tblattendance (userid, dated, in_AM) VALUES (:id, :dated, :in_AM)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':dated', $currentDate);
        $stmt->bindParam(':in_AM', $currentTime);
        $stmt->execute();
        
        echo $studentInfo;
    } else {
        echo "Student not found";
    }
} else {
    echo "Invalid request";
}
?>
