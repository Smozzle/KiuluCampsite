<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");

// Check if review ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$reviewID = $_GET['id'];

// Fetch the review details
$sql = "SELECT ar.activity_reviewID, ar.rating, ar.comment, ar.activityID, u.userEmail, a.activityName
        FROM activity_review ar
        JOIN user u ON ar.userID = u.userID
        JOIN activity a ON ar.activityID = a.activityID
        WHERE ar.activity_reviewID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $reviewID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$review = mysqli_fetch_assoc($result);

if (!$review) {
    die("Review not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $updateSQL = "UPDATE activity_review SET rating = ?, comment = ? WHERE activity_reviewID = ?";
    $updateStmt = mysqli_prepare($conn, $updateSQL);
    mysqli_stmt_bind_param($updateStmt, "isi", $rating, $comment, $reviewID);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>alert('Review updated successfully!'); window.location.href='reviewActivityList.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating review. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>Edit Activity Review</title>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>

    <section class="admin-dashboard">
        <div class="dashboard-container">

            <h2 id="form-title">EDIT ACTIVITY REVIEW</h2>

            <div class="admin-form">
                <form method="POST" action="">

                    <label for="userEmail">User Email:</label>
                    <input type="text" id="userEmail" value="<?php echo htmlspecialchars($review['userEmail']); ?>" readonly style="border: 1px solid; height: 30px; color: gray;" required><br><br>

                    <label for="activityName">Activity:</label>
                    <input type="text" id="activityName" value="<?php echo htmlspecialchars($review['activityName']); ?>" readonly style="border: 1px solid; height: 30px; color: gray;" required><br><br>

                    <label for="rating">Rating (1-5):</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" value="<?php echo htmlspecialchars($review['rating']); ?>" required style="border: 1px solid; height: 30px; width: 100%; max-width: 1000px;"><br><br>

                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="comment" rows="6" required style="border: 1px solid; width: 100%; max-width: 1000px;"><?php echo htmlspecialchars($review['comment']); ?></textarea><br><br>

                    <button type="submit" style="width: 30%; background-color: #659e2f; padding: 10px 20px;">Update Review</button>
                    <a href="reviewActivityList.php" style="background-color: red; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Cancel</a>
                </form>
            </div>

        </div>
    </section>

    <script src="../../js/admin_Script.js"></script>
</body>
</html>
