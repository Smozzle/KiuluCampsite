<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
session_start();
include __DIR__ . '/../config/user_config.php';
if (!isset($conn)) {
    die("Database connection error. Please check your configuration.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN ACTION</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../css/user_style.css">
</head>

<body>
    <?php
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail'] ?? '');
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd'] ?? '');

    $sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($userPwd == $row['userPwd']) {
            echo '<script type="text/javascript">alert("Login successful!");</script>';
            $_SESSION["UID"] = $row["userID"];
            $_SESSION["userName"] = $row["userName"];
            $_SESSION["userRoles"] = $row["userRoles"];
            $_SESSION['loggedin_time'] = time();

            if ($row['userRoles'] == 1) {
                echo '<script type="text/javascript">
                    window.location.href = "' . ADMIN_BASE_URL . '/index.php";
                </script>';
            } elseif ($row['userRoles'] == 2) {
                echo '<script type="text/javascript">
                    window.location.href = "' . BASE_URL . '/index.php";
                </script>';
            } else {
                echo '<script type="text/javascript">
                    alert("Unknown user role.");
                    window.location.href = "' . BASE_URL . '/index.php";
                </script>';
            }
            exit();
        } else {
            echo 'Login error, user email and password are incorrect.<br>';
            echo '<a href="' . BASE_URL . '/index.php"> | BACK |</a> &nbsp;&nbsp;&nbsp; <br>';
        }
    } else {
        echo "Login error, user <b>$userEmail</b> does not exist. <br>";
        echo '<a href="' . BASE_URL . '/index.php"> | BACK |</a>&nbsp;&nbsp;&nbsp; <br>';
    }

    mysqli_close($conn);
    ?>
</body>

</html>
