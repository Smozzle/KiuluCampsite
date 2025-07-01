<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

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

$userId = $_SESSION['UID'];

// Update accommodation bookings query
$accommodationSql = "SELECT b.*, a.name as accommodation_name 
                    FROM accommodation_bookings b
                    JOIN accommodations a ON b.accommodation_id = a.id
                    WHERE b.user_id = ? 
                    AND b.check_out_date >= CURRENT_DATE
                    ORDER BY b.check_in_date ASC";

$accommodationStmt = $conn->prepare($accommodationSql);
$accommodationStmt->bind_param("i", $userId); // Changed to "i" for integer
$accommodationStmt->execute();
$accommodationResult = $accommodationStmt->get_result();

// Update activity bookings query
$activitySql = "SELECT ab.*, a.activityName, ab.booking_date, a.startTime, a.endTime
                FROM activity_bookings ab
                JOIN activity a ON ab.activity_id = a.activityID
                WHERE ab.user_id = ? 
                AND ab.booking_date >= CURRENT_DATE
                ORDER BY ab.booking_date ASC";

$activityStmt = $conn->prepare($activitySql);
$activityStmt->bind_param("i", $userId);
$activityStmt->execute();
$activityResult = $activityStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        .bookings-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        }

        .booking-section {
            margin-bottom: 40px;
        }

        .booking-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .booking-header h3 {
            margin: 0;
            color: #333;
            font-size: 1.2em;
        }

        .booking-status {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .date-badge {
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            display: inline-block;
        }

        .no-bookings {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
            color: #6c757d;
        }

        @media (max-width: 576px) {
            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .booking-status {
                align-self: flex-start;
            }
        }
    </style>
</head>
<body>
    <?php include '../user/includes/topNav.php';?>

    <div class="bookings-container">
        <h1>My Bookings</h1>

        <!-- Upcoming Stays Section -->
        <div class="booking-section">
            <h2>Upcoming Stays</h2>
            <?php if ($accommodationResult->num_rows > 0): ?>
                <?php while ($booking = $accommodationResult->fetch_assoc()): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3><?php echo htmlspecialchars($booking['accommodation_name']); ?></h3>
                            <span class="booking-status status-<?php echo strtolower($booking['booking_status']); ?>">
                                <?php echo ucfirst($booking['booking_status']); ?>
                            </span>
                        </div>
                        <div class="booking-details">
                            <div>
                                <p><strong>Check-in:</strong></p>
                                <span class="date-badge">
                                    <?php echo date('F d, Y', strtotime($booking['check_in_date'])); ?>
                                </span>
                            </div>
                            <div>
                                <p><strong>Check-out:</strong></p>
                                <span class="date-badge">
                                    <?php echo date('F d, Y', strtotime($booking['check_out_date'])); ?>
                                </span>
                            </div>
                            <div>
                                <p><strong>Guests:</strong> <?php echo $booking['num_guests']; ?></p>
                                <p><strong>Total:</strong> RM<?php echo number_format($booking['total_price'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-bookings">
                    <p>No upcoming stays found</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Upcoming Activities Section -->
        <div class="booking-section">
            <h2>Upcoming Activities</h2>
            <?php if ($activityResult->num_rows > 0): ?>
                <?php while ($activity = $activityResult->fetch_assoc()): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3><?php echo htmlspecialchars($activity['activityName']); ?></h3>
                            <span class="booking-status status-<?php echo strtolower($activity['booking_status']); ?>">
                                <?php echo ucfirst($activity['booking_status']); ?>
                            </span>
                        </div>
                        <div class="booking-details">
                            <div>
                                <p><strong>Date:</strong></p>
                                <span class="date-badge">
                                    <?php echo date('F d, Y', strtotime($activity['booking_date'])); ?>
                                </span>
                            </div>
                            <div>
                                <p><strong>Time:</strong></p>
                                <span class="date-badge">
                                    <?php 
                                        echo date('g:i A', strtotime($activity['startTime'])) . ' - ' . 
                                             date('g:i A', strtotime($activity['endTime']));
                                    ?>
                                </span>
                            </div>
                            <div>
                                <p><strong>Participants:</strong> <?php echo $activity['num_guests']; ?></p>
                                <p><strong>Total:</strong> RM<?php echo number_format($activity['total_price'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-bookings">
                    <p>No upcoming activities found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../user/includes/user_Footer.php';?>
    <script>
function openLoginPopup() {
    document.getElementById('login-popup').style.display = 'block';
    document.getElementById('register-overlay').style.display = 'block';
}

function closeLoginPopup() {
    document.getElementById('login-popup').style.display = 'none';
    document.getElementById('register-overlay').style.display = 'none';
}

// Add this to automatically show login popup if not logged in
<?php if (!isset($_SESSION["UID"])) { ?>
    // Show popup when clicking restricted content
    function checkLogin() {
        openLoginPopup();
        return false;
    }
<?php } ?>
</script>
</body>
</html>