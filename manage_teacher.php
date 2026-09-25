<?php
session_start();
include 'includes/db.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle teacher addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        echo "<p style='color:red;'>Email already exists!</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'teacher')");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Teacher added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error adding teacher!</p>";
        }
    }
}

// Handle teacher deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Teacher deleted successfully!</p>";
    }
}

// Fetch all teachers
$result = $conn->query("SELECT * FROM users WHERE role = 'teacher'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Teachers</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #f4a261; color: white; }
        .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
        .delete { background-color: red; color: white; }
        .edit { background-color: blue; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Manage Teachers</h1>

        <h3>Add New Teacher</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="add_teacher">Add Teacher</button>
        </form>

        <h3>Teacher List</h3>
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
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <a href="admin_dashboard.php">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
