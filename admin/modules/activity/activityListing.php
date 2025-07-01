<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>Activity Management</title>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>
    <div class="userList-container" style = "width: 1400px; margin-right: 50px;">
        <div class="userList-form">
            <h2 style="text-align: center;">Manage Activities</h2>
            
            <form method="GET" action="">
                <div>
                    <label for="search">Search Activity:</label>
                    <input type="text" name="search" id="search" placeholder="Search by activity name" value="<?php echo htmlspecialchars($search); ?>" style="padding: 8px; width: 200px; border: 1px solid; font-size: 16px;">
                </div>
                <button type="submit" style="background-color: #659e2f;padding:10px">Search</button>
                <div style="text-align: left; margin-top: 15px;">
                    <a href="createActivity.php" style="background-color: #659e2f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Add New Activity</a>
                </div>
            </form>
            <br>
            <br>
            
            <?php
            $sql = "SELECT * FROM activity WHERE activityName LIKE '%$search%' ORDER BY activityID ASC";
            $result = mysqli_query($conn, $sql);
            $rowcount = mysqli_num_rows($result);
            
            if ($rowcount > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Name</th>";
                echo "<th>Description</th>";
                echo "<th>Start Day</th>";
                echo "<th>End Day</th>";
                echo "<th>Status</th>";
                echo "<th>Start Time</th>";
                echo "<th>End Time</th>";
                echo "<th>Max Participants</th>";
                echo "<th>Price (RM)</th>";
                echo "<th>Image</th>";
                echo "<th>Actions</th>";
                echo "</tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['activityID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['activityName']) . "</td>";
                    echo "<td>" . htmlspecialchars(substr($row['activityDescription'], 0, 100)) . "...</td>";
                    echo "<td>" . htmlspecialchars($row['activityDayStart']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['activityDayEnd']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['activityStatus']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['startTime']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['endTime']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['maxParticipants']) . "</td>";
                    echo "<td>RM " . number_format($row['price'], 2) . "</td>";
                    
                    if (!empty($row['activityImage'])) {
                        echo "<td><img src='../../../img/" . htmlspecialchars($row['activityImage']) . "' alt='Activity Image' style='width: 50px; height: 50px;'></td>";
                    } else {
                        echo "<td>No Image</td>";
                    }
                    
                    echo "<td>";
                    echo "<a href='editActivity.php?id=" . urlencode($row['activityID']) . "'>Edit</a> | ";
                    echo "<a href='deleteActivity.php?id=" . urlencode($row['activityID']) . "' onclick='return confirm(\"Are you sure you want to delete this activity?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<p>Total Activities: $rowcount</p>";
            } else {
                echo "<p>No activities found.</p>";
            }
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <script src="../../js/admin_Script.js"></script>
</body>
</html>
