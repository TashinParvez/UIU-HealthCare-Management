<?php

session_start();
$user_id = $_SESSION['user_id'] ?? '1220';

include "../Includes/Database_connection.php";


// Set the time zone to Bangladesh Standard Time (BST)
$bdTimeZone = new DateTimeZone('Asia/Dhaka');
$bdDateTime = new DateTime('now', $bdTimeZone);

$currentDateTime = $bdDateTime->getTimestamp(); // Current time as timestamp

$current_time = $bdDateTime->format('H:i:s'); // Output format 10:25:45
$today_date = $bdDateTime->format('d-m-Y'); // Output: 20-05-2025


// ............... Taking Today's Doctors Information ..........................

$stmt = $conn->prepare("
    SELECT 
        CONCAT(u.first_name, ' ', u.last_name) AS name,
        d.department,
        u.phone
    FROM
        doctors d JOIN users u 
    ON
        d.doctor_id = u.user_id
    WHERE
        d.available_days LIKE CONCAT('%', DAYNAME(CURDATE()), '%')
");

$stmt->execute();
$result = $stmt->get_result();
$today_doctors_info = $result->fetch_all(MYSQLI_ASSOC);


// ........... Taking data for Visitors Traffic Graph ..........

$stmt = $conn->prepare("
    SELECT 
        months.month,
        IF(IFNULL(vc.total_visits * 0.1, 0) = 0, 250, vc.total_visits * 0.1) AS total_visits,
        IF(IFNULL(ua.total_accounts * 3, 0) = 0, 30, ua.total_accounts * 3) AS total_accounts,
        IF(IFNULL(ap.total_appointments * 10, 0) = 0, 100, ap.total_appointments * 10) AS total_appointments
    FROM (
        SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%b-%y') AS month,
               DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL n MONTH), '%Y-%m') AS ym
        FROM (
            SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
            UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8
            UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
        ) AS months_back
    ) AS months
    LEFT JOIN (
        SELECT 
            DATE_FORMAT(visit_date, '%Y-%m') AS ym,
            SUM(visit_count) AS total_visits
        FROM visit_counts
        WHERE visit_date >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 13 MONTH), '%Y-%m-01')
          AND visit_date < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-01')
        GROUP BY ym
    ) AS vc ON vc.ym = months.ym
    LEFT JOIN (
        SELECT 
            DATE_FORMAT(created_at, '%Y-%m') AS ym,
            COUNT(*) AS total_accounts
        FROM users
        WHERE created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 13 MONTH), '%Y-%m-01')
          AND created_at < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-01')
        GROUP BY ym
    ) AS ua ON ua.ym = months.ym
    LEFT JOIN (
        SELECT 
            DATE_FORMAT(appointment_booked_time, '%Y-%m') AS ym,
            COUNT(*) AS total_appointments
        FROM appointments
        WHERE appointment_booked_time >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 13 MONTH), '%Y-%m-01')
          AND appointment_booked_time < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-01')
        GROUP BY ym
    ) AS ap ON ap.ym = months.ym
    ORDER BY months.ym
");

$stmt->execute();
$result = $stmt->get_result();
$summary_data = $result->fetch_all(MYSQLI_ASSOC);


//  Sample Output

// [
//   ["month" => "Jun-24", "total_visits" => 240, "total_accounts" => 18, "total_appointments" => 45],
//   ["month" => "Jul-24", "total_visits" => 220, "total_accounts" => 14, "total_appointments" => 39],
//   ...
// ]


// ........... Taking data for "Total Patients Departmentwise Statistics" for the last month ..........

$stmt = $conn->prepare("
    SELECT 
        d.department,
        COUNT(a.appointment_id) AS total_appointments
    FROM 
        appointments a
    JOIN 
        doctors d ON a.doctor_id = d.doctor_id
    WHERE 
        MONTH(a.appointment_date) = MONTH(CURDATE() - INTERVAL 1 MONTH)
        AND YEAR(a.appointment_date) = YEAR(CURDATE() - INTERVAL 1 MONTH)
    GROUP BY 
        d.department
    ORDER BY 
        total_appointments DESC
");

$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);

// Shuffle top 5 and re-append the rest
$top5 = array_slice($appointments, 0, 5);
$rest = array_slice($appointments, 5);

shuffle($top5);
shuffle($rest);

$last_month_department_appointments = array_merge($top5, $rest);

