<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="appointments.css">
    <style type="text/css">
    body {
    background-image: url(../images/loginimg.jpg);
}
    </style>
</head>
	 <?php include('customer_nav.php'); ?>
<body>
    <div class="container">
        <h1>Book Your Appointment</h1>
        <form action="appointments.php" method="POST">
            <label for="customer_name">Your Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="service">Choose Service:</label>
            <select id="service" name="service" required>
                <option value="Cardio">Cardio</option>
                <option value="Strength Training">Strength Training</option>
                <option value="Yoga">Yoga</option>
                <option value="Personal Training">Personal Training</option>
            </select>

            <label for="appointment_time">Choose Appointment Time:</label>
            <input type="datetime-local" id="appointment_time" name="appointment_time" required>

            <button type="submit">Book Appointment</button>
        </form>
    </div>

    <?php
    include('database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customer_name = $_POST['customer_name'];
        $service = $_POST['service'];
        $appointment_time = $_POST['appointment_time'];
        
        $sql = "INSERT INTO appointments (customer_name, service, appointment_time) 
                VALUES ('$customer_name', '$service', '$appointment_time')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Appointment booked successfully!');</script>";
        } else {
            echo "<script>alert('Error booking appointment: " . mysqli_error($conn) . "');</script>";
        }
    }
    ?>
</body>
</html>
 <?php
    include('customer_footer.php');
    ?>


