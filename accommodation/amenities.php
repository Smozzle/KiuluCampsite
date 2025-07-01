<!DOCTYPE html>
<!--Suziliana Mosingkil (BI22110296)-->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amenities Pricing</title>

    <!-- CDN icon link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS file -->
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .admin-dashboard {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 36px;
            color: #333;
        }

        .amenity-item {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .amenity-item i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #4CAF50;
        }

        .amenity-item h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .price {
            font-size: 20px;
            color: green;
        }

        .note {
            font-size: 16px;
            color: #777;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .amenity-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
    <section class="admin-dashboard">
        <div class="dashboard-container">
            <h1>Amenities</h1>

            <!-- Amenities Details -->
            <div class="amenity-container">
                <!-- Chair -->
                <div class="amenity-item">
                    <i class="fas fa-chair"></i>
                    <div>
                        <h3>Chair</h3>
                        <span class="price">RM 0.70 each</span>
                    </div>
                </div>

                <!-- Table -->
                <div class="amenity-item">
                    <i class="fas fa-table"></i>
                    <div>
                        <h3>Table</h3>
                        <span class="price">RM 15 each</span>
                    </div>
                </div>

                <!-- PA System -->
                <div class="amenity-item">
                    <i class="fas fa-volume-up"></i>
                    <div>
                        <h3>PA System</h3>
                        <span class="price">RM 250 /day</span>
                    </div>
                </div>

                <!-- Open Hall -->
                <div class="amenity-item">
                    <i class="fas fa-building"></i>
                    <div>
                        <h3>Open Hall</h3>
                        <span class="price">RM 200</span>
                        <div class="note">Inclusive of tables, chairs, and electricity fee</div>
                    </div>
                </div>

                <!-- Kitchen -->
                <div class="amenity-item">
                    <i class="fas fa-utensils"></i>
                    <div>
                        <h3>Kitchen</h3>
                        <span class="price">RM 30</span>
                        <div class="note">However, for larger groups above 25 pax, an additional RM 1/pax will be
                            charged.</div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- JS file -->
    <script src="../../js/admin_Script.js"></script>
</body>

</html>
