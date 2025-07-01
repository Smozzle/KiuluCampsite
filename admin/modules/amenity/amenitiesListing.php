<?php
//ALVINA ALPHONSUS BI22110003
// include db config
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="../../css/admin_Style.css">
  <title>ADMIN AMENITIES LIST</title>
</head>

<body>
  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("../../includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container">
      <!-- AMENITIES LIST SECTION STARTS HERE -->
      <h1>AMENITIES LIST</h1>

      <a href="createAmenity.php" style="background-color: #57872a; color:white; padding:10px">Add Amenity</a>
      <br><br>

      <!-- Search and filter form -->
      <form method="GET" action="">
        <label for="search">Search:</label>
        <br>
        <input type="text" id="search" name="search" placeholder="Search by name..." 
          style="width: 250px; height: 40px; border: 1px solid; font-size: 16px; border-radius: 10px; padding: 10px;" 
          value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        <br><br>
        <button type="submit" style="background-color: #659e2f; padding:10px">Search</button>
      </form>
      <br>

      <?php
      // Fetch amenities with optional search filter
      $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";

      $sql_amenities = "SELECT id, name, description, price, unit, created_at FROM amenities WHERE name LIKE ? ORDER BY id ASC";
      $stmt = mysqli_prepare($conn, $sql_amenities);
      mysqli_stmt_bind_param($stmt, "s", $search);

      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowcount = mysqli_num_rows($result);
      ?>

      <div class="admin-amenitiesListContainer">
        <table id="amenities-table" style="width: 100%;">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Unit</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
          <?php
          if ($rowcount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
              echo "<td>RM " . number_format($row["price"], 2) . "</td>";
              echo "<td>" . htmlspecialchars($row["unit"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
              echo "<td>";
              echo "<a href='editAmenity.php?id=" . urlencode($row["id"]) . "' style='background-color:#c8d9b8; color:black'>Edit</a> | ";
              echo "<a href='deleteAmenity.php?id=" . urlencode($row["id"]) . "' style='background-color:#d9b8b8; color:black' onclick='return confirm(\"Are you sure you want to delete this amenity?\");'>Delete</a>";
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
        <h2 id="list-row-count">Total Amenities: <?php echo $rowcount; ?></h2>
      </div>
      <!-- AMENITIES LIST SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>

</html>
