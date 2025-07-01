
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
    <title>ADMIN CREATE PRIZE</title>

    <!-- CDN Icon Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS File -->
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php

// Handle prize creation form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prizeName = $_POST['prizeName'];
    $prizeDescription = $_POST['prizeDescription'];
    $quantity = $_POST['quantity'];

    // Insert new prize
    $sql_insert = "INSERT INTO prizes (prize_name, prize_description, quantity) 
                    VALUES (?, ?, ?)";

    $stmt_insert = mysqli_prepare($conn, $sql_insert);

    // Bind parameters to match the query
    mysqli_stmt_bind_param($stmt_insert, "ssi", 
        $prizeName, 
        $prizeDescription, 
        $quantity
    );

    // Execute query
    if (mysqli_stmt_execute($stmt_insert)) {
        echo "
            <div id='userSuccessMessage'>
                <p>Prize added successfully!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                Back to Admin Dashboard
                </a>
                <br>
                <a id='viewPrizeList' href='prizeList.php'>
                View Prize List
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

            <!-- PRIZE CREATE SECTION STARTS HERE -->
            <!-- Form title -->
            <h2 class="form-title">CREATE PRIZE</h2>

            <div class="admin-form">
                <form action="" method="POST">
                    <label for="prizeName">Prize Name:</label>
                    <input type="text" id="prizeName" name="prizeName" required><br><br>

                    <label for="prizeDescription">Prize Description:</label>
                    <textarea id="prizeDescription" name="prizeDescription" required></textarea><br><br>

                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required><br><br>

                    <button type="submit">Save Prize</button>
                </form>
            </div>

            <!-- PRIZE CREATE SECTION ENDS HERE -->
        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- JS File -->
    <script src="../../js/admin_Script.js"></script>
</body>

</html>
