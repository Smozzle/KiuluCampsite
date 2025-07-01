<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include '../user/config/user_config.php';
session_start();

try {
    $conn->begin_transaction();
    
    if (!isset($_SESSION['UID'])) {
        throw new Exception("User not logged in");
    }
    
    $price_per_person = $_POST['price_per_person'];
    $num_participants = $_POST['num_participants'];
    $total_price = $price_per_person * $num_participants;
    
    $sql = "INSERT INTO activity_bookings (
        user_id,
        activity_id, 
        booking_date, 
        guest_name, 
        guest_email, 
        guest_phone, 
        num_guests, 
        total_price, 
        booking_status,
        created_at,
        updated_at
    ) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, 'confirmed', NOW(), NOW())";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssid", 
        $_SESSION['UID'],
        $_POST['activity_id'],
        $_POST['name'],
        $_POST['email'], 
        $_POST['phone'],
        $_POST['num_participants'],
        $total_price
    );
    
    $stmt->execute();
    $conn->commit();

    echo "<script>
        alert('Booking successful!');
        window.location.href = '../index.php';
    </script>";

} catch (Exception $e) {
    $conn->rollback();
    error_log("Activity booking error: " . $e->getMessage());
    
    echo "<script>
        alert('Error: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
}
?>