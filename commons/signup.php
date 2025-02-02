<?php
function drawSignUp() { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form - GreenBrowse</title>
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <div class="sign-form">
        <h1>Sign up</h1>
        <form action="../CRUD/add_user.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" class="input" required>
                <label for="email" class="label">Email</label>
            </div>
            <div class="form-group">
                <input type="text" id="username" name="username" class="input" required>
                <label for="username" class="label">Username</label>
            </div>
            <div class="form-group">
                <input type="text" id="name" name="name" class="input" required>
                <label for="name" class="label">Name</label>
            </div>
            <div class="form-group">
                <input type="text" id="surname" name="surname" class="input" required>
                <label for="surname" class="label">Surname</label>
            </div>
            <div class="form-group">
                <input type="tel" id="phoneNumber" name="phoneNumber" class="input" required>
                <label for="phoneNumber" class="label">Phone Number</label>
            </div>
            <div class="form-group">
                <input type="text" id="address" name="address" class="input" required>
                <label for="address" class="label">Address</label>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="input" required>
                <label for="password" class="label">Password</label>
            </div>
            <div class="form-group">
                <input type="password" id="password_confirmation" name="password_confirmation" class="input" required>
                <label for="password_confirmation" class="label">Password Confirmation</label>
            </div>
            <button type="submit">Sign up</button>
        </form>
        <div class="form-frase">
            <p>Already has an account?</p>
            <a href="../pages/loginPage.php">Login</a>
        </div>
        <a href="../index.php" class="home">Home</a>
    </div>  
</body>
</html>



<?php
}
?>