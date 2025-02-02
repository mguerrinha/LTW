<?php

function drawLogIn() { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form - GreenBrowse</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/notification.css">
    <script src="../javascript/notification.js" defer></script>
</head>
<body>
    <div class="login-form">
        <h1>Login</h1>
        <form action="../utils/authentication.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" class="input" required>
                <label for="email" class="label">Email</label>
            </div>
            <div class="form-group">
                <input type="text" id="username" name="username" class="input" required>
                <label for="username" class="label">Username</label>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="input" required>
                <label for="password" class="label">Password</label>
            </div>
            <button type="submit">Log In</button>
        </form>
        <div class="form-frase">
            <p>Doesn't have an account?</p>
            <a href="../pages/signupPage.php">Signup</a>
        </div>
        <a href="../index.php" class="home">Home</a>
    </div>  
</body>
</html><?php
}
?>

