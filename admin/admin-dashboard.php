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
    <?php include '../Includes/Sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content flex-1">
        <div class="dashboard-container">
            <div class="dashboard-section">
                <h1>Dashboard</h1>

                <!-- Today's Available Doctors -->
                <div class="row mb-4">
                    <div class="col-md-6">
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
                                <tr>
                                    <td>01</td>
                                    <td>Dr. Kendrick Debus</td>
                                    <td>Critical Care</td>
                                    <td>+01746888888</td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>Dr. Kendrick Debus</td>
                                    <td>Critical Care</td>
                                    <td>+01746888888</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>Dr. Kendrick Debus</td>
                                    <td>Critical Care</td>
                                    <td>+01746888888</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>Dr. Kendrick Debus</td>
                                    <td>Critical Care</td>
                                    <td>+01746888888</td>
                                </tr>
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
                    <div class="col-md-3">
                        <div class="stat-card" style="background-color: #ffe5e5;">
                            <div class="icon-placeholder"></div>
                            <h3>1k</h3>
                            <p>Endocrinology</p>
                            <p class="percentage">+8% from yesterday</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="background-color: #fff5e5;">
                            <div class="icon-placeholder"></div>
                            <h3>300</h3>
                            <p>Cardiology</p>
                            <p class="percentage">+5% from yesterday</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="background-color: #e5f5e5;">
                            <div class="icon-placeholder"></div>
                            <h3>5</h3>
                            <p>Oncology</p>
                            <p class="percentage down">-1.2% from yesterday</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="background-color: #e5e5ff;">
                            <div class="icon-placeholder"></div>
                            <h3>8</h3>
                            <p>Dental</p>
                            <p class="percentage">0.5% from yesterday</p>
                        </div>
                    </div>
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
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: 'Created Account',
                        data: [50, 70, 90, 120, 150, 180, 200, 220, 210, 190, 170, 160],
                        borderColor: '#6f42c1',
                        backgroundColor: 'rgba(111, 66, 193, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Visited Website',
                        data: [100, 120, 140, 160, 180, 200, 220, 240, 230, 210, 190, 180],
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Took Appointment',
                        data: [30, 40, 50, 60, 70, 80, 90, 100, 95, 90, 85, 80],
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