<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback Form</title>
  <link href="feedbackpage.css" rel="stylesheet" type="text/css">
  <style type="text/css">
  body {
    background-image: url(../assets/membership.jpg);
}
  </style>
</head>
	
<body>
 
  <?php
  include 'database.php';  

  $username = $email = $message = "";
  $isUpdate = false;

  if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $isUpdate = true;

      $sql = "SELECT * FROM feedback WHERE id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $feedback = $result->fetch_assoc();

      $username = $feedback['username'];
      $email = $feedback['email'];
      $message = $feedback['message'];
      $stmt->close();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $message = $_POST['message'];

      if ($isUpdate && isset($_POST['id'])) {
        
          $id = $_POST['id'];
          $sql = "UPDATE feedback SET username=?, email=?, message=? WHERE id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sssi", $username, $email, $message, $id);
          $stmt->execute();
          $stmt->close();
          echo "<div class='feedback-message'>Feedback updated successfully!</div>";
      } else {
         
          $sql = "INSERT INTO feedback (username, email, message) VALUES (?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sss", $username, $email, $message);
          $stmt->execute();
          $stmt->close();
          echo "<div class='feedback-message'>Feedback submitted successfully!</div>";
      }
  }
  ?>

<div class="feedback-container">
    <h2><?php echo $isUpdate ? "Update Feedback" : "Submit Feedback"; ?></h2>
  <form id="feedbackForm" action="feedbackpage.php<?php echo $isUpdate ? "?id=$id" : ""; ?>" method="post">
      <input type="hidden" name="id" value="<?php echo $isUpdate ? $id : ''; ?>">
      
      <label for="username">Name:</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="4" required><?php echo htmlspecialchars($message); ?></textarea>

      <button type="submit" class="btn"><?php echo $isUpdate ? "Update" : "Send"; ?></button>
      <button type="reset" class="btn-clear">Clear</button>
  </form>
  </div>

</body>
</html>





