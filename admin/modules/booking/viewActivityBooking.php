<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include("../../config/admin_config.php");

// Check if booking ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No booking ID specified.");
}

$bookingID = intval($_GET['id']);

// Fetch booking details with activity information
$sql_booking = "SELECT ab.*, a.activityName AS activity_name 
                FROM activity_bookings ab
                LEFT JOIN activity a ON ab.activity_id = a.activityID 
                WHERE ab.id = ?";
$stmt_booking = mysqli_prepare($conn, $sql_booking);
mysqli_stmt_bind_param($stmt_booking, "i", $bookingID);
mysqli_stmt_execute($stmt_booking);
$result_booking = mysqli_stmt_get_result($stmt_booking);
$booking = mysqli_fetch_assoc($result_booking);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity Booking Details</title>
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>
    
    <section class="admin-dashboard">
        <div class="dashboard-container">
            <h2 class="form-title">ACTIVITY BOOKING DETAILS</h2>
            
            <?php if ($booking): ?>
            <div class="booking-details">
                <table>
                    <tr>
                        <th>Booking ID</th>
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                    </tr>
                    <tr>
                        <th>Activity</th>
                        <td><?php echo htmlspecialchars($booking['activity_name'] ?: 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Guest Name</th>
                        <td><?php echo htmlspecialchars($booking['guest_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Guest Email</th>
                        <td><?php echo htmlspecialchars($booking['guest_email']); ?></td>
                    </tr>
                    <tr>
                        <th>Guest Phone</th>
                        <td><?php echo htmlspecialchars($booking['guest_phone']); ?></td>
                    </tr>
                    <tr>
                        <th>Booking Date</th>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                    </tr>
                    <tr>
                        <th>Number of Guests</th>
                        <td><?php echo htmlspecialchars($booking['num_guests']); ?></td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>RM <?php echo number_format($booking['total_price'], 2); ?></td>
                    </tr>
                    <tr>
                        <th>Booking Status</th>
                        <td><?php echo htmlspecialchars($booking['booking_status']); ?></td>
                    </tr>
                </table>

                <div class="actions">
                    <a href="activityList.php" class="btn btn-secondary">Back to Booking List</a>
                </div>
            </div>
            <?php else: ?>
                <p>Booking not found.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
