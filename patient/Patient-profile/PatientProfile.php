<!-- Patient Profile -->

<?php


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="\Images\logo\logo.png" type="image/x-icon">
    <title>Patient Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

            <!-- Profile Header -->
            <div class="profile-header">
                <img src="profile-placeholder.png" alt="Profile Photo" class="profile-photo">
                <h2 class="mt-3" id="name-header">Tashin Parvez</h2>
                <p class="text-muted mb-0">Role: PATIENT</p>
            </div>

            <!-- Basic Information -->
            <div class="section">
                <h5 class="section-title">Basic Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="profile-label">Email</div>
                        <div class="profile-value profile-field" data-field="email">orwad.nadam0@gmail.com</div>
                        <input type="email" class="form-control profile-input d-none" value="orwad.nadam0@gmail.com">
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Phone</div>
                        <div class="profile-value profile-field" data-field="phone">+8801234567890</div>
                        <input type="tel" class="form-control profile-input d-none" value="+8801234567890">
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Date of Birth</div>
                        <div class="profile-value profile-field" data-field="dob">08/09/2002</div>
                        <input type="date" class="form-control profile-input d-none" value="2002-09-08">
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Gender</div>
                        <div class="profile-value profile-field" data-field="gender">Male</div>
                        <select class="form-control profile-input d-none">
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="profile-label">Address</div>
                        <div class="profile-value profile-field" data-field="address">123 Example Street, Dhaka, Bangladesh</div>
                        <input type="text" class="form-control profile-input d-none" value="123 Example Street, Dhaka, Bangladesh">
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
                        <div class="profile-value profile-field" data-field="chronic_conditions">Diabetes</div>
                        <input type="text" class="form-control profile-input d-none" value="Diabetes">
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Blood Group</div>
                        <div class="profile-value profile-field" data-field="blood_group">O+</div>
                        <input type="text" class="form-control profile-input d-none" value="O+">
                    </div>
                    <div class="col-12">
                        <div class="profile-label">Medical History</div>
                        <div class="profile-value profile-field" data-field="medical_history">Previous surgeries, no major illnesses.</div>
                        <input type="text" class="form-control profile-input d-none" value="Previous surgeries, no major illnesses.">
                    </div>
                    <div class="col-12">
                        <div class="profile-label">Allergies</div>
                        <div class="profile-value profile-field" data-field="allergies">Peanuts, Dust</div>
                        <input type="text" class="form-control profile-input d-none" value="Peanuts, Dust">
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
                        <div class="profile-value profile-field" data-field="insurance_details">XYZ Health Insurance, Policy #12345</div>
                        <input type="text" class="form-control profile-input d-none" value="XYZ Health Insurance, Policy #12345">
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Emergency Contact</div>
                        <div class="profile-value profile-field" data-field="emergency_contact">John Doe (Brother) - +880987654321</div>
                        <input type="text" class="form-control profile-input d-none" value="John Doe (Brother) - +880987654321">
                    </div>
                    <div class="col-12">
                        <div class="profile-label">Medications</div>
                        <div class="profile-value profile-field" data-field="medications">Metformin 500mg daily</div>
                        <input type="text" class="form-control profile-input d-none" value="Metformin 500mg daily">
                    </div>
                </div>
            </div>

            <!-- Save Button (Hidden by Default) -->
            <div class="d-flex justify-content-end gap-2 mt-4 d-none" id="save-section">
                <button class="btn btn-primary" id="save-btn">Save</button>
            </div>

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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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