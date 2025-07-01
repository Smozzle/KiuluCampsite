<?php
//Suziliana Mosingkil (BI22110296)
include '../user/config/user_config.php';

// Check if accommodation ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. Accommodation ID is missing.");
}

$accommodationID = intval($_GET['id']); // Sanitize input

// Fetch accommodation details
$accommodationQuery = "SELECT name FROM accommodations WHERE id = ?";
$stmt = $conn->prepare($accommodationQuery);
$stmt->bind_param("i", $accommodationID);
$stmt->execute();
$accommodationResult = $stmt->get_result();

if ($accommodationResult->num_rows === 0) {
    die("Accommodation not found.");
}

$accommodation = $accommodationResult->fetch_assoc();
$stmt->close();

// Fetch accommodation reviews
$reviewQuery = "SELECT ar.rating, ar.comment, ar.created_at, u.username 
                FROM accommodation_review ar
                JOIN user u ON ar.userID = u.userID
                WHERE ar.accommodationID = ?
                ORDER BY ar.created_at DESC";
$stmt = $conn->prepare($reviewQuery);
$stmt->bind_param("i", $accommodationID);
$stmt->execute();
$reviews = $stmt->get_result();
$stmt->close();

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID']; // Replace with actual session user ID
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($rating < 1 || $rating > 5) {
        echo "<p class='error-msg'>Invalid rating. Please select between 1 and 5.</p>";
    } else {
        $insertQuery = "INSERT INTO accommodation_review (userID, accommodationID, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("iiis", $userID, $accommodationID, $rating, $comment);
        if ($stmt->execute()) {
            echo "<p class='success-msg'>Review submitted successfully!</p>";
            header("Refresh:0"); // Refresh to display new review
        } else {
            echo "<p class='error-msg'>Error submitting review.</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/css/user_style.css">
    <title>Accommodation Reviews - <?php echo htmlspecialchars($accommodation['name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .review-container {
            max-width: 700px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            
        }

        .review-container h1 {
            text-align: center;
            color: #333;
            
        }

        .review-list {
            margin-top: 2rem;
        }

        .review-item {
            padding: 1rem;
            margin-bottom: 1rem;
            background-color:rgb(240, 241, 243);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .review-item strong {
            color: #007bff;
        }

        .review-item p {
            margin: 0.5rem 0;
        }

        .rating {
            color: #ffc107;
        }

        .success-msg {
            color: green;
            text-align: center;
        }

        .error-msg {
            color: red;
            text-align: center;
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
    

    <div class="review-container">
        <h1>Reviews for <?php echo htmlspecialchars($accommodation['name']); ?></h1>

        <!-- Display Reviews -->
        <div class="review-list">
            <?php
            if ($reviews->num_rows > 0) {
                echo "<p style='text-align:center; color:black; margin-bottom:20px;'>Customer Reviews.</p>";
                while ($row = $reviews->fetch_assoc()) {
                    echo "<div class='review-item'>";
                    echo "<p><strong>" . htmlspecialchars($row['username']) . "</strong> - " . date("F j, Y", strtotime($row['created_at'])) . "</p>";
                    echo "<p class='rating'>" . str_repeat("⭐", $row['rating']) . "</p>";
                    echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p></p>";
                echo "<p></p>";
                echo "<p></p>";
                echo "<p style='text-align:center; color:#888;'>No reviews yet.</p>";
            }
            ?>
        </div>
        <!-- Back Button -->
        <a href="accommodation.php?id=<?php echo $accommodationID; ?>" class="back-btn"> Back to Accommodation</a>
    </div>


</body>

</html>

