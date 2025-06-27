<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Page 02 - Prescribe Medicine</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .prescription-section {
            padding: 20px 0;
            width: 100%;
        }

        .prescription-section .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
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

        .prescription-section .medicine-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .prescription-section .medicine-row input[type="text"],
        .prescription-section .medicine-row input[type="number"],
        .prescription-section .medicine-row select {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 8px;
            font-size: 0.9rem;
            color: #6c757d;
            margin-right: 10px;
        }

        .prescription-section .medicine-row input[type="text"] {
            flex: 2;
        }

        .prescription-section .medicine-row input[type="number"] {
            width: 60px;
        }

        .prescription-section .medicine-row select {
            flex: 1;
        }

        .prescription-section .add-more {
            text-align: center;
            margin-bottom: 20px;
        }

        .prescription-section .add-more a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .prescription-section .add-more a:hover {
            color: #007bff;
        }

        .prescription-section .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1rem;
            display: block;
            margin: 0 auto;
        }

        .prescription-section .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!------------------------------ Include Sidebar ------------------------------>
        <?php include '../../Includes/Sidebar.php'; ?>

        <!------------------------------ Main Content ------------------------------>
        <div class="flex-grow-1 p-4" style="margin-left: 4rem;">
            <div class="prescription-section">
                <div class="card">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active">1</div>
                        <div class="line active"></div>
                        <div class="step active">2</div>
                        <div class="line active"></div>
                        <div class="step">3</div>
                        <div class="line"></div>
                        <div class="step">4</div>
                    </div>

                    <!-- Title -->
                    <h5>Medicine</h5>

                    <!-- Medicine Rows -->
                    <div class="medicine-row">
                        <input type="text" placeholder="Medicine Name">
                        <input type="number" value="1">
                        <select>
                            <option>Before Meal</option>
                            <option>After Meal</option>
                        </select>
                        <input type="text" value="10 Days">
                    </div>
                    <div class="medicine-row">
                        <input type="text" placeholder="Medicine Name">
                        <input type="number" value="1">
                        <select>
                            <option>Before Meal</option>
                            <option>After Meal</option>
                        </select>
                        <input type="text" value="10 Days">
                    </div>
                    <div class="medicine-row">
                        <input type="text" placeholder="Medicine Name">
                        <input type="number" value="1">
                        <select>
                            <option>Before Meal</option>
                            <option>After Meal</option>
                        </select>
                        <input type="text" value="10 Days">
                    </div>
                    <div class="medicine-row">
                        <input type="text" placeholder="Medicine Name">
                        <input type="number" value="1">
                        <select>
                            <option>Before Meal</option>
                            <option>After Meal</option>
                        </select>
                        <input type="text" value="10 Days">
                    </div>

                    <!-- Add More Link -->
                    <div class="add-more">
                        <a href="#"><i class="bi bi-plus-circle me-1"></i>Add More</a>
                    </div>

                    <!-- Submit Button -->
                    <a href="\doctor\patient-view\pescrive-3.php">
                        <button class="btn-submit">Continue</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>