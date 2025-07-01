
<?php
//ALVINA ALPHONSUS BI22110003
session_start();
include 'C:/xampp/htdocs/KIULU-CAMPSITE/user/config/user_config.php';

$isLoggedIn = isset($_SESSION['UID']);

// Check if the user is logged in
if (!$isLoggedIn) {
    // If not logged in, show the login popup
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("login-popup").style.display = "block";
            document.getElementById("register-overlay").style.display = "block";
        });
    </script>';
    include 'C:/xampp/htdocs/KIULU-CAMPSITE/user/userAuth/login_popup.php';
    exit;
}

$userID = $_SESSION['UID'];

// Check how many times the user has played today
$today = date('Y-m-d');
$checkQuery = "SELECT COUNT(*) AS play_count FROM lucky_draw WHERE userID = ? AND draw_date = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("is", $userID, $today);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
$playCount = $checkResult->fetch_assoc()['play_count'];

if ($playCount >= 3) {
    $message = "You have reached your limit of 3 plays for today. Please come back tomorrow!";
} else {
    // Fetch available prizes
    $query = "SELECT * FROM prizes WHERE quantity > 0";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $prizes = [];
        while ($row = $result->fetch_assoc()) {
            $prizes[] = $row;
        }
    } else {
        $prizes = [];
        $message = "No prizes available at the moment. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Prize Picker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../user/css/user_style.css">
    <style>
        .register-x-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }

        .login-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            cursor: pointer;
            color: #333;
        }

        .prize-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f1f1f1;
        }

        .prize-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 50%;
            max-width: 600px;
        }

        .prize-container h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .prize-container p {
            font-size: 18px;
            color: #555;
        }

        /* Prize Picker Styles */
        .prize-picker {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .prize-item {
            width: 100px;
            height: 100px;
            margin: 10px;
            background-color: #ff6600;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .prize-item:hover {
            transform: scale(1.1);
        }

        .result-display {
            display: none;
            margin-top: 20px;
            font-size: 1.2em;
            color: #333;
        }

        .result-display span {
            color: #ff6600;
            font-weight: bold;
        }

        /* Back to Home Button */
        .back-to-home-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px; /* Ensure this margin moves the button below */
            transition: background-color 0.3s;
        }

        .back-to-home-btn:hover {
            background-color: #45a049;
        }

        /* Redeem Information */
        .redeem-info {
            margin-top: 15px;
            font-size: 16px;
            color: #555;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="prize-box">
        <div class="prize-container">
            <h2>Pick a Prize Box!</h2>
            <p>Click on any box to pick a random prize! 🎁</p>

            <?php if (isset($message)): ?>
                <p><?php echo $message; ?></p>
            <?php else: ?>
                <div class="prize-picker" id="prizePicker">
                    <!-- Prize boxes, each triggering a random prize when clicked -->
                    <div class="prize-item" onclick="pickPrize()">Pick Box 1</div>
                    <div class="prize-item" onclick="pickPrize()">Pick Box 2</div>
                    <div class="prize-item" onclick="pickPrize()">Pick Box 3</div>
                    <div class="prize-item" onclick="pickPrize()">Pick Box 4</div>
                </div>

                <div class="result-display" id="resultDisplay">
                    You won: <span id="pickedPrize"></span>
                    <div class="redeem-info">
                        Please redeem at the counter at the campsite. 🏕️
                    </div>
                    <!-- Back to Home Button -->
                    <button class="back-to-home-btn" onclick="window.location.href = 'voucher.php';">Go To Voucher</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!$isLoggedIn): ?>
    <div id="register-overlay" class="register-x-overlay"></div>
    <div id="login-popup" class="login-popup">
        <span class="close-popup" onclick="closeLoginPopup()">✖</span>
        <?php include 'C:/xampp/htdocs/KIULU-CAMPSITE/user/userAuth/login_popup.php'; ?>
    </div>
    <?php endif; ?>

    <script>
        function closeLoginPopup() {
            document.getElementById('login-popup').style.display = 'none';
            document.getElementById('register-overlay').style.display = 'none';
        }

        function pickPrize() {
            // Randomly select a prize from the available prizes
            const prizes = <?php echo json_encode($prizes); ?>;
            const randomPrize = prizes[Math.floor(Math.random() * prizes.length)];

            // Hide the prize picker and show the result
            document.getElementById('prizePicker').style.display = 'none';
            document.getElementById('resultDisplay').style.display = 'block';

            // Set the picked prize
            document.getElementById('pickedPrize').textContent = randomPrize.prize_name;

            // Insert into lucky_draw table
            const userID = <?php echo $_SESSION['UID']; ?>;
            const prizeName = randomPrize.prize_name;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_prize.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('userID=' + userID + '&prize_name=' + prizeName);
        }
    </script>
</body>
</html>

