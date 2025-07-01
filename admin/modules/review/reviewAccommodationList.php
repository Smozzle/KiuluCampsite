<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");

// Fetch accommodation reviews
$sql = "SELECT ar.accommodation_reviewID, u.userEmail, a.name, ar.rating, ar.comment, ar.created_at
        FROM accommodation_review ar
        JOIN user u ON ar.userID = u.userID
        JOIN accommodations a ON ar.accommodationID = a.id
        ORDER BY ar.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>Review Accommodation Management</title>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>

    <div class="userList-container">
        <div class="userList-form">
            <h2 style="text-align: center;">Manage Accommodation Reviews</h2>
            <br>

            <?php
            $rowcount = $result->num_rows;
            if ($rowcount > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>Review ID</th>";
                echo "<th>User Email</th>";
                echo "<th>Accommodation</th>";
                echo "<th>Rating</th>";
                echo "<th>Comment</th>";
                echo "<th>Date</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["accommodation_reviewID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userEmail"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rating"]) . "</td>";
                    echo "<td>" . htmlspecialchars(substr($row["comment"], 0, 100)) . "...</td>";
                    echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editAccommodationReview.php?id=" . urlencode($row["accommodation_reviewID"]) . "'>Edit</a> | ";
                    echo "<a href='deleteAccommodationReview.php?id=" . urlencode($row["accommodation_reviewID"]) . "' onclick='return confirm(\"Are you sure you want to delete this review?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<p>Total Reviews: $rowcount</p>";
            } else {
                echo "<p>No reviews found.</p>";
            }
            ?>

        </div>
    </div>

    <?php
    $result->free();
    $conn->close();
    ?>

    <script src="../../js/admin_Script.js"></script>
</body>
</html>
