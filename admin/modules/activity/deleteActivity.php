<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN DELETE ACIVITY</title>
  
  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<body>
  <?php
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
      $activityID = intval($_GET['id']);
      // delete activity record
      $sql = "DELETE FROM activity WHERE activityID = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $activityID);

      if (mysqli_stmt_execute($stmt)) {
        echo "
              <div id='userSuccessMessage'>
                <p>ACTIVITY WITH ID ($activityID) DELETED SUCCESSFULLY!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                  Back to Admin Dashboard
                </a>
                <br>
                <a id='viewactivityList' href='activityListing.php'>
                  View activity List
                </a>
                <br>
              </div>
              ";
      }
      else {
        echo "Error deleting record: " . mysqli_error($conn);
      }
      mysqli_stmt_close($stmt);
    }
    else {
      echo "Invalid request.";
    }
    mysqli_close($conn);
  ?>
</body>