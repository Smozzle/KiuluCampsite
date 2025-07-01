<?php
//Suziliana Mosingkil (BI22110296)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN EDIT ACCOMMODATION</title>

  <!-- cdn icon link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// Check if ID is provided
if (isset($_GET['id'])) {
  $accommodationID = intval($_GET['id']);

  // Retrieve the existing accommodation data using prepared statement
  $sql = "SELECT * FROM accommodations WHERE id = ?";
  $stmt_select = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt_select, "i", $accommodationID);
  mysqli_stmt_execute($stmt_select);
  $result = mysqli_stmt_get_result($stmt_select);

  if ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $description = $row['description'];
    $location = $row['location'];
    $price = $row['price'];
    $max_capacity = $row['max_capacity'];
    $mainImage = $row['mainImage'];
    $secImage = $row['secImage'];
    $thirdImage = $row['thirdImage'];
    $keyFeatures = $row['keyFeatures'];
  } else {
    echo "Accommodation not found.";
    exit;
  }
  mysqli_stmt_close($stmt_select);
} else {
  echo "Invalid Request.";
  exit;
}

// Handle accommodation update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $location = $_POST['location'];
  $price = $_POST['price'];
  $max_capacity = $_POST['max_capacity'];
  $mainImage = $_POST['mainImage'];
  $secImage = $_POST['secImage'];
  $thirdImage = $_POST['thirdImage'];
  $keyFeatures = $_POST['keyFeatures'];

  // Update accommodation
  $sql_update = "UPDATE accommodations SET name = ?, description = ?, location = ?, price = ?, max_capacity = ?, mainImage = ?, secImage = ?, thirdImage = ?, keyFeatures = ? WHERE id = ?";
  $stmt_update = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt_update, "sssdissssi", $name, $description, $location, $price, $max_capacity, $mainImage, $secImage, $thirdImage, $keyFeatures, $accommodationID);

  // Execute query
  if (mysqli_stmt_execute($stmt_update)) {
    echo "
      <div id='userSuccessMessage'>
        <p> Accommodation ($name) with Accommodation ID ($accommodationID) was edited successfully!</p>
        <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
          Back to Admin Dashboard
        </a>
        <br>
        <a id='viewAccommodationList' href='accommodationListing.php'>
          View Accommodation List
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

      <!-- ACCOMMODATION EDIT SECTION STARTS HERE -->
      <h2 id="form-title">EDIT ACCOMMODATION</h2>

      <div class="admin-form">
        <form action="" method="POST">

          <input type="hidden" name="id"
            value="<?= isset($accommodationID) ? htmlspecialchars($accommodationID) : 'NONE'; ?>">

          <label for="name">Accommodation Name:</label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" style="border: 1px solid;"
            required><br><br>

          <label for="description">Description:</label>
          <textarea id="description" name="description" rows="6" style="border: 1px solid;"
            required><?= htmlspecialchars($description) ?></textarea><br><br>

          <label for="location">Location:</label>
          <input type="text" id="location" name="location" value="<?= htmlspecialchars($location) ?>"
            style="border: 1px solid;" required><br><br>

          <label for="price">Price Per Night:</label>
          <input type="number" id="price" name="price" value="<?= htmlspecialchars($price) ?>" min="0.01" step="0.01"
            style="border: 1px solid;" required><br><br>

          <label for="max_capacity">Max Guests:</label>
          <input type="number" id="max_capacity" name="max_capacity" value="<?= htmlspecialchars($max_capacity) ?>"
            style="border: 1px solid;" required><br><br>

          <label for="mainImage">Main Image URL:</label>
          <input type="text" id="mainImage" name="mainImage" value="<?= htmlspecialchars($mainImage) ?>"
            style="border: 1px solid;"><br><br>

          <label for="secImage">Second Image URL:</label>
          <input type="text" id="secImage" name="secImage" value="<?= htmlspecialchars($secImage) ?>"
            style="border: 1px solid;"><br><br>

          <label for="thirdImage">Third Image URL:</label>
          <input type="text" id="thirdImage" name="thirdImage" value="<?= htmlspecialchars($thirdImage) ?>"
            style="border: 1px solid;"><br><br>

          <label for="keyFeatures">Key Features:</label>
          <textarea id="keyFeatures" name="keyFeatures" rows="4"
            style="border: 1px solid;"><?= htmlspecialchars($keyFeatures) ?></textarea><br><br>

          <button type="submit" style="background-color: black;">Update</button>
          <br><br><br>
        </form>
      </div>
      <!-- ACCOMMODATION EDIT SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>

</html>
