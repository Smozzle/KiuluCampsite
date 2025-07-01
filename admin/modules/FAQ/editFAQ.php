<?php
//Suziliana Mosingkil (BI22110296)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN EDIT FAQ</title>

    <!-- cdn icon link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- css file -->
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php
// Check if ID is provided
if (isset($_GET['id'])) {
    $faqID = intval($_GET['id']);

    // Retrieve the existing FAQ data using prepared statement
    $sql = "SELECT * FROM faqs WHERE id = ?";
    $stmt_select = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt_select, "i", $faqID);
    mysqli_stmt_execute($stmt_select);
    $result = mysqli_stmt_get_result($stmt_select);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $email = $row['email'];
        $message = $row['message'];
        $created_at = $row['created_at'];
    } else {
        echo "FAQ not found.";
        exit;
    }
    mysqli_stmt_close($stmt_select);
} else {
    echo "Invalid Request.";
    exit;
}

// Handle FAQ update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Update FAQ
    $sql_update = "UPDATE faqs SET name = ?, email = ?, message = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "sssi", $name, $email, $message, $faqID);

    // Execute query
    if (mysqli_stmt_execute($stmt_update)) {
        echo "
      <div id='userSuccessMessage'>
        <p> FAQ with ID ($faqID) was edited successfully!</p>
        <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
          Back to Admin Dashboard
        </a>
        <br>
        <a id='viewFAQList' href='FAQList.php'>
          View FAQ List
        </a>
        <br>
      </div>
    ";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt_update);
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

            <!-- FAQ EDIT SECTION STARTS HERE -->
            <h2 id="form-title">EDIT FAQ</h2>

            <div class="admin-form">
                <form action="" method="POST">

                    <input type="hidden" name="id" value="<?= isset($faqID) ? htmlspecialchars($faqID) : 'NONE'; ?>">

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>"
                        style="border: 1px solid;" required><br><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>"
                        style="border: 1px solid;" required><br><br>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="6" style="border: 1px solid;"
                        required><?= htmlspecialchars($message) ?></textarea><br><br>

                    <button type="submit" style="background-color: black;">Update FAQ</button>
                    <br><br><br>
                </form>
            </div>
            <!-- FAQ EDIT SECTION ENDS HERE -->
        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- js file -->
    <script src="../../js/admin_Script.js"></script>
</body>

</html>
