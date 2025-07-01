<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include("../../config/admin_config.php");

// Check if booking ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No booking ID specified.");
}

$bookingID = intval($_GET['id']);

// Fetch booking details with accommodation information
$sql_booking = "SELECT b.*, a.name AS accommodation_name 
                FROM accommodation_bookings b
                LEFT JOIN accommodations a ON b.accommodation_id = a.id 
                WHERE b.id = ?";

$stmt_booking = mysqli_prepare($conn, $sql_booking);
mysqli_stmt_bind_param($stmt_booking, "i", $bookingID);
mysqli_stmt_execute($stmt_booking);
$result_booking = mysqli_stmt_get_result($stmt_booking);
$booking = mysqli_fetch_assoc($result_booking);

// Fetch booking amenities
$sql_amenities = "SELECT ba.*, am.name AS amenity_name, am.price AS amenity_price
                FROM booking_amenities ba
                JOIN amenities am ON ba.amenity_id = am.id
                WHERE ba.booking_id = ?";
$stmt_amenities = mysqli_prepare($conn, $sql_amenities);
mysqli_stmt_bind_param($stmt_amenities, "i", $bookingID);
mysqli_stmt_execute($stmt_amenities);
$result_amenities = mysqli_stmt_get_result($stmt_amenities);
$amenities = mysqli_fetch_all($result_amenities, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Details</title>
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>  
    <section class="admin-dashboard">
        <div class="dashboard-container">
            <h2 class="form-title">BOOKING DETAILS</h2>
         
            <?php if ($booking): ?>
            <div class="booking-details">
                <table>
                    <tr>
                        <th>Booking ID</th>
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                    </tr>
                    <tr>
                        <th>Accommodation</th>
                        <td><?php echo htmlspecialchars($booking['accommodation_name'] ?: 'N/A'); ?></td>
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
                        <td><?php echo htmlspecialchars($booking['created_at']); ?></td>
                    </tr>
                    <tr>
                        <th>Check-in Date</th>
                        <td><?php echo htmlspecialchars($booking['check_in_date']); ?></td>
                    </tr>
                    <tr>
                        <th>Check-out Date</th>
                        <td><?php echo htmlspecialchars($booking['check_out_date']); ?></td>
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
                
                <h3>Booked Amenities</h3>
                <?php if (!empty($amenities)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Amenity</th>
                                <th>Quantity</th>
                                <th>Price per Unit</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($amenities as $amenity): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($amenity['amenity_name']); ?></td>
                                    <td><?php echo htmlspecialchars($amenity['quantity']); ?></td>
                                    <td>RM <?php echo number_format($amenity['price_at_booking'], 2); ?></td>
                                    <td>RM <?php echo number_format($amenity['total_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No additional amenities booked.</p>
                <?php endif; ?>
                
                <div class="actions">
                    <a href="bookingList.php" class="btn btn-secondary">Back to Booking List</a>
                </div>
            </div>
            <?php else: ?>
                <p>Booking not found.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>