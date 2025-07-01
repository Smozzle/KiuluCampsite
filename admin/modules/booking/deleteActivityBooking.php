<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

// Include database configuration
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN CANCEL BOOKING</title>
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<body>
  <?php
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
      $bookingID = intval($_GET['id']);
      // Update booking status to 'cancelled'
      $sql = "UPDATE activity_bookings SET booking_status = 'cancelled' WHERE id = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $bookingID);

      if (mysqli_stmt_execute($stmt)) {
        echo "
              <div id='userSuccessMessage'>
                <p>BOOKING WITH ID ($bookingID) CANCELLED SUCCESSFULLY!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                  Back to Admin Dashboard
                </a>
                <br>
                <a id='viewBookingList' href='activityList.php'>
                  View Booking List
                </a>
                <br>
              </div>
              ";
      }
      else {
        echo "Error updating record: " . mysqli_error($conn);
      }
      mysqli_stmt_close($stmt);
    }
    else {
      echo "Invalid request.";
    }
    mysqli_close($conn);
  ?>
</body>
</html>
