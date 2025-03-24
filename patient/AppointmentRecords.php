<!-- appointments.php -->
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
        /* gray-200 */
    }

    .table-container th {
        background-color: #f9fafb;
        /* gray-50 */
        font-weight: 600;
        color: #374151;
        /* gray-700 */
    }

    .table-container td {
        color: #4b5563;
        /* gray-600 */
    }

    /* Prescription column with buttons */
    .table-container td.flex {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        /* Space between prescription text and buttons */
    }

    /* Button styles */
    .edit-btn {
        background-color: #1f2937;
        /* gray-800 */
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
        transition: background-color 0.2s ease;
    }

    .edit-btn:hover {
        background-color: #374151;
        /* gray-700 */
    }

    .print-btn {
        background-color: #ef4444;
        /* red-500 */
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s ease;
    }

    .print-btn:hover {
        background-color: #dc2626;
        /* red-600 */
    }

    .prescribe-btn {
        background-color: transparent;
        border: 1px solid #d1d5db;
        /* gray-300 */
        color: #4b5563;
        /* gray-600 */
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s ease;
    }

    .prescribe-btn:hover {
        background-color: #f3f4f6;
        /* gray-100 */
    }

    .book-new-btn {
        background-color: #3b82f6;
        /* blue-500 */
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s ease;
    }

    .book-new-btn:hover {
        background-color: #2563eb;
        /* blue-600 */
    }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Include Sidebar -->
        <?php include '../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-6 ml-16">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-blue-900">Appointments</h1>
                <a href="booking.php" class="book-new-btn">Book New Appointment</a>
            </div>

            <!-- Appointments Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Appt. ID</th>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Prescription</th>
                            <th>Contact</th>
                            <th>Doctor Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Sample appointment data
                        $appointments = [
                            [
                                'id' => '#123456',
                                'patient_name' => 'Ravad NADAM',
                                'date' => '05.01.2024',
                                'time' => '12:00',
                                'prescription' => 'Amoxicillin 250 mg tablets',
                                'doctor_name' => 'Ravad NADAM',
                            ],
                            [
                                'id' => '#153151',
                                'patient_name' => 'Ravad NADAM',
                                'date' => '04.01.2024',
                                'time' => '15:00',
                                'prescription' => '',
                                'doctor_name' => 'Ravad NADAM',
                            ],
                            [
                                'id' => '#123456',
                                'patient_name' => 'Ravad NADAM',
                                'date' => '05.01.2024',
                                'time' => '12:00',
                                'prescription' => 'Amoxicillin 250 mg tablets',
                                'doctor_name' => 'Ravad NADAM',
                            ],
                            [
                                'id' => '#123456',
                                'patient_name' => 'Ravad NADAM',
                                'date' => '05.01.2024',
                                'time' => '12:00',
                                'prescription' => '',
                                'doctor_name' => 'Ravad NADAM',
                            ],
                            [
                                'id' => '#123456',
                                'patient_name' => 'Ravad NADAM',
                                'date' => '05.01.2024',
                                'time' => '12:00',
                                'prescription' => 'Amoxicillin 250 mg tablets',
                                'doctor_name' => 'Ravad NADAM',
                            ],
                        ];

                        foreach ($appointments as $appointment) {
                            echo '<tr>';
                            echo '<td>' . $appointment['id'] . '</td>';
                            echo '<td>' . $appointment['patient_name'] . '</td>';
                            echo '<td>' . $appointment['date'] . '</td>';
                            echo '<td>' . $appointment['time'] . '</td>';
                            echo '<td class="flex items-center gap-2">';
                            if ($appointment['prescription']) {
                                echo $appointment['prescription'];
                            } else {
                                echo '<button class="prescribe-btn">prescribe</button>';
                            }
                            echo '<button class="edit-btn">Edit</button>';
                            echo '<button class="print-btn">Print</button>';
                            echo '</td>';
                            echo '<td>';
                            echo '<button class="edit-btn">send msg.</button>';
                            echo '</td>';
                            echo '<td>' . $appointment['doctor_name'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>