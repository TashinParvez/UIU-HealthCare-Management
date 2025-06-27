<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - UIU Health Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .welcome-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .welcome-section {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .illustration-side {
            background: #e6f0fa;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .illustration-side h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        .illustration-side img {
            max-width: 100%;
            height: auto;
        }

        .welcome-side {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .welcome-side h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .welcome-side p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .welcome-side .btn {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 25px;
        }

        .welcome-side .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .welcome-side .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .user-profile {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-profile span {
            font-size: 1rem;
            color: #333;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <div class="user-profile">
            <img src="/Includes/Images/happy-patient.jpg" alt="Profile Picture">
            <span>John Smith</span>
        </div>
        <div class="welcome-section row g-0">
            <!-- Illustration Side -->
            <div class="col-md-6 illustration-side">
                <h1>Care. Heal. Thrive.</h1>
                <img src="/Includes/Images/care1.jpg" alt="Doctor, Nurse, and Patient Illustration" style="width: 50px;">

            </div>
            <!-- Welcome Side -->
            <div class="col-md-6 welcome-side">
                <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care Logo" class="mb-4" style="width: 134px;">

                <h2>Welcome!</h2>
                <p>Now continue you have to:</p>
                <a href="../patient/Patient.php" class="btn btn-outline-secondary">Go To Homepage</a>
                <a href="../patient/Patient-profile/PatientProfile.php" class="btn btn-primary">Update Your Profile</a> <p>© 2025 IgnoreUs.</p>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>