<?php
//ALVINA ALPHONSUS BI22110003
// include db config (admin_config.php)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN EDIT AMENITY</title>

  <!-- cdn icon link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// Check if ID is provided
if (isset($_GET['id'])) {
  $amenityID = intval($_GET['id']);

  // Retrieve the existing amenity data using prepared statement
  $sql = "SELECT * FROM amenities WHERE id = ?";
  $stmt_select = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt_select, "i", $amenityID);
  mysqli_stmt_execute($stmt_select);
  $result = mysqli_stmt_get_result($stmt_select);

  if ($row = mysqli_fetch_assoc($result)) {
    $amenityName = $row['name'];
    $amenityDescription = $row['description'];
    $amenityPrice = $row['price'];
    $amenityUnit = $row['unit'];
  } else {
    echo "Amenity not found.";
    exit;
  }
  mysqli_stmt_close($stmt_select);
} else {
  echo "Invalid Request.";
  exit;
}

// Handle amenity update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $amenityName = $_POST['amenityName'];
  $amenityDescription = $_POST['amenityDescription'];
  $amenityPrice = $_POST['price'];
  $amenityUnit = $_POST['unit'];

  // Update amenity
  $sql_update = "UPDATE amenities SET name = ?, description = ?, price = ?, unit = ? WHERE id = ?";
  $stmt_update = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt_update, "ssdsi", $amenityName, $amenityDescription, $amenityPrice, $amenityUnit, $amenityID);

  // Execute query
  if (mysqli_stmt_execute($stmt_update)) {
    echo "
      <div id='userSuccessMessage'>
        <p>Amenity ($amenityName) with Amenity ID of ($amenityID) was edited successfully!</p>
        <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
          Back to Admin Dashboard
        </a>
        <br>
        <a id='viewAmenityList' href='amenitiesListing.php'>
          View Amenity List
        </a>
        <br>
      </div>
    ";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  mysqli_stmt_close($stmt_update);
  mysqli_close($conn);
  exit;
}
?>

<body>
  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("../../includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container">

      <!-- AMENITY EDIT SECTION STARTS HERE -->
      <h2 id="form-title">EDIT AMENITY</h2>

      <div class="admin-form">
        <form action="" method="POST">

          <input type="hidden" name="amenityID" value="<?= isset($amenityID) ? htmlspecialchars($amenityID) : 'NONE'; ?>">

          <label for="amenityName">Amenity Name:</label>
          <input type="text" id="amenityName" name="amenityName" value="<?= htmlspecialchars($amenityName) ?>" style="border: 1px solid;" required><br><br>

          <label for="amenityDescription">Amenity Description:</label>
          <textarea id="amenityDescription" name="amenityDescription" rows="6" style="border: 1px solid;" required><?= htmlspecialchars($amenityDescription) ?></textarea><br><br>

          <label for="price">Price:</label>
          <input type="number" id="price" name="price" value="<?= htmlspecialchars($amenityPrice) ?>" min="0.01" step="0.01" style="border: 1px solid;" required placeholder="Enter Amenity Price"><br><br>

          <label for="unit">Unit:</label>
          <input type="text" id="unit" name="unit" value="<?= htmlspecialchars($amenityUnit) ?>" style="border: 1px solid;" required><br><br>

          <button type="submit" style="background-color: black;">Update</button>
          <br><br><br>
        </form>
      </div>
      <!-- AMENITY EDIT SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>

</html>
