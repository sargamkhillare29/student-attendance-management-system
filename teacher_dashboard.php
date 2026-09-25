<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['teacher_name']; ?></h2>
    <a href="attendance_marking.php">Attendance marking</a> 
    <a href="view_attendance.php">View Attendance</a> 
    <a href="logout.php">Logout</a>
</body>
</html>
