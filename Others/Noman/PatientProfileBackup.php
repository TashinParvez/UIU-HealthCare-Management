<!-- Patient Profile -->

<?php

session_start();
$user_id = $_SESSION['user_id'] ?? '2003';

include "../../Includes/Database_connection.php";



// ............... Taking User All Informations ..........................

$profile_photo = '../../Includes/Images/Patient-Photo/' . $user_id . '.jpg';

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


        // ..... To upload a photo in a folder ........

        $response = ['success' => false, 'message' => '', 'file_url' => ''];

        if (isset($_FILES['profile_photo'])) {
            $file = $_FILES['profile_photo'];
            $targetDir = "../../Includes/Images/Patient-Photo/";
            $filename = $user_id . ".jpg";
            $targetFile = $targetDir . $filename;

            // Check/create uploads directory
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                $response['message'] = 'Only JPG, PNG, and GIF files are allowed.';
            } else {
                // Convert image to JPG
                $imgInfo = getimagesize($file['tmp_name']);
                $mime = $imgInfo['mime'];

                switch ($mime) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($file['tmp_name']);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($file['tmp_name']);
                        break;
                    case 'image/gif':
                        $image = imagecreatefromgif($file['tmp_name']);
                        break;
                    default:
                        $response['message'] = 'Unsupported image format.';
                        echo json_encode($response);
                        exit;
                }

                if (file_exists($targetFile)) {
                    unlink($targetFile);
                }

                // Save as JPG
                if (imagejpeg($image, $targetFile, 90)) {
                    $response['success'] = true;
                    $response['file_url'] = $targetFile;
                } else {
                    $response['message'] = 'Failed to save image as JPG.';
                }

                imagedestroy($image);
            }
        } else {
            $response['message'] = 'No file uploaded.';
        }


        header('Location: PatientProfile.php');
        // exit();
    }
}



// header('Content-Type: application/json');
// echo json_encode($response);



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
                    <!-- <img src="https://t4.ftcdn.net/jpg/03/83/25/83/360_F_383258331_D8imaEMl8Q3lf7EKU2Pi78Cn0R7KkW9o.jpg"
                        alt="Profile Photo" class="profile-photo"> -->


                    <!-- Profile photo (clickable only after edit mode) -->
                    <div class="text-center">
                        <img id="profile-photo" src="<?php echo htmlspecialchars($profile_photo); ?>"
                            alt="Profile Photo" class="profile-photo" style="width: 150px; height: 150px; border-radius: 50%; cursor: default;">

                        <!-- File input (hidden) -->
                        <input type="file" id="profile-photo-input" name="profile_photo" class="d-none" accept="image/*">

                        <!-- "Choose a profile picture" text -->
                        <div id="choose-photo-text" class="mt-2 d-none text-primary" style="cursor: pointer;">
                            Choose a profile picture
                        </div>
                    </div>



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
                                <i class="bi bi-shield-lock" style="font-size: 2rem; color: #0d6efd;"></i>
                                <h5 class="card-title mt-2">Change Password</h5>
                                <p class="text-muted small">Update your login credentials.</p>
                                <button class="btn btn-primary btn-sm mt-2">Change</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-file-earmark-arrow-up" style="font-size: 2rem; color: #0d6efd;"></i>
                                <h5 class="card-title mt-2">Upload/View Documents</h5>
                                <p class="text-muted small">Manage your medical documents.</p>
                                <button class="btn btn-info btn-sm mt-2 text-white">Upload/View</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-file-earmark-arrow-down" style="font-size: 2rem; color: #0d6efd;"></i>
                                <h5 class="card-title mt-2">Download Medical Record</h5>
                                <p class="text-muted small">Get your full report in PDF.</p>
                                <button class="btn btn-success btn-sm mt-2">Download</button>
                            </div>
                        </div>
                    </div>

                </div>

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

    <!-- ........... Noman .............. -->
    <!-- For editting profile photo -->
    <script>
        let editMode = false;

        // Toggle edit mode when edit icon is clicked
        document.getElementById('edit-icon').addEventListener('click', function() {
            editMode = !editMode;
            document.getElementById('choose-photo-text').classList.toggle('d-none');
            document.getElementById('profile-photo').style.cursor = editMode ? 'pointer' : 'default';
        });

        // Click image or text to open file input in edit mode
        document.getElementById('profile-photo').addEventListener('click', function() {
            if (editMode) {
                document.getElementById('profile-photo-input').click();
            }
        });

        document.getElementById('choose-photo-text').addEventListener('click', function() {
            document.getElementById('profile-photo-input').click();
        });

        // Optional: Preview selected image immediately
        document.getElementById('profile-photo-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('profile-photo').src = URL.createObjectURL(file);
            }
        });
    </script>

    <!-- For save photo into a directory -->
    <script>
        // Trigger file input on photo click
        document.getElementById('profile-photo').addEventListener('click', function() {
            document.getElementById('profile-photo-input').click();
        });

        // Upload when file is selected
        document.getElementById('profile-photo-input').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('profile_photo', file);

            fetch('upload_photo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Show new photo
                        document.getElementById('profile-photo').src = data.file_url;
                        alert("Profile photo updated!");
                    } else {
                        alert("Upload failed: " + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Something went wrong.");
                });
        });
    </script>

