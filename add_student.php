<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $conn->query("INSERT INTO students (name, email) VALUES ('$name', '$email')");
    header("Location: manage_students.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        input { width: 90%; padding: 10px; margin: 5px; }
        button { padding: 10px; background: green; color: white; border: none; cursor: pointer; }
        button:hover { background: darkgreen; }
        a { text-decoration: none; display: block; margin-top: 10px; color: blue; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Add New Student</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Student Name" required>
            <input type="email" name="email" placeholder="Student Email" required>
            <button type="submit">Add Student</button>
        </form>
        <a href="manage_students.php">⬅ Back to Manage Students</a>
    </div>

</body>
</html>
