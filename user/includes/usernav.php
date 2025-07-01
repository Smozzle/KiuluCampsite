<!-- USER HEADER SECTION STARTS HERE -->
<!--SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395) -->
<header class="header">

  <!-- logo container -->
  <div class="logo-content">
    <h1 class="logo-name"></h1>
  </div>

  <!-- search bar container -->
  <div class="search-bar">
    <form action="<?php echo BASE_URL; ?>/user/function/user_Search.php" method="post">
      <input type="search" placeholder="Search " name="search_text" required>
      <button type="submit" aria-label="Search"><i class="fa fa-search"></i></button>
    </form>
  </div>

  <!-- icons container -->
  <div class="icons">
    <?php if (isset($_SESSION["UID"])) { ?>
      <span id="welcome-message">Welcome, <b><?php echo htmlspecialchars($_SESSION["userName"]); ?></b></span>
      <a href="<?php echo BASE_URL; ?>/user/userAuth/logout.php" class="logout-button" title="Logout">
        <div class="logout-icon">
          <i class="fas fa-sign-out-alt" id="logout-icon" style="color:black"> Logout</i>
        </div>
      </a>
    <?php } else { ?>
      <a href="javascript:void(0);" onclick="openLoginPopup()" class="login-button" title="Login">
        <div class="login-icon">
          <i class="fas fa-sign-in-alt" id="login-icon" style="color:black"> LOGIN </i>
        </div>
      </a>
    <?php } ?>
      </div>
    </a>
  </div>

</header>
<!-- USER HEADER SECTION ENDS HERE -->
</div>