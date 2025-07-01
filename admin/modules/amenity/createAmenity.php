<?php
//ALVINA ALPHONSUS BI22110003
// Include database config
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN CREATE AMENITY</title>

    <!-- CDN Icon Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS File -->
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// Handle amenity creation form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amenityName = $_POST['amenityName'];
    $amenityDescription = $_POST['amenityDescription'];
    $amenityPrice = $_POST['amenityPrice'];
    $amenityUnit = $_POST['amenityUnit'];

    // Insert new amenity
    $sql_insert = "INSERT INTO amenities (name, description, price, unit) VALUES (?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "ssds", $amenityName, $amenityDescription, $amenityPrice, $amenityUnit);

    // Execute query
    if (mysqli_stmt_execute($stmt_insert)) {
        echo "
            <div id='userSuccessMessage'>
                <p>Amenity Added Successfully!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                    Back to Admin Dashboard
                </a>
                <br>
                <a id='viewAmenityList' href='amenitiesListing.php'>
                    View Amenities List
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

            <!-- AMENITY CREATE SECTION STARTS HERE -->
            <h2 class="form-title">CREATE AMENITY</h2>

            <div class="admin-form">
                <form action="" method="POST">
                    <label for="amenityName">Amenity Name:</label>
                    <input type="text" id="amenityName" name="amenityName" value="" required><br><br>

                    <label for="amenityDescription">Amenity Description:</label>
                    <textarea id="amenityDescription" name="amenityDescription" rows="4" required></textarea><br><br>

                    <label for="amenityPrice">Amenity Price:</label>
                    <input type="number" id="amenityPrice" name="amenityPrice" min="0.01" step="0.01" required><br><br>

                    <label for="amenityUnit">Amenity Unit:</label>
                    <input type="text" id="amenityUnit" name="amenityUnit" value="" required><br><br>

                    <button type="submit">Save Amenity</button>
                </form>
            </div>

            <!-- AMENITY CREATE SECTION ENDS HERE -->
        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- JS File -->
    <script src="../../js/admin_Script.js"></script>
</body>

</html>
