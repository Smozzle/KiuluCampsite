<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include '../user/config/user_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->begin_transaction();

        // Get user_id from session or lookup
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            // Look up user by email
            $user_query = "SELECT userID FROM user WHERE userEmail = ?";
            $user_stmt = $conn->prepare($user_query);
            $user_stmt->bind_param("s", $_POST['email']);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            
            if ($user_result->num_rows > 0) {
                $user_row = $user_result->fetch_assoc();
                $user_id = $user_row['userID'];
            } else {
                throw new Exception("User not found");
            }
        }

        $accommodation_id = $_POST['accommodation_id'];
        $check_in_date = $_POST['selected_checkin'];
        $check_out_date = $_POST['selected_checkout'];
        $guest_name = $_POST['name'];
        $guest_email = $_POST['email'];
        $guest_phone = $_POST['phone'];
        $num_guests = $_POST['num_people'];

        $check_in = new DateTime($check_in_date);
        $check_out = new DateTime($check_out_date);
        $nights = $check_in->diff($check_out)->days;

        $base_query = "SELECT price FROM accommodations WHERE id = ?";
        $base_stmt = $conn->prepare($base_query);
        $base_stmt->bind_param("i", $accommodation_id);
        $base_stmt->execute();
        $base_result = $base_stmt->get_result();
        $base_row = $base_result->fetch_assoc();
        
        $total_price = floatval($base_row['price']) * $nights;

        if (isset($_POST['amenities']) && is_array($_POST['amenities'])) {
            foreach ($_POST['amenities'] as $amenity_id) {
                $quantity = isset($_POST['quantity_' . $amenity_id]) ? (int)$_POST['quantity_' . $amenity_id] : 1;
                if ($quantity <= 0) continue;
                
                $amenity_query = "SELECT price, unit FROM Amenities WHERE id = ?";
                $amenity_stmt = $conn->prepare($amenity_query);
                $amenity_stmt->bind_param("i", $amenity_id);
                $amenity_stmt->execute();
                $amenity_result = $amenity_stmt->get_result();
                $amenity = $amenity_result->fetch_assoc();
                
                $amenity_price = floatval($amenity['price']);
                if (stripos($amenity['unit'], 'per person') !== false) {
                    $total_price += $amenity_price * $quantity * $num_guests;
                } else {
                    $total_price += $amenity_price * $quantity;
                }
            }
        }

        $sql = "INSERT INTO accommodation_bookings (
            user_id,
            accommodation_id, 
            check_in_date, 
            check_out_date, 
            guest_name, 
            guest_email, 
            guest_phone, 
            num_guests, 
            total_price, 
            booking_status,
            created_at,
            updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssssid", 
            $user_id,
            $accommodation_id,
            $check_in_date,
            $check_out_date,
            $guest_name,
            $guest_email,
            $guest_phone,
            $num_guests,
            $total_price
        );
    
        if (!$stmt->execute()) {
            throw new Exception("Error inserting booking: " . $stmt->error);
        }
        
        $booking_id = $conn->insert_id;

        if (isset($_POST['amenities']) && is_array($_POST['amenities'])) {
            $amenity_sql = "INSERT INTO booking_amenities (booking_id, amenity_id, quantity, price_at_booking, total_amount) 
                           VALUES (?, ?, ?, ?, ?)";
            
            $amenity_stmt = $conn->prepare($amenity_sql);
            
            foreach ($_POST['amenities'] as $amenity_id) {
                $quantity = isset($_POST['quantity_' . $amenity_id]) ? (int)$_POST['quantity_' . $amenity_id] : 1;
                if ($quantity <= 0) continue;
                
                $amenity_query = "SELECT price FROM Amenities WHERE id = ?";
                $price_stmt = $conn->prepare($amenity_query);
                $price_stmt->bind_param("i", $amenity_id);
                $price_stmt->execute();
                $price_result = $price_stmt->get_result();
                $price_row = $price_result->fetch_assoc();
                
                $price_at_booking = $price_row['price'];
                $total_amount = $price_at_booking * $quantity;
                
                $amenity_stmt->bind_param("iiddd", 
                    $booking_id, 
                    $amenity_id, 
                    $quantity, 
                    $price_at_booking, 
                    $total_amount
                );
                
                if (!$amenity_stmt->execute()) {
                    throw new Exception("Error inserting amenity: " . $amenity_stmt->error);
                }
            }
        }

        $conn->commit();
        ?>
        <script>
            alert('Booking Successful! Your booking ID is: <?php echo $booking_id; ?>');
            window.location.href = '../index.php';
        </script>
        <?php
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        ?>
        <script>
        alert('Error processing booking: <?php echo htmlspecialchars($e->getMessage()); ?>');
        </script>
        <?php
    }
} else if (isset($_GET['id'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
    
    $accommodationId = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO accommodation_bookings (user_id, accommodation_id, booking_status) VALUES (?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $accommodationId);
    
    if ($stmt->execute()) {
        $bookingId = $conn->insert_id;
        header("Location: booking.php?bookingID=" . $bookingId);
        exit();
    } else {
        echo "Error creating booking. Please try again.";
    }
}
?>