<?php
session_start();
include 'includes/db.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Check if an ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: manage_students.php");
    exit();
}

$id = intval($_GET['id']); // Get student ID

// Fetch student details from the database
$result = $conn->query("SELECT * FROM students WHERE id = $id");
$student = $result->fetch_assoc();

if (!$student) {
    header("Location: manage_students.php");
    exit();
}

// Handle form submission for updating student details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    $updateQuery = "UPDATE students SET name='$name', email='$email' WHERE id=$id";

    if ($conn->query($updateQuery) === TRUE) {
        header("Location: manage_students.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        input { width: 90%; padding: 10px; margin: 5px; }
        button { padding: 10px; background: orange; color: white; border: none; cursor: pointer; }
        button:hover { background: darkorange; }
        a { text-decoration: none; display: block; margin-top: 10px; color: blue; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Student</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
            <button type="submit">Update Student</button>
        </form>
        <a href="manage_students.php">⬅ Back to Manage Students</a>
    </div>

</body>
</html>
