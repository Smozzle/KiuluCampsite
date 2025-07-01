<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

//include db config
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>Booking Management</title>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>
    <div class="userList-container">
    <div class="userList-form">
    <h1 style="text-align: center;">Accommodation Bookings</h1>
        <div class="rowform">
            <?php
            $sql_accommodation_bookings = "SELECT b.id, b.accommodation_id, a.name as accommodation_name, 
                                b.created_at as booking_date, b.check_in_date, b.check_out_date, 
                                b.guest_name, b.guest_email, b.guest_phone, 
                                b.num_guests, b.booking_status, b.created_at
                            FROM accommodation_bookings b
                            JOIN accommodations a ON b.accommodation_id = a.id
                            ORDER BY b.created_at DESC";
            
            $result = mysqli_query($conn, $sql_accommodation_bookings);
            $rowcount = mysqli_num_rows($result);
          
            if ($rowcount > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";               
                echo "<th>Booking ID</th>";
                echo "<th>Accommodation</th>";
                echo "<th>Booking Date</th>";
                echo "<th>Check-in</th>";
                echo "<th>Check-out</th>";
                echo "<th>Guest Details</th>";
                echo "<th>Number of Guests</th>";
                echo "<th>Status</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    // Format dates for display
                    $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                    $check_in = date('d-m-Y', strtotime($row['check_in_date']));
                    $check_out = date('d-m-Y', strtotime($row['check_out_date']));
                    
                    echo "<tr>";                    
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["accommodation_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($booking_date) . "</td>";
                    echo "<td>" . htmlspecialchars($check_in) . "</td>";
                    echo "<td>" . htmlspecialchars($check_out) . "</td>";
                    echo "<td>Name: " . htmlspecialchars($row["guest_name"]) . 
                         "<br>Email: " . htmlspecialchars($row["guest_email"]) . 
                         "<br>Phone: " . htmlspecialchars($row["guest_phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["num_guests"]) . "</td>";
                    // Add status with color coding
                    $status_color = '';
                    switch($row["booking_status"]) {
                        case 'confirmed':
                            $status_color = 'green';
                            break;
                        case 'pending':
                            $status_color = 'orange';
                            break;
                        case 'cancelled':
                            $status_color = 'red';
                            break;
                    }
                    echo "<td style='color: $status_color;'>" . 
                         ucfirst(htmlspecialchars($row["booking_status"])) . "</td>";
                    
                    echo "<td>";
                    if ($row["booking_status"] != 'cancelled') {
                        echo "<a href='editBooking.php?id=" . urlencode($row["id"]) . "'>Edit</a> | ";
                    }
                    echo "<a href='viewBooking.php?id=" . urlencode($row["id"]) . "'>View</a>";
                    if ($row["booking_status"] != 'cancelled') {
                        echo " | <a href='deleteBooking.php?id=" . urlencode($row["id"]) . "' 
                              onclick='return confirm(\"Are you sure you want to cancel this booking?\");'>Cancel</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<p>Total Bookings: $rowcount</p>";
            } else {
                echo "<p>No bookings found.</p>";
            }
            ?>
    </div>
</div>
    <?php
        mysqli_free_result($result);
        mysqli_close($conn);
    ?>
    <script src="../../js/admin_Script.js"></script>
</body>
</html>