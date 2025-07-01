<?php
//Suziliana Mosingkil (BI22110296)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Reviews</title>

    <!-- Font Awesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .review-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .review-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-author {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .review-stars {
            color: #FFD700;
        }

        .review-text {
            margin-top: 10px;
            font-size: 16px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="review-container">
        <h1 style="text-align: center;">Customer Reviews</h1>

        <!-- Review 1 -->
        <div class="review-item">
            <div class="review-author">By Beatrice Bagavan</div>
            <div class="review-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <div class="review-text">
                Good Morning! I know this is Kamandus View, my family are living nearby, very close to my house,
                hahahaha! You go to Kg. Bayag, Pekan Kiulu, my father and Mr. Nelver Sikul are community, Great, Have a
                nice day, Good luck, ##Beatrice Bagavan
            </div>
        </div>

        <!-- Review 2 -->
        <div class="review-item">
            <div class="review-author">By Yale Ya'le</div>
            <div class="review-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <div class="review-text">
                It’s a spacious place surrounded by nature 🌳 . Love this place! Suitable for large group gatherings.
            </div>
        </div>

        <!-- Review 3 -->
        <div class="review-item">
            <div class="review-author">By Cristlina Cristilla</div>
            <div class="review-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <div class="review-text">
                Friendly and kind-hearted owners. The place is just next to the Kiulu River.
            </div>
        </div>
    </div>
</body>

</html>
