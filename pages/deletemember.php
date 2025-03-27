<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delete Member - FitZone Fitness Center</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-container">
    <header>
        <h1>Delete Member</h1>
    </header>

    <?php
   
    include('database.php');

   
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $member_id = $_GET['id'];

      
        $sql = "SELECT username FROM users WHERE id = ? AND role = 'customer'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $member = $result->fetch_assoc();
            echo "<p>Are you sure you want to delete member: <strong>" . htmlspecialchars($member['username']) . "</strong>?</p>";

            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $deleteSQL = "DELETE FROM users WHERE id = ?";
                $stmt = $conn->prepare($deleteSQL);
                $stmt->bind_param("i", $member_id);

                
                if ($stmt->execute()) {
                    echo "<p>Member deleted successfully. <a href='managemembers.php'>Return to Manage Members</a></p>";
                } else {
                    echo "<p style='color:red;'>Error: Could not delete member. Please try again later.</p>";
                }

                
                $stmt->close();
            } else {
                
                echo "<form action='deletemember.php?id=" . $member_id . "' method='POST'>";
                echo "<button type='submit'>Confirm Delete</button>";
                echo "</form>";
            }
        } else {
            echo "<p style='color:red;'>Member not found.</p>";
        }

    } else {
        echo "<p style='color:red;'>Invalid member ID.</p>";
    }

    
    $conn->close();
    ?>
</div>

</body>
</html>
