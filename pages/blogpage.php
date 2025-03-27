<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog page - FitZone Fitness Center</title>
    <link href="blog.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    body {
    background-image: url(../images/session-1.jpg);
}
    </style>
</head>
 <?php include('customer_nav.php'); ?>
<body>
<div class="container">
    <?php
    include 'database.php'; 

    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

       
        $sql = "SELECT * FROM blog WHERE id=?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            
            if ($row = $result->fetch_assoc()): ?>
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                
               
                <?php
                $imagePath = "uploads/" . htmlspecialchars($row['image']);
                
                if (!empty($row['image']) && file_exists($imagePath)): ?>
                  <img src="<?php echo $imagePath; ?>" alt="Blog Image" style="display: block; margin-left: auto; margin-right: auto;">

                <?php else: ?>
  <p><strong>No image available for this blog post.</strong></p>
                <?php endif; ?>

                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

               
                <button onclick="goBack()">Back</button>

            <?php else: ?>
                <p>Blog not found.</p>
            <?php endif;

            $stmt->close();
        } else {
            echo "<p>Error preparing the SQL statement.</p>";
        }
    } else {
        
        echo "<h2>All Blogs</h2>";
        $sql = "SELECT id, title FROM blog ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li><a href='blogpage.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No blogs found.</p>";
        }
    }
    ?>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
<?php
    include('customer_footer.php');
    ?>


