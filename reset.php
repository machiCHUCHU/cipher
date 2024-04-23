<?php
include('dbconnection.php');

if(isset($_POST["submit"])) {
    try {
        // Execute separate SQL queries to set each column to NULL
        $columns = array('in_AM', 'out_AM', 'in_PM', 'out_PM', 'dated');
        foreach ($columns as $column) {
            $query = "UPDATE tblattendance SET $column = NULL";
            $stmt = $conn->prepare($query);
            $stmt->execute();
        }

        header("Location: index.php");
        exit;
    } catch(PDOException $e) {

        echo "Error: " . $e->getMessage();
    }
} else {

    header("Location: index.php");
    exit;
}
?>


