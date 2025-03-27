<?php
session_start();
include('database.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = trim($_POST['address']);
    $mobile = trim($_POST['mobile']);
    $role = 'customer';

    $errors = []; 

   
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($password)) $errors[] = "Password is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($dob)) $errors[] = "Date of Birth is required.";
    if (empty($address)) $errors[] = "Address is required.";
    if (empty($mobile)) $errors[] = "Mobile number is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (strlen($password) < 3) $errors[] = "Password must be at least 3 characters long.";

   
    $checkSQL = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkSQL);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "Username or Email already exists.";
    }
    $stmt->close();

    
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insertSQL = "INSERT INTO users (username, password, email, gender, dob, address, mobile, role)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);
        $stmt->bind_param("ssssssss", $username, $hashed_password, $email, $gender, $dob, $address, $mobile, $role);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Registration successful! Please log in.";
            header("Location: registerpage.php"); 
            exit();
        } else {
            $errors[] = "Error: Unable to complete registration. Please try again later.";
        }
        $stmt->close();
    }

    
    if (!empty($errors)) {
        $_SESSION['registration_errors'] = $errors;
        header("Location: registerpage.php");
        exit();
    }
}
$conn->close();
?>
