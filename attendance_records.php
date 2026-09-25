<?php
session_start();
include 'includes/db.php';

// Ensure only admin or teacher can access
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    header("Location: index.php");
    exit();
}

// Fetch attendance records
$query = "SELECT students.id AS student_id, students.name, attendance.date, attendance.status 
          FROM attendance 
          INNER JOIN students ON attendance.student_id = students.id 
          ORDER BY attendance.date DESC";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching attendance records: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Attendance Records</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #2a9d8f; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Attendance Records</h1>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <a href="admin_dashboard.php">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
