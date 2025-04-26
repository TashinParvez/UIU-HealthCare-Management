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

        .appointments-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .appointments-section {
            padding: 20px 0;
            width: 100%;
        }

        .appointments-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
            /* Updated to match Doctor Registration Form */
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
        <div class="appointments-container">
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
                        <tr onclick="window.location.href='patient-info.html?patient=leslie-alexander';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Leslie Alexander"> Leslie Alexander</td>
                            <td>leslie.alexander@example.com</td>
                            <td>10/10/2020</td>
                            <td>09:15-09:45am</td>
                            <td>Dr. Jacob Jones</td>
                            <td>Mumps Stage II</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=ronald-richards';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Ronald Richards"> Ronald Richards</td>
                            <td>ronald.richards@example.com</td>
                            <td>10/12/2020</td>
                            <td>12:00-12:45pm</td>
                            <td>Dr. Theresa Webb</td>
                            <td>Depression</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=jane-cooper';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Jane Cooper"> Jane Cooper</td>
                            <td>jane.cooper@example.com</td>
                            <td>10/13/2020</td>
                            <td>01:15-01:45pm</td>
                            <td>Dr. Jacob Jones</td>
                            <td>Arthritis</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=robert-fox';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Robert Fox"> Robert Fox</td>
                            <td>robert.fox@gmail.com</td>
                            <td>10/14/2020</td>
                            <td>02:00-02:45pm</td>
                            <td>Dr. Arlene McCoy</td>
                            <td>Fracture</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=jenny-wilson';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Jenny Wilson"> Jenny Wilson</td>
                            <td>jenny.wilson@example.com</td>
                            <td>10/15/2020</td>
                            <td>12:00-12:45pm</td>
                            <td>Dr. Esther Howard</td>
                            <td>Depression</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=marshall-cook';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Marshall Cook"> Marshall Cook</td>
                            <td>marshall.cook@example.com</td>
                            <td>10/17/2020</td>
                            <td>01:15-01:45pm</td>
                            <td>Dr. Jacob Jones</td>
                            <td>Dyslexia</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=stephanie-cook';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Stephanie Cook"> Stephanie Cook</td>
                            <td>stephanie.cook@exzmple.com</td>
                            <td>10/17/2020</td>
                            <td>02:00-02:45pm</td>
                            <td>Dr. Theresa Webb</td>
                            <td>Hypothermia</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=marion-james';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Marion James"> Marion James</td>
                            <td>marion.james@example.com</td>
                            <td>10/18/2020</td>
                            <td>09:15-09:45am</td>
                            <td>Dr. Esther Howard</td>
                            <td>Sunburn</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=teresa-holland';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Teresa Holland"> Teresa Holland</td>
                            <td>teresa.holland@example.com</td>
                            <td>10/19/2020</td>
                            <td>12:00-12:45pm</td>
                            <td>Dr. Arlene McCoy</td>
                            <td>Diarrhoea</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <tr onclick="window.location.href='patient-info.html?patient=zachary-marshall';">
                            <td><img src="/Includes/Images/happy-patient.jpg" alt="Zachary Marshall"> Zachary Marshall</td>
                            <td>zachary.marshall@example.com</td>
                            <td>10/20/2020</td>
                            <td>09:15-09:45am</td>
                            <td>Dr. Arlene McCoy</td>
                            <td>Arthritis</td>
                            <td class="action-icons">
                                <a href="#"><i class="bi bi-pencil"></i></a>
                                <a href="#"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
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