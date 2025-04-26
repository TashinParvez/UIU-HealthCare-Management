<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Page 04 - Give Advice</title>
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
                        <div class="step active">3</div>
                        <div class="line active"></div>
                        <div class="step active">4</div>
                    </div>

                    <!-- Title -->
                    <h5>Advice</h5>

                    <!-- Textarea -->
                    <textarea placeholder="Advice"></textarea>

                    <!-- Submit Button -->
                    <button class="btn-submit">Submit</button>
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