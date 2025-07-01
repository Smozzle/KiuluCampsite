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

$accommodationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$accommodationName = isset($_GET['name']) ? $_GET['name'] : '';
$userSql = "SELECT userEmail FROM user WHERE userID = ?";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("i", $_SESSION['UID']);
$userStmt->execute();
$userEmail = $userStmt->get_result()->fetch_assoc()['userEmail'];

$sql = "SELECT id, name, price FROM accommodations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $accommodationId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
   die("Accommodation not found");
}

$accommodation = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo htmlspecialchars($accommodationName); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        .booking-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .booking-header {
            text-align: center;
            margin-bottom: 20px;
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
        .date-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        #checkAvailability, #submit {
            display: block;  
            margin: 20px auto; /*center*/
            width: fit-content; 
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .availability-message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: none;
        }

        .amenities-section {
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
        }

        .amenity-item {
            margin-bottom: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }

        .pricing-note {
            display: block;
            color: #666;
            font-size: 0.9em;
            margin-left: 25px;
        }

        .quantity-input {
            margin-left: 25px;
            margin-top: 5px;
        }

        .total-section {
            margin-top: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 4px;
        }

        .total-section p {
            margin: 5px 0;
        }

        .total-section .total {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
    </style>
    </head>
    <body>
    <?php include '../user/includes/topNav.php';?>
    <div class="booking-container" style="padding-top: 40px">
        <div class="booking-header">
            <h1><?php echo htmlspecialchars($accommodationName); ?></h1>
        </div>

        <div class="date-inputs">
            <div class="form-group">
                <label for="checkin">Check-in Date:</label>
                <input type="date" id="checkin" name="checkin" 
                    min="<?php echo date('Y-m-d'); ?>" 
                    onchange="updateCheckoutMin()" required>
            </div>

            <div class="form-group">
                <label for="checkout">Check-out Date:</label>
                <input type="date" id="checkout" name="checkout"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
            </div>
        </div>
        <button id="checkAvailability" onclick="checkDateAvailability()">Check Availability</button>

        <div id="availabilityMessage" class="availability-message"></div>

        <form id="bookingForm" class="book-form" method="POST" action="processBooking.php" style="display: none;">
            <input type="hidden" name="accommodation_id" value="<?php echo $accommodationId; ?>">
            <input type="hidden" name="selected_checkin" id="selected_checkin">
            <input type="hidden" name="selected_checkout" id="selected_checkout">
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
                <label for="num_people">Number of People:</label>
                <input type="number" id="num_people" name="num_people" 
                    min="1" max="10" required>
            </div>

            <div class="form-group amenities-section">
                <h3>Additional Amenities</h3>
                <?php
                $amenities_sql = "SELECT * FROM Amenities ORDER BY name";
                $amenities_result = mysqli_query($conn, $amenities_sql);
                
                while ($amenity = mysqli_fetch_assoc($amenities_result)) {
                    ?>
                    <div class="amenity-item">
                        <label>
                            <input type="checkbox" name="amenities[]" 
                                value="<?php echo $amenity['id']; ?>" 
                                onchange="calculateTotal()">
                            <?php echo htmlspecialchars($amenity['name']); ?> - 
                            RM<?php echo number_format($amenity['price'], 2); ?> 
                            <?php echo htmlspecialchars($amenity['unit']); ?>
                        </label>
                        
                        <?php if (stripos($amenity['name'], 'Kitchen') !== false): ?>
                            <small class="pricing-note">
                                <?php if (stripos($amenity['unit'], 'per person') !== false): ?>
                                    (Applies for groups larger than 25 people)
                                <?php else: ?>
                                    (For groups up to 25 people)
                                <?php endif; ?>
                            </small>
                        <?php endif; ?>
                        
                        <?php if ($amenity['unit'] === 'each'): ?>
                            <div class="quantity-input" style="display: none;">
                                <label>Quantity: 
                                    <input type="number" name="quantity_<?php echo $amenity['id']; ?>" 
                                        min="0" value="0" onchange="calculateTotal()">
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php } ?>
    
                <div class="total-section">
                    <p>Base Price: RM<span id="basePrice"><?php echo number_format($accommodation['price'], 2); ?></span></p>
                    <p>Additional Amenities: RM<span id="amenitiesTotal">0.00</span></p>
                    <p class="total"><strong>Total Price: RM<span id="totalPrice"><?php echo number_format($accommodation['price'], 2); ?></span></strong></p>
                </div>
            </div>
            <button id="submit" type="submit" class="submit-btn">Confirm Booking</button>
        </form>
    </div>
    <?php include '../user/includes/user_Footer.php';?>
    
    <script>
        function updateCheckoutMin() {
            const checkinInput = document.getElementById('checkin');
            const checkoutInput = document.getElementById('checkout');
            
            // Set minimum checkout date to be the day after checkin
            const checkinDate = new Date(checkinInput.value);
            const minCheckoutDate = new Date(checkinDate);
            minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
            
            checkoutInput.min = minCheckoutDate.toISOString().split('T')[0];
            
            // If current checkout date is before new minimum, update it
            if (new Date(checkoutInput.value) <= checkinDate) {
                checkoutInput.value = minCheckoutDate.toISOString().split('T')[0];
            }
            
            calculateTotal();
        }


        function checkDateAvailability() {
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;
            const accommodationId = <?php echo $accommodationId; ?>;

            if (!checkin || !checkout) {
                alert('Please select both check-in and check-out dates');
                return;
            }

            // AJAX request to check availability
            fetch(`check_availability.php?id=${accommodationId}&checkin=${checkin}&checkout=${checkout}`)
                .then(response => response.json())
                .then(data => {
                    const messageDiv = document.getElementById('availabilityMessage');
                    const bookingForm = document.getElementById('bookingForm');
                    
                    messageDiv.style.display = 'block';
                    
                    if (data.available) {
                        messageDiv.style.backgroundColor = '#d4edda';
                        messageDiv.style.color = '#155724';
                        messageDiv.textContent = 'Dates are available! You can proceed with booking.';
                        bookingForm.style.display = 'block';
                        // Update hidden fields with selected dates
                        document.getElementById('selected_checkin').value = checkin;
                        document.getElementById('selected_checkout').value = checkout;
                    } else {
                        messageDiv.style.backgroundColor = '#f8d7da';
                        messageDiv.style.color = '#721c24';
                        messageDiv.textContent = 'Sorry, these dates are not available.';
                        bookingForm.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Show/hide quantity inputs when checkboxes are clicked
                document.querySelectorAll('input[name="amenities[]"]').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const quantityDiv = this.closest('.amenity-item').querySelector('.quantity-input');
                        if (quantityDiv) {
                            quantityDiv.style.display = this.checked ? 'block' : 'none';
                            if (!this.checked) {
                                quantityDiv.querySelector('input[type="number"]').value = 0;
                            }
                        }
                    });
                });
            });

            function calculateTotal() {
                const basePrice = parseFloat(document.getElementById('basePrice').textContent);
                const numPeople = parseInt(document.getElementById('num_people').value) || 0;
                const checkin = document.getElementById('checkin').value;
                const checkout = document.getElementById('checkout').value;
                const selectedAmenities = [];
                const quantities = {};

                document.querySelectorAll('input[name="amenities[]"]:checked').forEach(checkbox => {
                    selectedAmenities.push(checkbox.value);
                    const quantityInput = document.querySelector(`input[name="quantity_${checkbox.value}"]`);
                    if (quantityInput) {
                        quantities[checkbox.value] = parseInt(quantityInput.value) || 0;
                    }
                });

                const formData = new FormData();
                formData.append('base_price', basePrice);
                formData.append('num_people', numPeople);
                formData.append('checkin', checkin);
                formData.append('checkout', checkout);
                formData.append('amenities', JSON.stringify(selectedAmenities));
                formData.append('quantities', JSON.stringify(quantities));

                fetch('calculatePrice.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('amenitiesTotal').textContent = data.amenities_total;
                    document.getElementById('totalPrice').textContent = data.total_price;
                })
                .catch(error => console.error('Error:', error));
            }
            // Add event listener to number of people input
            document.getElementById('num_people').addEventListener('change', calculateTotal);
    </script>
    </body>
</html>
