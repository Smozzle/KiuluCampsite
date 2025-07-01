<?php
//SYAMSUL ANIS NABILA BINTI SHAMSOL KAMAL (BI22110395)
session_start();
include __DIR__ . '/../config/user_config.php';

if (isset($_SESSION["UID"])) {
    unset($_SESSION["UID"]);
    unset($_SESSION["userName"]);
    session_destroy();
    header("Location: " . BASE_URL . "/index.php?logout=success");
    exit();
}
