<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include("../../config/admin_config.php");

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $shortDesc = $_POST['shortDesc'];
    $content = $_POST['content'];
    $publishDate = $_POST['publishDate'];
    $categoryID = $_POST['categoryID'];
    
    if (!empty($_FILES['image']['name'])) {
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            $image = $_FILES["image"]["name"];
            if (move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $image)) {
                $sql = "INSERT INTO blogs (title, image, shortDesc, content, publishDate, categoryID, createdAt, updatedAt) 
                        VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssss", $title, $image, $shortDesc, $content, $publishDate, $categoryID);
                
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: blogList.php");
                    exit();
                } else {
                    $msg = "Error: " . mysqli_error($conn);
                }
            } else {
                $msg = "Sorry, error uploading file.";
            }
        }
    } else {
        $msg = "Please select an image.";
    }
}

$sql_categories = "SELECT * FROM categories";
$result_categories = mysqli_query($conn, $sql_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>Add New Blog</title>
    <style>
        .userList-container {
            padding: 20px;
            margin-left: 250px;
            background-color: #e6f0db;
            min-height: 100vh;
        }

        .userList-form {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .userList-form h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
            font-weight: 500;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .form-group img {
            max-width: 200px;
            border-radius: 8px;
            margin: 10px 0;
        }

        .form-group input[type="file"] {
            margin-top: 10px;
        }

        button[type="submit"] {
            background-color: #659e2f;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>
    <div class="userList-container">
        <div class="userList-form">
            <h2>Add New Blog</h2>
            <?php if (!empty($msg)) echo "<p style='color: red;'>$msg</p>"; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" required>
                </div>

                <div class="form-group">
                    <label for="shortDesc">Short Description:</label>
                    <textarea id="shortDesc" name="shortDesc" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="10" required></textarea>
                </div>

                <div class="form-group">
                    <label for="publishDate">Publish Date:</label>
                    <input type="date" id="publishDate" name="publishDate" required>
                </div>

                <div class="form-group">
                    <label for="categoryID">Category:</label>
                    <select id="categoryID" name="categoryID" required>
                        <option value="">Select Category</option>
                        <?php
                        while ($category = mysqli_fetch_assoc($result_categories)) {
                            echo "<option value='" . htmlspecialchars($category['categoryID']) . "'>" . 
                                 htmlspecialchars($category['name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" style="background-color: #659e2f;">Add Blog</button>
                    <a href="blogList.php" style="background-color: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/admin_Script.js"></script>
</body>
</html>
<?php 
    mysqli_close($conn); 
?>