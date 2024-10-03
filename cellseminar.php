<?php
include 'dbconnection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    
        $conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT tblstudents.stud_id, tblstudents.name, tblstudents.section, seminar.time_in, seminar.date_in,
    seminar.activity_name FROM tblstudents INNER JOIN seminar ON tblstudents.id = seminar.student_id");
    
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Student ID', 'Name', 'Section', 'Time In', 'Date', 'Activity Name'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header); // Set header values
        }

        $row = 2;
        foreach ($result as $row_data) {
            $sheet->setCellValueByColumnAndRow(1, $row, $row_data['stud_id']);
            $sheet->setCellValueByColumnAndRow(2, $row, $row_data['name']);
            $sheet->setCellValueByColumnAndRow(3, $row, $row_data['section']);
            $sheet->setCellValueByColumnAndRow(4, $row, $row_data['time_in']);
            $sheet->setCellValueByColumnAndRow(5, $row, $row_data['date_in']);
            $sheet->setCellValueByColumnAndRow(6, $row, $row_data['activity_name']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Seminar.xlsx";
        $writer->save($filename);

        echo "<script>alert('Exported to Excel'); window.location.href = 'index2.php';</script>";
    } else {
        echo "No records found.";
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>