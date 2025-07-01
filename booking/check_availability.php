<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include '../user/config/user_config.php';

header('Content-Type: application/json');

// Input validation
$accommodationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$checkinDate = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkoutDate = isset($_GET['checkout']) ? $_GET['checkout'] : '';

// First check if accommodation exists and get its details
$accommodationSql = "SELECT a.*, al.quantity 
                     FROM accommodations a
                     LEFT JOIN accommodation_limit al ON a.id = al.accommodation_id
                     WHERE a.id = ? AND a.availability_status = 'available'";
$stmt = $conn->prepare($accommodationSql);
$stmt->bind_param("i", $accommodationId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'available' => false,
        'error' => 'Accommodation not found or not available'
    ]);
    exit;
}

$accommodationData = $result->fetch_assoc();
$totalQuantity = $accommodationData['quantity'] ?? 0;

// Validate dates
if (!DateTime::createFromFormat('Y-m-d', $checkinDate) || 
    !DateTime::createFromFormat('Y-m-d', $checkoutDate)) {
    echo json_encode([
        'available' => false,
        'error' => 'Invalid date format'
    ]);
    exit;
}

// Check if checkin is before checkout and not the previous days
$today = new DateTime();
$today->setTime(0, 0, 0);
$checkinDateTime = new DateTime($checkinDate);
$checkoutDateTime = new DateTime($checkoutDate);

if ($checkinDateTime < $today) {
    echo json_encode([
        'available' => false,
        'error' => 'Check-in date cannot be in the past'
    ]);
    exit;
}

if ($checkinDateTime >= $checkoutDateTime) {
    echo json_encode([
        'available' => false,
        'error' => 'Check-in must be before check-out'
    ]);
    exit;
}

// Check availability for each day in the date range
$sql = 'WITH RECURSIVE dates AS (
    SELECT ? as date
    UNION ALL
    SELECT DATE_ADD(date, INTERVAL 1 DAY)
    FROM dates
    WHERE date < ?
),
daily_bookings AS (
    SELECT dates.date, COUNT(b.id) as booking_count
    FROM dates
    LEFT JOIN accommodation_bookings b ON dates.date >= b.check_in_date 
        AND dates.date < b.check_out_date
        AND b.accommodation_id = ?
        AND b.booking_status IN ("pending", "confirmed")
    GROUP BY dates.date
)
SELECT 
    date,
    booking_count,
    ? as total_quantity,
    CASE WHEN booking_count >= ? THEN false ELSE true END as is_available
FROM daily_bookings
HAVING is_available = false
LIMIT 1';

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiii", 
    $checkinDate,
    $checkoutDate,
    $accommodationId,
    $totalQuantity,
    $totalQuantity
);

$stmt->execute();
$result = $stmt->get_result();
$unavailable_date = $result->fetch_assoc();

$available = !$unavailable_date;

// Return response with accommodation details
echo json_encode([
    'available' => $available,
    'unavailable_date' => $unavailable_date ? $unavailable_date['date'] : null,
    'accommodation' => [
        'id' => $accommodationData['id'],
        'name' => $accommodationData['name'],
        'price' => $accommodationData['price'],
        'max_capacity' => $accommodationData['max_capacity'],
        'total_quantity' => $totalQuantity
    ],
    'dates' => [
        'check_in' => $checkinDate,
        'check_out' => $checkoutDate,
        'total_nights' => $checkinDateTime->diff($checkoutDateTime)->days
    ]
]);