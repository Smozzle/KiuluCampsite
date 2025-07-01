<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

//include db config
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>Blog Management</title>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>
    <div class="userList-container">
    <div class="userList-form">
    <h2 style="text-align: center;">Manage Blogs</h2>
        <div class="rowform">
            <?php
            $sql_categories = "SELECT * FROM categories";
            $result_categories = mysqli_query($conn, $sql_categories);

            $categoryID = isset($_GET['categoryID']) ? $_GET['categoryID'] : null;

            $sql_blogs = "SELECT b.blogID, b.title, b.image, b.shortDesc, b.content, b.publishDate, b.createdAt, b.updatedAt, c.name as category_name
                          FROM blogs b
                          JOIN categories c ON b.categoryID = c.categoryID";


            if (!empty($categoryID)) {
                $sql_blogs .= " WHERE b.categoryID = ?";
            }

            $sql_blogs .= " ORDER BY b.blogID ASC";

            $stmt = mysqli_prepare($conn, $sql_blogs);

            if (!empty($categoryID)) {
                mysqli_stmt_bind_param($stmt, "s", $categoryID);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $rowcount = mysqli_num_rows($result);
            ?>

            <!-- Category Filter -->
            <form method="GET" action="">
            <div>
                <label for="categoryID">Category:</label>
                <select id="categoryID" name="categoryID" style="width: 170px !important; border: 1px solid; font-size: 16px;">
                    <option value="">All Categories</option>
                    <?php
                    if (mysqli_num_rows($result_categories) > 0) {
                        while ($category = mysqli_fetch_assoc($result_categories)) {
                            echo "<option value='" . htmlspecialchars($category['categoryID']) . "' " . (($categoryID == $category['categoryID']) ? 'selected' : '') . ">" . htmlspecialchars($category['name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" style="background-color: #659e2f;padding:10px">Search</button>
            <div style="text-align: left; margin-top: 15px;">
                <a href="insertBlog.php" style="background-color: #659e2f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Add New Blog</a>
            </div>
            </form>
            <br>
            <br>
            
            <?php
            if ($rowcount > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Title</th>";
                echo "<th>Image</th>";
                echo "<th>Short Description</th>";
                echo "<th>Content</th>";
                echo "<th>Publish Date</th>";
                echo "<th>Category</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["blogID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                    echo "<td><img src='../" . htmlspecialchars($row["image"]) . "' alt='Blog Image' style='width: 50px; height: 50px;'></td>";
                    echo "<td>" . htmlspecialchars(substr($row["shortDesc"], 0, 100)) . "...</td>";
                    echo "<td>" . htmlspecialchars(substr($row["content"], 0, 100)) . "...</td>";
                    echo "<td>" . htmlspecialchars($row["publishDate"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["category_name"]) . "</td>";
                    echo "<td>";
                    echo "<a href='editBlog.php?id=" . urlencode($row["blogID"]) . "'>Edit</a> | ";
                    echo "<a href='deleteBlog.php?id=" . urlencode($row["blogID"]) . "' onclick='return confirm(\"Are you sure you want to delete this blog?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<p>Total Blogs: $rowcount</p>";
            } else {
                echo "<p>No blogs found.</p>";
            }
            ?>
    </div>
</div>
    <?php
        mysqli_free_result($result);
        mysqli_free_result($result_categories); 
        mysqli_close($conn);
    ?>
    <script src="../../js/admin_Script.js"></script>
</body>
</html>
