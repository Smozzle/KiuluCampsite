<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
include __DIR__ . '/../config/user_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REGISTER POPUP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../../css/user_style.css">
</head>

<body>
  <div id="reg-popup" class="login-popup">
    <span class="close-btn" onclick="closeRegPopup()">&times;</span>
    <h3>USER REGISTRATION</h3><br>

    <form action="<?php echo BASE_URL; ?>/user/userAuth/register_action.php" method="post">
      <label for="userName">Username:</label><br>
      <input type="text" id="userName" name="userName" required><br><br>

      <label for="userEmail">User Email:</label><br>
      <input type="email" id="userEmail" name="userEmail" required><br><br>

      <label for="userPwd">Password:</label><br>
      <input type="password" id="userPwd" name="userPwd" required maxlength="8"><br><br>

      <label for="confirmPwd">Confirm Password:</label><br>
      <input type="password" id="confirmPwd" name="confirmPwd" required><br><br><br>

      <button type="submit" value="Register">Register</button>
      <button type="reset" value="Reset">Reset</button><br>
    </form>
  </div>

  <div id="overlay" class="overlay" onclick="closeRegPopup()"></div>
</body>
</html>
