<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="\Images\logo\logo.png" type="image/x-icon">
    <title>Doctor Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        .form-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .form-container h2 {
            color: #007bff;
            font-weight: bold;
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
    <?php include '../Includes/SidebarAdmin.php'; ?>

    <!-- Main Content -->
    <div class="content flex-1">
        <div class="form-container">
            <h2 class="text-center mb-4">Doctor Registration Form</h2>
            <form>
                <!-- Personal Information -->
                <div class="section">
                    <h5 class="section-title">Personal Information</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" placeholder="First Name">
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Phone Number">
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password">
                        </div>
                    </div> -->
                </div>

                <hr class="section-divider">

                <!-- Professional Details -->
                <div class="section">
                    <h5 class="section-title">Professional Details</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="specialty" class="form-label">Specialty</label>
                            <input type="text" class="form-control" id="specialty" placeholder="Specialty">
                        </div>
                        <div class="col-md-6">
                            <label for="consultation_fee" class="form-label">Consultation Fee</label>
                            <input type="number" class="form-control" id="consultation_fee" placeholder="Consultation Fee">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="experience_years" class="form-label">Years of Experience</label>
                            <input type="number" class="form-control" id="experience_years" placeholder="Years of Experience">
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Availability -->
                <div class="section">
                    <h5 class="section-title">Availability</h5>
                    <div class="mb-3">
                        <label class="form-label">Available Days</label>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="mon" value="Monday">
                                    <label class="form-check-label" for="mon">Monday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tue" value="Tuesday">
                                    <label class="form-check-label" for="tue">Tuesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="wed" value="Wednesday">
                                    <label class="form-check-label" for="wed">Wednesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="thu" value="Thursday">
                                    <label class="form-check-label" for="thu">Thursday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="fri" value="Friday">
                                    <label class="form-check-label" for="fri">Friday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="sat" value="Saturday">
                                    <label class="form-check-label" for="sat">Saturday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="sun" value="Sunday">
                                    <label class="form-check-label" for="sun">Sunday</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="start_time">
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="end_time">
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- Education -->
                <div class="section">
                    <h5 class="section-title">Education</h5>
                    <div id="education-fields">
                        <div class="row mb-2 education-entry">
                            <div class="col-md-5">
                                <input type="text" class="form-control" placeholder="Degree Name">
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" placeholder="Institution">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-education">✖</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2 add-education">➕ Add Education</button>
                </div>

                <hr class="section-divider">

                <!-- Work Experience -->
                <div class="section">
                    <h5 class="section-title">Work Experience</h5>
                    <div id="work-experience-fields">
                        <div class="row mb-2 work-experience-entry">
                            <div class="col-md-5">
                                <input type="text" class="form-control" placeholder="Designation">
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" placeholder="Workplace">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-work-experience">✖</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2 add-work-experience">➕ Add Work Experience</button>
                </div>

                <!-- Submit Button -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Add Doctor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        // Add Education Field
        document.querySelector('.add-education').addEventListener('click', function() {
            const educationFields = document.getElementById('education-fields');
            const newField = document.createElement('div');
            newField.className = 'row mb-2 education-entry';
            newField.innerHTML = `
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Degree Name">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Institution">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-education">✖</button>
                </div>
            `;
            educationFields.appendChild(newField);
        });

        // Remove Education Field
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-education')) {
                e.target.closest('.education-entry').remove();
            }
        });

        // Add Work Experience Field
        document.querySelector('.add-work-experience').addEventListener('click', function() {
            const workFields = document.getElementById('work-experience-fields');
            const newField = document.createElement('div');
            newField.className = 'row mb-2 work-experience-entry';
            newField.innerHTML = `
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Designation">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Workplace">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-work-experience">✖</button>
                </div>
            `;
            workFields.appendChild(newField);
        });

        // Remove Work Experience Field
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-work-experience')) {
                e.target.closest('.work-experience-entry').remove();
            }
        });
    </script>
</body>

</html>