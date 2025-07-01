<?php
//ALVINA ALPHONSUS BI22110003
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN EDIT PRIZE</title>

  <!-- cdn icon link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// Check if ID is provided
if (isset($_GET['id'])) {
  $prizeID = intval($_GET['id']);

  // Retrieve the existing prize data using prepared statement
  $sql = "SELECT * FROM prizes WHERE luckyDrawID = ?";
  $stmt_select = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt_select, "i", $prizeID);
  mysqli_stmt_execute($stmt_select);
  $result = mysqli_stmt_get_result($stmt_select);

  if ($row = mysqli_fetch_assoc($result)) {
    $prizeName = $row['prize_name'];
    $prizeDescription = $row['prize_description'];
    $quantity = $row['quantity'];
  } else {
    echo "Prize not found.";
    exit;
  }
  mysqli_stmt_close($stmt_select);
} else {
  echo "Invalid Request.";
  exit;
}

// Handle prize update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $prizeName = $_POST['prizeName'];
  $prizeDescription = $_POST['prizeDescription'];
  $quantity = $_POST['quantity'];

  // Update prize
  $sql_update = "UPDATE prizes 
                 SET prize_name = ?, prize_description = ?, quantity = ? 
                 WHERE luckyDrawID = ?";
  $stmt_update = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt_update, "ssii", $prizeName, $prizeDescription, $quantity, $prizeID);

  // Execute query
  if (mysqli_stmt_execute($stmt_update)) {
    echo "
      <div id='userSuccessMessage'>
        <p> Prize ($prizeID) was edited successfully!</p>
        <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
          Back to Admin Dashboard
        </a>
        <br>
        <a id='viewPrizeList' href='prizeList.php'>
          View Prize List
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

      <!-- PRIZE EDIT SECTION STARTS HERE -->
      <h2 id="form-title">EDIT PRIZE</h2>

      <div class="admin-form">
        <form action="" method="POST">

          <input type="hidden" name="prizeID" value="<?= isset($prizeID) ? htmlspecialchars($prizeID) : 'NONE'; ?>">

          <label for="prizeName">Prize Name:</label>
          <input type="text" id="prizeName" name="prizeName" value="<?= htmlspecialchars($prizeName) ?>" style="border: 1px solid;" required><br><br>

          <label for="prizeDescription">Prize Description:</label>
          <textarea id="prizeDescription" name="prizeDescription" style="border: 1px solid;" required><?= htmlspecialchars($prizeDescription) ?></textarea><br><br>

          <label for="quantity">Quantity:</label>
          <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($quantity) ?>" min="1" style="border: 1px solid;" required><br><br>

          <button type="submit" style="background-color: black;">Update</button>
          <br><br><br>
        </form>
      </div>
      <!-- PRIZE EDIT SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>

</html>
