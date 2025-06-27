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
    <!-- Bootstrap JS (for modals and tabs) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f9fafb;
        margin: 0;
    }

    .content {
        margin-left: 64px;
        padding: 1.5rem 2rem;
        width: calc(100% - 64px);
        min-height: 100vh;
        transition: margin-left 0.4s ease, width 0.4s ease;
    }

    .sidebar:hover+.content {
        margin-left: 256px;
        width: calc(100% - 256px);
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
    }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include '../../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content">
            <h1 class="text-xl font-semibold text-gray-800 mb-6">Patient Details</h1>

            <!-- Patient Header -->
            <?php if (!empty($basicInfo)): ?>
            <?php $patient = $basicInfo[0]; ?>
            <div class="bg-white rounded-lg p-4 mb-6 shadow-sm flex justify-between items-center">
                <div class="flex items-center">
                    <div class="avatar bg-blue-600">
                        <?php echo strtoupper(substr($patient['full_name'], 0, 2)); ?>
                    </div>
                    <div class="ml-3">
                        <h2 class="text-base font-semibold text-gray-800">
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
                <a href="#" class="text-blue-600 text-sm hover:underline">Send Message</a>
            </div>
            <?php else: ?>
            <p class="text-red-600 text-sm">No patient data found.</p>
            <?php endif; ?>

            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <ul class="flex space-x-6">
                    <li><a href="#overview" class="pb-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600"
                            data-bs-toggle="tab">Overview</a></li>
                    <li><a href="#appointments" class="pb-2 text-sm font-medium text-gray-500 hover:text-blue-600"
                            data-bs-toggle="tab">Appointments</a></li>
                    <li><a href="#records" class="pb-2 text-sm font-medium text-gray-500 hover:text-blue-600"
                            data-bs-toggle="tab">Medical Records</a></li>
                    <li><a href="#prescriptions" class="pb-2 text-sm font-medium text-gray-500 hover:text-blue-600"
                            data-bs-toggle="tab">Prescriptions</a></li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview">
                    <!-- Appointment Info -->
                    <div class="bg-white rounded-lg p-4 mb-6 shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600">Today's Appointment</span>
                            <div class="flex space-x-2">
                                <input type="text" class="p-2 border border-gray-200 rounded-lg w-36 text-sm bg-gray-50"
                                    value="Fri, 21 Mar 2025" readonly>
                                <input type="text" class="p-2 border border-gray-200 rounded-lg w-20 text-sm bg-gray-50"
                                    value="02:00 PM" readonly>
                                < enter code hereinput type="text"
                                    class="p-2 border border-gray-200 rounded-lg w-20 text-sm bg-gray-50"
                                    value="11:20 PM" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Vitals -->
                    <div class="bg-white rounded-lg p-4 mb-6 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3"><i class="bi bi-heart mr-1"></i>Vitals</h3>
                        <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Blood Glucose</p>
                                <p class="text-sm font-medium text-gray-800">120 mg/dL</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Weight</p>
                                <p class="text-sm font-medium text-gray-800">55 Kg</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Heart Rate</p>
                                <p class="text-sm font-medium text-gray-800">70 bpm</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Oxygen Saturation</p>
                                <p class="text-sm font-medium text-gray-800">71%</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Temperature</p>
                                <p class="text-sm font-medium text-gray-800">98.1 F</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Blood Pressure</p>
                                <p class="text-sm font-medium text-gray-800">120/80 mmHg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Medications -->
                    <div class="bg-white rounded-lg p-4 mb-6 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Medications</h3>
                        <?php if (!empty($prescriptions)): ?>
                        <?php foreach ($prescriptions as $prescription): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($prescription['medicines']); ?>
                            </p>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($prescription['dosage']); ?> -
                                <?php echo date('h:i A', strtotime($prescription['created_at'])); ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">No medications recorded.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Routine Notes -->
                    <div class="bg-white rounded-lg p-4 mb-6 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Routine Notes</h3>
                        <?php if (!empty($prescriptions)): ?>
                        <?php foreach ($prescriptions as $prescription): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <p class="text-sm text-gray-600">
                                <?php echo htmlspecialchars($prescription['test_name'] ?: 'General Note'); ?></p>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($prescription['instructions'] ?: 'No instructions'); ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">No notes recorded.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Test Reports -->
                    <div class="bg-white rounded-lg p-4 mb-6 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Test Reports</h3>
                        <?php if (!empty($medical_records)): ?>
                        <?php foreach ($medical_records as $record): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($record['test_title']); ?></p>
                            <p class="text-sm text-gray-500">
                                <?php echo date('M d, Y', strtotime($record['uploaded_at'])); ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">No test reports recorded.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <a href="#"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Reschedule
                            Appointment</a>
                        <button type="button"
                            class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700"
                            data-bs-toggle="modal" data-bs-target="#complaintsModal"
                            onclick="setPatientId('<?php echo htmlspecialchars($patient['user_id']); ?>')">Prescribe</button>
                    </div>
                </div>

                <!-- Appointments Tab -->
                <div class="tab-pane fade" id="appointments">
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Appointment History</h3>
                        <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <p class="text-sm text-gray-600">
                                <?php echo htmlspecialchars($appointment['appointment_type']); ?></p>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">
                                    <?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?> |
                                    <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></p>
                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($appointment['status']); ?>
                                </p>
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
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Medical Records</h3>
                        <?php if (!empty($medical_records)): ?>
                        <?php foreach ($medical_records as $record): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($record['test_title']); ?>
                                (<?php echo htmlspecialchars($record['document_type']); ?>)</p>
                            <div class="flex items-center space-x-3">
                                <p class="text-sm text-gray-500">
                                    <?php echo date('M d, Y', strtotime($record['uploaded_at'])); ?></p>
                                <a href="<?php echo htmlspecialchars($record['file_path']); ?>"
                                    class="text-blue-600 text-sm hover:underline">View</a>
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
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Prescriptions</h3>
                        <?php if (!empty($prescriptions)): ?>
                        <?php foreach ($prescriptions as $prescription): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($prescription['medicines']); ?>
                            </p>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($prescription['dosage']); ?> -
                                <?php echo date('M d, Y', strtotime($prescription['created_at'])); ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">No prescriptions recorded.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Include Modals -->
            <?php include 'prescription_merged.php'; ?>
        </div>
    </div>

    <script>
    function setPatientId(patientId) {
        document.querySelector('input[name="patient_id"]').value = patientId;
    }
    </script>
</body>

</html>