<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
// include db config (admin_config.php)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN EDIT SAFETY RECORD</title>

  <!-- cdn icon link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// check if ID is provided
if (isset($_GET['id'])) {
  $safetyID = intval($_GET['id']);

  // fetch existing safety data using prepared statement
  $sql = "SELECT * FROM safetyinfo WHERE id = ?";
  $stmt_select = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt_select, "i", $safetyID);
  mysqli_stmt_execute($stmt_select);
  $result = mysqli_stmt_get_result($stmt_select);

  if ($row = mysqli_fetch_assoc($result)) {
    $safetyTitle = $row['title'];
    $safetyDescription = $row['description'];
    $safetyType = $row['type'];
    $lastUpdated = $row['last_updated'];
  } else {
    echo "Safety record not found.";
    exit;
  }
  mysqli_stmt_close($stmt_select);
} else {
  echo "Invalid Request.";
  exit;
}

// handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $safetyTitle = $_POST['safetyTitle'];
  $safetyDescription = $_POST['safetyDescription'];
  $safetyType = $_POST['safetyType'];
  $lastUpdated = date('Y-m-d H:i:s'); // update the timestamp

  // update safety record
  $sql_update = "UPDATE safetyinfo SET title = ?, description = ?, type = ?, last_updated = ? WHERE id = ?";
  $stmt_update = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt_update, "ssssi", $safetyTitle, $safetyDescription, $safetyType, $lastUpdated, $safetyID);

  if (mysqli_stmt_execute($stmt_update)) {
    echo "
      <div id='userSuccessMessage'>
        <p>Safety record with ID ($safetyID) was successfully updated!</p>
        <a id='dashboardLink' href='" . ADMIN_BASE_URL . "'>Back to Admin Dashboard</a><br>
        <a id='viewSafetyList' href='safety_list.php'>View Safety List</a><br>
      </div>
    ";
  } else {
    echo "Error updating record: " . mysqli_error($conn);
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
      <!-- EDIT SAFETY RECORD SECTION STARTS HERE -->
      <h2 id="form-title">EDIT SAFETY RECORD</h2>
      <div class="admin-form">
        <form action="" method="POST">
          <input type="hidden" name="safetyID" value="<?= isset($safetyID) ? htmlspecialchars($safetyID) : 'NONE'; ?>">

          <label for="safetyTitle">Safety Title:</label>
          <input type="text" id="safetyTitle" name="safetyTitle" value="<?= htmlspecialchars($safetyTitle) ?>" required><br><br>

          <label for="safetyDescription">Safety Description:</label>
          <textarea id="safetyDescription" name="safetyDescription" rows="5" required><?= htmlspecialchars($safetyDescription) ?></textarea><br><br>

          <label for="safetyType">Safety Type:</label>
          <input type="text" id="safetyType" name="safetyType" value="<?= htmlspecialchars($safetyType) ?>" required><br><br>

          <label for="lastUpdated">Last Updated:</label>
          <input type="text" id="lastUpdated" name="lastUpdated" value="<?= htmlspecialchars($lastUpdated) ?>" readonly><br><br>

          <button type="submit" style="background-color: black;">Update</button><br><br>
        </form>
      </div>
      <!-- EDIT SAFETY RECORD SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>
</html>
