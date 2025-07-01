<?php
//Suziliana Mosingkil (BI22110296)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN CREATE ACCOMMODATION</title>

    <!-- CDN Icon Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS File -->
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php

// Handle accommodation creation form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $maxCapacity = $_POST['maxCapacity'];
    $mainImage = $_POST['mainImage'];
    $secImage = $_POST['secImage'];
    $thirdImage = $_POST['thirdImage'];
    $availabilityStatus = $_POST['availabilityStatus'];
    $contactInfo = $_POST['contactInfo'];
    $keyFeatures = $_POST['keyFeatures'];

    // Insert new accommodation
    $sql_insert = "INSERT INTO accommodations 
        (name, description, location, price, max_capacity, mainImage, secImage, thirdImage, availability_status, contact_info, keyFeatures) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param(
        $stmt_insert,
        "sssdissssss",
        $name,
        $description,
        $location,
        $price,
        $maxCapacity,
        $mainImage,
        $secImage,
        $thirdImage,
        $availabilityStatus,
        $contactInfo,
        $keyFeatures
    );

    // Execute query
    if (mysqli_stmt_execute($stmt_insert)) {
        echo "
            <div id='userSuccessMessage'>
                <p>Accommodation added successfully!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                Back to Admin Dashboard
                </a>
                <br>
                <a id='viewAccommodationList' href='accommodationListing.php'>
                View Accommodation List
                </a>
                <br>
            </div>
        ";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt_insert);
    mysqli_close($conn);
    exit;
}
?>

<body>
    <!-- ADMIN SIDENAV SECTION STARTS HERE -->
    <?php include("../../includes/admin_SideNav.php"); ?>
    <!-- ADMIN SIDENAV SECTION ENDS HERE -->

    <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
    <section class="admin-dashboard">
        <div class="dashboard-container">

            <!-- ACCOMMODATION CREATE SECTION STARTS HERE -->
            <!-- Form title -->
            <h2 class="form-title">CREATE ACCOMMODATION</h2>

            <div class="admin-form">
                <form action="" method="POST">
                    <label for="name">Accommodation Name:</label>
                    <input type="text" id="name" name="name" value="" required><br><br>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea><br><br>

                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required><br><br>

                    <label for="price">Price (per night):</label>
                    <input type="number" id="price" name="price" min="0.01" step="0.01" required><br><br>

                    <label for="maxCapacity">Max Capacity:</label>
                    <input type="number" id="maxCapacity" name="maxCapacity" min="1" required><br><br>

                    <label for="mainImage">Main Image URL:</label>
                    <input type="text" id="mainImage" name="mainImage"><br><br>

                    <label for="secImage">Second Image URL:</label>
                    <input type="text" id="secImage" name="secImage"><br><br>

                    <label for="thirdImage">Third Image URL:</label>
                    <input type="text" id="thirdImage" name="thirdImage"><br><br>

                    <label for="availabilityStatus">Availability Status:</label>
                    <select id="availabilityStatus" name="availabilityStatus" required>
                        <option value="available">Available</option>
                        <option value="booked">Booked</option>
                        <option value="unavailable">Unavailable</option>
                    </select><br><br>

                    <label for="contactInfo">Contact Information:</label>
                    <input type="text" id="contactInfo" name="contactInfo" required><br><br>

                    <label for="keyFeatures">Key Features:</label>
                    <textarea id="keyFeatures" name="keyFeatures" rows="4"></textarea><br><br>

                    <button type="submit">Save Accommodation</button>
                </form>
            </div>

            <!-- ACCOMMODATION CREATE SECTION ENDS HERE -->
        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- JS File -->
    <script src="../../js/admin_Script.js"></script>
</body>

</html>
