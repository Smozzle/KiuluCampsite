<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include '../user/config/user_config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $base_price = isset($_POST['base_price']) ? floatval($_POST['base_price']) : 0;
    $num_people = isset($_POST['num_people']) ? intval($_POST['num_people']) : 0;
    $amenities = json_decode($_POST['amenities'], true) ?? [];
    $quantities = json_decode($_POST['quantities'], true) ?? [];
    $checkin = new DateTime($_POST['checkin']);
    $checkout = new DateTime($_POST['checkout']);
    $nights = $checkin->diff($checkout)->days;

    $total_amenities = 0;
    $amenities_breakdown = [];

    foreach ($amenities as $amenity_id) {
        $stmt = $conn->prepare("SELECT name, price, unit FROM Amenities WHERE id = ?");
        $stmt->bind_param("i", $amenity_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $amenity = $result->fetch_assoc();

        if ($amenity) {
            $quantity = isset($quantities[$amenity_id]) ? intval($quantities[$amenity_id]) : 1;
            $price = $amenity['price'];
            $amount = 0;

            if ($amenity['unit'] === 'per person') {
                $amount = $price * $num_people * $nights;
            } elseif ($amenity['unit'] === 'each') {
                $amount = $price * $quantity * $nights;
            } else {
                $amount = $price * $nights;
            }

            $total_amenities += $amount;
            $amenities_breakdown[] = [
                'name' => $amenity['name'],
                'quantity' => $quantity,
                'price' => $price,
                'total' => $amount
            ];
        }
        $stmt->close();
    }

    $total = $base_price + $total_amenities;

    echo json_encode([
        'base_price' => number_format($base_price, 2),
        'amenities_total' => number_format($total_amenities, 2),
        'total_price' => number_format($total, 2),
        'nights' => $nights,
        'amenities_breakdown' => $amenities_breakdown
    ]);
    exit;
}
?>