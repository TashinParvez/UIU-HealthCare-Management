-- Generate fake visit_counts data for last 15 months

START TRANSACTION;

-- Adjust the range as needed
-- Insert one row per day with a random visit count between 20 and 200
<?php

include "../../../UIU-HealthCare-Management/Includes/Database_connection.php";

$startDate = new DateTime();
$startDate->modify('-15 months');
$endDate = new DateTime();

while ($startDate <= $endDate) {
    $visit_date = $startDate->format('Y-m-d');
    $visit_count = rand(20, 200);

    echo "INSERT INTO visit_counts (visit_date, visit_count) VALUES ('$visit_date', $visit_count);\n";

    $startDate->modify('+1 day');
}
?>
COMMIT;

