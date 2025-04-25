<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UIU Health Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-section {
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

        .login-side {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-side h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .login-side .btn {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 25px;
        }

        .login-side .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .login-side .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .login-side .btn-outline-secondary img {
            width: 20px;
            margin-right: 10px;
        }

        .login-side .signup-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-side .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-side .signup-link a:hover {
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
    <div class="login-container">
        <div class="login-section row g-0">

            <!-- Illustration Side -->
            <div class="col-md-6 illustration-side">
                <h1>Care. Heal. Thrive.</h1>
                <!-- <img src=" " alt="Doctor and Patient Illustration"> -->
                <img src="/Includes/Images/care1.jpg" alt="Doctor and Patient Illustration" style="width: 350px;">
            </div>

            <!-- Login Side -->
            <div class="col-md-6 login-side">
                <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care Logo" class="mb-4">
                <h2>Welcome Back...</h2>
                <button class="btn btn-primary">Log in with Email</button>
                <button class="btn btn-outline-secondary">
                    <!-- <img src="google-icon-placeholder.png" alt="Google Icon"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" preserveAspectRatio="xMidYMid" viewBox="0 0 256 262" id="google">
                        <path fill="#4285F4" d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"></path>
                        <path fill="#34A853" d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"></path>
                        <path fill="#FBBC05" d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"></path>
                        <path fill="#EB4335" d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"></path>
                    </svg>
                    Log in with Google
                </button>
                <div class="signup-link">
                    <p>Don't have an account? <a href="#">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-text">
        <p>&copy; 2025 IgnoreUs.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>