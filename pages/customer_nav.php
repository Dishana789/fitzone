<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
    <link rel="stylesheet" href="customer.css" />
</head>
<body>
<nav>
    <div class="nav__bar">
        <div class="nav__header">
            <div class="nav__logo">
                <a href="#"><img src="../images/logo1.webp" alt="logo" /></a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <li><a href="home.php">HOME</a></li>
            <li><a href="aboutus.php">ABOUT US</a></li>
            <li><a href="class.php">OUR CLASSES</a></li>
            <li><a href="package.php">PACKAGES</a></li>
            <li><a href="blogpage.php">BLOG</a></li>
            <li><a href="feedbackpage.php">FEEDBACK</a></li>
			<li><a href="appointments.php">APPOINTMENTS</a></li>
			
            
            <?php if (isset($_SESSION['user_name'])): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" onclick="logout()">
                        <i class='bx bxs-user'></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?> / Log out
                    </a>
                </li>
            <?php else: ?>
                <li><a href="loginpage.php"><i class='bx bxs-user'></i> LOG OUT</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script>

function logout() {
    
    const confirmLogout = confirm("Are you sure you want to log out?");
    if (confirmLogout) {
        
        <?php
        session_unset();
        session_destroy();
        ?>
       
        window.location.href = 'home.php';
    }
}
</script>
</body>
</html>
