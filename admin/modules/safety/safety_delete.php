<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
// include db config
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN DELETE SAFETY INFO</title>
  
  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<body>
  <?php
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
      $safetyID = intval($_GET['id']);
      
      // delete safety info record
      $sql = "DELETE FROM safetyinfo WHERE id = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $safetyID);

      if (mysqli_stmt_execute($stmt)) {
        echo "
              <div id='userSuccessMessage'>
                <p>SAFETY INFO WITH ID ($safetyID) DELETED SUCCESSFULLY!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                  Back to Admin Dashboard
                </a>
                <br>
                <a id='viewSafetyList' href='safety_list.php'>
                  View Safety Info List
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
</html>
