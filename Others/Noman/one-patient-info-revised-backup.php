<?php
include "../../Includes/Database_connection.php";


if (isset($_GET['appointment_id'])) {
    $appointment_id = intval($_GET['appointment_id']); // Use intval to sanitize input
} else {
    $appointment_id = 30;
}


//  ===================================== get patient id    =====================================
$sql = "SELECT patient_id
        FROM appointments
        WHERE appointment_id = '$appointment_id';
";
$p_id = mysqli_query($conn, $sql);
$p_id = mysqli_fetch_all($p_id, MYSQLI_ASSOC);


$p_id =  $p_id[0]['patient_id'];

// echo $p_id;
// 2001 sadia


// Sanitize patient_id to prevent SQL injection
$patient_id = mysqli_real_escape_string($conn, $p_id);

//==================================================================== Basic Info  =====================================
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

//==================================================================== Todays Appointments  =====================================
$sql = "SELECT 
    a.appointment_id,
    a.appointment_date,
    a.appointment_time,
    a.status,
    a.appointment_type,
    a.appointment_booked_time
FROM appointments a
WHERE a.appointment_id = 33;        
";

$today_appointments = mysqli_query($conn, $sql);
$today_appointments = mysqli_fetch_all($today_appointments, MYSQLI_ASSOC);


// print_r($today_appointments);

//==================================================================== ALL Appointments  =====================================
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

//==================================================================== last Prescriptions/Medications  =====================================
$sql = "SELECT 
            pr.medicines, 
            pr.instructions
        FROM appointments a
        LEFT JOIN prescriptions pr ON a.appointment_id = pr.appointment_id
        WHERE a.patient_id = '$patient_id'
        AND a.status = 'COMPLETED'
        ORDER BY a.appointment_date DESC, a.appointment_time DESC
        LIMIT 1;
";

$medications = mysqli_query($conn, $sql);
$medications = mysqli_fetch_all($medications, MYSQLI_ASSOC);




$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $medications = $row['medicines'];
    $instructions = $row['instructions'];
}

