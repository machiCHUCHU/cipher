<?php
require("dbconnection.php");


if (isset($_GET['stud_id'])) {
    $studentId = $_GET['stud_id'];


    $query = "SELECT * FROM tblstudents WHERE stud_id = :stud_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':stud_id', $studentId);
    $stmt->execute();
    
   
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $studentInfo = "Name: " . $row['name'] . "\n";
        $studentInfo .= "Student ID: " . $row['stud_id'] . "\n";
        $studentInfo .= "Section: " . $row['section'];
        
 
        
        // Display student info
        echo $studentInfo;
    } else {
        echo "Student not found";
    }
} else {
    echo "Invalid request";
}
?>
