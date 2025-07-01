<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN EDIT ACTIVITY</title>

  <!-- cdn icon link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// check if ID is provided
if (isset($_GET['id'])) {
  $activityID = intval($_GET['id']);

  // retrieve the existing activity data
  $sql = "SELECT * FROM activity WHERE activityID = ?";
  $stmt_select = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt_select, "i", $activityID);
  mysqli_stmt_execute($stmt_select);
  $result = mysqli_stmt_get_result($stmt_select);

  if ($row = mysqli_fetch_assoc($result)) {
    $activityName = $row['activityName'];
    $activityDescription = $row['activityDescription'];
    $activityDayStart = $row['activityDayStart'];
    $activityDayEnd = $row['activityDayEnd'];
    $activityStatus = $row['activityStatus'];
    $startTime = $row['startTime'];
    $endTime = $row['endTime'];
    $maxParticipants = $row['maxParticipants'];
    $price = $row['price'];
    $activityImage = $row['activityImage'];
  } else {
    echo "Activity not found.";
    exit;
  }
  mysqli_stmt_close($stmt_select);
} else {
  echo "Invalid Request.";
  exit;
}

// handle activity update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $activityName = $_POST['activityName'];
  $activityDescription = $_POST['activityDescription'];
  $activityDayStart = $_POST['activityDayStart'];
  $activityDayEnd = $_POST['activityDayEnd'];
  $activityStatus = $_POST['activityStatus'];
  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];
  $maxParticipants = $_POST['maxParticipants'];
  $price = $_POST['price'];
  $activityImage = $_FILES['activityImage']['name'];

  // Handling file upload for activityImage
  if (!empty($activityImage)) {
    $target_dir = "../../../img/";
    $target_file = $target_dir . basename($activityImage);
    move_uploaded_file($_FILES['activityImage']['tmp_name'], $target_file);
  }

  // update activity
  $sql_update = "UPDATE activity SET activityName = ?, activityDescription = ?, activityDayStart = ?, activityDayEnd = ?, activityStatus = ?, startTime = ?, endTime = ?, maxParticipants = ?, price = ?, activityImage = ?
    WHERE activityID = ?";
  $stmt_update = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt_update, "ssssssiiisi", $activityName, $activityDescription, $activityDayStart, $activityDayEnd, $activityStatus, $startTime, $endTime, $maxParticipants, $price, $activityImage, $activityID);

  // execute query
  if (mysqli_stmt_execute($stmt_update)) {
    echo "
      <div id='userSuccessMessage'>
        <p>Activity ($activityName) with Activity ID of ($activityID) was edited successfully!</p>
        <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>Back to Admin Dashboard</a>
        <br>
        <a id='viewActivityList' href='activityListing.php'>View Activity List</a>
        <br>
      </div>
    ";
    exit;
  } else {
    $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
    header("Location: activityEdit.php?id=" . $activityID);
    exit;
  }
}
?>

<body>
  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("../../includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container">

      <!-- ACTIVITY EDIT SECTION STARTS HERE -->
      <h2 id="form-title">EDIT ACTIVITY</h2>

      <!-- form edit details -->
      <div class="admin-form">
        <form action="" method="POST" enctype="multipart/form-data">

          <input type="hidden" name="activityID" value="<?= isset($activityID) ? htmlspecialchars($activityID) : 'NONE'; ?>">

          <label for="activityName">Activity Name:</label>
          <input type="text" id="activityName" name="activityName" value="<?= htmlspecialchars($activityName) ?>" style="border: 1px solid;" required><br><br>

          <label for="activityDescription">Activity Description:</label>
          <textarea id="activityDescription" name="activityDescription" style="border: 1px solid;" required><?= htmlspecialchars($activityDescription) ?></textarea><br><br>

          <label for="activityDayStart">Start Day:</label>
          <select id="activityDayStart" name="activityDayStart" style="border: 1px solid;" required>
            <option value="" disabled selected>-- select start day --</option>
            <?php
              $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
              foreach ($days as $day) {
                echo "<option value='$day' " . ($activityDayStart == $day ? 'selected' : '') . ">$day</option>";
              }
            ?>
          </select><br><br>

          <label for="activityDayEnd">End Day:</label>
          <select id="activityDayEnd" name="activityDayEnd" style="border: 1px solid;" required>
            <option value="" disabled selected>-- select end day --</option>
            <?php
              foreach ($days as $day) {
                echo "<option value='$day' " . ($activityDayEnd == $day ? 'selected' : '') . ">$day</option>";
              }
            ?>
          </select><br><br>

          <label for="activityStatus">Status:</label>
          <select id="activityStatus" name="activityStatus" style="border: 1px solid;" required>
            <option value="open" <?= ($activityStatus == 'open') ? 'selected' : ''; ?>>Open</option>
            <option value="closed" <?= ($activityStatus == 'closed') ? 'selected' : ''; ?>>Closed</option>
            <option value="ongoing" <?= ($activityStatus == 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
          </select><br><br>

          <label for="startTime">Start Time:</label>
          <input type="time" id="startTime" name="startTime" value="<?= htmlspecialchars($startTime) ?>" style="border: 1px solid;" required><br><br>

          <label for="endTime">End Time:</label>
          <input type="time" id="endTime" name="endTime" value="<?= htmlspecialchars($endTime) ?>" style="border: 1px solid;" required><br><br>

          <label for="maxParticipants">Max Participants:</label>
          <input type="number" id="maxParticipants" name="maxParticipants" value="<?= htmlspecialchars($maxParticipants) ?>" style="border: 1px solid;" required><br><br>

          <label for="price">Price:</label>
          <input type="number" id="price" name="price" value="<?= htmlspecialchars($price) ?>" step="0.01" style="border: 1px solid;" required><br><br>

          <label for="activityImage">Activity Image:</label>
          <input type="file" id="activityImage" name="activityImage" style="border: 1px solid;"><br><br>

          <button type="submit" style="background-color: black;">Update</button>
          <br><br><br>
        </form>
      </div>
      <!-- ACTIVITY EDIT SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>

</html>
