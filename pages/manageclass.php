<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gym Classes</title>
    <link href="manageclass.css" rel="stylesheet" type="text/css">
</head>
<body>
   
    <div class="manage-class-container">
        <h2>Manage Gym Classes</h2>
        <?php
        include 'database.php';

        
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $class_name = $_POST['classname'];
            $class_time = $_POST['classtime'];
            $class_details = $_POST['classdetails'];
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            
            $image = $_FILES['image']['name'];
            $target = 'uploads/' . basename($image);
            if (!empty($image)) {
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
            }

            if ($id) { 
                if (!empty($image)) {
                    $sql = "UPDATE class SET classname=?, classtime=?, classdetails=?, image=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssi", $class_name, $class_time, $class_details, $image, $id);
                } else { 
                    $sql = "UPDATE class SET classname=?, classtime=?, classdetails=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssi", $class_name, $class_time, $class_details, $id);
                }
                $message = 'Class updated successfully!';
            } else { 
                $sql = "INSERT INTO class (classname, classtime, classdetails, image) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $class_name, $class_time, $class_details, $image);
                $message = 'Class added successfully!';
            }
            $stmt->execute();
            $stmt->close();
        }

       
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $sql = "DELETE FROM class WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
            $stmt->close();
            $message = 'Class deleted successfully!';
        }

        
        $sql = "SELECT * FROM class ORDER BY id DESC";
        $result = $conn->query($sql);
        ?>

       
        <?php if ($message): ?>
            <div class="message" id="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

       
        <form id="classForm" action="manageclass.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="classId">
            <input type="text" name="classname" id="className" placeholder="Class Name" required>
            <input type="text" name="classtime" id="classTime" placeholder="Class Time" required>
            <textarea name="classdetails" id="classDetails" placeholder="Class Details" required></textarea>
            <input type="file" name="image" id="classImage">
            <button type="submit" id="submitButton">Add Class</button>
        </form>

       
        <div class="class-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="class-item">
                    <div class="class-details">
                        <h3><?php echo htmlspecialchars($row['classname']); ?></h3>
                        <p><strong>Time:</strong> <?php echo htmlspecialchars($row['classtime']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($row['classdetails'])); ?></p>
                    </div>
                    <img class="class-image" src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['classname']); ?>">
                    <div class="actions">
                        <button onclick="editClass('<?php echo $row['id']; ?>', '<?php echo addslashes($row['classname']); ?>', '<?php echo addslashes($row['classtime']); ?>', '<?php echo addslashes($row['classdetails']); ?>')">Edit</button>
                        <a href="manageclass.php?delete_id=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirmDelete()">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function editClass(id, name, time, details) {
            
            document.getElementById('classId').value = id;
            document.getElementById('className').value = name;
            document.getElementById('classTime').value = time;
            document.getElementById('classDetails').value = details;
            document.getElementById('submitButton').textContent = 'Update Class';
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this class?');
        }

        
        <?php if ($message): ?>
            setTimeout(function() {
                document.getElementById('message').style.display = 'none';
            }, 3000);
        <?php endif; ?>
    </script>
</body>
</html>





