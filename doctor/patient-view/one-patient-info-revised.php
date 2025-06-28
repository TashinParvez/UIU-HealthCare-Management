<?php
include "../../Includes/Database_connection.php";

// Sanitize patient_id to prevent SQL injection
$patient_id = mysqli_real_escape_string($conn, '2010');

// Basic Info
$sql = "SELECT 
    u.user_id,
    CONCAT(u.first_name, ' ', u.last_name) AS full_name,
    u.email,
    u.phone,
    p.date_of_birth,
    p.gender,
    p.address,
    p.blood_group,
    p.medical_history,
    p.allergies,
    p.insurance_details
FROM 
    users u
JOIN 
    patients p ON u.user_id = p.patient_id
WHERE 
    u.user_id = '$patient_id'";
$basicInfo = mysqli_query($conn, $sql);
$basicInfo = mysqli_fetch_all($basicInfo, MYSQLI_ASSOC);

// Appointments
$sql = "SELECT 
    a.appointment_id,
    a.appointment_date,
    a.appointment_time,
    a.status,
    a.appointment_type,
    a.doctor_id
FROM 
    appointments a
WHERE 
    a.patient_id = '$patient_id'";
$appointments = mysqli_query($conn, $sql);
$appointments = mysqli_fetch_all($appointments, MYSQLI_ASSOC);

// Prescriptions
$sql = "SELECT 
    prescription_id,
    appointment_id,
    doctor_id,
    medicines,
    dosage,
    test_name,
    instructions,
    created_at
FROM 
    prescriptions
WHERE 
    patient_id = '$patient_id'";
$prescriptions = mysqli_query($conn, $sql);
$prescriptions = mysqli_fetch_all($prescriptions, MYSQLI_ASSOC);

// Medical Records
$sql = "SELECT 
    record_id,
    test_title,
    document_type,
    file_path,
    uploaded_at
FROM 
    medical_records
WHERE 
    patient_id = '$patient_id'";
