<?php
// AVELLE SHAYNE ALBIN (BI22110268)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN CREATE ACTIVITY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $activityName = trim($_POST['activityName']);
    $activityDescription = trim($_POST['activityDescription']);
    $activityDayStart = $_POST['activityDayStart'];
    $activityDayEnd = $_POST['activityDayEnd'];
    $activityStatus = $_POST['activityStatus'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $maxParticipants = (int)$_POST['maxParticipants'];
    $price = (float)$_POST['price'];
    
    $uploadDir = "../../img/";
    $activityImage = NULL;
    
    if (!empty($_FILES['activityImage']['name'])) {
        $fileTmpPath = $_FILES['activityImage']['tmp_name'];
        $fileName = basename($_FILES['activityImage']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                $activityImage = $fileName;
            } else {
                echo "<div class='error-message'>Error uploading image.</div>";
            }
        } else {
            echo "<div class='error-message'>Invalid image format.</div>";
        }
    }
    
    $sql_insert = "INSERT INTO activity (activityName, activityDescription, activityDayStart, activityDayEnd, activityStatus, activityDate, startTime, endTime, maxParticipants, price, activityImage) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    
    mysqli_stmt_bind_param($stmt_insert, "ssssssssdds", 
        $activityName, 
        $activityDescription, 
        $activityDayStart, 
        $activityDayEnd, 
        $activityStatus, 
        $startTime, 
        $endTime, 
        $maxParticipants, 
        $price, 
        $activityImage
    );

    if (mysqli_stmt_execute($stmt_insert)) {
        $insertedID = mysqli_insert_id($conn);
        echo "
            <div id='userSuccessMessage'>
                <p>Activity ($activityName) with ID ($insertedID) was added successfully!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>Back to Admin Dashboard</a>
                <br>
                <a id='viewActivityList' href='activityListing.php'>View Activity List</a>
                <br>
            </div>
        ";
        mysqli_stmt_close($stmt_insert);
        mysqli_close($conn);
        exit;
    } else {
        echo "<div class='error-message'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
<body>
    <?php include("../../includes/admin_SideNav.php"); ?>

    <section class="admin-dashboard">
        <div class="dashboard-container">
            <h2 class="form-title">CREATE ACTIVITY</h2>

            <div class="admin-form">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="activityName">Activity Name:</label>
                    <input type="text" id="activityName" name="activityName" required><br><br>

                    <label for="activityDescription">Activity Description:</label>
                    <textarea id="activityDescription" name="activityDescription" rows="4" required></textarea><br><br>

                    <label for="activityDayStart">Activity Start Day:</label>
                    <select id="activityDayStart" name="activityDayStart" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select><br><br>

                    <label for="activityDayEnd">Activity End Day:</label>
                    <select id="activityDayEnd" name="activityDayEnd" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select><br><br>

                    <label for="activityStatus">Activity Status:</label>
                    <select id="activityStatus" name="activityStatus" required>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                        <option value="ongoing">Ongoing</option>
                    </select><br><br>


                    <label for="startTime">Start Time:</label>
                    <input type="time" id="startTime" name="startTime" required><br><br>

                    <label for="endTime">End Time:</label>
                    <input type="time" id="endTime" name="endTime" required><br><br>

                    <label for="maxParticipants">Max Participants:</label>
                    <input type="number" id="maxParticipants" name="maxParticipants" min="1" required><br><br>

                    <label for="price">Activity Price:</label>
                    <input type="number" id="price" name="price" min="0.01" step="0.01" required><br><br>
                    
                    <label for="activityImage">Activity Image:</label>
                    <input type="file" id="activityImage" name="activityImage" accept="image/*"><br><br>

                    <button type="submit">Create Activity</button>
                </form>
            </div>
        </div>
    </section>

    <script src="../../js/admin_Script.js"></script>
</body>
</html>
