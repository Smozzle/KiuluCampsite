
<?php
//ALVINA ALPHONSUS BI22110003
session_start();
include 'C:/xampp/htdocs/KIULU-CAMPSITE/user/config/user_config.php';

// Check if user is logged in
if (!isset($_SESSION['UID'])) {
    header("Location: user/userAuth/login_popup.php");
    exit();
}

$userID = $_SESSION['UID'];

// Fetch user's unredeemed prizes with prize details
$unredeemedQuery = "
    SELECT ld.luckyDrawID, ld.draw_date, p.prize_name, p.prize_description 
    FROM lucky_draw ld
    JOIN prizes p ON ld.luckyDrawID = p.luckyDrawID
    WHERE ld.userID = ? AND ld.redeemed = 0
";
$unredeemedStmt = $conn->prepare($unredeemedQuery);
$unredeemedStmt->bind_param("i", $userID);
$unredeemedStmt->execute();
$unredeemedResult = $unredeemedStmt->get_result();
$unredeemedPrizes = $unredeemedResult->fetch_all(MYSQLI_ASSOC);

// Fetch user's redeemed prizes
$redeemedQuery = "
    SELECT ld.luckyDrawID, ld.draw_date, p.prize_name, p.prize_description 
    FROM lucky_draw ld
    JOIN prizes p ON ld.luckyDrawID = p.luckyDrawID
    WHERE ld.userID = ? AND ld.redeemed = 1
";
$redeemedStmt = $conn->prepare($redeemedQuery);
$redeemedStmt->bind_param("i", $userID);
$redeemedStmt->execute();
$redeemedResult = $redeemedStmt->get_result();
$redeemedPrizes = $redeemedResult->fetch_all(MYSQLI_ASSOC);

// Handle prize redemption
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redeem_prize'])) {
    $luckyDrawID = $_POST['luckyDrawID'];
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Update prize as redeemed
        $updateQuery = "UPDATE lucky_draw SET redeemed = 1 WHERE luckyDrawID = ? AND userID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ii", $luckyDrawID, $userID);
        $updateStmt->execute();
        
        // Decrease prize quantity
        $decreaseQuantityQuery = "UPDATE prizes SET quantity = quantity - 1 WHERE luckyDrawID = ?";
        $decreaseStmt = $conn->prepare($decreaseQuantityQuery);
        $decreaseStmt->bind_param("i", $luckyDrawID);
        $decreaseStmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        header("Location: voucher.php?message=Prize redeemed successfully!");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        header("Location: voucher.php?error=Redemption failed");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../user/css/user_style.css">
    <title>KIULU CAMPSITE - My Vouchers</title>
    <style>
        /* (Previous CSS remains the same) */
        .prize-description {
            color: #666;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include '../user/includes/topNav.php';?>

    <section class="voucher__container section__container">
        <div class="voucher__content">
            <div class="voucher__header">
                <h2 class="section__header">🎉 My Lucky Draw Vouchers 🎉</h2>
                <p class="section__description">Claim your exciting prizes from our Lucky Draw!</p>
            </div>

            <?php if (empty($unredeemedPrizes) && empty($redeemedPrizes)): ?>
                <div class="no-prizes">
                    <div class="no-prizes-content">
                        <h3>No Prizes Yet</h3>
                        <p>You haven't won any prizes in our Lucky Draw. Keep trying!</p>
                        <a href="luckyprize.php" class="btn">Join Lucky Draw</a>
                    </div>
                </div>
            <?php else: ?>
                <?php if (!empty($unredeemedPrizes)): ?>
                    <h3 class="section__header" style="text-align: center; margin-bottom: 1.5rem;">Unredeemed Prizes</h3>
                    <div class="voucher__grid">
                        <?php foreach ($unredeemedPrizes as $prize): ?>
                            <div class="voucher__card voucher__unredeemed">
                                <div class="voucher__card-header">
                                    <span class="voucher__icon"><i class="ri-gift-line"></i></span>
                                    <span><?php echo date('F j, Y', strtotime($prize['draw_date'])); ?></span>
                                </div>
                                <h3><?php echo htmlspecialchars($prize['prize_name']); ?></h3>
                                <p class="prize-description"><?php echo htmlspecialchars($prize['prize_description']); ?></p>
                                <form method="post" class="voucher__form">
                                    <input type="hidden" name="luckyDrawID" value="<?php echo $prize['luckyDrawID']; ?>">
                                    <button type="submit" name="redeem_prize" class="redeem-btn">
                                        Redeem Prize
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($redeemedPrizes)): ?>
                    <h3 class="section__header" style="text-align: center; margin-top: 2rem; margin-bottom: 1.5rem;">Redeemed Prizes</h3>
                    <div class="voucher__grid">
                        <?php foreach ($redeemedPrizes as $prize): ?>
                            <div class="voucher__card voucher__redeemed">
                                <div class="voucher__card-header">
                                    <span class="voucher__icon"><i class="ri-gift-fill"></i></span>
                                    <span><?php echo date('F j, Y', strtotime($prize['draw_date'])); ?></span>
                                </div>
                                <h3><?php echo htmlspecialchars($prize['prize_name']); ?></h3>
                                <p class="prize-description"><?php echo htmlspecialchars($prize['prize_description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php include '../user/includes/user_Footer.php';?>
</body>
<style>
    .no-prizes {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    .no-prizes-content {
        background-color: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
    }

    .no-prizes-content h3 {
        margin-bottom: 1rem;
        color: #1b8c46;
    }

    .no-prizes-content p {
        margin-bottom: 1.5rem;
        color: #666;
    }
</style>
</html>