$medical_records = mysqli_query($conn, $sql);
$medical_records = mysqli_fetch_all($medical_records, MYSQLI_ASSOC);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Info - UIU Health Care</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS (required for modals) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        margin: 0;
    }

    .content {
        margin-left: 64px;
        /* Collapsed sidebar width */
        padding: 2rem 3rem;
        /* Increased padding for spacious feel */
        width: calc(100% - 64px - 3rem);
        /* Adjust for right padding */
        min-height: 100vh;
        transition: margin-left 0.3s ease, width 0.3s ease;
    }


    .avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
    }

    .modal-content {
        border-radius: 0.75rem;
        border: none;
    }

    .modal-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .tab-link {
        transition: color 0.2s ease, border-color 0.2s ease;
    }

    .tab-link:hover {
        color: #2563eb;
    }

    .card {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn {
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include '../../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-2xl font-semibold text-gray-900 mb-8">Patient Details</h1>

                <!-- Patient Header -->
                <?php if (!empty($basicInfo)): ?>
                <?php $patient = $basicInfo[0]; ?>
                <div class="card p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="flex items-center">
                        <div class="avatar bg-indigo-600">
                            <?php echo strtoupper(substr($patient['full_name'], 0, 2)); ?>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                <?php echo htmlspecialchars($patient['full_name']); ?></h2>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($patient['gender']); ?> - Age
                                <?php echo date_diff(date_create($patient['date_of_birth']), date_create('today'))->y; ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($patient['medical_history'] ?: 'No medical history'); ?></p>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($patient['email']); ?></p>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($patient['phone']); ?></p>
                        </div>
                    </div>
                    <button type="button"
                        class="mt-4 md:mt-0 btn bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700"
                        data-bs-toggle="modal" data-bs-target="#messageModal">Send Message</button>
                </div>
                <?php else: ?>
                <p class="text-red-600 text-sm">No patient data found.</p>
                <?php endif; ?>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-8">
                    <ul class="flex flex-wrap gap-6">
                        <li><a href="#overview"
                                class="tab-link pb-2 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600"
                                data-bs-toggle="tab">Overview</a></li>
                        <li><a href="#appointments"
                                class="tab-link pb-2 text-sm font-medium text-gray-500 hover:text-indigo-600"
                                data-bs-toggle="tab">Appointments</a></li>
                        <li><a href="#records"
                                class="tab-link pb-2 text-sm font-medium text-gray-500 hover:text-indigo-600"
                                data-bs-toggle="tab">Medical Records</a></li>
                        <li><a href="#prescriptions"
                                class="tab-link pb-2 text-sm font-medium text-gray-500 hover:text-indigo-600"
                                data-bs-toggle="tab">Prescriptions</a></li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview">
                        <!-- Appointment Info -->
                        <div class="card p-6 mb-8">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                <span class="text-sm font-medium text-gray-600 mb-4 md:mb-0">Today's Appointment</span>
                                <div
                                    class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 w-full md:w-auto">
                                    <input type="text"
                                        class="p-2 border border-gray-200 rounded-lg text-sm bg-gray-50 w-full md:w-40"
                                        value="Fri, 21 Mar 2025" readonly>
                                    <input type="text"
                                        class="p-2 border border-gray-200 rounded-lg text-sm bg-gray-50 w-full md:w-24"
                                        value="02:00 PM" readonly>
                                    <input type="text"
                                        class="p-2 border border-gray-200 rounded-lg text-sm bg-gray-50 w-full md:w-24"
                                        value="11:20 PM" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Vitals -->
                        <div class="card p-6 mb-8">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4"><i class="bi bi-heart mr-1"></i>Vitals
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500">Blood Glucose</p>
                                    <p class="text-sm font-medium text-gray-900">120 mg/dL</p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500">Weight</p>
                                    <p class="text-sm font-medium text-gray-900">55 Kg</p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500">Heart Rate</p>
                                    <p class="text-sm font-medium text-gray-900">70 bpm</p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500">Oxygen Saturation</p>
                                    <p class="text-sm font-medium text-gray-900">71%</p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500">Temperature</p>
                                    <p class="text-sm font-medium text-gray-900">98.1 F</p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-xs text-gray-500">Blood Pressure</p>
                                    <p class="text-sm font-medium text-gray-900">120/80 mmHg</p>
                                </div>
                            </div>
                        </div>

                        <!-- Medications -->
                        <div class="card p-6 mb-8">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Medications</h3>
                            <?php if (!empty($prescriptions)): ?>
                            <?php foreach ($prescriptions as $prescription): ?>
                            <div
                                class="flex flex-col md:flex-row justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <p class="text-sm text-gray-600">
                                    <?php echo htmlspecialchars($prescription['medicines']); ?></p>
                                <p class="text-sm text-gray-500 mt-2 md:mt-0">
                                    <?php echo htmlspecialchars($prescription['dosage']); ?> -
                                    <?php echo date('h:i A, M d, Y', strtotime($prescription['created_at'])); ?></p>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p class="text-sm text-gray-500">No medications recorded.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Routine Notes -->
                        <div class="card p-6 mb-8">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Routine Notes</h3>
                            <?php if (!empty($prescriptions)): ?>
                            <?php foreach ($prescriptions as $prescription): ?>
                            <div
                                class="flex flex-col md:flex-row justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <p class="text-sm text-gray-600">
                                    <?php echo htmlspecialchars($prescription['test_name'] ?: 'General Note'); ?></p>
                                <p class="text-sm text-gray-500 mt-2 md:mt-0">
                                    <?php echo htmlspecialchars($prescription['instructions'] ?: 'No instructions'); ?>
                                </p>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p class="text-sm text-gray-500">No notes recorded.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Test Reports -->
                        <div class="card p-6 mb-8">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Test Reports</h3>
                            <?php if (!empty($medical_records)): ?>
                            <?php foreach ($medical_records as $record): ?>
                            <div
                                class="flex flex-col md:flex-row justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($record['test_title']); ?>
                                </p>
                                <div class="flex items-center space-x-3 mt-2 md:mt-0">
                                    <p class="text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($record['uploaded_at'])); ?></p>
                                    <a href="<?php echo htmlspecialchars($record['file_path']); ?>" target="_blank"
                                        class="text-indigo-600 text-sm hover:underline">View</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p class="text-sm text-gray-500">No test reports recorded.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                            <button type="button"
                                class="btn bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 w-full sm:w-auto"
                                data-bs-toggle="modal" data-bs-target="#rescheduleModal">Reschedule Appointment</button>
                            <button type="button"
                                class="btn bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 w-full sm:w-auto"
                                data-bs-toggle="modal" data-bs-target="#prescribeModal">Prescribe</button>
                        </div>
                    </div>

                    <!-- Appointments Tab -->
                    <div class="tab-pane fade" id="appointments">
                        <div class="card p-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Appointment History</h3>
                            <?php if (!empty($appointments)): ?>
                            <?php foreach ($appointments as $appointment): ?>
                            <div
                                class="flex flex-col md:flex-row justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <p class="text-sm text-gray-600">
                                    <?php echo htmlspecialchars($appointment['appointment_type']); ?></p>
                                <div class="text-left md:text-right mt-2 md:mt-0">
                                    <p class="text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?> |
                                        <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></p>
                                    <p class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($appointment['status']); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p class="text-sm text-gray-500">No appointments recorded.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Medical Records Tab -->
                    <div class="tab-pane fade" id="records">
                        <div class="card p-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Medical Records</h3>
                            <?php if (!empty($medical_records)): ?>
                            <?php foreach ($medical_records as $record): ?>
                            <div
                                class="flex flex-col md:flex-row justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($record['test_title']); ?>
                                    (<?php echo htmlspecialchars($record['document_type']); ?>)</p>
                                <div class="flex items-center space-x-3 mt-2 md:mt-0">
                                    <p class="text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($record['uploaded_at'])); ?></p>
                                    <a href="<?php echo htmlspecialchars($record['file_path']); ?>" target="_blank"
                                        class="text-indigo-600 text-sm hover:underline">View</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p class="text-sm text-gray-500">No medical records found.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Prescriptions Tab -->
                    <div class="tab-pane fade" id="prescriptions">
                        <div class="card p-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Prescriptions</h3>
                            <?php if (!empty($prescriptions)): ?>
                            <?php foreach ($prescriptions as $prescription): ?>
                            <div
                                class="flex flex-col md:flex-row justify-between py-3 border-b border-gray-100 last:border-b-0">
                                <p class="text-sm text-gray-600">
                                    <?php echo htmlspecialchars($prescription['medicines']); ?></p>
                                <p class="text-sm text-gray-500 mt-2 md:mt-0">
                                    <?php echo htmlspecialchars($prescription['dosage']); ?> -
                                    <?php echo date('M d, Y', strtotime($prescription['created_at'])); ?></p>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p class="text-sm text-gray-500">No prescriptions recorded.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm font-semibold" id="messageModalLabel">Send Message to
                        <?php echo !empty($basicInfo) ? htmlspecialchars($basicInfo[0]['full_name']) : 'Patient'; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="messageForm" action="send_message.php" method="POST">
                        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
                        <div class="mb-4">
                            <label for="messageContent" class="form-label text-sm text-gray-600">Message</label>
                            <textarea
                                class="form-control w-full p-3 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                id="messageContent" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit"
                            class="btn bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 w-full">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reschedule Appointment Modal -->
    <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm font-semibold" id="rescheduleModalLabel">Reschedule Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rescheduleForm" action="reschedule_appointment.php" method="POST">
                        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
                        <div class="mb-4">
                            <label for="appointmentDate" class="form-label text-sm text-gray-600">Date</label>
                            <input type="date"
                                class="form-control w-full p-3 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                id="appointmentDate" name="appointment_date" required>
                        </div>
                        <div class="mb-4">
                            <label for="appointmentTime" class="form-label text-sm text-gray-600">Time</label>
                            <input type="time"
                                class="form-control w-full p-3 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                id="appointmentTime" name="appointment_time" required>
                        </div>
                        <button type="submit"
                            class="btn bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 w-full">Reschedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescribe Modal -->
    <div class="modal fade" id="prescribeModal" tabindex="-1" aria-labelledby="prescribeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm font-semibold" id="prescribeModalLabel">Prescribe Medication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="prescribeForm" action="prescribe_medication.php" method="POST">
                        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
                        <div class="mb-4">
                            <label for="medicines" class="form-label text-sm text-gray-600">Medicines</label>
                            <input type="text"
                                class="form-control w-full p-3 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                id="medicines" name="medicines" required>
                        </div>
                        <div class="mb-4">
                            <label for="dosage" class="form-label text-sm text-gray-600">Dosage</label>
                            <input type="text"
                                class="form-control w-full p-3 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                id="dosage" name="dosage" required>
                        </div>
                        <div class="mb-4">
                            <label for="instructions" class="form-label text-sm text-gray-600">Instructions</label>
                            <textarea
                                class="form-control w-full p-3 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                id="instructions" name="instructions" rows="4"></textarea>
                        </div>
                        <button type="submit"
                            class="btn bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 w-full">Prescribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Ensure script runs after DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Bootstrap is available
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap JavaScript is not loaded.');
            return;
        }

        // Initialize modals
        const messageModal = document.getElementById('messageModal');
        const rescheduleModal = document.getElementById('rescheduleModal');
        const prescribeModal = document.getElementById('prescribeModal');

        if (messageModal) {
            messageModal._modal = new bootstrap.Modal(messageModal);
        }
        if (rescheduleModal) {
            rescheduleModal._modal = new bootstrap.Modal(rescheduleModal);
        }
        if (prescribeModal) {
            prescribeModal._modal = new bootstrap.Modal(prescribeModal);
        }

        // Modal open functions
        window.openMessageModal = function() {
            if (messageModal && messageModal._modal) {
                messageModal._modal.show();
            } else {
                console.error('Message modal not initialized.');
            }
        };

        window.openRescheduleModal = function() {
            if (rescheduleModal && rescheduleModal._modal) {
                rescheduleModal._modal.show();
            } else {
                console.error('Reschedule modal not initialized.');
            }
        };

        window.openPrescribeModal = function() {
            if (prescribeModal && prescribeModal._modal) {
                prescribeModal._modal.show();
            } else {
                console.error('Prescribe modal not initialized.');
            }
        };

        // Client-side form validation
        const messageForm = document.getElementById('messageForm');
        if (messageForm) {
            messageForm.addEventListener('submit', function(e) {
                const message = document.getElementById('messageContent').value.trim();
                if (!message) {
                    e.preventDefault();
                    alert('Please enter a message.');
                }
            });
        }

        const rescheduleForm = document.getElementById('rescheduleForm');
        if (rescheduleForm) {
            rescheduleForm.addEventListener('submit', function(e) {
                const date = document.getElementById('appointmentDate').value;
                const time = document.getElementById('appointmentTime').value;
                if (!date || !time) {
                    e.preventDefault();
                    alert('Please select both date and time.');
                }
            });
        }

        const prescribeForm = document.getElementById('prescribeForm');
        if (prescribeForm) {
            prescribeForm.addEventListener('submit', function(e) {
                const medicines = document.getElementById('medicines').value.trim();
                const dosage = document.getElementById('dosage').value.trim();
                if (!medicines || !dosage) {
                    e.preventDefault();
                    alert('Please enter both medicines and dosage.');
                }
            });
        }
    });
    </script>
</body>

</html>