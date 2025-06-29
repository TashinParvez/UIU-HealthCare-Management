<!-- Patient Profile -->

<?php

session_start();
$user_id = $_SESSION['user_id'] ?? '2003';

include "../../Includes/Database_connection.php";

$profile_photo = '../../Includes/Images/Patient-Photo/' . $user_id . '.jpg';

// ............... Taking User All Informations ..........................



$stmt = $conn->prepare('
    SELECT 
        u.user_id,
        CONCAT(u.first_name, " " , u.last_name) AS name,
        u.email,
        u.phone,
        u.role,
        p.date_of_birth,
        p.gender,
        p.address,
        p.blood_group,
        p.medical_history,
        p.allergies,
        p.insurance_details,
        p.chronic_conditions,
        p.emergency_contact,
        p.medications
    FROM
        users u INNER JOIN patients p
    ON 
        u.user_id = p.patient_id
    WHERE 
        u.user_id = ?
');

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user_informations = $result->fetch_assoc();

// Example usage:
// echo "Patient Name: " . $user_informations['name'];


// .......... Updating database edited by user .............

if (isset($_POST['save'])) {

    $errors = array('name' => '', 'email' => '', 'phone' => '', 'date_of_birth' => '', 'gender' => '', 'address' => '', 'blood_group' => '', 'medical_history' => '', 'allergies' => '', 'insurance_details' => '', 'chronic_conditions' => '', 'emergency_contact' => '', 'medications' => '');

    //................ Retrieve all data  from input field ...............

    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group'] ?? '');
    $medical_history = mysqli_real_escape_string($conn, $_POST['medical_history'] ?? '');
    $allergies = mysqli_real_escape_string($conn, $_POST['allergies'] ?? '');
    $insurance_details = mysqli_real_escape_string($conn, $_POST['insurance_details'] ?? '');
    $chronic_conditions = mysqli_real_escape_string($conn, $_POST['chronic_conditions'] ?? '');
    $emergency_contact = mysqli_real_escape_string($conn, $_POST['emergency_contact'] ?? '');
    $medications = mysqli_real_escape_string($conn, $_POST['medications'] ?? '');


    //.............. All input field validation checking ...................

    // check name
    if (empty($name)) {
        $errors['name'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z\s\.]+$/', $name)) {
            $errors['name'] = 'This field contains letters and space only!';
        }
    }

    $name = trim($name);
    $name_parts = preg_split('/\s+/', $name); // split by one or more spaces

    if (count($name_parts) === 1) {
        $first_name = $name_parts[0];
        $last_name = '';
    } else {
        $last_name = array_pop($name_parts); // take last part
        $first_name = implode(' ', $name_parts); // join the rest
    }

    // check email
    if ($email !== $user_informations['email']) {
        if (empty($email)) {
            $errors['email'] = 'This field cannot be empty!';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email!';
            } else {

                // Duplication checking for email
                $sql = "SELECT user_id FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $errors['email'] = 'Sorry, this email is already registered!
                                    Please use a different one';
                }
            }
        }
    }

    // check phone
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required!';
    } else {
        if (!preg_match('/^01[3-9][0-9]{8}$/', $phone)) {
            $errors['phone'] = 'Phone number must be 11 digits and in the format 01460######!';
        }
    }

    // check Address
    if (empty($address)) {
        $errors['address'] = 'Address number is required!!';
    } else {
        if (!preg_match('/^[a-zA-Z0-9\s.,-]+$/', $address)) {
            $errors['address'] = 'Address can contain letters, numbers, spaces, commas, periods, and hyphens only!';
        }
    }

    // check Blood group
    if (empty($blood_group)) {
        $errors['blood_group'] = 'Blood group is required!';
    } else {
        if (!preg_match('/^(A|B|AB|O)[+-]$/', $blood_group)) {
            $errors['blood_group'] = 'Invalid blood group! Use formats like A+, O-, AB+, etc.';
        }
    }

    if (!array_filter($errors)) {

        // Start transaction
        $conn->begin_transaction();

        try {
            // First update: users table
            $stmt1 = $conn->prepare('
                UPDATE users 
                SET
                    email = ?, phone = ?, first_name = ?, last_name = ?
                WHERE user_id = ?
    ');
            $stmt1->bind_param('ssssi', $email, $phone, $first_name, $last_name, $user_id);
            $stmt1->execute();
            $stmt1->close();

            // Second update: patients table
            $stmt2 = $conn->prepare('
                UPDATE patients 
                SET
                    date_of_birth = ?, gender = ?, address = ?, blood_group = ?, 
                    medical_history = ?, allergies = ?, insurance_details = ?, 
                    chronic_conditions = ?, emergency_contact = ?, medications = ?
                WHERE patient_id = ?
    ');
            $stmt2->bind_param(
                'ssssssssssi',
                $date_of_birth,
                $gender,
                $address,
                $blood_group,
                $medical_history,
                $allergies,
                $insurance_details,
                $chronic_conditions,
                $emergency_contact,
                $medications,
                $user_id
            );
            $stmt2->execute();
            $stmt2->close();

            // Commit transaction if both succeed
            $conn->commit();
            echo "Update successful!";
        } catch (Exception $e) {
            // Rollback transaction if error occurs
            $conn->rollback();
            echo "Update failed: " . $e->getMessage();
        }

        // Close connection
        $conn->close();

        header('Location: PatientProfile.php');
        // exit();
    }
}


// .......... Updating database edited by user .............

if (isset($_POST['change_password'])) {

    $password = '';
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password'] ?? '');
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password'] ?? '');
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password'] ?? '');


    // Old password varification
    $stmt = $conn->prepare('SELECT `password` FROM users WHERE user_id = ? LIMIT 1');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($password);
    $stmt->fetch();
    $stmt->close();

    if ($old_password !== $password) {

        $error_message = "Old password is incorrect.";

        echo "<script>document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            modal.show();
        });</script>";
    } else {

        if ($new_password !== $confirm_password) {

            $error_message = "New passwords do not match.";
            echo "<script>document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                modal.show();
            });</script>";
        } else {

            // Update new password
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $new_password, $user_id);

            if ($stmt->execute()) {

                echo "<script>alert('Password changed successfully!');</script>";

                $stmt->close();
                $conn->close();

                header('Location: PatientProfile.php');
            } else {

                echo "<script>alert('Error updating password!');</script>";
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="\Images\logo\logo.png" type="image/x-icon">
    <title>Patient Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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

        .profile-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            position: relative;
        }

        .profile-container h2 {
            color: #007bff;
            font-weight: bold;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-photo {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #0d6efd;
        }

        .edit-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: #0d6efd;
            cursor: pointer;
        }

        .section-title {
            color: #343a40;
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .section-divider {
            border-top: 1px solid #dee2e6;
            margin: 20px 0;
        }

        .profile-label {
            font-weight: 600;
            color: #495057;
        }

        .profile-value {
            background: #e9ecef;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .profile-input {
            padding: 8px;
            margin-bottom: 15px;
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

        /* Noman */

        /* Optional: Smoother modal and better spacing */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 10px;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }

        .modal-title {
            font-weight: 600;
            font-size: 20px;
        }

        .modal-body {
            padding: 20px 25px;
        }

        .modal-footer {
            padding: 15px 25px;
            border-top: 1px solid #dee2e6;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
        }
    </style>
</head>

<body class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <?php include '../../Includes/Sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content flex-1">
        <div class="profile-container">
            <!-- Edit Icon -->
            <i id="edit-icon" class="bi bi-pencil-square edit-icon" title="Edit Profile"></i>
            <form action="PatientProfile" method="post">
                <!-- Profile Header -->
                <div class="profile-header">
                    <img src="https://scontent.fdac181-1.fna.fbcdn.net/v/t39.30808-6/349299836_991411121934653_7461298287642662667_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeHkaG79KsavuwJBOw4yjCML68uk7QofQiDry6TtCh9CIBkiWWh-SO0pqQfoXWHouq9vbhU7GWjCqFcPZJrHR1Wj&_nc_ohc=UEkMJR_yIj0Q7kNvwFPd1kM&_nc_oc=AdkGr0yM7eRfAQA8T11qTp-X47oKg3tDKxsUO1mMFt8cxkNYLv6ojs_i4a7ZKzeSsDA&_nc_zt=23&_nc_ht=scontent.fdac181-1.fna&_nc_gid=LYSozN4ZiUhSJG6ErtylCA&oh=00_AfOzg3Z4FbnX6vCh0wWUhHftZJV6vVQNkpy-hE7IEzQ-lg&oe=6866BF71"
                        alt="Profile Photo" class="profile-photo">


                    <div class="col-md-">
                        <h2 class="mt-3 profile-field" id="name-header">
                            <?php echo htmlspecialchars(strtoupper($user_informations['name'])); ?>
                        </h2>
                        <div class="row">
                            <div class="col-md-4 offset-md-4 text-center">
                                <!-- Hidden input field for name -->
                                <input type="text" name="name" id="name-input"
                                    class="form-control profile-input d-none mt-2 text-left"
                                    value="<?php echo htmlspecialchars($user_informations['name']); ?>"
                                    required>
                            </div>
                        </div>

                    </div>

                    <p class="text-muted mb-0">Role: <?php echo htmlspecialchars($user_informations['role']); ?></p>
                </div>

                <!-- Basic Information -->
                <div class="section">
                    <h5 class="section-title">Basic Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="profile-label">Email</div>
                            <div class="profile-value profile-field" data-field="email"><?php echo htmlspecialchars($user_informations['email']); ?></div>
                            <input type="email" name="email" class="form-control profile-input d-none" value="<?php echo htmlspecialchars($user_informations['email']); ?>" placeholder="example@gmail.com" required>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">Phone</div>
                            <div class="profile-value profile-field" data-field="phone">+88 <?php echo htmlspecialchars($user_informations['phone']); ?></div>
                            <input type="tel" name="phone" class="form-control profile-input d-none" value="<?php echo htmlspecialchars($user_informations['phone']); ?>" placeholder="01745######" required>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">Date of Birth</div>
                            <div class="profile-value profile-field" data-field="dob"><?php echo htmlspecialchars(DateTime::createFromFormat('Y-m-d', $user_informations['date_of_birth'])->format('d/m/Y')); ?></div>
                            <input type="date" name="date_of_birth" class="form-control profile-input d-none" value="<?php echo htmlspecialchars($user_informations['date_of_birth']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">Gender</div>
                            <div class="profile-value profile-field" data-field="gender"><?php echo htmlspecialchars(ucfirst(strtolower($user_informations['gender']))); ?></div>
                            <select class="form-control profile-input d-none" name="gender" required>
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="profile-label">Address</div>
                            <div class="profile-value profile-field" data-field="address"><?php echo htmlspecialchars($user_informations['address']); ?></div>
                            <input type="text" name="address" class="form-control profile-input d-none"
                                value="<?php echo htmlspecialchars($user_informations['address']); ?>" placeholder="Road-12, Gulshan-2, Dhaka ... (Comma separated)" required>
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Medical Information -->
                <div class="section">
                    <h5 class="section-title">Medical Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="profile-label">Chronic Conditions</div>
                            <div class="profile-value profile-field" data-field="chronic_conditions"><?php echo htmlspecialchars($user_informations['chronic_conditions']); ?></div>
                            <input type="text" name="chronic_conditions" class="form-control profile-input d-none" value="<?php echo htmlspecialchars($user_informations['chronic_conditions']); ?>" placeholder="Diabetes, Description, ... .. (Comma separated)">
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">Blood Group</div>
                            <div class="profile-value profile-field" data-field="blood_group"><?php echo htmlspecialchars($user_informations['blood_group']); ?></div>
                            <input type="text" name="blood_group" class="form-control profile-input d-none" value="<?php echo htmlspecialchars($user_informations['blood_group']); ?>" placeholder="B+" required>
                        </div>
                        <div class="col-12">
                            <div class="profile-label">Medical History</div>
                            <div class="profile-value profile-field" data-field="medical_history"><?php echo htmlspecialchars($user_informations['medical_history']); ?></div>
                            <input type="text" name="medical_history" class="form-control profile-input d-none"
                                value="<?php echo htmlspecialchars($user_informations['medical_history']); ?>" placeholder="Heart Surgery, Wrist (distal radius), ... .. (Comma separated)">
                        </div>
                        <div class="col-12">
                            <div class="profile-label">Allergies</div>
                            <div class="profile-value profile-field" data-field="allergies"><?php echo htmlspecialchars($user_informations['allergies']); ?></div>
                            <input type="text" name="allergies" class="form-control profile-input d-none" value="<?php echo htmlspecialchars($user_informations['allergies']); ?>" placeholder="Penicillin, Milk (dairy), Peanuts, ... .. (Comma separated)">
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Additional Data -->
                <div class="section">
                    <h5 class="section-title">Additional Data</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="profile-label">Insurance Details</div>
                            <div class="profile-value profile-field" data-field="insurance_details"><?php echo htmlspecialchars($user_informations['insurance_details']); ?></div>
                            <input type="text" name="insurance_details" class="form-control profile-input d-none"
                                value="<?php echo htmlspecialchars($user_informations['insurance_details']); ?>" placeholder="XYZ Health Insurance, Policy #12345">
                        </div>
                        <div class="col-md-6">
                            <div class="profile-label">Emergency Contact</div>
                            <div class="profile-value profile-field" data-field="emergency_contact"><?php echo htmlspecialchars($user_informations['emergency_contact']); ?></div>
                            <input type="text" name="emergency_contact" class="form-control profile-input d-none"
                                value="<?php echo htmlspecialchars($user_informations['emergency_contact']); ?>" placeholder="John Doe (Brother) -
                            01987######">
                        </div>
                        <div class="col-12">
                            <div class="profile-label">Medications</div>
                            <div class="profile-value profile-field" data-field="medications"><?php echo htmlspecialchars($user_informations['medications']); ?></div>
                            <input type="text" name="medications" class="form-control profile-input d-none" value="<?php echo htmlspecialchars($user_informations['medications']); ?>" placeholder="Metformin 500mg daily, Lisinopril 10 mg daily, ... .. (Comma separated)">
                        </div>
                    </div>
                </div>

                <!-- Save Button (Hidden by Default) -->
                <div class="d-flex justify-content-end gap-2 mt-4 d-none" id="save-section">
                    <button type="submit" class="btn btn-primary" id="save-btn" name="save">Save</button>
                </div>

            </form>

            <!-- Action Buttons -->
            <!-- <div class="d-flex justify-content-end gap-2 mt-4">
                <button class="btn btn-primary">Change Password</button>
                <button class="btn btn-info text-white">Upload/View Documents</button>
                <button class="btn btn-success">Download Medical Record</button>
            </div> -->

            <div class="text-center mt-5">

                <div class="row g-3 justify-content-center">

                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-shield-lock" style="font-size: 2rem; color: #fd410dff;"></i>
                                <h5 class="card-title mt-2">Change Password</h5>
                                <p class="text-muted small">Update your login credentials.</p>
                                <!-- <button class="btn btn-primary btn-sm mt-2">Change</button> -->
                                <button class="btn btn-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change</button>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-file-earmark-arrow-up" style="font-size: 2rem; color: #0d6efd;"></i>
                                <h5 class="card-title mt-2">Upload/View Documents</h5>
                                <p class="text-muted small">Manage your medical documents.</p>
                                <button class="btn btn-info btn-sm mt-2 text-white">Upload/View</button>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-file-earmark-arrow-down" style="font-size: 2rem; color: #0d6efd;"></i>
                                <h5 class="card-title mt-2">Download Medical Record</h5>
                                <p class="text-muted small">Get your full report in PDF.</p>
                                <button class="btn btn-primary btn-sm mt-2" onclick="window.location.href='../AppointmentRecords.php'">Download</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>


    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <!-- Error message placeholder -->
                        <div class="text-danger" id="error-message">
                            <?php if (isset($error_message)) echo $error_message; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="change_password" class="btn btn-danger">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script>
        const editIcon = document.getElementById('edit-icon');
        const saveSection = document.getElementById('save-section');
        const saveBtn = document.getElementById('save-btn');
        const fields = document.querySelectorAll('.profile-field');
        const inputs = document.querySelectorAll('.profile-input');
        let isEditing = false;

        editIcon.addEventListener('click', () => {
            if (isEditing) {
                // Cancel editing
                fields.forEach((field, index) => {
                    const input = inputs[index];
                    field.textContent = input.dataset.originalValue || field.textContent;
                    field.classList.remove('d-none');
                    input.classList.add('d-none');
                });
                editIcon.classList.remove('bi-x-circle');
                editIcon.classList.add('bi-pencil-square');
                editIcon.title = 'Edit Profile';
                saveSection.classList.add('d-none');
            } else {
                // Start editing
                fields.forEach((field, index) => {
                    const input = inputs[index];
                    input.value = field.textContent;
                    input.dataset.originalValue = field.textContent;
                    field.classList.add('d-none');
                    input.classList.remove('d-none');
                });
                editIcon.classList.remove('bi-pencil-square');
                editIcon.classList.add('bi-x-circle');
                editIcon.title = 'Cancel';
                saveSection.classList.remove('d-none');
            }
            isEditing = !isEditing;
        });

        saveBtn.addEventListener('click', () => {
            // Save changes
            fields.forEach((field, index) => {
                const input = inputs[index];
                field.textContent = input.value;
                field.classList.remove('d-none');
                input.classList.add('d-none');
            });
            editIcon.classList.remove('bi-x-circle');
            editIcon.classList.add('bi-pencil-square');
            editIcon.title = 'Edit Profile';
            saveSection.classList.add('d-none');
            isEditing = false;
        });
    </script>


</body>

</html>