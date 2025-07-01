<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include '../user/config/user_config.php';

if (!isset($_GET['activityID']) || empty($_GET['activityID'])) {
    echo "Invalid activity.";
    exit;
}

$activityID = intval($_GET['activityID']);

// Fetch activity details
$activityQuery = "SELECT activityName FROM activity WHERE activityID = ?";
$stmtActivity = $conn->prepare($activityQuery);
$stmtActivity->bind_param("i", $activityID);
$stmtActivity->execute();
$activityResult = $stmtActivity->get_result();
$activity = $activityResult->fetch_assoc();
$stmtActivity->close();

if (!$activity) {
    echo "Activity not found.";
    exit;
}

// Fetch reviews for the activity
$reviewQuery = "
    SELECT ar.rating, ar.comment, ar.created_at, u.username 
    FROM activity_review ar
    JOIN user u ON ar.userID = u.userID
    WHERE ar.activityID = ?
    ORDER BY ar.created_at DESC";

$stmtReview = $conn->prepare($reviewQuery);
$stmtReview->bind_param("i", $activityID);
$stmtReview->execute();
$reviewResult = $stmtReview->get_result();
$stmtReview->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Reviews - <?php echo htmlspecialchars($activity['activityName']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: rgb(255, 255, 255);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .reviewCard {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .reviewCard:last-child {
            border-bottom: none;
        }
        .username {
            font-weight: bold;
            color: #333;
        }
        .rating {
            color: #ffcc00;
        }
        .comment {
            margin: 10px 0;
            color: #444;
        }
        .date {
            font-size: 12px;
            color: #888;
        }
        /* Back Button Styling */
        .back-btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            font-size: 16px;
            color: white;
            background-color:rgb(151, 187, 225);
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease-in-out;
            
        }

        .back-btn:hover {
            background-color:rgb(28, 98, 173);
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="header">Reviews for <?php echo htmlspecialchars($activity['activityName']); ?></h1>

        <?php if ($reviewResult->num_rows > 0) { 
            while ($review = $reviewResult->fetch_assoc()) { ?>
                <div class="reviewCard">
                    <p class="username"><?php echo htmlspecialchars($review['username']); ?></p>
                    <p class="rating"><?php echo str_repeat("⭐", $review['rating']); ?></p>
                    <p class="comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                    <p class="date"><?php echo date("F j, Y, g:i A", strtotime($review['created_at'])); ?></p>
                </div>
        <?php } 
        } else { ?>
            <p style = "text-align: center;">No reviews yet for this activity.</p>
        <?php } ?>

        <a href="activityList.php" class="back-btn">Back to Activities</a>
    </div>

</body>
</html>
