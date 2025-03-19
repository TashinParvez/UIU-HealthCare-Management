<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hero Page</title>

    <!-- Include Bootstrap (CSS and JS) -->
    <?php include('../includes/bootstrap_links.html'); ?>

    <!-- css -->
    <link rel="stylesheet" href="hero_page.css">


    <style>
        * {
            margin: 0px;
            padding: 0px;
            font-family: monospace;
            font-size: large;
        }

        nav {
            font-size: larger;
            font-weight: bolder;
        }

        .segment1 {
            width: 100vw;
            height: 832px;

        }
    </style>


</head>

<body>

    <!-- ===================== Navbar Section (Start) ===================== -->
    <!-- This is the navigation bar containing the logo and menu items for easy site navigation. -->

    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #A7CEF3;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <!-- Company logo with a fixed width of 182px -->
                <img src="../includes/Images/logo/logo-blue.png" alt="Bootstrap" width="182px">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar menu items centered in the navigation bar -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Departments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">FAQ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===================== Section 1 (Start) ===================== -->
    <!-- Placeholder for the first content section of the page -->

    <div class="segment1">
        <div class="row align-items-center">

            <div class="col-md-4">
                <h1>Health Care Now <br>
                    Simplified For <span style="color:#4C70F8; font-weight: bolder;">Everyone</span>
                </h1>
                <p>Health Care is a new way to get health insurance quotes. We offer tools similar to those
                    provided by insurance companies for free, and prices are based on donations and not
                    restrictive health plan networks.</p>
            </div>

            <div class="col-md-8">
                <img src="../Includes/Images/HeroPage/hero_img.png" alt="Hero Image" class="img-fluid">
            </div>

        </div>
    </div>


    <!-- ===================== Section 2 (Start) ===================== -->
    <!-- Placeholder for the second content section of the page -->

    <div class="segment2">
        <!-- Content for segment 2 goes here -->
    </div>

    <!-- ===================== Section 3 (Start) ===================== -->
    <!-- Placeholder for the third content section of the page -->

    <div class="segment3">
        <!-- Content for segment 3 goes here -->
    </div>






</body>

</html>