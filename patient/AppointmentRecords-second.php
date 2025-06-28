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
    <title>Appointments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                        }
                    <\/script>
                </body>
                </html>`);
            win.document.close();
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <?php include '../Includes/Sidebar.php'; ?>

        <div class="flex-1 p-6 content">
            <div class="table-container bg-white p-4 rounded shadow">
                <h1 class="text-xl font-bold mb-4">All Appointments</h1>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>Appt. ID</th>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Prescription</th>
                            <th>Status</th>
                            <th>Cancel</th>
                            <th>Doctor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($appointments as $row): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($row['appointment_id']) ?></td>
                            <td><?= htmlspecialchars($row['patient_name']) ?></td>
                            <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                            <td class="flex gap-2">
                                <?= htmlspecialchars($row['medicines']) ?>
                                <button class="print-btn btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#printModal<?= $row['appointment_id'] ?>">Print</button>
                            </td>
                            <td>
                                <?php
                                $date = $row['appointment_date'];
                                $today = date('Y-m-d');
                                if ($date < $today) {
                                    echo '<span class="text-gray-700">END</span>';
                                } elseif ($date === $today) {
                                    echo '<span class="text-yellow-600">TODAY</span>';
                                } else {
                                    echo '<span class="text-green-600">UPCOMING</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($row['appointment_date'] > date('Y-m-d')): ?>
                                    <button class="bg-red-500 text-white px-2 py-1 rounded">Cancel</button>
                                <?php else: ?>
                                    <button class="bg-gray-300 text-white px-2 py-1 rounded cursor-not-allowed" disabled>Cancel</button>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                        </tr>

                        <div class="modal fade" id="printModal<?= $row['appointment_id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Prescription Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body" id="printContent<?= $row['appointment_id'] ?>">
                                        <p><strong>Appointment ID:</strong> <?= htmlspecialchars($row['appointment_id']) ?></p>
                                        <p><strong>Patient Name:</strong> <?= htmlspecialchars($row['patient_name']) ?></p>
                                        <p><strong>Phone:</strong> <?= htmlspecialchars($row['patient_phone']) ?></p>
                                        <p><strong>Date:</strong> <?= htmlspecialchars($row['appointment_date']) ?></p>
                                        <p><strong>Time:</strong> <?= htmlspecialchars($row['appointment_time']) ?></p>
                                        <p><strong>Doctor:</strong> <?= htmlspecialchars($row['doctor_name']) ?></p>
                                        <p><strong>Medicines:</strong><br><?= nl2br(htmlspecialchars($row['medicines'] ?? 'No prescription provided.')) ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" onclick="printSection('printContent<?= $row['appointment_id'] ?>')">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