</body>

</html>


<!-- // .......... Upload profile photo if exists ..........
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
$file = $_FILES['profile_photo'];
$targetDir = "../../Includes/Images/Patient-Photo/";
$filename = $user_id . ".jpg";
$targetFile = $targetDir . $filename;

if (!file_exists($targetDir)) {
mkdir($targetDir, 0755, true);
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (in_array($file['type'], $allowedTypes)) {
$imgInfo = getimagesize($file['tmp_name']);
$mime = $imgInfo['mime'];

switch ($mime) {
case 'image/jpeg':
$image = imagecreatefromjpeg($file['tmp_name']);
break;
case 'image/png':
$image = imagecreatefrompng($file['tmp_name']);
break;
case 'image/gif':
$image = imagecreatefromgif($file['tmp_name']);
break;
default:
$image = false;
}

if ($image) {
if (file_exists($targetFile)) {
unlink($targetFile); // delete old image
}
imagejpeg($image, $targetFile, 90);
imagedestroy($image);
}
}
} -->



<!-- Profile photo (clickable only after edit mode) -->
<div class="text-center">
    <img id="profile-photo" src="<?php echo htmlspecialchars($profile_photo); ?>"
        alt="Profile Photo" class="profile-photo" style="width: 150px; height: 150px; border-radius: 50%; cursor: default;">

    <!-- File input (hidden) -->
    <input type="file" id="profile-photo-input" name="profile_photo" class="d-none" accept="image/*">

    <!-- "Choose a profile picture" text -->
    <div id="choose-photo-text" class="mt-2 d-none text-primary" style="cursor: pointer;">
        Choose a profile picture
    </div>
</div>


<!-- ........... Noman .............. -->

<!-- For editting profile photo -->
<script>
    let editMode = false;

    // Toggle edit mode when edit icon is clicked
    document.getElementById('edit-icon').addEventListener('click', function() {
        editMode = !editMode;
        document.getElementById('choose-photo-text').classList.toggle('d-none');
        document.getElementById('profile-photo').style.cursor = editMode ? 'pointer' : 'default';
    });

    // Click image or text to open file input in edit mode
    document.getElementById('profile-photo').addEventListener('click', function() {
        if (editMode) {
            document.getElementById('profile-photo-input').click();
        }
    });

    document.getElementById('choose-photo-text').addEventListener('click', function() {
        document.getElementById('profile-photo-input').click();
    });

    // Optional: Preview selected image immediately
    document.getElementById('profile-photo-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('profile-photo').src = URL.createObjectURL(file);
        }
    });
</script>