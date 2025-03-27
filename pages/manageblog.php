<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog Management</title>
    <link href="manageblog.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php
include 'database.php'; 


$title = $content = "";
$isEdit = false;
$id = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imageName = '';

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/";
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $imageName;

        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);
    }

    if (isset($_POST['id']) && $_POST['id'] !== "") {
        
        $id = $_POST['id'];

        
        $sql = "UPDATE blog SET title=?, content=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $content, $imageName, $id);
        $stmt->execute();
        echo "<div class='message'>Blog updated successfully!</div>";
    } else {
        
        $sql = "INSERT INTO blog (title, content, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $content, $imageName);
        $stmt->execute();
        echo "<div class='message'>Blog added successfully!</div>";
    }

    $stmt->close();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM blog WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        echo "<div class='message'>Blog deleted successfully!</div>";
    } else {
        echo "<div class='error'>Error deleting blog. Please try again.</div>";
    }
}


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM blog WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $content = $row['content'];
            $isEdit = true;
        }
        $stmt->close();
    } else {
        echo "<div class='error'>Error fetching blog for editing. Please try again.</div>";
    }
}
?>

<div class="container">
    <h2>Blog Management</h2>

    
    <form action="manageblog.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $isEdit ? $id : ''; ?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" required><?php echo htmlspecialchars($content); ?></textarea>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image">

        <button type="submit"><?php echo $isEdit ? 'Update Blog' : 'Add Blog'; ?></button>
    </form>

   
    <h3>Existing Blogs</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $sql = "SELECT * FROM blog ORDER BY id DESC";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td>
                        <a href="manageblog.php?edit=<?php echo $row['id']; ?>">Edit</a>
                        <a href="manageblog.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                        <a href="blogpage.php?id=<?php echo $row['id']; ?>">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>









