<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        a {
            display: block;
            margin: 10px;
            padding: 10px;
            background: blue;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background: darkblue;
        }
        /* Marquee styling */
        .marquee-box {
            border: 3px solid blue;
            padding: 10px;
            margin-bottom: 20px;
            background: yellow;
            color: black;
            font-weight: bold;
            border-radius: 8px;
        }
        marquee {
            font-size: 18px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>

    <!-- Marquee box at the top -->
    <div class="marquee-box">
        <marquee behavior="scroll" direction="left"> welcome, admin! Manage the student attendance system from here</marquee>
    </div>

    <div class="container">
        <h1>Welcome, Admin!</h1>

        <a href="manage_students.php">Manage Students</a>
        <a href="manage_teacher.php">Manage Teachers</a>
        <a href="attendance_records.php">View Attendance Records</a>

      

        
        <a href="logout.php">Logout</a>
    </div>

</body>
</html>
