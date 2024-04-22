<?php
include 'dbconnection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT tblstudents.stud_id, tblstudents.name, tblstudents.section, tblattendance.in_AM, tblattendance.out_AM,
    tblattendance.in_PM, tblattendance.out_PM, tblattendance.dated FROM tblstudents INNER JOIN tblattendance ON tblstudents.id = tblattendance.userid");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Student ID', 'Name', 'Section', 'Time In (AM)', 'Time Out (AM)', 'Time In (PM)', 'Time Out (PM)', 'Date'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header); // Set header values
        }

        $row = 2;
        foreach ($result as $row_data) {
            $sheet->setCellValueByColumnAndRow(1, $row, $row_data['stud_id']);
            $sheet->setCellValueByColumnAndRow(2, $row, $row_data['name']);
            $sheet->setCellValueByColumnAndRow(3, $row, $row_data['section']);
            $sheet->setCellValueByColumnAndRow(4, $row, $row_data['in_AM']);
            $sheet->setCellValueByColumnAndRow(5, $row, $row_data['out_AM']);
            $sheet->setCellValueByColumnAndRow(6, $row, $row_data['in_PM']);
            $sheet->setCellValueByColumnAndRow(7, $row, $row_data['out_PM']);
            $sheet->setCellValueByColumnAndRow(8, $row, $row_data['dated']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Students Week Attendance.xlsx';
        $writer->save($filename);

        echo "<script>alert('Exported to Excel'); window.location.href = 'index.php';</script>";
    } else {
        echo "No records found.";
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>