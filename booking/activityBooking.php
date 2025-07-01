<?php
// SITI NUR AISHAH BINTI JUAN (BI22110101)

session_start();
include '../user/config/user_config.php';
include '../user/userAuth/login_popup.php';

if (!isset($_SESSION['UID'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("login-popup").style.display = "block";
            document.getElementById("register-overlay").style.display = "block";
        });
    </script>';
    exit();
}

$userEmail = '';
if (isset($_SESSION['UID'])) {
    $sql = "SELECT userEmail FROM user WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['UID']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $userEmail = $row['userEmail'];
    }
}

// Check if activity ID is provided in URL
if (!isset($_GET['activityID']) || !is_numeric($_GET['activityID'])) {
    die("Invalid activity ID");
}

$activityId = (int)$_GET['activityID'];

// Get activity details and current bookings
$sql = "SELECT a.*, 
               acc.name as accommodationName,
               COALESCE(( /*to return 0 if there are no bookings*/
                   SELECT SUM(ab.num_guests) 
                   FROM activity_bookings ab 
                   WHERE ab.activity_id = a.activityID 
                   AND ab.booking_status != 'cancelled'
               ), 0) as booked_spots
        FROM activity a 
        LEFT JOIN accommodations acc ON a.activityID = acc.id
        WHERE a.activityID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $activityId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Activity not found");
}

$activity = $result->fetch_assoc();

// Calculate remaining spots
$spotsLeft = max(0, $activity['maxParticipants'] - $activity['booked_spots']);

// Get activity name for the page title
$activityName = $activity['activityName'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo htmlspecialchars($activityName); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <link href="styles2.css" rel="stylesheet">
    <style>
        .booking-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .booking-header h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .activity-details {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .activity-details p {
            margin: 8px 0;
        }

        .spots-warning {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: none;
        }

        .book-form {
            display: grid;
            gap: 15px;
        }

        .form-group {
            display: grid;
            gap: 5px;
        }

        .form-group input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .total-section {
            margin-top: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 4px;
        }

        .submit-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: fit-content;
            margin: 20px auto;
        }

        .submit-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }

        .form-group small {
            color: #888;
        }
    </style>
</head>
<body>
    <?php include '../user/includes/topNav.php';?>

    <div class="booking-container">
        <div class="booking-header">
            <h1><?php echo htmlspecialchars($activity['activityName']); ?></h1>
        </div>

        <div class="activity-details">
            
            <p><strong>Price per Person:</strong> RM<?php echo number_format($activity['price'], 2); ?></p>
            <p><strong>Maximum Participants:</strong> <?php echo $activity['maxParticipants']; ?></p>
            <p><strong>Spots Left:</strong> <span id="spotsLeft"><?php echo $spotsLeft; ?></span></p>
            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($activity['activityDescription'])); ?></p>
        </div>

        <div id="spotsWarning" class="spots-warning"></div>

        <?php if ($spotsLeft > 0): ?>
            <form id="bookingForm" class="book-form" method="POST" action="activityProcess.php">
            <input type="hidden" name="activity_id" value="<?php echo $activityId; ?>">
            <input type="hidden" name="price_per_person" value="<?php echo $activity['price']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['UID']; ?>">

            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" 
                    value="<?php echo htmlspecialchars($userEmail); ?>" readonly style="background-color: #f0f0f0; color: #666; cursor: not-allowed;" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="num_participants">Number of Participants:</label>
                <input type="number" id="num_participants" name="num_participants" 
                    min="1" max="<?php echo $spotsLeft; ?>" 
                    onchange="calculateTotal()" required>
                <small>Maximum <?php echo $spotsLeft; ?> participants available</small>
            </div>

            <div class="form-group">
                <label for="booking_date">Preferred Booking Date:</label>
                <input type="date" id="booking_date" name="booking_date" required>
            </div>

            <div class="total-section">
                <p>Price per Person: RM<span id="pricePerPerson"><?php echo number_format($activity['price'], 2); ?></span></p>
                <p class="total"><strong>Total Price: RM<span id="totalPrice">0.00</span></strong></p>
            </div>

            <button id="submitBtn" type="submit" class="submit-btn">Book Activity</button>
        </form>
        <?php else: ?>
        <div class="spots-warning" style="display: block;">
            Sorry, this activity is fully booked.
        </div>
        <?php endif; ?>
    </div>

    <?php include '../user/includes/user_Footer.php';?>

    <script>
        const spotsLeft = <?php echo $spotsLeft; ?>;
        const warningDiv = document.getElementById('spotsWarning');

        if (spotsLeft <= 5 && spotsLeft > 0) {
            warningDiv.style.display = 'block';
            warningDiv.textContent = `Only ${spotsLeft} spots left! Book soon to secure your place.`;
        }

        function calculateTotal() {
            const pricePerPerson = parseFloat(<?php echo $activity['price']; ?>);
            const numParticipants = parseInt(document.getElementById('num_participants').value) || 0;
            const total = pricePerPerson * numParticipants;
            
            document.getElementById('totalPrice').textContent = total.toFixed(2);
        }

        // Check availability before form submission
        document.getElementById('bookingForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const numParticipants = document.getElementById('num_participants').value;
            const activityId = <?php echo $activityId; ?>;
            
            try {
                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Checking availability...';
                
                const response = await fetch(`activityAvailability.php?activityID=${activityId}&participants=${numParticipants}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.available) {
                    this.submit();
                } else {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(`Sorry, only ${data.spotsAvailable} spots are available for this activity.`);
                        location.reload();
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('There was an error checking availability. Please try again.');
            } finally {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Book Activity';
            }
        });
    </script>
</body>
</html>
