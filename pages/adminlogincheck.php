<?php
session_start();
include('database.php'); 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $selected_role = $_POST['role'];

    $error = "";

    $loginSQL = "SELECT id, password, role FROM users WHERE username = ? AND role = ?";
    $stmt = $conn->prepare($loginSQL);
    $stmt->bind_param("ss", $username, $selected_role);
    $stmt->execute();
    $stmt->store_result();

    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        
        if (password_verify($password, $hashed_password)) {
           
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            
            if ($role == 'admin') {
                header("Location: adminpage.php");
            } else {
                header("Location: staffpage.php");
            }
            exit();
        } else {
            
            $error = "Incorrect password.";
        }
    } else {
        
        $error = "Username not found.";
    }

    
    $stmt->close();

    
    $_SESSION['login_error'] = $error;
    header("Location: adminlogin.php");
    exit();
}


$conn->close();
?>
