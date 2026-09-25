<?php
session_start();
include 'includes/db.php'; // Database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle student deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM students WHERE id = $delete_id");
    header("Location: manage_students.php");
    exit();
}

// Fetch all students
$result = $conn->query("SELECT * FROM students");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        a { text-decoration: none; padding: 8px 12px; background: red; color: white; border-radius: 5px; }
        a:hover { background: darkred; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Manage Students</h1>
        <a href="add_student.php" style="background: green;">➕ Add New Student</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="edit_student.php?id=<?php echo $row['id']; ?>">✏ Edit</a>
                    <a href="manage_students.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">❌ Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <a href="admin_dashboard.php" style="background: blue;">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
