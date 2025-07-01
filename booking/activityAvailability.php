<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include '../user/config/user_config.php';

header('Content-Type: application/json');

$activityId = isset($_GET['activityID']) ? (int)$_GET['activityID'] : 0;
$requestedParticipants = isset($_GET['participants']) ? (int)$_GET['participants'] : 0;

//Get activity max participants
$sql = "SELECT maxParticipants FROM activity WHERE activityID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $activityId);
$stmt->execute();
$result = $stmt->get_result();
$activity = $result->fetch_assoc();

if (!$activity) {
    echo json_encode(['available' => false, 'error' => 'Activity not found']);
    exit;
}

//Get current number of participants
$sql = "SELECT SUM(num_guests) as current_participants 
        FROM activity_bookings 
        WHERE activity_id = ? 
        AND booking_status != 'cancelled'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $activityId);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_assoc();

$currentParticipants = $bookings['current_participants'] ?? 0;
$spotsAvailable = $activity['maxParticipants'] - $currentParticipants; 

echo json_encode([
    'available' => $spotsAvailable >= $requestedParticipants,
    'spotsAvailable' => $spotsAvailable
]);
?>