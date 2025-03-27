<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Member - FitZone Fitness Center</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-container">
    <header>
        <h1>Edit Member</h1>
        <p>Modify the details of the gym member.</p>
    </header>

    <?php
   
    include('database.php');

    
    $username = $email = $gender = $dob = $address = $mobile = "";
    $errors = [];
    $member_id = null;

   
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $member_id = $_GET['id'];

        
        $sql = "SELECT * FROM users WHERE id = ? AND role = 'customer'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $member = $result->fetch_assoc();
            $username = $member['username'];
            $email = $member['email'];
            $gender = $member['gender'];
            $dob = $member['dob'];
            $address = $member['address'];
            $mobile = $member['mobile'];
        } else {
            echo "<p style='color:red;'>Member not found.</p>";
            exit;
        }
    } else {
        echo "<p style='color:red;'>Invalid member ID.</p>";
        exit;
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $address = trim($_POST['address']);
        $mobile = trim($_POST['mobile']);

        
        if (empty($username)) $errors[] = "Username is required.";
        if (empty($email)) $errors[] = "Email is required.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
        if (empty($dob)) $errors[] = "Date of Birth is required.";
        if (empty($address)) $errors[] = "Address is required.";
        if (empty($mobile)) $errors[] = "Mobile number is required.";

        
        if (empty($errors)) {
            $updateSQL = "UPDATE users SET username = ?, email = ?, gender = ?, dob = ?, address = ?, mobile = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSQL);
            $stmt->bind_param("ssssssi", $username, $email, $gender, $dob, $address, $mobile, $member_id);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Member updated successfully. <a href='managemembers.php'>Return to Manage Members</a></p>";
            } else {
                echo "<p style='color:red;'>Error updating member. Please try again.</p>";
            }

            $stmt->close();
        } else {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        }
    }

   
    $conn->close();
    ?>

    <div class="member-form">
        <form action="editmembers.php".php?id=<?php echo $member_id; ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="m" <?php if ($gender === 'm') echo 'selected'; ?>>Male</option>
                <option value="f" <?php if ($gender === 'f') echo 'selected'; ?>>Female</option>
            </select>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required>

            <button type="submit">Update Member</button>
        </form>
    </div>
</div>

</body>
</html>
