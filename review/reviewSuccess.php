<?php
// AVELLE SHAYNE ALBIN (BI22110268)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Submitted Successfully</title>
    <link href="../user/css/user_style.css" rel="stylesheet">
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            max-width: 500px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #28a745;
        }

        p {
            font-size: 16px;
            color: #333;
        }

        .btn {
            display: inline-block;
            margin: 10px 5px;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary {
            background: #007bff;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background: #545b62;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Review Submitted Successfully!</h1>
    <p>Thank you for sharing your experience. Your review has been recorded.</p>

    <a href="reviewForm.php" class="btn btn-primary">Submit Another Review</a>
    <a href="../user/index.php" class="btn btn-secondary">Back to Home</a>
</div>

</body>
</html>
