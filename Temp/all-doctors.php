<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Doctors</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

        .doctors-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .doctors-section {
            padding: 20px 0;
        }

        .doctors-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .doctors-section .search-bar {
            max-width: 500px;
            margin-bottom: 30px;
        }

        .doctors-section .search-bar .form-control {
            border-radius: 25px;
            border: 1px solid #ced4da;
        }

        .doctors-section .category-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .doctors-section .category-card h3 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .doctors-section .category-card p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .doctors-section .doctor-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .doctors-section .doctor-card img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            margin-left: 20px;
        }

        .doctors-section .doctor-card h5 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .doctors-section .doctor-card p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .doctors-section .doctor-card .social-icons a {
            color: #6c757d;
            margin-right: 10px;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .doctors-section .doctor-card .social-icons a:hover {
            color: #007bff;
        }

        .disply-flex-for-card {
            display: flex;
            justify-content: space-between;
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
    <?php include '../Includes/Sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content flex-1">
        <div class="doctors-container">
            <div class="doctors-section">
                <h1>Doctors List</h1>

                <!-- Search Bar -->
                <div class="search-bar" style="display: flex; justify-content: center; width: 100%; align-items: center;">
                    <input type="text" class="form-control" placeholder="Search available doctors...">
                </div>

                <!-- Category Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="category-card">
                            <h3>5</h3>
                            <p>Heart Surgeon</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="category-card">
                            <h3>8</h3>
                            <p>Neurologist</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="category-card">
                            <h3>6</h3>
                            <p>Orthopedic Surgeon</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="category-card">
                            <h3>10</h3>
                            <p>Pediatrician</p>
                        </div>
                    </div>
                </div>

                <!-- Doctors List -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="doctor-card disply-flex-for-card">
                            <div>
                                <h5>Dr. Kendrick Debus</h5>
                                <p>MBBS, FCPS (Anaesthesiology)</p>
                                <p>Senior Consultant & Coordinator</p>
                                <p>Department: Critical Care</p>
                                <div class="social-icons">
                                    <a href="#"><i class="bi bi-facebook"></i></a>
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-behance"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                    <a href="#"><i class="bi bi-globe"></i></a>
                                </div>
                            </div>
                            <img src="/Includes/male-doctors-white-medical.jpg" alt="Dr. Kendrick Debus">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="doctor-card disply-flex-for-card">
                            <div>
                                <h5>Dr. Summer Grullon</h5>
                                <p>MBBS, FCPS (Anaesthesiology)</p>
                                <p>Senior Consultant & Coordinator</p>
                                <p>Department: Critical Care</p>
                                <div class="social-icons">
                                    <a href="#"><i class="bi bi-facebook"></i></a>
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-behance"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                    <a href="#"><i class="bi bi-globe"></i></a>
                                </div>
                            </div>
                            <img src="/Includes/male-doctors-white-medical.jpg" alt="Dr. Summer Grullon">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="doctor-card disply-flex-for-card">
                            <div>
                                <h5>Prof. Brig Gen (Retd) Dr. Md Mahbub Noor</h5>
                                <p>MBBS, FCPS (Anaesthesiology)</p>
                                <p>Senior Consultant & Coordinator</p>
                                <p>Department: Critical Care</p>
                                <div class="social-icons">
                                    <a href="#"><i class="bi bi-facebook"></i></a>
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-behance"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                    <a href="#"><i class="bi bi-globe"></i></a>
                                </div>
                            </div>
                            <img src="/Includes/male-doctors-white-medical.jpg" alt="Prof. Brig Gen (Retd) Dr. Md Mahbub Noor">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>