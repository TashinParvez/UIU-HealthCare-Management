<?php


$error = $email = $password = '';


if (isset($_POST['login'])) {


    //...................... Database Connection ..............................
    include '../Includes/Database_connection.php';


    //................ Retrieve all data  from input field & escape sql chars ...............

    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = mysqli_real_escape_string($conn, $_POST['password'] ?? '');


    if (empty($_POST['email']) || empty($_POST['password'])) {

        $error = 'Please Enter email or password.';
    } else {

        $stmt = $conn->prepare('SELECT user_id, password FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($user_id, $stored_password);

        if ($stmt->fetch()) {

            if ($password === $stored_password) {

                session_start();
                $_SESSION['user_id'] = $user_id;

                $stmt->close();
                mysqli_close($conn);
                header('Location: ../patient/Patient.php');
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Data Fetch Failed";
        }
    }
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UIU Health Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            min-height: 100vh;
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

        .login-side .form-control {
            border-radius: 25px;
            margin-bottom: 15px;
        }

        .login-side .btn {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border-radius: 25px;
            background-color: #007bff;
            border: none;
        }

        .login-side .btn:hover {
            background-color: #0056b3;
        }

        .login-side .form-check-label {
            color: #6c757d;
        }

        .login-side .forgot-password {
            text-align: right;
            margin-bottom: 15px;
        }

        .login-side .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .login-side .forgot-password a:hover {
            text-decoration: underline;
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
                <img src="/Includes\Images\logo\United_International_University_Monogram.svg"
                    alt="Doctor and Patient Illustration" style="width: 350px;">

            </div>
            <!-- Login Side -->
            <div class="col-md-6 login-side">
                <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care Logo" class="mb-4"
                    style="width: 134px;">
                <h2>Welcome Back...</h2>
                <form action="login-second.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Email"
                            value="<?php echo htmlspecialchars($email); ?>" name="email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mb-3 me-2">

                        <div class="forgot-password">
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Log In</button>
                </form>
                <div class="signup-link">
                    <p>Don't have an account? <a href="../SignUp/signup.php">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-text">
        <p>© 2025 IgnoreUs.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>