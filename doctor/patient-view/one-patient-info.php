<?php

include "../../Includes/Database_connection.php";


// --------------- BasicInfo ---------------------

$patient_id = '2010';

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
  u.user_id = '$patient_id';
";

$basicInfo = mysqli_query($conn, $sql);
$basicInfo = mysqli_fetch_all($basicInfo, MYSQLI_ASSOC);  // returns associative array


// foreach ($basicInfo as $row) {
//     print_r($row);
//     echo   "<br><br>";
// }


// --------------- appointpents ---------------------

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
  a.patient_id = '$patient_id';
";

$appointments = mysqli_query($conn, $sql);
$appointments = mysqli_fetch_all($appointments, MYSQLI_ASSOC);  // returns associative array


// --------------- prescription ---------------------

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
    patient_id = '$patient_id'; 
";

$prescription = mysqli_query($conn, $sql);
$prescription = mysqli_fetch_all($prescription, MYSQLI_ASSOC);  // returns associative array



// --------------- medical_records ---------------------

$sql = "SELECT 
  record_id,
  test_title,
  document_type,
  file_path,
  uploaded_at
FROM 
  medical_records
WHERE 
  patient_id = '$patient_id'; 
";

$medical_records = mysqli_query($conn, $sql);
$medical_records = mysqli_fetch_all($medical_records, MYSQLI_ASSOC);  // returns associative array


// --------------- medical_records ---------------------

$sql = "SELECT 
  record_id,
  test_title,
  document_type,
  file_path,
  uploaded_at
FROM 
  medical_records
WHERE 
  patient_id = '$patient_id';";

$medical_records = mysqli_query($conn, $sql);
$medical_records = mysqli_fetch_all($medical_records, MYSQLI_ASSOC);  // returns associative array









