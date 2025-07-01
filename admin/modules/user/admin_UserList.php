<!-- include db config (admin_config.php) -->
<?php 
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
include("../../config/admin_config.php"); ?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="../../css/admin_Style.css">
  <title>ADMIN USER LIST</title>
</head>

<body>
  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("../../includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container">
      <!-- USER LIST SECTION STARTS HERE -->
      <h1> USER LIST </h1>

      <a href="admin_addUser.php" style="background-color: #57872a;color:white;padding:10px">Add User</a>
      <br>
      <br>
      <!-- form lis title -->

      <!-- form list details -->
      <?php
      // Check if the start_date and end_date filters are set
      $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
      $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

      // Build the SQL query with optional date filters
      $sql_user = "SELECT u.userID, u.userName, u.userEmail, u.regDate, u.userRoles
    FROM user u";

      // Add date filters if provided
      if (!empty($start_date) && !empty($end_date)) {
        $sql_user .= " WHERE u.regDate BETWEEN ? AND ?";
      } elseif (!empty($start_date)) {
        $sql_user .= " WHERE u.regDate >= ?";
      } elseif (!empty($end_date)) {
        $sql_user .= " WHERE u.regDate <= ?";
      }

      $sql_user .= " ORDER BY u.userID ASC";

      $stmt = mysqli_prepare($conn, $sql_user);

      // Bind parameters for the date filters
      if (!empty($start_date) && !empty($end_date)) {
        mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
      } elseif (!empty($start_date)) {
        mysqli_stmt_bind_param($stmt, "s", $start_date);
      } elseif (!empty($end_date)) {
        mysqli_stmt_bind_param($stmt, "s", $end_date);
      }

      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowcount = mysqli_num_rows($result);
      ?>

      <!-- Date Filter Form -->
      <form method="GET" action="">
        <label for="start_date">Start Date:</label>
        <br>
        <input type="date" id="start_date" name="start_date" style="width: 170px !important; border: 1px solid; font-size: 16px;" value="<?php echo htmlspecialchars($start_date); ?>">

        <br>
        <br>
        <label for="end_date">End Date:</label>
        <br>
        <input type="date" id="end_date" name="end_date" style="width: 250px !important;border: 1px solid; font-size: 16px;" value="<?php echo htmlspecialchars($end_date); ?>">
        <br>
        <br>
        <button type="submit" style="background-color: #659e2f;padding:10px">Search</button>
      </form>
      <br>
      <br>
      <div class="admin-userListContainer">

        <table id="user-table" style="width: 100%;">
          <tr>
            <th>USER ID</th>
            <th>USERNAME</th>
            <th>USER EMAIL</th>
            <th>ROLE</th>
            <th>REGISTER DATE</th>
            <th>ACTIONS</th>
          </tr>
          <?php
          if ($rowcount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row["userID"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["userName"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["userEmail"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["userRoles"]) . "</td>";
              echo "<td>" . htmlspecialchars($row["regDate"]) . "</td>";
              echo "<td>";
              echo "<a href='admin_EditUser.php?id=" . urlencode($row["userID"]) . "' style='background-color:#c8d9b8;color:black'>Edit</a> | ";
              echo "<a href='admin_DeleteUser.php?id=" . urlencode($row["userID"]) . "' style='background-color:#d9b8b8;color:black' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'><p>No results found.</p></td></tr>";
          }
          mysqli_free_result($result);
          mysqli_close($conn);
          ?>
        </table>

        <!-- display row count -->
        <h2 id="list-row-count">( 1: ADMIN | 2: USER )</h2>
        <h2 id="list-row-count">Total User: <?php echo $rowcount; ?></h2>
      </div>
      <!-- USER LIST SECTION ENDS HERE -->
    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>
