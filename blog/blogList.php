<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include '../user/config/user_config.php';

// Fetch all categories
$categoryQuery = "SELECT * FROM categories ORDER BY name ASC";
$categoryResult = $conn->query($categoryQuery);

// Get selected category from URL parameter
$selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Modify blog query based on category filter
$blogQuery = "SELECT * FROM blogs";
if ($selectedCategory > 0) {
    $blogQuery .= " WHERE categoryID = " . $selectedCategory;
}
$blogQuery .= " ORDER BY publishDate DESC";
$blogResult = $conn->query($blogQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camping Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
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

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .title-section {
            flex: 1;
        }

        .filter-section {
            margin-left: 24px;
        }

        .category-select {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            color: #333;
            background-color: white;
            cursor: pointer;
            min-width: 200px;
        }

        .category-select:focus {
            outline: none;
            border-color: #666;
        }

        /* Content Section */
        .content {
            padding: 40px 0;
        }

        .contentTitle {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .contentDesc {
            color: #666666;
            margin-bottom: 32px;
        }

        .blogContainer {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .blogCard {
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

        .blogDate {
            font-size: 14px;
            color: #666666;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .bi-calendar3 {
            font-size: 16px;
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
            .blogContainer {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media screen and (max-width: 640px) {
            .blogContainer {
                grid-template-columns: 1fr;
            }
            
            .headerBlog {
                height: 300px;
            }
        }

        @media screen and (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }

            .filter-section {
                margin-left: 0;
                width: 100%;
            }

            .category-select {
                width: 100%;
            }
        }
    </style>
</head>
<body class="blogSection">
    <?php include '../user/includes/topNav.php';?>
    <main class="main">
        <section class="headerBlog">
            <img class="headerImage" src="../img/bannerCamp.jpg" alt="Tranquil camping scene with chairs by a lake">
        </section>

        <section class="content">
            <div class="container">
                <div class="header-content">
                    <div class="title-section">
                        <h1 class="contentTitle">Blogs Curated For You</h1>
                        <p class="contentDesc">Read all of our blogs</p>
                    </div>
                    
                    <div class="filter-section">
                        <select class="category-select" onchange="window.location.href='?category=' + this.value">
                            <option value="0" <?php echo $selectedCategory == 0 ? 'selected' : ''; ?>>All Categories</option>
                            <?php while ($category = $categoryResult->fetch_assoc()) { ?>
                                <option value="<?php echo $category['categoryID']; ?>" 
                                        <?php echo $selectedCategory == $category['categoryID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="blogContainer">
                    <?php 
                    if ($blogResult->num_rows > 0) {
                        while ($blog = $blogResult->fetch_assoc()) { 
                    ?>
                        <article class="blogCard">
                            <a href="blogContent.php?id=<?php echo $blog['blogID']; ?>" style="text-decoration: none; color: inherit;">
                                <div class="blogImageContainer">
                                    <img class="blogImage" src="../img/<?php echo htmlspecialchars($blog['image']); ?>"
                                         alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                </div>
                                <div class="blogContent">
                                    <div class="blogDate">
                                        <i class="bi bi-calendar3"></i>
                                        <?php echo date("l, d F Y", strtotime($blog['publishDate'])); ?>
                                    </div>
                                    <h2 class="blogTitle"><?php echo htmlspecialchars($blog['title']); ?></h2>
                                    <p class="blogDesc"><?php echo htmlspecialchars($blog['shortDesc']); ?></p>
                                </div>
                            </a>
                        </article>
                    <?php 
                        }
                    } else {
                        echo '<p>No blogs found for this category.</p>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <p></p>
        <?php include '../user/includes/user_Footer.php';?>
    </main>
</body>
</html>