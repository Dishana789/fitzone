<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments Dashboard</title>
    <link rel="stylesheet" href="staff.css">
</head>
<body>
    <div class="container">
        <h1>Appointments</h1>
        
        <h2>Upcoming Appointments</h2>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Service</th>
                <th>Appointment Time</th>
            </tr>
            <?php 
            // Include database connection
            include('database.php');

            // Fetch appointments from the database
            $sql = "SELECT * FROM appointments";
            $result = mysqli_query($conn, $sql);

            // Display appointments
            while($appointment = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?php echo $appointment['customer_name']; ?></td>
                <td><?php echo $appointment['service']; ?></td>
                <td>
                    <?php 
                    // Format the appointment time to include AM/PM
                    echo date("Y-m-d h:i A", strtotime($appointment['appointment_time'])); 
                    ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
		 <h1>Manage feedbacks</h1>
		<a href="managefeedback.php">
                    <span>Manage feedbacks</span>
        </a>
    </div>
</body>
</html>




