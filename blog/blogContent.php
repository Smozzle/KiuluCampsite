<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include '../user/config/user_config.php';

// Get blogID from URL parameter
$blogID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validate blogID
if ($blogID <= 0) {
    header("Location: blogList.php");
    exit;
}

// Fetch blog details from the database
$query = "SELECT b.*, c.name as categoryName 
          FROM blogs b 
          LEFT JOIN categories c ON b.categoryID = c.categoryID 
          WHERE b.blogID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $blogID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $blog = $result->fetch_assoc();
    
    // Fetch related posts from the same category
    $relatedQuery = "SELECT * FROM blogs 
                    WHERE categoryID = ? 
                    AND blogID != ? 
                    ORDER BY publishDate DESC 
                    LIMIT 3";
    $relatedStmt = $conn->prepare($relatedQuery);
    $relatedStmt->bind_param("ii", $blog['categoryID'], $blogID);
    $relatedStmt->execute();
    $relatedResult = $relatedStmt->get_result();
    
} else {
    echo "Blog not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        /* Base Styles */
        .blogSection {
            font-family: system-ui, -apple-system, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Image Section */
        .headerBlog {
            position: relative;
            width: 100%;
            height: 400px;
        }

        .headerImage {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content {
            padding: 40px 0;
        }

        .blogMeta {
            margin-bottom: 24px;
        }

        .blogDate {
            font-size: 14px;
            color: #666666;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .bi-calendar3 {
            font-size: 16px;
        }

        .contentTitle {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .contentDesc {
            color: #666666;
            margin-bottom: 32px;
            font-size: 16px;
            line-height: 1.8;
        }

        .articleContent {
            background-color: #ffffff;
            padding: 32px;
        }

        .articleSection {
            margin-bottom: 32px;
        }

        .articleSection h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .articleSection p {
            color: #666666;
            margin-bottom: 16px;
            line-height: 1.8;
        }

        .articleImage {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 24px 0;
        }

        .relatedPosts {
            margin-top: 48px;
            border-top: 1px solid #e5e5e5;
        }

        .relatedTitle {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 24px;
            text-transform: uppercase;
        }

        .blogContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
        }


        .blogCard {
            width: 30%;
            min-width: 300px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .blogCard:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .blogImageContainer {
            position: relative;
            height: 200px;
        }

        .blogImage {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blogContent {
            padding: 16px;
        }

        .blogTitle {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-transform: uppercase;
        }

        .blogDesc {
            font-size: 14px;
            color: #666666;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media screen and (max-width: 1024px) {
            .blogCard {
                width: 45%;
            }
        }

        @media screen and (max-width: 640px) {
            .blogCard {
                width: 100%;
            }
            
            .headerBlog {
                height: 300px;
            }

            .articleContent {
                padding: 20px;
            }

            .contentTitle {
                font-size: 24px;
            }
        }
    </style>

</head>
<body class="blogSection">
    <?php include '../user/includes/topNav.php';?>
    <main class="main">
        <section class="headerBlog">
            <img class="headerImage" src="../img/<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog Image">
        </section>

        <section class="content">
            <div class="container">
                <article class="articleContent">
                    <div class="blogMeta">
                        <div class="blogDate">
                            <i class="bi bi-calendar3"></i>
                            <?php echo date("l, d F Y", strtotime($blog['publishDate'])); ?>
                        </div>
                        <h1 class="contentTitle"><?php echo htmlspecialchars($blog['title']); ?></h1>
                        <p class="contentDesc"><?php echo htmlspecialchars($blog['shortDesc']); ?></p>
                        <div class="category">
                            Category: <?php echo htmlspecialchars($blog['categoryName']); ?>
                        </div>
                    </div>

                    <div class="articleSection">
                        <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
                    </div>
                </article>
                
                <div class="relatedPosts">
                    <h2 class="relatedTitle">Related Posts in <?php echo htmlspecialchars($blog['categoryName']); ?></h2>
                    <div class="blogContainer">
                        <?php 
                        if ($relatedResult->num_rows > 0) {
                            while ($relatedPost = $relatedResult->fetch_assoc()) { 
                        ?>
                            <article class="blogCard">
                                <a href="blogContent.php?id=<?php echo $relatedPost['blogID']; ?>" style="text-decoration: none; color: inherit;">
                                    <div class="blogImageContainer">
                                        <img class="blogImage" src="../img/<?php echo htmlspecialchars($blog['image']); ?>"
                                            alt="<?php echo htmlspecialchars($relatedPost['title']); ?>">
                                    </div>
                                    <div class="blogContent">
                                    <div class="blogDate">
                                        <i class="bi bi-calendar3"></i>
                                        <?php echo date("l, d F Y", strtotime($relatedPost['publishDate'])); ?>
                                    </div>
                                    <h2 class="blogTitle"><?php echo htmlspecialchars($relatedPost['title']); ?></h2>
                                    <p class="blogDesc"><?php echo htmlspecialchars($relatedPost['shortDesc']); ?></p>
                                </div>
                            </article>
                        <?php 
                            }
                        } else {
                            echo '<p>No related posts found in this category.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>  
        </section>
        <p></p>
        <?php include '../user/includes/user_Footer.php';?>
    </main>
</body>
</html>
