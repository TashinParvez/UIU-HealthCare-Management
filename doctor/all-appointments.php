<?php

include "../Includes/Database_connection.php";


// ---------------ALL Patient---------------------

$doctor_id = '1225';
$sql = "SELECT 
            u.first_name AS Name,
            u.email AS Email,
            a.appointment_date AS AppointmentDate,
            a.appointment_time AS VisitTime
        FROM 
            appointments a
        JOIN 
            users u ON a.patient_id = u.user_id
        WHERE 
            a.doctor_id = '$doctor_id';";

$allAppointments = mysqli_query($conn, $sql);
$allAppointments = mysqli_fetch_all($allAppointments, MYSQLI_ASSOC);  // returns associative array


// foreach ($allAppointments as $row) {
//     print_r($row);
//     echo   "<br><br>";
// }


// ===========================================================
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .appointments-section {
            padding: 20px 0;
            width: 100%;
        }

        .appointments-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .appointments-section .table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .appointments-section .table th {
            color: #6c757d;
            font-weight: 500;
        }

        .appointments-section .table td {
            color: #333;
            vertical-align: middle;
        }

        .appointments-section .table td img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .appointments-section .table tr {
            cursor: pointer;
        }

        .appointments-section .table tr:hover {
            background-color: #f1f1f1;
        }

        .appointments-section .table .action-icons a {
            color: #6c757d;
            margin-left: 10px;
            text-decoration: none;
        }

        .appointments-section .table .action-icons a:hover {
            color: #007bff;
        }

        .appointments-section .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .appointments-section .pagination .page-link {
            color: #007bff;
        }

        .appointments-section .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Sidebar and layout adjustments */
        .content {
            margin-left: 64px;
            /* Match the collapsed sidebar width */
            padding: 20px;
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            width: calc(100% - 64px);
            /* Full width minus collapsed sidebar */
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Match the expanded sidebar width */
            width: calc(100% - 256px);
            /* Full width minus expanded sidebar */
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

<body>
    <div class="d-flex min-vh-100">
        <!------------------------------ Include Sidebar ------------------------------>
        <?php include '../Includes/Sidebar.php'; ?>

        <!------------------------------ Main Content ------------------------------>
        <div class="p-4 content">
            <div class="appointments-section">
                <h1>Appointments</h1>

                <!-- Appointments Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Visit Time</th>
                            <th>Doctor</th>
                            <th>Condition</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($allAppointments as $row) {
                        ?>
                            <tr onclick="window.location.href='patient-info.html?patient=leslie-alexander';">
                                <td><img src="/Includes/Images/happy-patient.jpg" alt="Leslie Alexander">
                                    <?php echo $row['Name']; ?>
                                </td>

                                <td> <?php echo $row['Email']; ?></td>
                                <td> <?php echo $row['AppointmentDate']; ?></td>
                                <td> <?php echo $row['VisitTime']; ?></td>

                                <td>DOCTORNAME </td>
                                <td>CONDITION</td>

                                <td class="action-icons">
                                    <a href="#"><i class="bi bi-pencil"></i></a>
                                    <a href="#"><i class="bi bi-trash"></i></a>
                                </td>

                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>

                <!----------------------------- Pagination ----------------------------->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">»</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>