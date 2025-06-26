<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Page 01 - Collect Complaints</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            /* Ensure no default margins interfere */
        }

        .content {
            margin-left: 64px;
            /* Collapsed sidebar width */
            padding: 0;
            /* Remove padding to maximize content width */
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            width: calc(100% - 64px);
            /* Full width minus collapsed sidebar */
            min-height: 100vh;
            /* Ensure content takes full viewport height */
            display: flex;
            /* Use flex to center the prescription section */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Expanded sidebar width */
            width: calc(100% - 256px);
            /* Full width minus expanded sidebar */
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

        .prescription-section {
            padding: 0;
            /* Remove padding to avoid offset */
            width: 100%;
            /* Take full width of content area */
            display: flex;
            /* Center the card */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            min-height: 100vh;
            /* Ensure it takes full height for centering */
        }

        .prescription-section .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 650px;
            /* Increased from 600px */
            width: 100%;
            /* Ensure responsiveness */
        }

        .prescription-section .card h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2e7d32;
            text-align: center;
            margin-bottom: 20px;
        }

        .prescription-section .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .prescription-section .step-indicator .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e0e0e0;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            font-size: 0.9rem;
        }

        .prescription-section .step-indicator .step.active {
            background-color: #007bff;
        }

        .prescription-section .step-indicator .line {
            width: 40px;
            height: 2px;
            background-color: #e0e0e0;
            margin: 14px 0;
        }

        .prescription-section .step-indicator .line.active {
            background-color: #007bff;
        }

        .prescription-section .complaint-tags .badge {
            background-color: #6c757d;
            color: white;
            font-size: 0.9rem;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 20px;
            cursor: pointer;
        }

        .prescription-section .complaint-tags .badge i {
            margin-left: 5px;
        }

        .prescription-section textarea {
            width: 100%;
            min-height: 150px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .prescription-section .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1rem;
            display: block;
            margin: 20px auto 0;
        }

        .prescription-section .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!-- Include Sidebar -->
        <?php include '../../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content">
            <div class="prescription-section">
                <div class="card">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active">1</div>
                        <div class="line active"></div>
                        <div class="step">2</div>
                        <div class="line"></div>
                        <div class="step">3</div>
                        <div class="line"></div>
                        <div class="step">4</div>
                    </div>

                    <!-- Title -->
                    <h5>Chief Complaints</h5>

                    <!-- Complaint Tags -->
                    <div class="complaint-tags">
                        <span class="badge">Headache <i class="bi bi-x"></i></span>
                        <span class="badge">Insomnia <i class="bi bi-x"></i></span>
                        <span class="badge">Tiredness <i class="bi bi-x"></i></span>
                        <span class="badge">Another Complaint <i class="bi bi-x"></i></span>
                        <span class="badge">Typhoid <i class="bi bi-x"></i></span>
                    </div>

                    <!-- Textarea -->
                    <textarea placeholder="Chief Complaints"></textarea>

                    <!-- Submit Button -->
                    <a href="\doctor\patient-view\pescrive-2.php">
                        <button class="btn-submit">Continue</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>