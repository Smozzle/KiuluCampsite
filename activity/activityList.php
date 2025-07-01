<?php
require_once 'config.php';

// Fetch activities from the database
$sql = "SELECT activityName, activityDescription, activityDate, startTime, endTime, maxParticipants 
        FROM CampsiteActivity 
        WHERE campsiteID = 1"; 
$result = $conn->query($sql); 

$activities = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>../styles.css" rel="stylesheet">
    <title>Campsite Activities</title>
</head>
<body>
    <?php
        require_once 'nav.php';
        outputNav();
    ?>
    <section class="activity-container">
        <div class="activity-header">
            <h1 class="activity-title">Campsite Activities</h1>
        </div>
        
        <div class="activity-list">
            <?php if (empty($activities)) { ?>
                <p>No activities available at the moment. Please check back later.</p>
            <?php } else { ?>
                <?php foreach ($activities as $activity) { ?>
                    <div class="activity-card">
                        <h2 class="activity-name"><?php echo htmlspecialchars($activity['activityName']); ?></h2>
                        <p class="activity-description"><?php echo htmlspecialchars($activity['activityDescription']); ?></p>
                        <p class="activity-schedule">
                            <strong>Date:</strong> <?php echo htmlspecialchars($activity['activityDate']); ?><br>
                            <strong>Time:</strong> <?php echo htmlspecialchars($activity['startTime']); ?> - <?php echo htmlspecialchars($activity['endTime']); ?>
                        </p>
                        <p class="activity-participants">
                            <strong>Max Participants:</strong> <?php echo htmlspecialchars($activity['maxParticipants']); ?>
                        </p>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
</body>
</html>