// ===========================================================
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Patient Info</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            margin: 0;
            /* Ensure no default body margins interfere */
        }

        .content {
            margin-left: 74px;
            /* Collapsed sidebar width (64px) + 10px gap */
            padding: 0;
            /* Remove padding to maximize content width */
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            width: calc(100% - 74px);
            /* Full width minus collapsed sidebar and gap */
        }

        .sidebar:hover+.content {
            margin-left: 266px;
            /* Expanded sidebar width (256px) + 10px gap */
            width: calc(100% - 266px);
            /* Full width minus expanded sidebar and gap */
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

        .patient-section {
            padding: 20px 0;
            /* No horizontal padding to stretch content fully */
            width: 100%;
            margin: 0;
            /* Remove any margins */
        }

        .patient-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            padding: 0 15px;
            /* Add padding to h1 for consistent spacing */
        }

        .patient-section .patient-header {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            margin-left: 15px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .patient-section .patient-header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .patient-section .patient-header .patient-info h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .patient-section .patient-header .patient-info p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .patient-section .patient-header .send-message {
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .patient-section .patient-header .send-message:hover {
            text-decoration: underline;
        }

        .patient-section .nav-tabs {
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .patient-section .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
        }

        .patient-section .nav-tabs .nav-link.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
        }

        .patient-section .appointment-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .patient-section .appointment-info .date-picker {
            max-width: 200px;
        }

        .patient-section .appointment-info .time-picker {
            max-width: 150px;
        }

        .patient-section .vitals,
        .patient-section .medications,
        .patient-section .routine-notes,
        .patient-section .test-reports {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .patient-section .vitals h6,
        .patient-section .medications h6,
        .patient-section .routine-notes h6,
        .patient-section .test-reports h6 {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .patient-section .vitals .vital-item {
            text-align: center;
        }

        .patient-section .vitals .vital-item p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .patient-section .vitals .vital-item h5 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .patient-section .medications .med-item,
        .patient-section .routine-notes .note-item,
        .patient-section .test-reports .report-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .patient-section .medications .med-item p,
        .patient-section .routine-notes .note-item p,
        .patient-section .test-reports .report-item p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .patient-section .action-buttons {
            display: flex;
            gap: 15px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .patient-section .action-buttons .btn {
            border-radius: 8px;
            padding: 10px 20px;
            width: 200px;
        }

        .patient-section .action-buttons .btn-reschedule {
            background-color: #007bff;
            border: none;
        }

        .patient-section .action-buttons .btn-reschedule:hover {
            background-color: #0056b3;
        }

        .patient-section .action-buttons .btn-prescribe {
            background-color: #28a745;
            border: none;
        }

        .patient-section .action-buttons .btn-prescribe:hover {
            background-color: #218838;
        }

        /* Override Bootstrap row margins to stretch content */
        .full-width-row {
            margin-left: 0;
            margin-right: 0;
        }

        .full-width-row>div {
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!-- Include Sidebar -->
        <?php include '../../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content">
            <div class="patient-section">
                <h1>Patients</h1>

                <!-- Patient Header -->
                <div class="patient-header">
                    <div class="d-flex align-items-center">
                        <img src="/Includes/Images/tashin.jpg" alt="Tashin Parvez">
                        <div class="patient-info">
                            <h5>Tashin Parvez</h5>
                            <p>Male - Age 32</p>
                            <p>Brain, Spinal Cord, and Nerve Disorder</p>
                            <p>ovi@gmail.com</p>
                            <p>+880 1712435712</p>
                        </div>
                    </div>
                    <a href="#" class="send-message">Send Message</a>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#overview" data-bs-toggle="tab">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#appointment-history" data-bs-toggle="tab">Appointment History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#medical-record" data-bs-toggle="tab">Medical Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#medication" data-bs-toggle="tab">Medication</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview">
                        <!-- Appointment Info -->
                        <div class="appointment-info">
                            <span>Today</span>
                            <div class="date-picker">
                                <input type="text" class="form-control" value="Fri, 21 March 2025" readonly>
                            </div>
                            <div class="time-picker">
                                <input type="text" class="form-control" value="02:00 PM" readonly>
                            </div>
                            <div class="time-picker">
                                <input type="text" class="form-control" value="11:20 PM" readonly>
                            </div>
                        </div>

                        <!-- Vitals -->
                        <div class="vitals">
                            <h6><i class="bi bi-heart me-2"></i>Vitals</h6>
                            <div class="row full-width-row">
                                <div class="col-md-2 vital-item">
                                    <p>Blood glucose level</p>
                                    <h5>120 mg/dt</h5>
                                </div>
                                <div class="col-md-2 vital-item">
                                    <p>Weight</p>
                                    <h5>55 Kg</h5>
                                </div>
                                <div class="col-md-2 vital-item">
                                    <p>Heart rate</p>
                                    <h5>70 bpm</h5>
                                </div>
                                <div class="col-md-2 vital-item">
                                    <p>Oxygen saturation</p>
                                    <h5>71%</h5>
                                </div>
                                <div class="col-md-2 vital-item">
                                    <p>Body temperature</p>
                                    <h5>98.1 F</h5>
                                </div>
                                <div class="col-md-2 vital-item">
                                    <p>Blood pressure</p>
                                    <h5>120/80 mm hg</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Medications -->
                        <div class="medications">
                            <h6>Medications</h6>
                            <div class="med-item">
                                <p>Ursofalk 300</p>
                                <p>2 Pills - 02:00 PM</p>
                            </div>
                            <div class="med-item">
                                <p>Indever 20</p>
                                <p>1 Pill - 02:20 PM</p>
                            </div>
                        </div>

                        <!-- Routine Medicine or Notes -->
                        <div class="routine-notes">
                            <h6>Routine Medicine or notes</h6>
                            <div class="note-item">
                                <p>Emergency</p>
                                <p>Patient observed to be having seizures. Indever given to reduce blood pressure</p>
                            </div>
                        </div>

                        <!-- Test Reports -->
                        <div class="test-reports">
                            <h6>Test reports</h6>
                            <div class="report-item">
                                <p>UV Invasive Ultrsound</p>
                                <p>02:00 PM</p>
                            </div>
                            <div class="report-item">
                                <p>Nerve Disorder</p>
                                <p>A small nerve in the left-mid section of the neck has shown swollen property. A brain scan is suggested</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button class="btn btn-reschedule">Reschedule Appointment</button>
                            <button class="btn btn-prescribe">Prescribe</button>
                        </div>
                    </div>

                    <!-- Placeholder for Other Tabs -->
                    <div class="tab-pane fade" id="appointment-history">
                        <p>Appointment History content will go here.</p>
                    </div>
                    <div class="tab-pane fade" id="medical-record">
                        <p>Medical Record content will go here.</p>
                    </div>
                    <div class="tab-pane fade" id="medication">
                        <p>Medication content will go here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>