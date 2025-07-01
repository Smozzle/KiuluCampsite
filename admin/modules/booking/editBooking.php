<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN EDIT BOOKING</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// Check if ID is provided
if (isset($_GET['id'])) {
  $bookingID = intval($_GET['id']);

  // Retrieve the existing booking data using prepared statement
  $sql = "SELECT b.*, a.name AS accommodation_name 
          FROM accommodation_bookings b
          LEFT JOIN accommodations a ON b.accommodation_id = a.id
          WHERE b.id = ?";
          
        $stmt_select = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt_select, "i", $bookingID);
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);

  if ($row = mysqli_fetch_assoc($result)) {
    $accommodationID = $row['accommodation_id'];
    $accommodationName = $row['accommodation_name'];
    $guestName = $row['guest_name'];
    $guestEmail = $row['guest_email'];
    $guestPhone = $row['guest_phone'];
    $checkInDate = $row['check_in_date'];
    $checkOutDate = $row['check_out_date'];
    $numGuests = $row['num_guests'];
    $totalPrice = $row['total_price'];
    $bookingStatus = $row['booking_status'];
  } else {
    echo "Booking not found.";
    exit;
  }
  mysqli_stmt_close($stmt_select);
} else {
  echo "Invalid Request.";
  exit;
}

// Handle booking update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $bookingID = intval($_POST['id']);
  $accommodationID = $_POST['accommodationID'];
  $guestName = $_POST['guestName'];
  $guestEmail = $_POST['guestEmail'];
  $guestPhone = $_POST['guestPhone'];
  $checkInDate = $_POST['checkInDate'];
  $checkOutDate = $_POST['checkOutDate'];
  $numGuests = $_POST['numGuests'];
  $totalPrice = $_POST['totalPrice'];
  $bookingStatus = $_POST['bookingStatus'];

  // Update booking
  $sql_update = "UPDATE accommodation_bookings 
               SET accommodation_id = ?, guest_name = ?, guest_email = ?, guest_phone = ?, 
                   check_in_date = ?, check_out_date = ?, num_guests = ?, 
                   total_price = ?, booking_status = ?, updated_at = NOW()
               WHERE id = ?";
  $stmt_update = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt_update, "issssssdsi", $accommodationID, $guestName, $guestEmail, $guestPhone, 
                        $checkInDate, $checkOutDate, $numGuests, $totalPrice, $bookingStatus, $bookingID);
  // Execute query
  if (mysqli_stmt_execute($stmt_update)) {
    echo "
      <div id='userSuccessMessage'>
        <p>Booking ($bookingID) was edited successfully!</p>
        <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>Back to Admin Dashboard</a>
        <br>
        <a id='viewBookingList' href='bookingList.php'>View Booking List</a>
        <br>
      </div>
    ";
    exit;
  } else {
      $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
      header("Location: editBooking.php?id=" . $bookingID);
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
      <h2 id="form-title">EDIT BOOKING</h2>

      <div class="admin-form">
        <form action="" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($bookingID) ?>">

          <label for="accommodationID">Accommodation:</label>
          <select id="accommodationID" name="accommodationID" style="border: 1px solid;" required>
            <option value="<?= htmlspecialchars($accommodationID) ?>"><?= htmlspecialchars($accommodationName) ?></option>
            <?php
            $sql_accommodations = "SELECT id, name FROM accommodations";
            $result_accommodations = mysqli_query($conn, $sql_accommodations);

            while ($row_accommodation = mysqli_fetch_assoc($result_accommodations)) {
              echo "<option value='" . $row_accommodation['id'] . "'>" . htmlspecialchars($row_accommodation['name']) . "</option>";
            }
            ?>
          </select><br><br>

          <label for="guestName">Guest Name:</label>
          <input type="text" id="guestName" name="guestName" value="<?= htmlspecialchars($guestName) ?>" style="border: 1px solid;" required><br><br>

          <label for="guestEmail">Guest Email:</label>
          <input type="text" id="guestEmail" name="guestEmail" value="<?= htmlspecialchars($guestEmail) ?>" style="border: 1px solid;" required><br><br>
          
          <label for="guestPhone">Guest Phone:</label>
          <input type="text" id="guestPhone" name="guestPhone" value="<?= htmlspecialchars($guestPhone) ?>" style="border: 1px solid;" required><br><br>
      
          <label for="checkInDate">Check-in Date:</label>
          <input type="date" id="checkInDate" name="checkInDate" value="<?= htmlspecialchars($checkInDate) ?>" style="border: 1px solid;" required><br><br>

          <label for="checkOutDate">Check-out Date:</label>
          <input type="date" id="checkOutDate" name="checkOutDate" value="<?= htmlspecialchars($checkOutDate) ?>" style="border: 1px solid;" required><br><br>

          <label for="numGuests">Total Guests:</label>
          <input type="text" id="numGuests" name="numGuests" value="<?= htmlspecialchars($numGuests) ?>" style="border: 1px solid;" required><br><br>

          <label for="totalPrice">Total Price (RM):</label>
          <input type="text" id="totalPrice" name="totalPrice" value="<?= htmlspecialchars($totalPrice) ?>" min="0.01" step="0.01" style="border: 1px solid;" required><br><br>

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