<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

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
    <title>Activity Bookings Management</title>
    <style>
        th:last-child, td:last-child {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>
    <div class="userList-container">
        <div class="userList-form">
            <h1 style="text-align: center;">Activity Bookings</h1>
            <div class="rowform">
                <?php
                $sql_bookings = "SELECT ab.*, a.activityName as activity_name, u.userName as username 
                                FROM activity_bookings ab
                                LEFT JOIN activity a ON ab.activity_id = a.activityID
                                LEFT JOIN user u ON ab.user_id = u.userID
                                ORDER BY ab.created_at DESC";
                
                $result = mysqli_query($conn, $sql_bookings);
                $rowcount = mysqli_num_rows($result);
              
                if ($rowcount > 0) {
                    echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                    echo "<tr>";               
                    echo "<th>ID</th>";
                    echo "<th>User</th>";
                    echo "<th>Activity</th>";
                    echo "<th>Booking Date</th>";
                    echo "<th>Guest Details</th>";
                    echo "<th>Guests</th>";
                    echo "<th>Total Price</th>";
                    echo "<th>Status</th>";
                    echo "<th>Actions</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                        
                        echo "<tr>";                    
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["activity_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($booking_date) . "</td>";
                        echo "<td>Name: " . htmlspecialchars($row["guest_name"]) . 
                             "<br>Email: " . htmlspecialchars($row["guest_email"]) . 
                             "<br>Phone: " . htmlspecialchars($row["guest_phone"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["num_guests"]) . "</td>";
                        echo "<td>RM " . number_format($row["total_price"], 2) . "</td>";
                        
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
                            echo "<a href='editActivityBooking.php?id=" . urlencode($row["id"]) . "'>Edit</a> | ";
                        }
                        echo "<a href='viewActivityBooking.php?id=" . urlencode($row["id"]) . "'>View</a>";
                        if ($row["booking_status"] != 'cancelled') {
                            echo " | <a href='deleteActivityBooking.php?id=" . urlencode($row["id"]) . "' 
                                  onclick='return confirm(\"Are you sure you want to cancel this activity booking?\");'>Cancel</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<p>Total Activity Bookings: $rowcount</p>";
                } else {
                    echo "<p>No activity bookings found.</p>";
                }

                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div> 
    <script src="../../js/admin_Script.js"></script>
</body>
</html>
