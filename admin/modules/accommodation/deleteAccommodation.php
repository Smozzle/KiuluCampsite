<?php
//Suziliana Mosingkil (BI22110296)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN DELETE ACCOMMODATION</title>

  <!-- CSS file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<body>
  <?php
  if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $accommodationID = intval($_GET['id']);

    // Delete the accommodation record
    $sql = "DELETE FROM accommodations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $accommodationID);

    if (mysqli_stmt_execute($stmt)) {
      echo "
        <div id='userSuccessMessage'>
          <p>ACCOMMODATION WITH ID ($accommodationID) DELETED SUCCESSFULLY!</p>
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
      echo "<div id='userErrorMessage'>
              <p>Error deleting record: " . htmlspecialchars(mysqli_error($conn)) . "</p>
            </div>";
    }
    mysqli_stmt_close($stmt);
  } else {
    echo "<div id='userErrorMessage'><p>Invalid request.</p></div>";
  }

  mysqli_close($conn);
  ?>
</body>

</html>
