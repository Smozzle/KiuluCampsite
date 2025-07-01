<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
include '../user/config/user_config.php';

// Get the safety info ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch safety info details from the database
$query = "SELECT * FROM SafetyInfo WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $info = $result->fetch_assoc();
} else {
    die("Safety information not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($info['title']); ?></title>
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .headerImage {
            width: 100%;
            height: 300px;
            object-fit: cover;
            margin-bottom: 24px;
            border-radius: 8px;
        }

        .contentTitle {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 16px;
        }

        .contentDesc {
            font-size: 16px;
            color: #666666;
            margin-bottom: 16px;
            line-height: 1.8;
        }

        .lastUpdated {
            font-size: 12px;
            color: #999999;
            margin-top: 16px;
        }
    </style>
</head>
<body class="blogSection">
    <?php include '../user/includes/topNav.php'; ?>
    <main class="main">
        <div class="container">
            <img class="headerImage" src="<?php echo htmlspecialchars($info['image']); ?>" alt="Safety Image">
            <h1 class="contentTitle"><?php echo htmlspecialchars($info['title']); ?></h1>
            <p class="contentDesc"><?php echo nl2br(htmlspecialchars($info['description'])); ?></p>
            <p class="lastUpdated">Last Updated: <?php echo htmlspecialchars($info['last_updated']); ?></p>
        </div>
        <p></p>
        <?php include '../user/includes/user_Footer.php';?>
    </main>
</body>
</html>
