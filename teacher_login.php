<?php
session_start();
include 'includes/db.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check teacher in database
    $query = "SELECT * FROM teachers WHERE email = '$email' AND password = SHA1('$password')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['teacher_id'] = $row['id'];
        $_SESSION['teacher_name'] = $row['name'];
        header("Location: teacher_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
</head>
<body>
    <h2>Teacher Login</h2>
    <form method="post">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
