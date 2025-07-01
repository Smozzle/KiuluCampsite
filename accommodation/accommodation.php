<?php
//Suziliana Mosingkil (BI22110296)
include '../user/config/user_config.php';

// Fetch all accommodations
$sql = "SELECT id, name, description, location, price, max_capacity, availability_status, contact_info, keyFeatures, mainImage, secImage, thirdImage FROM accommodations";
$result = $conn->query($sql);

// Default values
$defaultImage = '../user/img/default.jpg';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <title>Accommodations</title>
    <style>
        .accommodation-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .accommodation-item {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        margin-bottom: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        background-color: rgb(255, 255, 255);
        transition: all 0.3s ease; /* Smooth transition for all properties */
        }

        .accommodation-item:hover {
            background-color: rgb(244, 244, 244); /* Slightly darker background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Larger shadow effect */
            transform: translateY(-5px); /* Slightly lift the element */
        }


        .accommodation-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .accommodation-image img {
            width: 100%;
            border-radius: 8px;
            height: 200px;
            object-fit: cover;
        }

        .accommodation-info {
            flex: 1;
            margin-left: 1rem;
        }

        .accommodation-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .accommodation-location {
            color: #666;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #4CAF50;
        }

        .book-now-btn {
            background-color:rgb(110, 199, 113);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 1rem;
        }

        .book-now-btn:hover {
            background-color: #45a049;
        }

        .accommodation-body {
            margin-top: 1rem;
        }

        .description-text,
        .features-section,
        .property-details {
            margin-bottom: 1rem;
            margin-top: 0;
        }

        .features-list {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-top: 0.5rem;
        }

        .features-list li {
            color: #666;
            line-height: 1.5;
        }

        .property-details li {
            color: #666;
            line-height: 1.5;
        }

        .property-details i {
            margin-right: 0.5rem;
        }

        .amenities-reviews-container {
            display: flex;
            gap: 20px;
            /* Space between sections */
            max-width: 1200px;
            margin: 2rem auto;
        }

        .amenities-section,
        .reviews-section {
            flex: 1;
            /* Equal width for both sections */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .amenities-reviews-container {
                flex-direction: column;
                /* Stack vertically on smaller screens */
            }
        }
    </style>
</head>

<body>
    <?php include '../user/includes/topNav.php'; ?>
    
    <section class="accommodation-container">
        <h1>Accommodations</h1>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Set default images if not provided
                $mainImage = !empty($row['mainImage']) ? $row['mainImage'] : $defaultImage;
                $secImage = !empty($row['secImage']) ? $row['secImage'] : $defaultImage;
                $thirdImage = !empty($row['thirdImage']) ? $row['thirdImage'] : $defaultImage;

                // Split key features into array
                $keyFeaturesList = explode("\n", $row['keyFeatures']);
                ?>

                <div class="accommodation-item">
                    <!-- Header with title, location, price, and book button -->
                    <div class="accommodation-header">
                        <div class="accommodation-image">
                            <img style = "width: 200px; height: 200px;" src="<?php echo htmlspecialchars($mainImage); ?>" alt="Accommodation Image">
                        </div>
                        <div class="accommodation-info">
                            <h2 class="accommodation-title" style="margin-bottom: 20px; margin-top:10px;"><?php echo htmlspecialchars($row['name']); ?></h2>
                            <p class="accommodation-location" style = "margin-bottom: 10px;"><?php echo htmlspecialchars($row['location']); ?></p>
                            <div class="price">RM<?php echo number_format($row['price'], 2); ?> per night</div>

                            <!-- Book Now button with link to booking.php -->
                            <a href="../booking/accommodationBooking.php?id=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['name']); ?>">
                                <button
                                    class="book-now-btn <?php echo $row['availability_status'] !== 'available' ? 'disabled' : ''; ?>"
                                    <?php echo $row['availability_status'] !== 'available' ? 'disabled' : ''; ?>>
                                    <?php echo $row['availability_status'] === 'available' ? 'Book Now' : 'Not Available'; ?>
                                </button>
                            </a>

                            <!-- View Reviews button -->
                            <a href="accommodationReview.php?id=<?php echo $row['id']; ?>">
                                <button class="book-now-btn" style="background-color:rgb(138, 138, 138); margin-top: 10px;">
                                    View Reviews
                                </button>
                            </a>

                        </div>
                    </div>

                    <!-- Accommodation Body: Description, Key Features, and Property Details -->
                    <div class="accommodation-body">
                        <div class="description-text">
                            <h3 style = "margin-bottom: 10px;">Description</h3>
                            <p style = "line-height: 1.7;"><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>

                        <div class="features-section">
                            <h3>Key Features:</h3>
                            <ul class="features-list">
                                <?php
                                foreach ($keyFeaturesList as $feature) {
                                    echo '<li>' . htmlspecialchars($feature) . '</li>';
                                }
                                ?>
                            </ul>
                        </div>

                        <div class="property-details">
                            <h3 style = "margin-bottom: 10px;">Property Details</h3>
                            <ul>
                                <li style = "margin-bottom: 4px;"><i class="bi bi-people"></i> Max Capacity: <?php echo $row['max_capacity']; ?> persons</li>
                                <li style = "margin-bottom: 4px;"><i class="bi bi-telephone"></i> Contact:
                                    <?php echo htmlspecialchars($row['contact_info']); ?>
                                </li>
                                <li style = "margin-bottom: 4px;"><i class="bi bi-check-circle"></i> Status:
                                    <?php echo ucfirst($row['availability_status']); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <?php
            }
        } else {
            echo "<p>No accommodations found.</p>";
        }
        ?>
    </section>
    <div class="amenities-reviews-container">
        <div class="amenities-section">
            <?php include '../accommodation/amenities.php'; ?>
        </div>
        <div class="reviews-section">
            <?php include '../accommodation/review.php'; ?>
        </div>
    </div>
    <?php include '../user/includes/user_Footer.php'; ?>

</body>

</html>

<?php
// Close connection
$conn->close();
?>
