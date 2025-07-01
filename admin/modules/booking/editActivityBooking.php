<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN EDIT ACTIVITY BOOKING</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// Check if ID is provided
if (isset($_GET['id'])) {
  $bookingID = intval($_GET['id']);

  // Retrieve the existing activity booking data using prepared statement
  $sql = "SELECT ab.*, a.activityName AS activity_name 
          FROM activity_bookings ab
          LEFT JOIN activity a ON ab.activity_id = a.activityID
          WHERE ab.id = ?";
          
  $stmt_select = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt_select, "i", $bookingID);
  mysqli_stmt_execute($stmt_select);
  $result = mysqli_stmt_get_result($stmt_select);

  if ($row = mysqli_fetch_assoc($result)) {
    $activityID = $row['activity_id'];
    $activityName = $row['activity_name'];
    $userID = $row['user_id'];
    $guestName = $row['guest_name'];
    $guestEmail = $row['guest_email'];
    $guestPhone = $row['guest_phone'];
    $bookingDate = $row['booking_date'];
    $numGuests = $row['num_guests'];
    $totalPrice = $row['total_price'];
    $bookingStatus = $row['booking_status'];
  } else {
    echo "Activity Booking not found.";
    exit;
  }
  mysqli_stmt_close($stmt_select);
} else {
  echo "Invalid Request.";
  exit;
}

// Handle activity booking update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $bookingID = intval($_POST['id']);
  $activityID = $_POST['activityID'];
  $userID = $_POST['userID'];
  $guestName = $_POST['guestName'];
  $guestEmail = $_POST['guestEmail'];
  $guestPhone = $_POST['guestPhone'];
  $bookingDate = $_POST['bookingDate'];
  $numGuests = $_POST['numGuests'];
  $totalPrice = $_POST['totalPrice'];
  $bookingStatus = $_POST['bookingStatus'];

  // Update activity booking
  $sql_update = "UPDATE activity_bookings 
               SET activity_id = ?, user_id = ?, guest_name = ?, guest_email = ?, 
                   guest_phone = ?, booking_date = ?, num_guests = ?, 
                   total_price = ?, booking_status = ?, updated_at = NOW()
               WHERE id = ?";
  $stmt_update = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt_update, "iissssissi", $activityID, $userID, $guestName, 
                        $guestEmail, $guestPhone, $bookingDate, $numGuests, 
                        $totalPrice, $bookingStatus, $bookingID);
  
  // Execute query
  if (mysqli_stmt_execute($stmt_update)) {
    echo "
      <div id='userSuccessMessage'>
        <p>Activity Booking ($bookingID) was edited successfully!</p>
        <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>Back to Admin Dashboard</a>
        <br>
        <a id='viewBookingList' href='eventBookingList.php'>View Activity Booking List</a>
        <br>
      </div>
    ";
    exit;
  } else {
    $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
    header("Location: activityBookingEdit.php?id=" . $bookingID);
    exit;
  }

  mysqli_stmt_close($stmt_update);
  mysqli_close($conn);
  exit;
}
?>

<body>
  <?php include("../../includes/admin_SideNav.php"); ?>

  <section class="admin-dashboard">
    <div class="dashboard-container">
      <h2 id="form-title">EDIT ACTIVITY BOOKING</h2>

      <div class="admin-form">
        <form action="" method="POST">
          <input type="hidden" name="id" value="<?= htmlspecialchars($bookingID) ?>">

          <label for="activityID">Activity:</label>
          <select id="activityID" name="activityID" style="border: 1px solid;" required>
            <option value="<?= htmlspecialchars($activityID) ?>"><?= htmlspecialchars($activityName) ?></option>
            <?php
            $sql_activities = "SELECT activityID, activityName FROM activity";
            $result_activities = mysqli_query($conn, $sql_activities);

            while ($row_activity = mysqli_fetch_assoc($result_activities)) {
              if ($row_activity['activityID'] != $activityID) {
                echo "<option value='" . $row_activity['activityID'] . "'>" . htmlspecialchars($row_activity['activityName']) . "</option>";
              }
            }
            ?>
          </select><br><br>

          <label for="userID">User ID:</label>
          <input type="number" id="userID" name="userID" value="<?= htmlspecialchars($userID) ?>" style="border: 1px solid;" required><br><br>

          <label for="guestName">Guest Name:</label>
          <input type="text" id="guestName" name="guestName" value="<?= htmlspecialchars($guestName) ?>" style="border: 1px solid;" required><br><br>

          <label for="guestEmail">Guest Email:</label>
          <input type="email" id="guestEmail" name="guestEmail" value="<?= htmlspecialchars($guestEmail) ?>" style="border: 1px solid;" required><br><br>
          
          <label for="guestPhone">Guest Phone:</label>
          <input type="text" id="guestPhone" name="guestPhone" value="<?= htmlspecialchars($guestPhone) ?>" style="border: 1px solid;" required><br><br>
      
          <label for="bookingDate">Booking Date:</label>
          <input type="datetime-local" id="bookingDate" name="bookingDate" 
                 value="<?= date('Y-m-d\TH:i', strtotime($bookingDate)) ?>" 
                 style="border: 1px solid;" required><br><br>

          <label for="numGuests">Number of Guests:</label>
          <input type="number" id="numGuests" name="numGuests" value="<?= htmlspecialchars($numGuests) ?>" style="border: 1px solid;" required><br><br>

          <label for="totalPrice">Total Price (RM):</label>
          <input type="number" id="totalPrice" name="totalPrice" value="<?= htmlspecialchars($totalPrice) ?>" min="0.01" step="0.01" style="border: 1px solid;" required><br><br>

          <label for="bookingStatus">Booking Status:</label>
          <select id="bookingStatus" name="bookingStatus" style="border: 1px solid;" required>
            <option value="confirmed" <?= $bookingStatus == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="pending" <?= $bookingStatus == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="cancelled" <?= $bookingStatus == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
          </select><br>

          <button type="submit" style="background-color: black;">Update</button>
          <br><br><br>
        </form>
      </div>
    </div>
  </section>
  <script src="../../js/admin_Script.js"></script>
</body>
</html>