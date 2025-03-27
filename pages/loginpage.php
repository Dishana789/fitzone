<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitZone Fitness Center</title>
    <link href="login.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        body {
            background-image: url(../images/loginimg.jpg);
        }
    </style>
</head>
<?php include('customer_nav.php'); ?>
<?php 
session_start(); 
?>
<body>
    <main>
        <div class="form-container">
            <h2>Login</h2>

           
            <?php 
            if (isset($_SESSION['login_error'])) {
                echo "<p style='color:red;'>" . $_SESSION['login_error'] . "</p>";
                unset($_SESSION['login_error']); 
            }
            ?>

            <form action="loginpagecheck.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <p>Not a member? <a href="registerpage.php">Register here</a></p>
        </div>
    </main>
</body>
</html>
<?php
    include('customer_footer.php');
?>
