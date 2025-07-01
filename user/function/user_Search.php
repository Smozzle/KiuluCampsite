<?php
session_start();
include_once("../config/user_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DELETE PRODUCT</title>
    
    <!-- CDN icon link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- CSS file -->
    <link rel="stylesheet" href="../css/user_Style.css">
</head>
<body>

<div id='searchMessage'>
    <p>SEARCH RESULT:</p>
</div>

<div class='searchResult-container'>
    <?php
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;" . "<a class='searchResult' href='" . BASE_URL . "" . htmlspecialchars($row['productID']) . "'>" . htmlspecialchars($row['productName']) . "</a><br>";
            }
        } else {
            echo "<p>Sorry, no result for '" . htmlspecialchars($search_text) . "'</p>";
        }
    } else {
        echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
    }
    ?>
    <br><a class='homePage-link' href='<?php echo BASE_URL; ?>'>Back to kiulu campsite</a>
</div>

</body>
</html>
