<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../control/logincontroller.php';
    $loginController = new LoginController();
    $result = $loginController->login($_POST);
    if (is_string($result)) {
        echo "<p style='color: green;'>$result</p>";
    } else {
        foreach ($result as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<div class="container">
    <form action="login.php" method="post">
        <h2>Login Form</h2>
        <div class="form-row column">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>       

            <input type="submit" value="Login">
          <p>dont have an account?<a href="registration.php">register here</a></p>
        </div>
    </form>
</div>
</body>
</html>
