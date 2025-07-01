<?php
// ALVINA ALPHONSUS BI22110003
session_start();
// include admin_config.php
include("config/admin_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN DASHBOARD</title>

  <!-- cdn icon link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- WOW Animation library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- CSS file -->
  <link rel="stylesheet" href="../admin/css/admin_Style.css">

  <!-- Google Font for smooth typography -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

</head>

<body>
  <div class="video-background">
    <video autoplay muted loop id="bg-video">
      <source src="background.mp4" type="video/mp4">
      <source src="background.webm" type="video/webm">
      Your browser does not support the video tag.
    </video>
  </div>

  <!-- ADMIN SIDENAV SECTION STARTS HERE -->
  <?php include("includes/admin_SideNav.php"); ?>
  <!-- ADMIN SIDENAV SECTION ENDS HERE -->

  <!-- Kiulu Campsite-->
  <h1 style="
    text-align: center; 
    font-size: 48px; 
    color: #fff; 
    font-weight: 700; 
    background: linear-gradient(135deg, #ffffff, #ffffff); 
    webkit-background-clip: text; 
    background-clip: text; 
    text-shadow: 2px 2px 8px rgba(255, 255, 255, 0.3), 0 0 25px rgba(255, 255, 255, 0.4), 0 0 5px rgba(255, 255, 255, 0.5);
    letter-spacing: 2px; 
    text-transform: uppercase;
    margin-top: 0; /* Removes the default margin at the top */
    padding-top: 0; /* Removes any padding at the top */
    line-height: 1.2;"> <!-- Adjusts line height if needed to reduce spacing -->
    Kiulu Campsite
  </h1>

  <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
  <section class="admin-dashboard">
    <div class="dashboard-container animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
      
      <!-- Admin Dashboard welcome message with more styling -->
      <h2 id="admin-welcomeMessage" class="animate__animated animate__fadeInUp" style="padding-left:50px;color:#333;">
        <span>
          <i class="fas fa-user-circle"></i> Welcome to Admin Panel Dashboard, 
          <b style="color: #2c3e50;">
            <?php
            echo isset($_SESSION["userName"])
              ? htmlspecialchars($_SESSION["userName"])
              : "Guest";
            ?>
          </b>
        </span>
      </h2>

      <!-- Add a subtle gradient background to the welcome section -->
      <div class="dashboard-greeting" style="background: linear-gradient(145deg, #ecf0f1, #f8f9fa); padding: 30px; border-radius: 8px;">
        <p class="animate__animated animate__fadeInUp" style="font-size: 18px; color: #7f8c8d;">We are excited to have you here. Manage your dashboard seamlessly with the tools available. Let's get started!</p>
      </div>

    </div>
  </section>
  <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

  <!-- js file -->
  <script src="./js/admin_Script.js"></script>

  <!-- WOW Animation JS for enhanced animations -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
  <script>
    new WOW().init();
  </script>

</body>
</html>
