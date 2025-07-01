<?php
//Suziliana Mosingkil (BI22110296)
include '../user/config/user_config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../user/css/user_style.css" rel="stylesheet">
    <title>FAQs</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .section {
            background: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
        }

        .faq-item {
            margin-bottom: 20px;
        }

        .faq-item h3 {
            cursor: pointer;
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .faq-item h3:hover {
            background: #4CAF50;
        }

        .faq-answer {
            display: none;
            padding: 15px;
            background: #ecf0f1;
            border-left: 4px solid #4CAF50;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-group input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s ease;
            display: block;
            width: 100%;
        }

        button:hover {
            background: #4CAF50;
        }
    </style>
</head>

<body>
    <?php include '../user/includes/topnav.php'; ?>

    <?php
    if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
        echo '<script type="text/javascript">alert("Logout successful!");</script>';
    }
    ?>
    <div class="container">
        <div class="section">Help Desk</div>
        <p>If you need assistance, feel free to reach us through the form below or call our support hotline.</p>
        <form id="helpdesk-form" action="submitFAQ.php" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="container">
        <div class="section">Support Tickets</div>
        <p>Track your support requests by submitting a ticket with your issue details.</p>
        <p>Email us at: <strong>info@KIULU-campsite</strong></p>
    </div>

    <div class="container">
        <div class="section">FAQs Resource Center</div>
        <div class="faq-item">
            <h3 aria-expanded="false" onclick="toggleFAQ(this)">Any network coverage in campsite</h3>
            <div class="faq-answer">YES. Maxis, Celcom, Digi & U Mobile can access 4G network.</div>
        </div>

        <div class="faq-item">
            <h3>What is the cancellation policy?</h3>
            <div class="faq-answer">Cancellations must be made 48 hours before arrival for a full refund.</div>
        </div>
        <div class="faq-item">
            <h3>What is the check in and check out time ?</h3>
            <div class="faq-answer">Check in time is 2.00pm and check out time is 11.00am.
            </div>
        </div>
        <div class="faq-item">
            <h3>Can i do karaoke at the campsite ?</h3>
            <div class="faq-answer">YES, karaoke is allowed but not after 9:00pm.
            </div>
        </div>
    </div>
    </div>

    <script>
        document.querySelectorAll('.faq-item h3').forEach(item => {
            item.addEventListener('click', () => {
                let answer = item.nextElementSibling;
                answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
            });
        });

        function toggleFAQ(element) {
            let answer = element.nextElementSibling;
            let isExpanded = element.getAttribute('aria-expanded') === 'true';
            element.setAttribute('aria-expanded', !isExpanded);
            answer.style.display = isExpanded ? 'none' : 'block';
        }

        document.getElementById('helpdesk-form').addEventListener('submit', function (event) {
            event.preventDefault();
            alert('Your message has been submitted. We will get back to you shortly.');
            this.reset();
        });
    </script>

    <?php include '../user/includes/user_Footer.php'; ?>
</body>

</html>
