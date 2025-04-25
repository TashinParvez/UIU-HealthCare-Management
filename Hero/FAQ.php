<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        /* FAQ Section Styling */
        .faq-section {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .faq-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .faq-section .subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .accordion-button {
            color: #007bff;
            font-weight: 500;
        }

        .accordion-button:not(.collapsed) {
            color: #007bff;
            background-color: #e6f0fa;
        }

        .accordion-body {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">

        <div class="flex-grow-1">
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <!-- Verify the logo path -->
                        <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">AboutUs</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Departments</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Doctors</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#">FAQ</a></li>
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
                <div class="p-4" style="margin-left: 4rem;">
                    <div class="faq-section">
                        <h1>FAQ</h1>
                        <p class="subtitle">Problems trying to resolve the conflict between the two major realms of Classical physics: Newtonian mechanics</p>
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEight">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNine">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                        The quick fox jumps over the lazy dog
                                    </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Things on a very small scale behave like nothing you have any direct experience with.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!-- Footer Section -->
    <?php include '../Includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>