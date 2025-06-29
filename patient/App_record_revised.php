<?php
session_start();
$user_id = $_SESSION['user_id'] ?? '2003';

include "../Includes/Database_connection.php";

$sql = "SELECT 
            a.appointment_id  AS appointment_id,
            CONCAT(u.first_name, ' ', u.last_name) AS patient_name,
            u.phone AS patient_phone,
            a.appointment_date AS appointment_date,
            a.appointment_time AS appointment_time,
            CONCAT(du.first_name, ' ', du.last_name) AS doctor_name,
            pr.medicines AS  medicines
        FROM appointments a
        JOIN patients ptn ON a.patient_id = ptn.patient_id
        JOIN users u ON ptn.patient_id = u.user_id
        JOIN doctors d ON a.doctor_id = d.doctor_id
        JOIN users du ON d.doctor_id = du.user_id
        LEFT JOIN prescriptions pr ON a.appointment_id = pr.appointment_id
        WHERE a.patient_id = '$user_id'
        ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$appointments = mysqli_query($conn, $sql);
$appointments = mysqli_fetch_all($appointments, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - UIU Health Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        margin: 0;
        overflow-x: hidden;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .content {
        margin-left: 64px;
        /* Collapsed sidebar width */
        padding: 2rem;
        width: calc(100% - 64px);
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    /* Adjust content when sidebar is hovered */
    .sidebar:hover~.content {
        margin-left: 256px;
        /* Expanded sidebar width */
        width: calc(100% - 256px);
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 1000;
        transition: width 0.3s ease;
    }

    .card {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .status-ended {
        background-color: #e5e7eb;
        color: #374151;
    }

    .status-today {
        background-color: #fef3c7;
        color: #b45309;
    }

    .status-upcoming {
        background-color: #d1fae5;
        color: #047857;
    }

    .modal-content {
        border-radius: 0.75rem;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
    }

    .btn-primary {
        background-color: #2563eb;
        border-color: #2563eb;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #1e40af;
        border-color: #1e40af;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #6b7280;
        border-color: #6b7280;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
        border-color: #4b5563;
        transform: translateY(-2px);
    }

    .btn-danger {
        background-color: #ef4444;
        border-color: #ef4444;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
        border-color: #b91c1c;
        transform: translateY(-2px);
    }

    .btn-disabled {
        background-color: #d1d5db;
        border-color: #d1d5db;
        cursor: not-allowed;
    }
    </style>
    <script>
    function printSection(sectionId) {
        const printContent = document.getElementById(sectionId).innerHTML;
        const win = window.open('', '_blank');
        win.document.open();
        win.document.write(`
                <html>
                <head>
                    <title>Prescription</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        h5 { font-size: 1.25rem; margin-bottom: 20px; }
                        p { margin-bottom: 10px; line-height: 1.6; }
                    </style>
                </head>
                <body>
                    ${printContent}
                    <script>
                        window.onload = function() {
                            window.print();
                        };
                    <\/script>
                </body>
                </html>
            `);
        win.document.close();
    }
    </script>
</head>

<body class="bg-gray-100">
    <div class="wrapper">
        <?php include '../Includes/Sidebar.php'; ?>

        <div class="content">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">All Appointments</h1>
                <?php if (empty($appointments)): ?>
                <div class="card p-6 text-center">
                    <p class="text-gray-500 text-lg">No appointments found.</p>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($appointments as $row): ?>
                    <div class="card p-6">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    Appointment #<?php echo htmlspecialchars($row['appointment_id']); ?>
                                </h3>
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Patient:</span>
                                        <?php echo htmlspecialchars($row['patient_name']); ?>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Doctor:</span>
                                        <?php echo htmlspecialchars($row['doctor_name']); ?>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Date:</span>
                                        <?php echo htmlspecialchars($row['appointment_date']); ?>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Time:</span>
                                        <?php echo htmlspecialchars($row['appointment_time']); ?>
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        <span class="font-medium">Prescription:</span><br>
                                        <?php echo nl2br(htmlspecialchars($row['medicines'] ?? 'No prescription provided.')); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-6 flex flex-col space-y-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    <?php
                                    $date = $row['appointment_date'];
                                    $today = date('Y-m-d');
                                    if ($date < $today) {
                                        echo 'status-ended';
                                    } elseif ($date === $today) {
                                        echo 'status-today';
                                    } else {
                                        echo 'status-upcoming';
                                    }
                                    ?>">
                                    <?php
                                            if ($date < $today) {
                                                echo 'Appointment Ended';
                                            } elseif ($date === $today) {
                                                echo 'TODAY IS YOUR APPOINTMENT';
                                            } else {
                                                echo 'UPCOMING Appointment';
                                            }
                                            ?>
                                </span>
                                <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">
                                    <button class="btn btn-primary text-white px-4 py-2 rounded-lg text-sm font-medium"
                                        data-bs-toggle="modal"
                                        data-bs-target="#printModal<?php echo $row['appointment_id']; ?>">
                                        Print
                                    </button>
                                    <?php if ($row['appointment_date'] > date('Y-m-d')): ?>
                                    <button class="btn btn-danger text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Cancel
                                    </button>
                                    <?php else: ?>
                                    <button class="btn btn-disabled text-white px-4 py-2 rounded-lg text-sm font-medium"
                                        disabled>
                                        Cancel
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="printModal<?php echo $row['appointment_id']; ?>" tabindex="-1"
                        aria-labelledby="printModalLabel<?php echo $row['appointment_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Prescription Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="printContent<?php echo $row['appointment_id']; ?>">
                                    <p><strong>Appointment ID:</strong>
                                        <?php echo htmlspecialchars($row['appointment_id']); ?></p>
                                    <p><strong>Patient Name:</strong>
                                        <?php echo htmlspecialchars($row['patient_name']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['patient_phone']); ?>
                                    </p>
                                    <p><strong>Date:</strong> <?php echo htmlspecialchars($row['appointment_date']); ?>
                                    </p>
                                    <p><strong>Time:</strong> <?php echo htmlspecialchars($row['appointment_time']); ?>
                                    </p>
                                    <p><strong>Doctor:</strong> <?php echo htmlspecialchars($row['doctor_name']); ?></p>
                                    <p><strong>Medicines:</strong><br><?php echo nl2br(htmlspecialchars($row['medicines'] ?? 'No prescription provided.')); ?>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        class="btn btn-secondary text-white px-4 py-2 rounded-lg text-sm font-medium"
                                        data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary text-white px-4 py-2 rounded-lg text-sm font-medium"
                                        onclick="printSection('printContent<?php echo $row['appointment_id']; ?>')">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>