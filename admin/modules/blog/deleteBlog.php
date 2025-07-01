<?php
//SITI NUR AISHAH BINTI JUAN (BI22110101)

include("../../config/admin_config.php");

if (isset($_GET['id'])) {
    $blogID = $_GET['id'];
    
    $sql = "SELECT image FROM blogs WHERE blogID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $blog = mysqli_fetch_assoc($result);
    
    //Delete blog
    $sql = "DELETE FROM blogs WHERE blogID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogID);
    
    if (mysqli_stmt_execute($stmt)) {
        //Delete image 
        if (!empty($blog['image'])) {
            $imagePath = "../" . $blog['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        echo "<script>
            alert('Blog deleted successfully!');
            window.location.href='blogList.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error deleting blog: " . mysqli_error($conn) . "');
            window.location.href='blogList.php';
        </script>";
    }
} else {
    header("Location: blogList.php");
    exit();
}

mysqli_close($conn);
?>