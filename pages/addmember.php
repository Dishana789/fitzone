<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Member - FitZone Fitness Center</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-container">
    <header>
        <h1>Add New Member</h1>
        <p>Fill out the form below to add a new member to the FitZone Fitness Center.</p>
    </header>

    <?php
    include('database.php');

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $email = trim($_POST['email']);
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $address = trim($_POST['address']);
        $mobile = trim($_POST['mobile']);
        $role = $_POST['role'];  

       
        if (empty($username)) $errors[] = "Username is required.";
        if (empty($password)) $errors[] = "Password is required.";
        if (empty($email)) $errors[] = "Email is required.";
        if (empty($dob)) $errors[] = "Date of Birth is required.";
        if (empty($address)) $errors[] = "Address is required.";
        if (empty($mobile)) $errors[] = "Mobile number is required.";

       
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        
        if (strlen($password) < 3) {
            $errors[] = "Password must be at least 3 characters long.";
        }

       
        $userCheckSQL = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($userCheckSQL);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Username already exists. Please choose a different one.";
        }
        $stmt->close();

       
        if (empty($errors)) {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $addMemberSQL = "INSERT INTO users (username, password, email, gender, dob, address, mobile, role)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($addMemberSQL);
            $stmt->bind_param("ssssssss", $username, $hashed_password, $email, $gender, $dob, $address, $mobile, $role);

        
            if ($stmt->execute()) {
               
                header('Location: managemembers.php');
                exit(); 
            } else {
                echo "<p style='color:red;'>Error: Could not add new member. Please try again later.</p>";
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
        <form action="addmember.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" required>

            <label for="role">Register as:</label>
            <select id="role" name="role" required>
                <option value="customer">Customer</option>
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Add Member</button>
        </form>
    </div>
</div>

</body>
</html>


