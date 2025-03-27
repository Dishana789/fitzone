<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Feedback</title>
  <link href="managefeedback.css" rel="stylesheet" type="text/css">
</head>
<body>
  
  <div class="manage-feedback-container">
    <h2>Manage Feedback</h2>
    <?php
    include 'database.php';  

    
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $sql = "DELETE FROM feedback WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<div class='feedback-message'>Feedback deleted successfully!</div>";
        } else {
            echo "<div class='feedback-message error'>Error deleting feedback!</div>";
        }
        $stmt->close();
    }

   
    $sql = "SELECT * FROM feedback ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <table class="feedback-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td>
                            <a href="managefeedback.php?delete_id=<?php echo $row['id']; ?>" 
                               class="btn-delete"
                               onclick="return confirm('Are you sure you want to delete this feedback?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No feedback entries found.</p>
    <?php endif; ?>
  </div>
</body>
</html>

</body>
</html>