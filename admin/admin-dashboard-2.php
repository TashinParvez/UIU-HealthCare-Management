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

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .dashboard-section {
            padding: 20px 0;
            width: 100%;
            /* Ensure full width */
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
            width: 100%;
            /* Full width for table */
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
            width: 100%;
            /* Full width for graph */
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
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!------------------------------ Include Sidebar ------------------------------>
        <?php include '../Includes/Sidebar.php'; ?>

        <!------------------------------ Main Content ------------------------------>
        <div class="flex-grow-1 p-4" style="margin-left: 4rem;">
            <div class="dashboard-section">
                <h1>Dashboard</h1>

                <!-- Today's Available Doctors -->
                <div class="mb-4">
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

                <!-- Visitors Traffic -->
                <div class="mb-4">
                    <h5>Visitors Traffic</h5>
                    <div class="graph-container">
                        <canvas id="visitorsTrafficChart"></canvas>
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