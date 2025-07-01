<?php
session_start();
include("user/config/user_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forget Password | KIULU CAMPSITE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./user/css/user_style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .forget-password-form {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .forget-password-form h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .forget-password-form label {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .forget-password-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .forget-password-form button {
            width: 100%;
            padding: 10px;
            background-color:rgb(97, 92, 89);
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .forget-password-form button:hover {
            background-color: #45a049;
        }

        .forget-password-form p {
            text-align: center;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .forget-password-form p a {
            color: #4CAF50;
            text-decoration: none;
        }

        .forget-password-form p a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include("./user/includes/usernav.php"); ?>
    <?php include './user/includes/topNav.php'; ?>
    <?php include 'user/userAuth/login_popup.php'; ?>
    <?php include 'user/userAuth/register_popup.php'; ?>

    <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success') : ?>
        <script>alert("Logout successful!");</script>
    <?php endif; ?>

    <section class="home">
        <div class="forget-password-form">
            <h2>Forget Password</h2>
            <form action="" method="POST">
                <input type="hidden" name="userID" value="">

                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName" placeholder="Enter your username" required>

                <label for="userEmail">User Email:</label>
                <input type="email" id="userEmail" name="userEmail" placeholder="Enter your email" required>

                <label for="userPwd">New Password:</label>
                <input type="password" id="userPwd" name="userPwd" placeholder="Enter your new password" required>

                <button name="forgetpassword" value="forgetpassword" type="submit">Save</button>
            </form>
            <p>Remembered your password? <a href="login.php">Login here</a></p>
        </div>

        <?php
        if (isset($_POST["forgetpassword"])) {
            $userName = $_POST["userName"];
            $userEmail = $_POST["userEmail"];
            $userPwd = $_POST["userPwd"];

            $check = $conn->query("SELECT * FROM user WHERE userName='$userName' AND userEmail='$userEmail'") or die($conn->error);
            if ($check->num_rows > 0) {
                $account = $check->fetch_assoc();
                $userID = $account['userID'];
                $conn->query("UPDATE user SET userPwd='$userPwd' WHERE userID='$userID'") or die($conn->error);
                echo "<script>alert('Password reset successful. Please log in.');</script>";
                echo "<script>location='login.php';</script>";
            } else {
                echo "<script>alert('Invalid username or email.');</script>";
                echo "<script>location='forgetpassword.php';</script>";
            }
        }
        ?>
    </section>

    <?php include './user/includes/user_Footer.php'; ?>
    <script src="./user/js/user_Script.js"></script>
</body>

</html>