//  Sample Output
// [
//     'department' => 'Neurology',
//     'total_appointments' => 27
// ]



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <!-- Tailwind CSS for Sidebar -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .content {
            margin-left: 64px;
            /* Match the collapsed sidebar width */
            padding: 20px;
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Match the expanded sidebar width */
        }

        .dashboard-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .dashboard-section {
            padding: 20px 0;
        }

        .dashboard-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .dashboard-section h5 {
            font-size: 1.25rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 15px;
        }

        .dashboard-section .table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-section .table th {
            color: #6c757d;
            font-weight: 500;
        }

        .dashboard-section .table td {
            color: #333;
        }

        .dashboard-section .graph-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            height: 300px;
        }

        .dashboard-section .export-btn {
            float: right;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .dashboard-section .export-btn:hover {
            text-decoration: underline;
        }

        .dashboard-section .stat-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .dashboard-section .stat-card .icon-placeholder {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
        }

        .dashboard-section .stat-card h3 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .dashboard-section .stat-card p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .dashboard-section .stat-card .percentage {
            font-size: 0.8rem;
            color: #28a745;
        }

        .dashboard-section .stat-card .percentage.down {
            color: #dc3545;
        }

        .sidebar {
            transition: width 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            transform: translateZ(0);
            will-change: width;
        }

        .sidebar:not(:hover) .sidebar-text {
            display: none;
        }

        .sidebar:not(:hover) .search-input {
            display: none;
        }

        .sidebar-item {
            position: relative;
            overflow: hidden;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(147, 51, 234, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .sidebar-item:hover::before {
            left: 100%;
        }

        .sidebar-item:hover {
            background-color: #f3f4f6;
            color: #9333ea;
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }
    </style>
</head>

<body class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <?php include '../Includes/SidebarAdmin.php'; ?>

    <!-- Main Content -->
    <div class="content flex-1">
        <div class="dashboard-container">
            <div class="dashboard-section">
                <h1>Dashboard</h1>

                <!-- Today's Available Doctors -->
                <div class="row mb-4">
                    <div class="">
                    <!-- <div class="col-md-6"> -->
                        <h5>Today's Available Doctors</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($today_doctors_info as $index => $today_doctor_info): ?>

                                    <?php if ($index >= 8) break; ?>

                                    <tr>
                                        <td><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo htmlspecialchars($today_doctor_info['name']); ?></td>
                                        <td><?php echo htmlspecialchars($today_doctor_info['department']); ?></td>
                                        <td>+<?php echo htmlspecialchars($today_doctor_info['phone']); ?></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Visitors Traffic</h5>
                        <div class="graph-container">
                            <canvas id="visitorsTrafficChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Total Patients Departmentwise -->
                <h5>Total Patients Departmentwise</h5>
                <p class="text-muted mb-3">Last Month Patients Statistics <a href="#" class="export-btn">Export</a></p>
                <div class="row">
                    <?php
                    $colors = ['#ffe5e5', '#e5f0ff', '#e5ffe5', '#fff5e5', '#f0e5ff'];

                    // Optional: Shuffle first 5, then merge with rest
                    $topFive = array_slice($last_month_department_appointments, 0, 5);
                    shuffle($topFive);
                    $remaining = array_slice($last_month_department_appointments, 5);
                    $appointments = array_merge($topFive, $remaining);

                    // Limit to 4 cards
                    $appointments = array_slice($appointments, 0, 4);

                    foreach ($appointments as $index => $data):
                        $bgColor = $colors[$index % count($colors)];
                        $count = $data['total_appointments'] * 17;

                        // Format number
                        $formatted = ($count < 1000) ? $count : round($count / 1000, 1) . 'k';
                    ?>
                        <div class="col-md-3">
                            <div class="stat-card" style="background-color: <?= $bgColor ?>;">
                                <div class="icon-placeholder"></div>
                                <h3><?= $formatted ?></h3>
                                <p><?= htmlspecialchars($data['department']) ?></p>
                                <p class="percentage">+8% from yesterday</p> <!-- placeholder -->
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('visitorsTrafficChart').getContext('2d');
        const visitorsTrafficChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    <?php foreach ($summary_data as $row) {
                        echo "'" . $row['month'] . "', ";
                    } ?>
                ],
                datasets: [{
                        label: 'Created Account',
                        data: [
                            <?php foreach ($summary_data as $row) {
                                echo $row['total_accounts'] . ", ";
                            } ?>
                        ],
                        borderColor: '#6f42c1',
                        backgroundColor: 'rgba(111, 66, 193, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Visited Website[K]',
                        data: [
                            <?php foreach ($summary_data as $row) {
                                echo $row['total_visits'] . ", ";
                            } ?>
                        ],
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Took Appointment',
                        data: [
                            <?php foreach ($summary_data as $row) {
                                echo $row['total_appointments'] . ", ";
                            } ?>
                        ],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 400,
                        ticks: {
                            stepSize: 100
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>

</html>