<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Classes</title>
    <link href="class.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    body {
    background-image: url(../images/aboutus.jfif);
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>
</head>
<body>
    <?php include('customer_nav.php'); ?>
    <div class="class-container">
        <h2>Our Gym Classes</h2>
        <?php
        include 'database.php';

        
        $sql = "SELECT * FROM class ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0): ?>
            <div class="class-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="class-item">
                        
                        <div class="class-details">
                            <h3><?php echo htmlspecialchars($row['classname']); ?></h3>
                            <p><strong>Time:</strong> <?php echo htmlspecialchars($row['classtime']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($row['classdetails'])); ?></p>
                        </div>
                        
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Class Image" class="class-image">
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No classes available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
    include('customer_footer.php');
    ?>



