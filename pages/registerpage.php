<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FitZone Fitness Center</title>
    <link href="register.css" rel="stylesheet" type="text/css">
	<style type="text/css">
    body {
    background-image: url(../images/aboutus.jfif);
	background-repeat: no-repeat;
    background-size: cover;
}
    </style>
</head>
<?php 
session_start(); 
?>
<body>
    <main>
        <div class="form-container">
            <center><h2>Register</h2></center>

          
            <?php
            if (isset($_SESSION['registration_errors'])) {
                foreach ($_SESSION['registration_errors'] as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
                unset($_SESSION['registration_errors']); 
            }
            if (isset($_SESSION['success_message'])) {
                echo "<p style='color:green;'>" . $_SESSION['success_message'] . "</p>";
                unset($_SESSION['success_message']); 
            }
            ?>

           
            <form action="registerchecking.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>

                <label for="mobile">Mobile No:</label>
                <input type="text" id="mobile" name="mobile" required>

                <button type="submit" class="submit-btn">Register</button>
            </form>

            
            <p>Already registered?</p>
           <center> <a href="loginpage.php" class="login-btn">Go to Login</a></center>
        </div>
    </main>
</body>
</html>
