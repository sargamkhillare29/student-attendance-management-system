<?php
session_start();
include 'includes/db.php';

// Check if the user is logged in as a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendance = $_POST['attendance'];

    foreach ($attendance as $student_id => $status) {
        $date = date('Y-m-d');
        
        // Check if attendance already exists for this student and date
        $checkQuery = "SELECT * FROM attendance WHERE student_id = $student_id AND date = '$date'";
        $result = $conn->query($checkQuery);
        
        if ($result->num_rows > 0) {
            // Update existing attendance
            $updateQuery = "UPDATE attendance SET status = '$status' WHERE student_id = $student_id AND date = '$date'";
            $conn->query($updateQuery);
        } else {
            // Insert new attendance
            $insertQuery = "INSERT INTO attendance (student_id, date, status) VALUES ($student_id, '$date', '$status')";
            $conn->query($insertQuery);
        }
    }

    header("Location: attendance.php?success=1");
    exit();
}
?>
