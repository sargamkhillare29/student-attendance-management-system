<?php
session_start();
include 'includes/db.php';

// Ensure only admins or teachers can access
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    header("Location: index.php");
    exit();
}

// Fetch attendance records
$query = "SELECT a.id, s.name, a.date, a.status 
          FROM attendance a
          JOIN students s ON a.student_id = s.id
          ORDER BY a.date DESC";
$result = $conn->query($query);

// Check if query failed
if (!$result) {
    die("Error fetching attendance: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Attendance</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #f4a261; color: white; }
        .present { color: green; font-weight: bold; }
        .absent { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Attendance Records</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td class="<?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <a href="admin_dashboard.php">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
