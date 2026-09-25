<?php
session_start();
include 'includes/db.php';

// Ensure only admins or teachers can access
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    header("Location: index.php");
    exit();
}

// Fetch students
$query = "SELECT * FROM students";  // Ensure table name is correct
$result = $conn->query($query);

// Check if query failed
if (!$result) {
    die("Error fetching students: " . $conn->error);
}

// Handle attendance submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = date("Y-m-d"); // Get current date

    foreach ($_POST['attendance'] as $student_id => $status) {
        // Prepare the insert query
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");

        // Check if query preparation failed
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("iss", $student_id, $date, $status);

        // Execute and check if it fails
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
    }
    echo "<p style='color:green;'>✅ Attendance recorded successfully!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Attendance</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f4a261; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Take Attendance</h1>
        <form method="POST">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Attendance</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <input type="radio" name="attendance[<?php echo $row['id']; ?>]" value="Present" required> Present
                            <input type="radio" name="attendance[<?php echo $row['id']; ?>]" value="Absent"> Absent
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <button type="submit">Submit Attendance</button>
        </form>
        <br>
        <a href="admin_dashboard.php">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
