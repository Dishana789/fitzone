<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages - FitZone Fitness Center</title>
    <link href="managepackage.css" rel="stylesheet" type="text/css">
</head>
<body>
    
    <?php include 'database.php'; ?>

    <main>
        <h1>Manage Fitness Packages</h1>

        <?php
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $duration = $_POST['duration'];
            $price = $_POST['price'];
            $type = $_POST['type'];
            $hardness = $_POST['hardness'];
            $action = $_POST['action'];

            if ($action == "add") {
                $sql = "INSERT INTO package (name, duration, price, type, hardness) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdss", $name, $duration, $price, $type, $hardness);
                $stmt->execute();
                echo $stmt->error ? "<p>Error adding package.</p>" : "<p><center>Package added successfully!</center></p>";
            } elseif ($action == "edit") {
                $id = $_POST['id'];
                $sql = "UPDATE package SET name=?, duration=?, price=?, type=?, hardness=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdssi", $name, $duration, $price, $type, $hardness, $id);
                $stmt->execute();
                echo $stmt->error ? "<p>Error updating package.</p>" : "<p><center>Package updated successfully!</center></p>";
            }
            $stmt->close();
        }

       
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $sql = "DELETE FROM package WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            echo $stmt->error ? "<p>Error deleting package.</p>" : "<p><center>Package deleted successfully!</center></p>";
            $stmt->close();
        }
        ?>

        <div class="package-list">
            <?php
           
            $result = $conn->query("SELECT * FROM package");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="package">';
                    echo '<h2>' . htmlspecialchars($row["name"]) . '</h2>';
                    echo '<p>Duration: ' . htmlspecialchars($row["duration"]) . '</p>';
                    echo '<p>Price: Rs ' . htmlspecialchars($row["price"]) . '</p>';
                    echo '<p>Type: ' . htmlspecialchars($row["type"]) . '</p>';
                    echo '<p>Hardness: ' . htmlspecialchars($row["hardness"]) . '</p>';
                    echo '<button onclick="editPackage(' . $row["id"] . ', \'' . $row["name"] . '\', \'' . $row["duration"] . '\', ' . $row["price"] . ', \'' . $row["type"] . '\', \'' . $row["hardness"] . '\')">Edit</button>';
                    echo '<a href="managepackage.php?delete=' . $row["id"] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No packages available.</p>";
            }
            ?>
        </div>

        <h2>Add / Edit Package</h2>
        <form id="package-form" method="POST" action="managepackage.php">
            <input type="hidden" name="id" id="package-id">
            <input type="text" name="name" id="package-name" placeholder="Package Name" required>
            <input type="text" name="duration" id="package-duration" placeholder="Duration (e.g., 1 Month)" required>
            <input type="number" name="price" id="package-price" placeholder="Price" required>
            <input type="text" name="type" id="package-type" placeholder="Type (e.g., Individual)" required>
            <input type="text" name="hardness" id="package-hardness" placeholder="Hardness (e.g., Beginner)" required>
            <input type="hidden" name="action" id="action" value="add">
            <button type="submit">Save Package</button>
        </form>
    </main>

    <script>
        function editPackage(id, name, duration, price, type, hardness) {
            document.getElementById('package-id').value = id;
            document.getElementById('package-name').value = name;
            document.getElementById('package-duration').value = duration;
            document.getElementById('package-price').value = price;
            document.getElementById('package-type').value = type;
            document.getElementById('package-hardness').value = hardness;
            document.getElementById('action').value = "edit";
        }
    </script>
</body>
</html>




