<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
include '../user/config/user_config.php';

// Check if the connection exists
if (!$conn) {
    die("Database connection failed.");
}

// Fetch all safety information from the database
$query = "SELECT * FROM SafetyInfo ORDER BY last_updated DESC";
$result = $conn->query($query);

if (!$result) {
    die("Failed to retrieve safety information.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Information List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto; /* Add vertical margin for spacing */
            padding: 20px;
        }

        .safetyList {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
        }

        .safetyCard {
            width: 30%;
            min-width: 300px;
            margin: 40px auto;
            background-color:rgb(235, 255, 241);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .safetyCard:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .safetyImageContainer {
            width: 100%;
            height: 300px;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
        }

        .safetyImage {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .safetyContent {
            padding: 16px;
        }

        .safetyTitle {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .safetyType {
            font-size: 14px;
            color: #666666;
            margin-bottom: 8px;
        }

        .safetyDate {
            font-size: 12px;
            color: #999999;
        }

        @media screen and (max-width: 1024px) {
            .safetyCard {
                width: 45%;
            }
        }

        @media screen and (max-width: 640px) {
            .safetyCard {
                width: 100%;
            }
        }
    </style>
</head>
<body class="blogSection">
    <?php include '../user/includes/topNav.php'; ?>
    <main class="main">
        <div class="container">
            <h1>Safety Information & Tips</h1>
            <div class="safetyList">
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <article class="safetyCard">
                            <a href="safetyDetails.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit;">
                                <div class="safetyImageContainer">
                                    <img class="safetyImage" src="<?php echo htmlspecialchars($row['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($row['title']); ?>">
                                </div>
                                <div class="safetyContent">
                                    <h2 class="safetyTitle"><?php echo htmlspecialchars($row['title']); ?></h2>
                                    <p class="safetyType">Type: <?php echo htmlspecialchars($row['type']); ?></p>
                                    <p class="safetyDate">Last Updated: <?php echo htmlspecialchars($row['last_updated']); ?></p>
                                </div>
                            </a>
                        </article>
                    <?php } ?>
                <?php } else { ?>
                    <p>No safety information available.</p>
                <?php } ?>
            </div>
        </div>
        <p></p>
        <?php include '../user/includes/user_Footer.php';?>
    </main>
</body>
</html>
