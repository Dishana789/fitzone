<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Fitness Center - Packages</title>
    <link href="package.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    body {
    background-image: url(../images/loginimg.jpg);
}
    </style>
</head>
	 <?php include('customer_nav.php'); ?>
	
<body>
   
    <?php include 'database.php'; ?>

    <main>
        <h1>Our Fitness Packages</h1>
        <div class="package-list">
            <?php
            
            $sql = "SELECT * FROM package";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="package">';
                    echo '<h2>' . htmlspecialchars($row["name"]) . '</h2>';
                    echo '<p>Duration: ' . htmlspecialchars($row["duration"]) . '</p>';
                    echo '<p>Price: Rs' . htmlspecialchars($row["price"]) . '</p>';
                    echo '<p>Type: ' . htmlspecialchars($row["type"]) . '</p>';
                    echo '<p>Hardness: ' . htmlspecialchars($row["hardness"]) . '</p>';
                    echo '<button onclick="purchasePackage(\'' . htmlspecialchars($row["name"]) . '\', ' . htmlspecialchars($row["id"]) . ')">Select</button>';
                    echo '</div>';
                }
            } else {
                echo "<p>No packages available.</p>";
            }
            $conn->close();
            ?>
        </div>

        <div id="customer-message" style="margin-top: 20px; font-weight: bold;"></div>

       
    </main>

    <script>
        function purchasePackage(packageName, packageId) {
            
            document.getElementById('customer-message').innerText = `You have selected the ${packageName} package.`;
            
           
            document.getElementById('package-id').value = packageId;
            document.getElementById('purchase-form').submit();
        }
    </script>
</body>
</html>
<?php
    include('customer_footer.php');
    ?>




