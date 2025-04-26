<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar-nav .nav-link {
            color: #333;
            font-weight: 500;
            margin-right: 15px;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .navbar .btn {
            border-radius: 25px;
            padding: 8px 20px;
        }

        .navbar .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .navbar .btn-primary:hover {
            background-color: #0056b3;
        }

        .navbar .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .navbar .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }

        /* Hero Section Styling */
        .hero-section {
            padding: 40px 0;
            background-color: #f8f9fa;
        }

        /* Contact Section Styling */
        .contact-section {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .contact-section h6 {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .contact-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .contact-section p {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .contact-section .form-control,
        .contact-section .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            margin-bottom: 15px;
        }

        .contact-section .form-control:focus,
        .contact-section .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .contact-section textarea.form-control {
            height: 150px;
        }

        .contact-section .form-check-label {
            color: #6c757d;
        }

        .contact-section .btn {
            background-color: #006d77;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            width: 100%;
        }

        .contact-section .btn:hover {
            background-color: #00565f;
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!------------------------------ Include Sidebar ------------------------------>


        <div class="flex-grow-1">
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <!-- Verify the logo path -->
                        <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link" href="\Hero\hero_page.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">AboutUs</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Departments</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Doctors</a></li>
                            <li class="nav-item"><a class="nav-link active" href="\Hero\FAQ.php">FAQ</a></li>
                            <li class="nav-item"><a class="nav-link active" href="\Hero\contactUs.php">Contact Us</a></li>
                        </ul>
                        <div class="d-flex">
                            <button class="btn btn-outline-secondary">Sign In</button>
                            <button class="btn btn-primary ms-2">Sign Up</button>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <section class="hero-section">
                <div class="flex-grow-1 p-4" style="margin-left: 4rem;">
                    <div class="contact-section">
                        <h6>Get in Touch</h6>
                        <h1>Contact Us</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="First name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="Last name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="tel" class="form-control" placeholder="Phone number">
                                </div>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" required>
                                    <option value="" disabled selected>Choose a topic...</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="appointment">Appointment Request</option>
                                    <option value="feedback">Feedback</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" placeholder="Type your message..." required></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="acceptTerms" required>
                                <label class="form-check-label" for="acceptTerms">I accept the terms</label>
                            </div>
                            <button type="submit" class="btn">Submit</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include '../Includes/footer.php'; ?>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>