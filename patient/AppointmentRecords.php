<?php

session_start();
$user_id = $_SESSION['user_id'] ?? '2003';

include "../Includes/Database_connection.php";



// --------------- A:: appointments INFO ---------------------
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
$appointments = mysqli_fetch_all($appointments, MYSQLI_ASSOC);  // returns associative array


// print_r($appointments);
// echo $appointments['blog_name'] . "<br>";






?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Table styles */
        .table-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-container th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        .table-container td {
            color: #4b5563;
        }

        .table-container td.flex {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .edit-btn {
            background-color: #1f2937;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            margin-right: 0.5rem;
            transition: background-color 0.2s ease;
        }

        .edit-btn:hover {
            background-color: #374151;
        }

        .print-btn {
            background-color: #ef4444;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease;
        }

        .print-btn:hover {
            background-color: #dc2626;
        }

        .prescribe-btn {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #4b5563;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease;
        }

        .prescribe-btn:hover {
            background-color: #f3f4f6;
        }

        .book-new-btn {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease;
        }

        .book-new-btn:hover {
            background-color: #2563eb;
        }

        /* Sidebar and layout adjustments */
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

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Include Sidebar -->
        <?php include '../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-6 content">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-blue-900">All Appointments</h1>
                <div>

                    <a href="AppointmentDashboard.php" class="book-new-btn">Appointments Timeline</a>
                    <a href="booking.php" class="book-new-btn">Book New Appointment</a>
                </div>
            </div>

            <!--=========================== Appointments Table ===========================-->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Appt. ID</th>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Prescription</th>
                            <th>Status</th>
                            <th>Cancellation</th>
                            <th>Doctor Name</th>
                        </tr>
                    </thead>

                    <tbody>


                        <!-- tashin -->
                        <?PHP
                        foreach ($appointments as $row) {  ?>
                            <tr>


                                <td>#<?php echo $row['appointment_id']; ?> </td>
                                <td><?php echo $row['patient_name']; ?> </td>
                                <td><?php echo $row['appointment_date']; ?> </td>
                                <td><?php echo $row['appointment_time']; ?> </td>

                                <!-- medicines -->
                                <td class="flex items-center gap-2">



                                    <!-- Amoxicillin 250 mg tablets -->

                                    <?PHP
                                    // foreach ($row['medicines'] as $med) {

                                    // echo $med . "<br>";
                                    // }

                                    echo "<p>" . htmlspecialchars($row['medicines']) . "</p>";

                                    ?>




                                    <!-- <button class="print-btn">Print</button> -->
                                    <button class="btn btn-secondary print-btn" data-bs-toggle="modal" data-bs-target="#printModal<?= $row['appointment_id'] ?>">Print</button>



                                </td>




                                <td>
                                    <?php
                                    $appointment_date = $row['appointment_date'];
                                    $today = date('Y-m-d'); // Current date

                                    if ($appointment_date < $today) {
                                        $status = '<button class="bg-gray-500 text-white px-2 py-1 rounded">END</button>';
                                    } elseif ($appointment_date == $today) {
                                        $status = '<button class="bg-yellow-500 text-white px-2 py-1 rounded">TODAY</button>';
                                    } else {
                                        $status = '<button class="bg-green-500 text-white px-2 py-1 rounded">UPCOMING</button>';
                                    }
                                    ?>

                                    <button class="center"><?php echo  $status; ?></button>

                                </td>

                                <td>
                                    <?php
                                    $appointment_date = $row['appointment_date'];
                                    $today = date('Y-m-d');

                                    $is_future = $appointment_date > $today;

                                    // Cancel button HTML
                                    if ($is_future) {
                                        $cancel_button = '<button class="cancel-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Cancel</button>';
                                    } else {
                                        $cancel_button = '<button class="cancel-btn bg-gray-400 text-white px-2 py-1 rounded cursor-not-allowed" disabled>Cancel</button>';
                                    }
                                    ?>

                                    <?php echo $cancel_button; ?>

                                </td>

                                <td>
                                    <?php echo $row['doctor_name']; ?>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="printModal<?= $row['appointment_id'] ?>" tabindex="-1" aria-labelledby="printModalLabel<?= $row['appointment_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="printModalLabel<?= $row['appointment_id'] ?>">Prescription Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="printContent<?= $row['appointment_id'] ?>">
                                            <div class="prescription-box">
                                                <p><strong>Appointment ID:</strong> <?= htmlspecialchars($row['appointment_id']) ?></p>
                                                <p><strong>Patient Name:</strong> <?= htmlspecialchars($row['patient_name']) ?></p>
                                                <p><strong>Phone:</strong> <?= htmlspecialchars($row['patient_phone']) ?></p>
                                                <p><strong>Date:</strong> <?= htmlspecialchars($row['appointment_date']) ?></p>
                                                <p><strong>Time:</strong> <?= htmlspecialchars($row['appointment_time']) ?></p>
                                                <p><strong>Doctor:</strong> <?= htmlspecialchars($row['doctor_name']) ?></p>
                                                <p><strong>Medicines:</strong><br><?= nl2br(htmlspecialchars($row['medicines'] ?? 'No prescription provided.')) ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="printSection('printContent<?= $row['appointment_id'] ?>')">Download PDF</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?PHP
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>