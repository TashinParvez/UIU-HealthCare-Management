<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - UIU Health Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .signup-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-section {
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

        .signup-side {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .signup-side h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .signup-side .form-control {
            border-radius: 25px;
            margin-bottom: 15px;
        }

        .signup-side .btn {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border-radius: 25px;
            background-color: #007bff;
            border: none;
        }

        .signup-side .btn:hover {
            background-color: #0056b3;
        }

        .signup-side .form-check-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .signup-side .form-check-label a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-side .form-check-label a:hover {
            text-decoration: underline;
        }

        .signup-side .signin-link {
            text-align: center;
            margin-top: 20px;
        }

        .signup-side .signin-link a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-side .signin-link a:hover {
            text-decoration: underline;
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
    <div class="signup-container">
        <div class="signup-section row g-0">
            <!-- Illustration Side -->
            <div class="col-md-6 illustration-side">
                <h1>Care. Heal. Thrive.</h1>
                <img src="\Includes\Images\3568984.jpg" alt="Doctor, Nurse, and Patient Illustration"
                    style="width: 50px;">
            </div>
            <!-- Sign Up Side -->
            <div class="col-md-6 signup-side">
                <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care Logo" class="mb-4"
                    style="width: 134px;">
                <h2>Sign Up</h2>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" placeholder="First Name" value="John" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" placeholder="Last Name" value="Smith" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email" value="johnsmith@gmail.com"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Confirm Password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="privacyPolicy" required>
                        <label class="form-check-label" for="privacyPolicy">
                            I have read and agree to StaffMerge’s <a href="#">Privacy Policy, Terms of Use, and Cookies
                                Policy</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Your Account</button>
                </form>
                <div class="signin-link">
                    <p>Already have an account? <a href="#">Sign In</a></p>
                    <p>© 2025 IgnoreUs.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>