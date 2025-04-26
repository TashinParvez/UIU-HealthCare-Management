<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> <!-- For pen icon -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-header {
            position: relative;
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #0d6efd;
        }

        .edit-icon {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 1.5rem;
            color: #0d6efd;
            cursor: pointer;
        }

        .section-title {
            font-size: 1.4rem;
            color: #0d6efd;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 20px;
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

        .action-buttons .btn {
            font-size: 0.9rem;
            padding: 6px 12px;
            margin: 3px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card shadow-sm p-4">

            <div class="profile-header">
                <img src="profile-placeholder.png" alt="Profile Photo">
                <i class="bi bi-pencil-square edit-icon" title="Edit Profile"></i>
                <h2 class="mt-3">Tashin Parvez</h2>
                <p class="text-muted mb-0">Role: PATIENT</p>
            </div>

            <div class="card-body">

                <h3 class="section-title">Basic Information</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="profile-label">Email</div>
                        <div class="profile-value">orwad.nadam0@gmail.com</div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Phone</div>
                        <div class="profile-value">+8801234567890</div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Date of Birth</div>
                        <div class="profile-value">08/09/2002</div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-label">Gender</div>
                        <div class="profile-value">Male</div>
                    </div>
                    <div class="col-12">
                        <div class="profile-label">Address</div>
                        <div class="profile-value">123 Example Street, Dhaka, Bangladesh</div>
                    </div>
                </div>

                <div class="accordion my-4" id="accordionMedicalInfo">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Medical Information
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionMedicalInfo">
                            <div class="accordion-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="profile-label">Chronic Conditions</div>
                                        <div class="profile-value">Diabetes</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-label">Blood Group</div>
                                        <div class="profile-value">O+</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="profile-label">Medical History</div>
                                        <div class="profile-value">Previous surgeries, no major illnesses.</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="profile-label">Allergies</div>
                                        <div class="profile-value">Peanuts, Dust</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mt-3">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Additional Data
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionMedicalInfo">
                            <div class="accordion-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="profile-label">Insurance Details</div>
                                        <div class="profile-value">XYZ Health Insurance, Policy #12345</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-label">Emergency Contact</div>
                                        <div class="profile-value">John Doe (Brother) - +880987654321</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="profile-label">Medications</div>
                                        <div class="profile-value">Metformin 500mg daily</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Small action buttons neatly at the bottom -->
                <!-- <div class="text-center action-buttons mt-4">
                    <button class="btn btn-outline-primary">Change Password</button>
                    <button class="btn btn-outline-info text-dark">Upload/View Documents</button>
                    <button class="btn btn-outline-success">Download Medical Record</button>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>