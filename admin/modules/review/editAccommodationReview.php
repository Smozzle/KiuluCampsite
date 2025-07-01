<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");

// Check if review ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$reviewID = $_GET['id'];

// Fetch the review details
$sql = "SELECT ar.accommodation_reviewID, ar.rating, ar.comment, ar.accommodationID, u.userEmail, a.name
        FROM accommodation_review ar
        JOIN user u ON ar.userID = u.userID
        JOIN accommodations a ON ar.accommodationID = a.id
        WHERE ar.accommodation_reviewID = ?";
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

    $updateSQL = "UPDATE accommodation_review SET rating = ?, comment = ? WHERE accommodation_reviewID = ?";
    $updateStmt = mysqli_prepare($conn, $updateSQL);
    mysqli_stmt_bind_param($updateStmt, "isi", $rating, $comment, $reviewID);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>alert('Review updated successfully!'); window.location.href='reviewAccommodationList.php';</script>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>Edit Accommodation Review</title>
</head>

<body>
    <!-- ADMIN SIDENAV SECTION STARTS HERE -->
    <?php include("../../includes/admin_SideNav.php"); ?>
    <!-- ADMIN SIDENAV SECTION ENDS HERE -->

    <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
    <section class="admin-dashboard">
        <div class="dashboard-container">

            <!-- EDIT REVIEW SECTION STARTS HERE -->
            <h2 id="form-title" style="text-align: center;">Edit Accommodation Review</h2>

            <div class="admin-form">
                <form method="POST" action="">

                    <label for="userEmail">User Email:</label>
                    <input type="text" value="<?php echo htmlspecialchars($review['userEmail']); ?>" readonly style="height: 30px; color: gray; width: 100%; max-width: 1000px; border: 1px solid;">

                    <label for="accommodationName">Accommodation:</label>
                    <input type="text" value="<?php echo htmlspecialchars($review['name']); ?>" readonly style="height: 30px; color: gray; width: 100%; max-width: 1000px; border: 1px solid;">

                    <label for="rating">Rating (1-5):</label>
                    <input type="number" name="rating" min="1" max="5" value="<?php echo htmlspecialchars($review['rating']); ?>" required style="height: 30px; width: 100%; max-width: 1000px; border: 1px solid;">

                    <label for="comment">Comment:</label>
                    <textarea name="comment" rows="5" required style="width: 100%; max-width: 1000px; height: 100px; border: 1px solid;"><?php echo htmlspecialchars($review['comment']); ?></textarea>

                    <button type="submit" style="width: 30%; background-color: #659e2f; padding: 10px 20px; border: none; color: white; font-size: 16px; cursor: pointer;">Update Review</button>

                    <a href="reviewAccommodationList.php" style="background-color: red; color: white; padding: 7px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px;">Cancel</a>

                </form>
            </div>
            <!-- EDIT REVIEW SECTION ENDS HERE -->

        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <script src="../../js/admin_Script.js"></script>
</body>

</html>
