<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Manage Members - FitZone Fitness Center</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-container">
    <header>
        <h1>Manage Members</h1>
        <p>Here you can view, add, edit, or delete gym members.</p>
    </header>

    <div class="member-actions">
        <a href="addmember.php"><center><button type="submit">Add Member</button></center></a>
    </div>

    <div class="members-list">
        <h2>Existing Members</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                include('database.php');

                
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . ($row['gender'] == 'm' ? 'Male' : 'Female') . "</td>";
                    echo "<td>" . $row['dob'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['mobile'] . "</td>";
                    echo "<td>" . ucfirst($row['role']) . "</td>"; 
                    echo "<td>
                            <a href='editmembers.php?id=" . $row['id'] . "'>Edit</a> |
                            <a href='deletemember.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this member?');\">Delete</a>
                          </td>";
                    echo "</tr>";
                }

               
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
