<?php session_start(); ?>
<h2>Login</h2>
<form method="POST" action="login.php">
    <input type="email" name="email" placeholder="Enter Email" required><br>
    <input type="password" name="password" placeholder="Enter Password" required><br>
    <button type="submit">Login</button>
</form>
