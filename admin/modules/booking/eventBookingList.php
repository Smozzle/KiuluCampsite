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
    <style>
        .activity-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .activity-table th {
            background-color: #8BC34A;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        .activity-table tr:nth-child(even) {
            background-color: #f5f9f5;
        }

        .activity-table tr:nth-child(odd) {
            background-color: white;
        }

        .activity-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .status-confirmed {
            color: #4CAF50;
            font-weight: 500;
        }

        .action-link {
            color: #4CAF50;
            text-decoration: none;
            margin: 0 5px;
        }

        .cancel-btn {
            background-color: #ff4444;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .total-bookings {
            margin-top: 20px;
            color: #666;
        }
    </style>
    <title>Activity Booking Management</title>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>
    <div class="userList-container">
        <div class="userList-form">
            <h1 style="text-align: center;">Manage Activity Bookings</h1>
            <div class="rowform">
                <?php
                // SQL query for activity bookings - note the plural table name
                $sql_bookings = "SELECT ab.*, a.activityName as activity_name 
                                FROM activity_bookings ab
                                JOIN activity a ON ab.activity_id = a.activityID
                                ORDER BY ab.id ASC";
                
                $result = mysqli_query($conn, $sql_bookings);
                $rowcount = mysqli_num_rows($result);
              
                if ($rowcount > 0) {
                    echo "<table class='activity-table'>";
                    echo "<thead>";
                    echo "<tr>";               
                    echo "<th>BOOKING ID</th>";
                    echo "<th>ACTIVITY</th>";
                    echo "<th>BOOKING DATE</th>";
                    echo "<th>GUEST DETAILS</th>";
                    echo "<th>NUMBER OF GUESTS</th>";
                    echo "<th>TOTAL PRICE</th>";
                    echo "<th>STATUS</th>";
                    echo "<th>ACTIONS</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        // Format date for display
                        $booking_date = date('d-m-Y', strtotime($row['booking_date']));
                        
                        echo "<tr>";                    
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["activity_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($booking_date) . "</td>";
                        echo "<td>Name: " . htmlspecialchars($row["guest_name"]) . 
                             "<br>Email: " . htmlspecialchars($row["guest_email"]) . 
                             "<br>Phone: " . htmlspecialchars($row["guest_phone"]) . "</td>";
                        echo "<td style='text-align: center;'>" . htmlspecialchars($row["num_guests"]) . "</td>";
                        echo "<td>$" . number_format($row["total_price"], 2) . "</td>";
                        echo "<td class='status-confirmed'>" . ucfirst(htmlspecialchars($row["booking_status"])) . "</td>";
                        
                        echo "<td>";
                        echo "<a href='editActivityBooking.php?id=" . urlencode($row["id"]) . "' class='action-link'>Edit</a> | ";
                        echo "<a href='viewActivityBooking.php?id=" . urlencode($row["id"]) . "' class='action-link'>View</a> | ";
                        echo "<a href='deleteActivityBooking.php?id=" . urlencode($row["id"]) . "' 
                              onclick='return confirm(\"Are you sure you want to cancel this activity booking?\");'
                              class='cancel-btn'>Cancel</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "<p class='total-bookings'>Total Activity Bookings: $rowcount</p>";
                } else {
                    echo "<p>No activity bookings found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php
        mysqli_free_result($result);
        mysqli_close($conn);
    ?>
    <script src="../../js/admin_Script.js"></script>
</body>
</html>