<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");

// Check if review ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$reviewID = $_GET['id'];

// Delete the review
$sql = "DELETE FROM activity_review WHERE activity_reviewID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $reviewID);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Review deleted successfully!'); window.location.href='reviewActivityList.php';</script>";
} else {
    echo "<script>alert('Error deleting review. Please try again.'); window.location.href='reviewActivityList.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
