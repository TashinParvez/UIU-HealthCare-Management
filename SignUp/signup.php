<?php


$first_name = $last_name = $email = $password = $confirm_password = '';
$errors = array('first_name' => '', 'last_name' => '', 'email' => '', 'password' => '', 'confirm_password' => '');


if (isset($_POST['sign_up'])) {


    //...................... Database Connection ..............................
    include '../Includes/Database_connection.php';



    //................ Retrieve all data  from input field & escape sql chars ...............

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name'] ?? '');
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = mysqli_real_escape_string($conn, $_POST['password'] ?? '');
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password'] ?? '');


    //.............. All input field validation checking ...................
    // check first name
    if (empty($first_name)) {
        $errors['first_name'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z\s\.]+$/', $first_name)) {
            $errors['first_name'] = 'This field contains letters and space only!';
        }
    }

    // check last name
    if (empty($last_name)) {
        $errors['last_name'] = 'This field cannot be empty!';
    } else {
        if (!preg_match('/^[a-zA-Z0-9\s\.]+$/', $last_name)) {
            $errors['last_name'] = 'This field contains letters and spaces only!';
        }
    }

    // check email
    if (empty($email)) {
        $errors['email'] = 'This field cannot be empty!';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email!';
        } else {

            // Duplication checking for email
            $sql = "SELECT user_id FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $errors['email'] = 'Sorry, this email is already registered!
                                    Please use a different one';
            }
        }
    }

    // check password
    if (empty($password)) {
        $errors['password'] = 'This field cannot be empty!';
    } else {
        if (strlen($password) < 8) {
            $errors['password'] = 'Password length(8-20)';
        }
    }

    // check confirm password
    if (!empty($password) && $confirm_password !== $password) {
        $errors['confirm_password'] = "Password doesn't match!";
    }


    if (!array_filter($errors)) {

        $sql = "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($row = $result->fetch_assoc()) {
            $last_id = $row['user_id'];
            $new_id = $last_id + 1;
        } else {
            $new_id = 1; // Table is empty, start from 1
        }


        // create sql
        $sql = "INSERT INTO users(user_id, first_name, last_name, email, `password`)
                VALUES('$new_id', '$first_name', '$last_name', '$email','$password')";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            // success

            session_start();
            $_SESSION['user_id'] = $user_id;

            header('Location: signup-second.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }

        // close connection
        mysqli_close($conn);
    }
} // end POST check

?>



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
                <!-- <img src=" " alt="Doctor and Patient Illustration"> -->
                <img src="\Includes\Images\logo\United_International_University_Monogram.svg"
                    alt="Doctor and Patient Illustration" style="width: 350px;">
            </div>
            <!-- Sign Up Side -->
            <div class="col-md-6 signup-side">
                <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care Logo" class="mb-4"
                    style="width: 134px;">
                <h2>Sign Up</h2>
                <form action="signup.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" placeholder="First Name"
                                value="<?php echo htmlspecialchars($first_name); ?>" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" placeholder="Last Name"
                                value="<?php echo htmlspecialchars($last_name); ?>" name="last_name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email"
                            value="<?php echo htmlspecialchars($email); ?>" name="email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Confirm Password"
                            name="confirm_password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="privacyPolicy" required>
                        <label class="form-check-label" for="privacyPolicy">
                            I have read and agree to StaffMerge’s <a href="#">Privacy Policy, Terms of Use, and Cookies
                                Policy</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="sign_up">Create Your Account</button>
                </form>
                <div class="signin-link">
                    <p>Already have an account? <a href="../logIn/login.php">Sign In</a></p>
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