
<?php
//ALVINA ALPHONSUS BI22110003
include("../../config/admin_config.php");

// Fetch prizes
$prizesSql = "SELECT * FROM prizes";
$prizesResult = mysqli_query($conn, $prizesSql);

if (!$prizesResult) {
    echo "Error fetching prizes: " . mysqli_error($conn);
    exit;
}

// Fetch lucky draw winners
$luckyDrawSql = "SELECT ld.luckyDrawID, ld.userID, ld.prize, ld.draw_date, ld.redeemed, u.username 
                 FROM lucky_draw ld
                 JOIN user u ON ld.userID = u.userID";
$luckyDrawResult = mysqli_query($conn, $luckyDrawSql);

if (!$luckyDrawResult) {
    echo "Error fetching lucky draw winners: " . mysqli_error($conn);
    exit;
}
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
  <title>Prize List</title>
</head>

<body>
  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("../../includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container">

      <h1>Prize List</h1>

      <!-- Add Prize Button -->
      <a href="createPrize.php" style="background-color: #57872a; color:white; padding:10px; margin-bottom: 20px; display: inline-block;">
          Add Prize
      </a>

      <!-- Prize List Table -->
      <h2>Prizes</h2>
      <table border="1" cellspacing="0" cellpadding="20" style="width: 100%; text-align: left;">
        <thead>
          <tr>
            <th>ID</th>
            <th>Prize Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($prizesResult) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($prizesResult)): ?>
              <tr>
                <td><?= htmlspecialchars($row['luckyDrawID']) ?></td>
                <td><?= htmlspecialchars($row['prize_name']) ?></td>
                <td><?= htmlspecialchars($row['prize_description']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td>
                  <a href="editPrize.php?id=<?= $row['luckyDrawID'] ?>" class="btn btn-edit" style="background-color: #ffa500; color: white; display: block; margin-bottom: 5px; padding: 10px; width: 100%; text-align: center;">Edit</a>
                  <a href="deletePrize.php?id=<?= $row['luckyDrawID'] ?>" class="btn btn-delete" style="background-color: #f44336; color: white; display: block; padding: 10px; width: 100%; text-align: center;" onclick="return confirm('Are you sure you want to delete this prize?');">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No prizes found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Lucky Draw Winners Table -->
      <h2>Lucky Draw Winners</h2>
      <table border="1" cellspacing="0" cellpadding="20" style="width: 100%; text-align: left;">
        <thead>
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Prize</th>
            <th>Draw Date</th>
            <th>Redeemed</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($luckyDrawResult) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($luckyDrawResult)): ?>
              <tr>
                <td><?= htmlspecialchars($row['luckyDrawID']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['prize']) ?></td>
                <td><?= htmlspecialchars($row['draw_date']) ?></td>
                <td><?= htmlspecialchars($row['redeemed'] ? 'Yes' : 'No') ?></td>
                <td>
                  <a href="editLuckyDraw.php?id=<?= $row['luckyDrawID'] ?>" class="btn btn-edit" style="background-color: #ffa500; color: white; display: block; margin-bottom: 5px; padding: 10px; width: 100%; text-align: center;">Edit</a>
                  <a href="deleteDraw.php?id=<?= $row['luckyDrawID'] ?>" class="btn btn-delete" style="background-color: #f44336; color: white; display: block; padding: 10px; width: 100%; text-align: center;" onclick="return confirm('Are you sure you want to delete this lucky draw entry?');">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No lucky draw winners found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="../../js/admin_Script.js"></script>
</body>

</html>
