
<?php
//ALVINA ALPHONSUS BI22110003
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN DELETE LUCKY DRAW</title>
  
  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<body>
  <?php
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
      $luckyDrawID = intval($_GET['id']);
      // delete lucky draw record
      $sql = "DELETE FROM lucky_draw WHERE luckyDrawID = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "i", $luckyDrawID);

      if (mysqli_stmt_execute($stmt)) {
        echo "
              <div id='userSuccessMessage'>
                <p>LUCKY DRAW ENTRY WITH ID ($luckyDrawID) DELETED SUCCESSFULLY!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                  Back to Admin Dashboard
                </a>
                <br>
                <a id='viewLuckyDrawList' href='prizeList.php'>
                  View Lucky Draw List
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
