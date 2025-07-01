<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
// include db config (admin_config.php)
include("../../config/admin_config.php");
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN EDIT USER</title>

    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- css file -->
    <link rel="stylesheet" href="../../css/admin_Style.css">
</head>

<?php

// fetch roles from database
$roles = [];
$sql_roles = "SELECT userRoles FROM user";
$result_roles = mysqli_query($conn, $sql_roles);
while ($row = mysqli_fetch_assoc($result_roles)) {
    $roles[] = $row;
}

// define roles mapping
$roles = [
    1 => 'Admin',
    2 => 'User'
];

// handle user update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userRoles = $_POST['userRoles'];
    $regDate = $_POST['regDate'];

    // check if password and confirm password are provided
    if (!empty($_POST['userPwd']) && !empty($_POST['confirmPwd'])) {
        $userPwd = $_POST['userPwd'];
        $confirmPwd = $_POST['confirmPwd'];

        // validate password and confirm password
        if ($userPwd !== $confirmPwd) {
            echo "<p> Error: Password and confirm password do not match. </p>";
            exit;
        }

        // hash the password (recommended for security)
        $pwdHash = $userPwd;

        // insert new user with password
        $sql_insert = "INSERT INTO user (userName, userEmail, userRoles, regDate, userPwd) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "ssiss", $userName, $userEmail, $userRoles, $regDate, $pwdHash);
    } else {
        // insert new user without password (not recommended in most scenarios)
        $sql_insert = "INSERT INTO user (userName, userEmail, userRoles, regDate) VALUES (?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "ssis", $userName, $userEmail, $userRoles, $regDate);
    }

    // execute query
    if (mysqli_stmt_execute($stmt_insert)) {
        echo "
            <div id='userSuccessMessage'>
                <p>Data insert successfully!</p>
                <a id='adminDashboardLink' href='" . ADMIN_BASE_URL . "'>
                    Back to Admin Dashboard
                </a>
                <br>
                <a id='viewUserList' href='admin_UserList.php'>
                    View User List
                </a>
                <br>
            </div>
        ";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt_insert);
    mysqli_close($conn);
    exit;
}
?>


<body>
    <!-- ADMIN SIDENAV SECTION STARTS HERE -->
    <?php include("../../includes/admin_SideNav.php"); ?>
    <!-- ADMIN SIDENAV SECTION ENDS HERE -->

    <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
    <section class="admin-dashboard">
        <div class="dashboard-container">

            <!-- USER EDIT SECTION STARTS HERE -->
            <!-- form edit title -->
            <h2 class="form-title">ADD USER</h2>

            <div class="admin-form">
                <form action="" method="POST">
                    <input type="hidden" name="userID" value="">

                    <label for="userName">User Name:</label>
                    <input type="text" id="userName" name="userName" value="" required><br><br>

                    <label for="userEmail">User Email:</label>
                    <input type="text" id="userEmail" name="userEmail" value="" required><br><br>

                    <label for="userPwd">New Password:</label>
                    <input type="password" id="userPwd" name="userPwd"><br><br>

                    <label for="confirmPwd">Confirm New Password:</label>
                    <input type="password" id="confirmPwd" name="confirmPwd"><br><br>

                    <label for="userRoles">User Role:</label>
                    <select id="userRoles" name="userRoles" required>
                        <option value="" disabled selected>-- select role --</option>
                        <?php foreach ($roles as $roleID => $roleName): ?>
                            <option value="<?= htmlspecialchars($roleID) ?>"><?= htmlspecialchars($roleName) ?></option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <label for="regDate">Register Date:</label>
                    <input type="date" id="regDate" name="regDate" required><br><br>

                    <button type="submit">Save</button>
                </form>
            </div>

            <!-- USER EDIT SECTION ENDS HERE -->
        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- js file -->
    <script src="../../js/admin_Script.js"></script>
</body>
