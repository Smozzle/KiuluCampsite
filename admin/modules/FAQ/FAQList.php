
<?php 
//Suziliana Mosingkil (BI22110296)
include("../../config/admin_config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="../../css/admin_Style.css">
    <title>ADMIN FAQ LIST</title>
</head>

<body>
    <!-- ADMIN SIDENAV SECTION STARTS HERE -->
    <?php include("../../includes/admin_SideNav.php"); ?>
    <!-- ADMIN SIDENAV SECTION ENDS HERE -->

    <!-- ADMIN DASHBOARD SECTION STARTS HERE -->
    <section class="admin-dashboard">
        <div class="dashboard-container">
            <!-- FAQ LIST SECTION STARTS HERE -->
            <h1>FAQ LIST</h1>

            <!-- Display Success Message -->
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo "<p style='color: green;'>FAQ has been successfully added!</p>";
            }
            ?>

            <a href="createFAQ.php" class="btn-add-faq">Add FAQ</a>
            <br><br>

            <!-- form list details -->
            <?php
            // Pagination Setup
            $limit = 10; // FAQs per page
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            // Fetch FAQs from the database with pagination
            $sql_faq = "SELECT * FROM faqs ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
            $result = mysqli_query($conn, $sql_faq);
            $rowcount = mysqli_num_rows($result);

            // Fetch total number of rows for pagination
            $sql_count = "SELECT COUNT(*) FROM faqs";
            $count_result = mysqli_query($conn, $sql_count);
            $total_rows = mysqli_fetch_array($count_result)[0];
            $total_pages = ceil($total_rows / $limit);
            ?>

            <div class="admin-faqListContainer">
                <table id="faq-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Submitted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($rowcount > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $formatted_date = date('M d, Y', strtotime($row["created_at"]));
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>" . htmlspecialchars(substr($row["message"], 0, 100)) . "...</td>";
                                echo "<td>" . $formatted_date . "</td>";
                                echo "<td>";
                                echo "<a href='editFAQ.php?id=" . urlencode($row["id"]) . "' class='btn-edit'><i class='fas fa-edit'></i> Edit</a> | ";
                                echo "<a href='deleteFAQ.php?id=" . urlencode($row["id"]) . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this FAQ?\");'><i class='fas fa-trash-alt'></i> Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'><p>No FAQs found.</p></td></tr>";
                        }
                        mysqli_free_result($result);
                        ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <ul>
                        <?php
                        if ($page > 1) {
                            echo "<li><a href='FAQList.php?page=" . ($page - 1) . "'>Previous</a></li>";
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $page) ? 'class="active"' : '';
                            echo "<li><a href='FAQList.php?page=$i' $active>$i</a></li>";
                        }
                        if ($page < $total_pages) {
                            echo "<li><a href='FAQList.php?page=" . ($page + 1) . "'>Next</a></li>";
                        }
                        ?>
                    </ul>
                </div>

                <!-- display row count -->
                <h2 id="list-row-count">Total FAQs: <?php echo $total_rows; ?></h2>
            </div>
            <!-- FAQ LIST SECTION ENDS HERE -->
        </div>
    </section>
    <!-- ADMIN DASHBOARD SECTION ENDS HERE -->

    <!-- js file -->
    <script src="../../js/admin_Script.js"></script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
