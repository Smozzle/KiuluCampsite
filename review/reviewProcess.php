<?php
// AVELLE SHAYNE ALBIN (BI22110268)
session_start();
include '../user/config/user_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = isset($_SESSION['UID']) ? intval($_SESSION['UID']) : null;

    if (!$userID) {
        die("Error: User not logged in");
    }

    $reviewFor = $_POST['reviewFor'];
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null; 
    $review = isset($_POST['review']) ? htmlspecialchars($_POST['review']) : '';

    if (!$rating || !$review) {
        die("Error: Missing required fields");
    }

    if ($reviewFor === "activity") {
        $activityID = isset($_POST['activityID']) ? intval($_POST['activityID']) : null;
        if (!$activityID) die("Error: No activity selected");

        $sql = "INSERT INTO activity_review (userID, activityID, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiis', $userID, $activityID, $rating, $review);
    } else {
        $accommodationID = isset($_POST['accommodationID']) ? intval($_POST['accommodationID']) : null;
        if (!$accommodationID) die("Error: No accommodation selected");

        $sql = "INSERT INTO accommodation_review (userID, accommodationID, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiis', $userID, $accommodationID, $rating, $review);
    }

    if ($stmt->execute()) {
        header("Location: reviewSuccess.php");
        exit();
    } else {
        echo "Error submitting review: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method";
}
?>
