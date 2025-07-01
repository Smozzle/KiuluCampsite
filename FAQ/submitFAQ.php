<?php
//Suziliana Mosingkil (BI22110296)
// Include database configuration
include('../user/config/user_config.php');

if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo "<p style='color: green;'>FAQ has been successfully added!</p>";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert FAQ into the database
    $sql = "INSERT INTO faqs (name, email, message) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

    // Check if the query executed successfully
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to FAQList page after successful submission with a success status
        header("Location: FAQList.php?status=success");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
