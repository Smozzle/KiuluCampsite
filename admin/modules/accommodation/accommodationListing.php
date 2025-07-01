<?php 
//Suziliana Mosingkil (BI22110296)
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
  <title>ADMIN ACCOMMODATION LIST</title>

  <!-- cdn icon link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- css file -->
  <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<body>
  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("../../includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container">
      <!-- ACCOMMODATION LIST SECTION STARTS HERE -->
      <h1>ACCOMMODATION LIST</h1>

      <a href="createAccommodation.php" style="background-color: #57872a;color:white;padding:10px">Add Accommodation</a>
      <br>
      <br>
      
      <!-- form list details -->
      <?php
      // Check if the availability status filter is set
      $availability_status = isset($_GET['availability_status']) ? $_GET['availability_status'] : null;

      // Build the SQL query with optional availability filter
      $sql_accommodation = "SELECT * FROM accommodations";

      // Add availability filter if provided
      if (!empty($availability_status)) {
        $sql_accommodation .= " WHERE availability_status = ?";
      }

      $sql_accommodation .= " ORDER BY id ASC";

      $stmt = mysqli_prepare($conn, $sql_accommodation);

      // Bind parameters for the availability filter
      if (!empty($availability_status)) {
        mysqli_stmt_bind_param($stmt, "s", $availability_status);
      }

      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowcount = mysqli_num_rows($result);
      ?>

      <!-- Availability Filter Form -->
      <form method="GET" action="">
        <label for="availability_status">Availability Status:</label>
        <br>
        <select id="availability_status" name="availability_status" style="width: 170px !important; border: 1px solid; font-size: 16px;">
          <option value="">All Statuses</option>
          <option value="available" <?php echo ($availability_status == 'available') ? 'selected' : ''; ?>>Available</option>
          <option value="booked" <?php echo ($availability_status == 'booked') ? 'selected' : ''; ?>>Booked</option>
          <option value="unavailable" <?php echo ($availability_status == 'unavailable') ? 'selected' : ''; ?>>Unavailable</option>
        </select>
        <br>
        <br>
        <button type="submit" style="background-color: #659e2f;padding:10px">Search</button>
      </form>
      <br>
      <br>
      <div class="admin-accommodationListContainer">
        <table id="accommodation-table" style="width: 100%;">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Location</th>
            <th>Price</th>
            <th>Max Capacity</th>
            <th>Availability</th>
            <th>Actions</th>
          </tr>
          <?php
          if ($rowcount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
              echo "<td>" . htmlspecialchars(substr($row["description"], 0, 100)) . "...</td>";
              echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
              echo "<td>RM " . htmlspecialchars($row["price"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["max_capacity"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["availability_status"]) . "</td>";
              echo "<td>";
              echo "<a href='editAccommodation.php?id=" . urlencode($row["id"]) . "' style='background-color:#c8d9b8;color:black'>Edit</a> | ";
              echo "<a href='deleteAccommodation.php?id=" . urlencode($row["id"]) . "' style='background-color:#d9b8b8;color:black' onclick='return confirm(\"Are you sure you want to delete this accommodation?\");'>Delete</a>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='8'><p>No results found.</p></td></tr>";
          }
          mysqli_free_result($result);
          mysqli_close($conn);
          ?>
        </table>

        <!-- display row count -->
        <h2 id="list-row-count">Total Accommodations: <?php echo $rowcount; ?></h2>
      </div>
      <!-- ACCOMMODATION LIST SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>

</html>
