<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
include __DIR__ . '/../config/user_config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN POPUP</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .register-x-modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1000;
      width: 90%;
      max-width: 700px;
      background-color:#ffffff;
      color:var(--dark--color);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
      border-radius: 15px;
      padding: 40px;
    }

    .register-x-modal-content {
      position: relative;
    }

    .register-x-close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 20px;
      cursor: pointer;
    }

    .register-x-modal h3 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 24px;
    }

    .register-x-modal form {
      text-align: left;
    }

    .register-x-modal label {
      font-size: 16px;
      margin-bottom: 8px;
      display: block;
    }

    .register-x-modal input {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    .register-x-btn {
      margin-top: 15px;
      padding: 15px 20px;
      background-color:rgb(97, 92, 89);
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      border-radius: 8px;
      width: 48%;
      display: inline-block;
      text-align: center;
    }

    .register-x-btn:hover {
      background-color: rgb(132, 158, 152);
    }

    .register-x-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }
  </style>
</head>

<body>
  <div id="login-popup" class="register-x-modal">
    <span class="register-x-close-btn" onclick="closeLoginPopup()">&times;</span>
    <h3>USER LOGIN</h3><br>
    <form action="<?php echo BASE_URL; ?>/user/userAuth/login_action.php" method="post">
      <label for="userEmail">User Email:</label><br>
      <input type="email" id="userEmail" name="userEmail" required><br><br>

      <label for="userPwd">Password:</label><br>
      <input type="password" id="userPwd" name="userPwd" required maxlength="8"><br><br><br>

      <button type="submit" class="register-x-btn" value="Login" >Login</button>
      <button type="reset" class="register-x-btn" value="Reset">Reset</button>
      <button type="button" class="register-x-btn" value="regis" id="register-btn">Register</button>
      <button class="register-x-btn"><a href="forgetpassword.php" style="color:white">Forget Password</a></button>
    </form>
  </div>

  <div id="register-modal" class="register-x-modal">
    <div class="register-x-modal-content">
      <span class="register-x-close-btn" onclick="closeRegisterModal()">&times;</span>
      <h3>USER REGISTRATION</h3><br>
      <form action="<?php echo BASE_URL; ?>/user/userAuth/register_action.php" method="post">
        <label for="userName">Username:</label>
        <input type="text" id="userName" name="userName" required>

        <label for="userEmail">User Email:</label>
        <input type="email" id="userEmail" name="userEmail" required>

        <label for="userPwd">Password:</label>
        <input type="password" id="userPwd" name="userPwd" required maxlength="8">

        <label for="confirmPwd">Confirm Password:</label>
        <input type="password" id="confirmPwd" name="confirmPwd" required>

        <button type="submit" class="register-x-btn" value="Register">Register</button>
        <button type="reset" class="register-x-btn" value="Reset">Reset</button>
        <a href="forgetpassword.php" class="register-x-btn">Forget Password</a>
      </form>
    </div>
  </div>

  <div id="register-overlay" class="register-x-overlay" onclick="closeRegisterModal()"></div>

  <script>
    const registerButton = document.getElementById('register-btn');
    const registerModal = document.getElementById('register-modal');
    const registerOverlay = document.getElementById('register-overlay');

    registerButton.addEventListener('click', () => {
      registerModal.style.display = 'block';
      registerOverlay.style.display = 'block';
    });

    function closeRegisterModal() {
      registerModal.style.display = 'none';
      registerOverlay.style.display = 'none';
    }

    registerOverlay.addEventListener('click', closeRegisterModal);
  </script>
</body>

</html>