//==================================================================== Medical Records  =====================================
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
    <!-- Bootstrap CSS -->
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
            padding: 2rem 3rem;
            width: calc(100% - 64px - 3rem);
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

        /* New Modal Styles */
        .modal {
            --bs-modal-bg: rgba(0, 0, 0, 0.5);
        }

        .modal-dialog {
            max-width: 700px;
            margin: 1.75rem auto;
            transition: transform 0.3s ease-out, opacity 0.2s ease-out;
        }

        .modal.fade .modal-dialog {
            transform: translateY(-50px);
            opacity: 0;
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            background: white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
            padding: 20px 24px;
        }

        .modal-header .btn-close {
            background-size: 1.2rem;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-body .card {
            border: none;
            box-shadow: none;
            background: transparent;
        }

        .modal-body .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .modal-body .step-indicator .step {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 6px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal-body .step-indicator .step.active {
            background-color: #007bff;
            color: white;
            transform: scale(1.1);
        }

        .modal-body .step-indicator .line {
            width: 36px;
            height: 3px;
            background-color: #e9ecef;
            margin: 12.5px 0;
            transition: background-color 0.3s ease;
        }

        .modal-body .step-indicator .line.active {
            background-color: #007bff;
        }

        .modal-body .card h5 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a3c34;
            text-align: center;
            margin-bottom: 24px;
        }

        .modal-body .complaint-tags .badge,
        .modal-body .test-tags .badge,
        .modal-body .specialist-tags .badge {
            background-color: #6c757d;
            color: white;
            font-size: 0.85rem;
            padding: 8px 14px;
            margin: 4px;
            border-radius: 16px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .modal-body .complaint-tags .badge:hover,
        .modal-body .test-tags .badge:hover,
        .modal-body .specialist-tags .badge:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
        }

        .modal-body .complaint-tags .badge i,
        .modal-body .test-tags .badge i,
        .modal-body .specialist-tags .badge i {
            margin-left: 6px;
        }

        .modal-body textarea {
            width: 100%;
            min-height: 140px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            font-size: 0.9rem;
            color: #495057;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .modal-body textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .modal-body .medicine-row,
        .modal-body .followup-row {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            gap: 8px;
        }

        .modal-body .medicine-row input[type="text"],
        .modal-body .medicine-row input[type="number"],
        .modal-body .medicine-row select,
        .modal-body .followup-row input[type="date"],
        .modal-body .followup-row input[type="time"] {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.9rem;
            color: #495057;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .modal-body .medicine-row input[type="text"] {
            flex: 2;
        }

        .modal-body .medicine-row input[type="number"] {
            width: 60px;
        }

        .modal-body .medicine-row select,
        .modal-body .followup-row input[type="date"],
        .modal-body .followup-row input[type="time"] {
            flex: 1;
        }

        .modal-body .medicine-row input:focus,
        .modal-body .medicine-row select:focus,
        .modal-body .followup-row input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .modal-body .add-more {
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-body .add-more a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .modal-body .add-more a:hover {
            color: #007bff;
        }

        .modal-body .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 40px;
            font-size: 1rem;
            font-weight: 500;
            display: block;
            margin: 20px auto 0;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }

        .modal-body .btn-submit:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .modal-footer {
            border-top: none;
            padding: 0 24px 24px;
            display: flex;
            justify-content: space-between;
        }

        .modal-footer .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 40px;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .modal-footer .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php
        if (file_exists('../../Includes/Sidebar.php')) {
            include '../../Includes/Sidebar.php';
        } else {
            echo '<div class="alert alert-warning">Sidebar.php not found.</div>';
        }
        ?>

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

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview">


                        <!--===================================== Appointment Info =====================================-->
                        <div class="card p-6 mb-8">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                <span class="text-sm font-medium text-gray-600 mb-4 md:mb-0">Today's Appointment</span>


                                <div
                                    class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 w-full md:w-auto">
                                    <input type="text"
                                        class="p-2 border border-gray-200 rounded-lg text-sm bg-gray-50 w-full md:w-40"
                                        value="<?php echo htmlspecialchars($today_appointments[0]['appointment_date']); ?>" readonly>
                                    <input type="text"
                                        class="p-2 border border-gray-200 rounded-lg text-sm bg-gray-50 w-full md:w-24"
                                        value="<?php echo htmlspecialchars($today_appointments[0]['appointment_time']); ?>" readonly>
                                    <input type="text"
                                        class="p-2 border border-gray-200 rounded-lg text-sm bg-gray-50 w-full md:w-24"
                                        value="<?php echo htmlspecialchars($today_appointments[0]['appointment_type']); ?>" readonly>
                                </div>

                            </div>
                        </div>


                        <!--================================ Vitals ================================-->
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

                        <!--================================ Medications ================================-->
                        <div class="card p-6 mb-8">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Medications</h3>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($medications); ?>

                            </p>

                        </div>


                        <!-- Routine Notes -->
                        <div class="card p-6 mb-8">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Routine Advice</h3>

                            <p class="text-sm text-gray-500"> <?php echo htmlspecialchars($instructions); ?></p>

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

                            <!-- modal call here  -->
                            <button type="button"
                                class="btn bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 w-full sm:w-auto"
                                data-bs-toggle="modal" data-bs-target="#complaintsModal">Start Prescription
                            </button>

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

            <!--===================================================== Complaints Modal =====================================================-->
            <!--===================================================== TASHIN =====================================================-->
            <!--===================================================== TASHIN =====================================================-->


            <div class="modal fade" id="complaintsModal" tabindex="-1" aria-labelledby="complaintsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="complaintsModalLabel">Chief Complaints</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line"></div>
                                    <div class="step">2</div>
                                    <div class="line"></div>
                                    <div class="step">3</div>
                                    <div class="line"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Chief Complaints</h5>

                                <!-- <div class="complaint-tags" id="complaintTags">
                                    <span class="badge" data-value="Headache">Headache <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Insomnia">Insomnia <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Tiredness">Tiredness <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Another Complaint">Another Complaint <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Typhoid">Typhoid <i
                                            class="bi bi-x remove-tag"></i></span>
                                </div>
                                 -->

                                <textarea id="complaintNotes" name="complaint_notes"
                                    placeholder="Enter additional chief complaints"
                                    aria-label="Chief Complaints Notes"></textarea>

                                <button class="btn-submit"
                                    onclick="saveAndContinue('complaintsModal', 'medicineModal')">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicine Modal -->
            <div class="modal fade" id="medicineModal" tabindex="-1" aria-labelledby="medicineModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="medicineModalLabel">Prescribe Medicine</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line"></div>
                                    <div class="step">3</div>
                                    <div class="line"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Medicine</h5>

                                <div id="medicineRows">
                                    <div class="medicine-row">
                                        <input type="text" name="medicines[]" placeholder="Medicine Name"
                                            aria-label="Medicine Name">
                                        <input type="number" name="dosages[]" min="1" value="1" aria-label="Dosage">
                                        <select name="timings[]" aria-label="Meal Timing">
                                            <option>Before Meal</option>
                                            <option>After Meal</option>
                                        </select>
                                        <input type="text" name="durations[]" value="10 Days" aria-label="Duration">
                                    </div>
                                </div>

                                <div class="add-more">
                                    <a href="#" onclick="addMedicineRow()">Add More <i
                                            class="bi bi-plus-circle me-1"></i></a>
                                </div>

                                <button class="btn-submit"
                                    onclick="saveAndContinue('medicineModal', 'testsModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('medicineModal', 'complaintsModal')">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tests Modal -->
            <div class="modal fade" id="testsModal" tabindex="-1" aria-labelledby="testsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="testsModalLabel">Order Tests</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step active">3</div>
                                    <div class="line"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Diagnosis</h5>

                                <!-- <div class="test-tags" id="testTags">
                                    <span class="badge" data-value="X Ray">X Ray <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="ECG">ECG <i class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Cholesterol">Cholesterol <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="RCB">RCB <i class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Typhoid">Typhoid <i
                                            class="bi bi-x remove-tag"></i></span>
                                </div> -->

                                <textarea id="testNotes" name="test_notes"
                                    placeholder="Enter additional diagnosis notes"
                                    aria-label="Diagnosis Notes"></textarea>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('testsModal', 'adviceModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('testsModal', 'medicineModal')">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advice Modal -->
            <div class="modal fade" id="adviceModal" tabindex="-1" aria-labelledby="adviceModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adviceModalLabel">Give Advice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step active">3</div>
                                    <div class="line active"></div>
                                    <div class="step active">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Advice</h5>
                                <textarea id="adviceNotes" name="advice" placeholder="Enter advice for the patient"
                                    aria-label="Advice Notes"></textarea>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('adviceModal', 'specialistModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('adviceModal', 'testsModal')">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specialist Modal -->
            <div class="modal fade" id="specialistModal" tabindex="-1" aria-labelledby="specialistModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="specialistModalLabel">Refer to Specialist</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step active">3</div>
                                    <div class="line active"></div>
                                    <div class="step active">4</div>
                                    <div class="line active"></div>
                                    <div class="step active">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Refer to Specialist</h5>

                                <!-- <div class="specialist-tags" id="specialistTags">
                                    <span class="badge" data-value="Neurologist">Neurologist <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Cardiologist">Cardiologist <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Oncologist">Oncologist <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Orthopedic Surgeon">Orthopedic Surgeon <i
                                            class="bi bi-x remove-tag"></i></span>
                                </div> -->

                                <textarea id="specialistNotes" name="specialist_notes"
                                    placeholder="Enter referral notes" aria-label="Referral Notes"></textarea>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('specialistModal', 'followupModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('specialistModal', 'adviceModal')">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Follow-Up Modal -->
            <div class="modal fade" id="followupModal" tabindex="-1" aria-labelledby="followupModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="followupModalLabel">Schedule Follow-Up</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step active">3</div>
                                    <div class="line active"></div>
                                    <div class="step active">4</div>
                                    <div class="line active"></div>
                                    <div class="step active">5</div>
                                    <div class="line active"></div>
                                    <div class="step active">6</div>
                                </div>
                                <h5>Schedule Follow-Up</h5>
                                <form id="prescriptionForm" action="one-patient-info-revised.php" method="POST">
                                    <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
                                    <input type="hidden" name="complaints" id="hiddenComplaints">
                                    <input type="hidden" name="tests" id="hiddenTests">
                                    <input type="hidden" name="specialists" id="hiddenSpecialists">
                                    <div class="followup-row">
                                        <input type="date" name="followup_date" id="followupDate" value="2025-04-26"
                                            aria-label="Follow-Up Date">
                                        <input type="time" name="followup_time" id="followupTime" value="09:00"
                                            aria-label="Follow-Up Time">
                                    </div>
                                    <textarea id="followupNotes" name="followup_notes"
                                        placeholder="Enter follow-up notes" aria-label="Follow-Up Notes"></textarea>
                                    <button type="submit" class="btn-submit"
                                        onclick="submitPrescription()">Submit</button>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('followupModal', 'specialistModal')">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <!---=================================== Send Message Modal -===================================-->
            <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel"
                aria-hidden="true">
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
                            <h5 class="modal-title text-sm font-semibold" id="rescheduleModalLabel">Reschedule
                                Appointment</h5>
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
            const complaintsModal = document.getElementById('complaintsModal');
            const medicineModal = document.getElementById('medicineModal');
            const testsModal = document.getElementById('testsModal');
            const adviceModal = document.getElementById('adviceModal');
            const specialistModal = document.getElementById('specialistModal');
            const followupModal = document.getElementById('followupModal');

            if (messageModal) messageModal._modal = new bootstrap.Modal(messageModal);
            if (rescheduleModal) rescheduleModal._modal = new bootstrap.Modal(rescheduleModal);
            if (complaintsModal) complaintsModal._modal = new bootstrap.Modal(complaintsModal);
            if (medicineModal) medicineModal._modal = new bootstrap.Modal(medicineModal);
            if (testsModal) testsModal._modal = new bootstrap.Modal(testsModal);
            if (adviceModal) adviceModal._modal = new bootstrap.Modal(adviceModal);
            if (specialistModal) specialistModal._modal = new bootstrap.Modal(specialistModal);
            if (followupModal) followupModal._modal = new bootstrap.Modal(followupModal);

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

            window.openComplaintsModal = function() {
                if (complaintsModal && complaintsModal._modal) {
                    complaintsModal._modal.show();
                } else {
                    console.error('Complaints modal not initialized.');
                }
            };

            // Client-side form validation for message and reschedule forms
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

            // Store prescription data
            let prescriptionData = {
                complaints: {
                    tags: [],
                    notes: ''
                },
                medicines: [],
                tests: {
                    tags: [],
                    notes: ''
                },
                advice: '',
                specialists: {
                    tags: [],
                    notes: ''
                },
                followup: {
                    date: '',
                    time: '',
                    notes: ''
                }
            };

            // Initialize tag removal listeners
            ['complaintTags', 'testTags', 'specialistTags'].forEach(tagContainerId => {
                const container = document.getElementById(tagContainerId);
                if (container) {
                    container.addEventListener('click', (e) => {
                        if (e.target.classList.contains('remove-tag')) {
                            const tag = e.target.parentElement;
                            const value = tag.dataset.value;
                            tag.remove();
                            updateTags(tagContainerId, value);
                        }
                    });
                }
            });

            // Update tags in prescriptionData
            function updateTags(containerId, removedValue) {
                if (containerId === 'complaintTags') {
                    prescriptionData.complaints.tags = prescriptionData.complaints.tags.filter(tag => tag !==
                        removedValue);
                } else if (containerId === 'testTags') {
                    prescriptionData.tests.tags = prescriptionData.tests.tags.filter(tag => tag !== removedValue);
                } else if (containerId === 'specialistTags') {
                    prescriptionData.specialists.tags = prescriptionData.specialists.tags.filter(tag => tag !==
                        removedValue);
                }
            }

            // Add new medicine row
            window.addMedicineRow = function() {
                const medicineRows = document.getElementById('medicineRows');
                const newRow = document.createElement('div');
                newRow.className = 'medicine-row';
                newRow.innerHTML = `
                    <input type="text" name="medicines[]" placeholder="Medicine Name" aria-label="Medicine Name">
                    <input type="number" name="dosages[]" min="1" value="1" aria-label="Dosage">
                    <select name="timings[]" aria-label="Meal Timing">
                        <option>Before Meal</option>
                        <option>After Meal</option>
                    </select>
                    <input type="text" name="durations[]" value="10 Days" aria-label="Duration">
                `;
                medicineRows.appendChild(newRow);
            };

            // Save data and continue to next modal
            window.saveAndContinue = function(currentModalId, nextModalId) {
                if (currentModalId === 'complaintsModal') {
                    const tags = Array.from(document.querySelectorAll('#complaintTags .badge')).map(tag => tag
                        .dataset.value);
                    const notes = document.getElementById('complaintNotes').value.trim();
                    if (tags.length === 0 && !notes) {
                        alert('Please add at least one complaint or note.');
                        return;
                    }
                    prescriptionData.complaints.tags = tags;
                    prescriptionData.complaints.notes = notes;
                } else if (currentModalId === 'medicineModal') {
                    const rows = document.querySelectorAll('#medicineRows .medicine-row');
                    const medicines = Array.from(rows).map(row => ({
                        name: row.children[0].value.trim(),
                        dosage: row.children[1].value,
                        timing: row.children[2].value,
                        duration: row.children[3].value.trim()
                    }));
                    if (medicines.every(med => !med.name)) {
                        alert('Please add at least one medicine.');
                        return;
                    }
                    prescriptionData.medicines = medicines.filter(med => med.name);
                } else if (currentModalId === 'testsModal') {
                    const tags = Array.from(document.querySelectorAll('#testTags .badge')).map(tag => tag
                        .dataset.value);
                    const notes = document.getElementById('testNotes').value.trim();
                    prescriptionData.tests.tags = tags;
                    prescriptionData.tests.notes = notes;
                } else if (currentModalId === 'adviceModal') {
                    const advice = document.getElementById('adviceNotes').value.trim();
                    prescriptionData.advice = advice;
                } else if (currentModalId === 'specialistModal') {
                    const tags = Array.from(document.querySelectorAll('#specialistTags .badge')).map(tag => tag
                        .dataset.value);
                    const notes = document.getElementById('specialistNotes').value.trim();
                    prescriptionData.specialists.tags = tags;
                    prescriptionData.specialists.notes = notes;
                }

                const currentModal = bootstrap.Modal.getInstance(document.getElementById(currentModalId));
                currentModal.hide();
                const nextModal = new bootstrap.Modal(document.getElementById(nextModalId), {
                    backdrop: 'static',
                    keyboard: false
                });
                nextModal.show();
            };

            // Go back to previous modal
            window.goBack = function(currentModalId, previousModalId) {
                const currentModal = bootstrap.Modal.getInstance(document.getElementById(currentModalId));
                currentModal.hide();
                const previousModal = new bootstrap.Modal(document.getElementById(previousModalId), {
                    backdrop: 'static',
                    keyboard: false
                });
                previousModal.show();
            };

            // Submit prescription
            window.submitPrescription = function() {
                const date = document.getElementById('followupDate').value;
                const time = document.getElementById('followupTime').value;
                const notes = document.getElementById('followupNotes').value.trim();

                if (!date || !time) {
                    alert('Please specify follow-up date and time.');
                    return;
                }

                prescriptionData.followup = {
                    date,
                    time,
                    notes
                };

                // Populate hidden fields for form submission
                document.getElementById('hiddenComplaints').value = JSON.stringify(prescriptionData.complaints);
                document.getElementById('hiddenTests').value = JSON.stringify(prescriptionData.tests);
                document.getElementById('hiddenSpecialists').value = JSON.stringify(prescriptionData
                    .specialists);

                // Submit the form
                document.getElementById('prescriptionForm').submit();

                // Reset form
                resetForm();

                const modal = bootstrap.Modal.getInstance(document.getElementById('followupModal'));
                modal.hide();
            };

            // Reset form data and UI
            function resetForm() {
                prescriptionData = {
                    complaints: {
                        tags: [],
                        notes: ''
                    },
                    medicines: [],
                    tests: {
                        tags: [],
                        notes: ''
                    },
                    advice: '',
                    specialists: {
                        tags: [],
                        notes: ''
                    },
                    followup: {
                        date: '',
                        time: '',
                        notes: ''
                    }
                };

                // Reset Complaints Modal
                document.getElementById('complaintNotes').value = '';
                const complaintTags = document.getElementById('complaintTags');
                complaintTags.innerHTML = `
                    <span class="badge" data-value="Headache">Headache <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Insomnia">Insomnia <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Tiredness">Tiredness <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Another Complaint">Another Complaint <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Typhoid">Typhoid <i class="bi bi-x remove-tag"></i></span>
                `;

                // Reset Medicine Modal
                const medicineRows = document.getElementById('medicineRows');
                medicineRows.innerHTML = `
                    <div class="medicine-row">
                        <input type="text" name="medicines[]" placeholder="Medicine Name" aria-label="Medicine Name">
                        <input type="number" name="dosages[]" min="1" value="1" aria-label="Dosage">
                        <select name="timings[]" aria-label="Meal Timing">
                            <option>Before Meal</option>
                            <option>After Meal</option>
                        </select>
                        <input type="text" name="durations[]" value="10 Days" aria-label="Duration">
                    </div>
                `;

                // Reset Tests Modal
                document.getElementById('testNotes').value = '';
                const testTags = document.getElementById('testTags');
                testTags.innerHTML = `
                    <span class="badge" data-value="X Ray">X Ray <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="ECG">ECG <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Cholesterol">Cholesterol <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="RCB">RCB <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Typhoid">Typhoid <i class="bi bi-x remove-tag"></i></span>
                `;

                // Reset Advice Modal
                document.getElementById('adviceNotes').value = '';

                // Reset Specialist Modal
                document.getElementById('specialistNotes').value = '';
                const specialistTags = document.getElementById('specialistTags');
                specialistTags.innerHTML = `
                    <span class="badge" data-value="Neurologist">Neurologist <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Cardiologist">Cardiologist <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Oncologist">Oncologist <i class="bi bi-x remove-tag"></i></span>
                    <span class="badge" data-value="Orthopedic Surgeon">Orthopedic Surgeon <i class="bi bi-x remove-tag"></i></span>
                `;

                // Reset Follow-Up Modal
                document.getElementById('followupDate').value = '2025-04-26';
                document.getElementById('followupTime').value = '09:00';
                document.getElementById('followupNotes').value = '';
            }
        });
    </script>
</body>

</html>