<?php
// AVELLE SHAYNE ALBIN (BI22110268)
session_start();
include '../user/config/user_config.php';
include '../user/userAuth/login_popup.php';

// Check if user is logged in, otherwise show login popup
if (!isset($_SESSION['UID'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("login-popup").style.display = "block";
            document.getElementById("register-overlay").style.display = "block";
        });
    </script>';
    exit();
}

$userId = $_SESSION['UID'];

// Fetch list of activities from the database
$activityQuery = "SELECT activityID, activityName FROM activity";
$activityResult = $conn->query($activityQuery);

// Fetch list of accommodations from the database
$accommodationQuery = "SELECT id, name FROM accommodations";
$accommodationResult = $conn->query($accommodationQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Review</title>
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        /* General Body Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: rgb(255, 255, 255);
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            background: rgb(251, 250, 250);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px; /* Adjust label font size */
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 13px;
            font-family: Arial, sans-serif;
            background: #fafafa;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
            background: #fff;
        }

        textarea {
            resize: vertical;
        }

        .submit-btn {
            display: inline-block;
            width: 100%;
            padding: 12px 20px;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: #0056b3;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px 20px;
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<?php include '../user/includes/topnav.php'; ?>
<div class="container">
    <div class="header">
        <h1>Submit Your Review</h1>
    </div>

    <!-- Review Form -->
    <form action="reviewProcess.php" method="POST" name="reviewForm">
        <div class="form-group">
            <label for="reviewFor">Review Type:</label>
            <select name="reviewFor" id="reviewFor" required>
                <option value="activity">Activity</option>
                <option value="accommodation">Accommodation</option>
            </select>
        </div>

        <!-- Activity Select -->
        <div class="form-group" id="activitySelect">
            <label for="activityID">Select Activity:</label>
            <select name="activityID" id="activityID">
                <option value="">-- Select Activity --</option>
                <?php while ($activity = $activityResult->fetch_assoc()): ?>
                    <option value="<?php echo $activity['activityID']; ?>"><?php echo htmlspecialchars($activity['activityName']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Accommodation Select -->
        <div class="form-group" id="accommodationSelect">
            <label for="accommodationID">Select Accommodation:</label>
            <select name="accommodationID" id="accommodationID">
                <option value="">-- Select Accommodation --</option>
                <?php while ($accommodation = $accommodationResult->fetch_assoc()): ?>
                    <option value="<?php echo $accommodation['id']; ?>"><?php echo htmlspecialchars($accommodation['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="review">Your Review:</label>
            <textarea name="review" id="review" rows="4" placeholder="Write your review here" required></textarea>
        </div>

        <div class="form-group">
            <label for="rating">Rating (1-5):</label>
            <input type="range" name="rating" id="rating" min="1" max="5" required>
        </div>

        <button type="submit" class="submit-btn">Submit Review</button>
    </form>
</div>

<script>
    // Toggle visibility of activity and accommodation select fields based on Review Type
    document.getElementById('reviewFor').addEventListener('change', function() {
        var reviewFor = this.value;
        document.getElementById('activitySelect').style.display = (reviewFor === 'activity') ? 'block' : 'none';
        document.getElementById('accommodationSelect').style.display = (reviewFor === 'accommodation') ? 'block' : 'none';
    });

    // Initialize visibility on page load
    document.getElementById('reviewFor').dispatchEvent(new Event('change'));
</script>
</body>
<?php include '../user/includes/user_Footer.php'; ?>
</html>
