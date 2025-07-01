<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
// include db config (admin_config.php)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD SAFETY INFO</title>

    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- css file -->
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php

// handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    // insert new safety info
    $sql_insert = "INSERT INTO safetyinfo (title, type, description, image) VALUES (?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "ssss", $title, $type, $description, $image);

    // execute query
    if (mysqli_stmt_execute($stmt_insert)) {
        echo "
            <div id='userSuccessMessage'>
                <p>Safety information added successfully!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                    Back to Admin Dashboard
                </a>
                <br>
                <a id='viewSafetyList' href='safety_list.php'>
                    View Safety List
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

            <!-- SAFETY ADD SECTION STARTS HERE -->
            <!-- form add title -->
            <h2 class="form-title">ADD SAFETY INFO</h2>

            <div class="admin-form">
                <form action="" method="POST">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="" required><br><br>

                    <label for="type">Type:</label>
                    <input type="text" id="type" name="type" value="" required><br><br>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="5" required></textarea><br><br>

                    <label for="image">Image Path:</label>
                    <input type="text" id="image" name="image" value="" required><br><br>

                    <button type="submit">Save</button>
                </form>
            </div>

            <!-- SAFETY ADD SECTION ENDS HERE -->
        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- js file -->
    <script src="../../js/admin_Script.js"></script>
</body>

</html>
