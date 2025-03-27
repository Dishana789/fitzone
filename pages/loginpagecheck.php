<?php
session_start();
include('database.php'); 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $error = "";

    $loginSQL = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($loginSQL);
    $stmt->bind_param("s", $username); 
    $stmt->execute();
    $stmt->store_result();

   
    if ($stmt->num_rows > 0) {
        
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            
            header("Location: home.php"); 
            exit();
        } else {
           
            $error = "Incorrect password.";
        }
    } else {
       
        $error = "Username not found.";
    }
  
    $stmt->close();
   
    $_SESSION['login_error'] = $error;
    header("Location: loginpage.php");
    exit();
}

$conn->close();
?>



