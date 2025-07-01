<?php 
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
include("../../config/admin_config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="../../css/admin_Style.css">
  <title>SAFETY INFORMATION LIST</title>
</head>

<body>
  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("../../includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container">
      <!-- SAFETY LIST SECTION STARTS HERE -->
      <h1> SAFETY INFORMATION LIST </h1>

      <a href="safety_add.php" style="background-color: #57872a;color:white;padding:10px">Add Safety Info</a>
      <br><br>

      <?php
      // Build the SQL query
      $sql_safety = "SELECT * FROM safetyinfo ORDER BY id ASC";
      $result = mysqli_query($conn, $sql_safety);
      $rowcount = mysqli_num_rows($result);
      ?>

      <div class="admin-userListContainer">
        <table id="safety-table" style="width: 100%;">
          <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>TYPE</th>
            <th>DESCRIPTION</th>
            <th>IMAGE</th>
            <th>LAST UPDATED</th>
            <th>ACTIONS</th>
          </tr>
          <?php
          if ($rowcount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
              echo "<td>" . nl2br(htmlspecialchars(substr($row["description"], 0, 50))) . "...</td>";
              echo "<td><img src='" . htmlspecialchars($row["image"]) . "' alt='Image' style='width:50px;height:50px;'></td>";
              echo "<td>" . htmlspecialchars($row["last_updated"]) . "</td>";
              echo "<td>";
              echo "<a href='safety_edit.php?id=" . urlencode($row["id"]) . "' style='background-color:#c8d9b8;color:black'>Edit</a> | ";
              echo "<a href='safety_delete.php?id=" . urlencode($row["id"]) . "' style='background-color:#d9b8b8;color:black' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='7'><p>No results found.</p></td></tr>";
          }
          mysqli_free_result($result);
          mysqli_close($conn);
          ?>
        </table>

        <!-- display row count -->
        <h2 id="list-row-count">Total Safety Info: <?php echo $rowcount; ?></h2>
      </div>
      <!-- SAFETY LIST SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>
</html>
