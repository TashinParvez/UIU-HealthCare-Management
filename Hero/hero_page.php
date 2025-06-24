<?php

include "../Includes/Database_connection.php";


// --------------- DOCTOR INFO ---------------------
$sql = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            d.specialization
        FROM 
            users u
        JOIN 
            doctors d 
        ON u.user_id = d.doctor_id;";

$allDoctors = mysqli_query($conn, $sql);
$allDoctors = mysqli_fetch_all($allDoctors, MYSQLI_ASSOC);  // returns associative array


// --------------- Cardiologist ---------------------

$sql = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            d.specialization
        FROM 
            users u
        JOIN 
            doctors d ON u.user_id = d.doctor_id
        WHERE 
            LOWER(d.specialization) = 'cardiologist';";

$cardiologist = mysqli_query($conn, $sql);
$cardiologist = mysqli_fetch_all($cardiologist, MYSQLI_ASSOC);  // returns associative array

// print_r($cardiologist);


// --------------- orthopedist ---------------------

$sql = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            d.specialization
        FROM 
            users u
        JOIN 
            doctors d ON u.user_id = d.doctor_id
        WHERE 
            LOWER(d.specialization) = 'orthopedist';";

$orthopedist = mysqli_query($conn, $sql);
$orthopedist = mysqli_fetch_all($orthopedist, MYSQLI_ASSOC);  // returns associative array

// print_r($orthopedist);


// --------------- headache ---------------------

$sql = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            d.specialization
        FROM 
            users u
        JOIN 
            doctors d ON u.user_id = d.doctor_id
        WHERE 
            LOWER(d.specialization) = 'headache';";

$headache = mysqli_query($conn, $sql);
$headache = mysqli_fetch_all($headache, MYSQLI_ASSOC);  // returns associative array

// print_r($headache);


// --------------- eyecare ---------------------

$sql = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            d.specialization
        FROM 
            users u
        JOIN 
            doctors d ON u.user_id = d.doctor_id
        WHERE 
            LOWER(d.specialization) = 'eyecare';";

$eyecare = mysqli_query($conn, $sql);
$eyecare = mysqli_fetch_all($eyecare, MYSQLI_ASSOC);  // returns associative array

// print_r($eyecare);


// --------------- nutritionist ---------------------

$sql = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS full_name,
            d.specialization
        FROM 
            users u
        JOIN 
            doctors d ON u.user_id = d.doctor_id
        WHERE 
            LOWER(d.specialization) = 'nutritionist';";

$nutritionist = mysqli_query($conn, $sql);
$nutritionist = mysqli_fetch_all($nutritionist, MYSQLI_ASSOC);  // returns associative array

// print_r($nutritionist);





// ===========================================================


// foreach ($result as $row) {
//     echo "Doctor Name: " . $row['full_name'] . "<br>";
//     echo "Specialization: " . $row['specialization'] . "<br><br>";
// }

// $firstName = $userInfo[0][1];
// $lastName = $userInfo[0][2];
// $email  = $userInfo[0][3];
// $phone = $userInfo[0][4];
// $role = $userInfo[0][5];

// echo $firstName . "<br>";
// echo $result[0] . "<br>";

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIU Health Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm fixed w-full z-10">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="#" class="flex items-center">
                <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care" class="h-10">
            </a>
            <div class="hidden lg:flex items-center space-x-8">
                <div class="flex space-x-6">
                    <a href="\Hero\hero_page.php"
                        class="text-gray-700 font-medium hover:text-blue-500 transition relative group no-underline">
                        Home
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full "></span>
                    </a>
                    <a href="#"
                        class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                        About Us
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#"
                        class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                        Departments
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#"
                        class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                        Doctors
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="\Hero\FAQ.php"
                        class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                        FAQ
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="\Hero\contactUs.php"
                        class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                        Contact Us
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="..\logIn\login.php"
                        class="no-underline text-gray-700 font-medium hover:text-blue-500 transition px-4 py-2 rounded-lg hover:bg-blue-50">Sign
                        In</a>
                    <a href="..\SignUp\signup.php"
                        class="bg-blue-500 text-white font-medium px-5 py-2 rounded-lg hover:bg-blue-600 transition shadow-sm">Sign
                        Up</a>
                </div>
            </div>
            <button class="lg:hidden text-gray-600 focus:outline-none" onclick="toggleMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div id="mobileMenu" class="hidden lg:hidden bg-white shadow-md">
            <div class="container mx-auto px-4 py-4 flex flex-col space-y-4">
                <a href="\Hero\hero_page.php" class="text-gray-700 font-medium hover:text-blue-500 transition">Home</a>
                <a href="#" class="text-gray-700 font-medium hover:text-blue-500 transition">About Us</a>
                <a href="#" class="text-gray-700 font-medium hover:text-blue-500 transition">Departments</a>
                <a href="#" class="text-gray-700 font-medium hover:text-blue-500 transition">Doctors</a>
                <a href="\Hero\FAQ.php" class="text-gray-700 font-medium hover:text-blue-500 transition">FAQ</a>
                <a href="\Hero\contactUs.php" class="text-gray-700 font-medium hover:text-blue-500 transition">Contact
                    Us</a>
                <div class="flex flex-col space-y-3">
                    <a href="..\logIn\login.php" class="text-gray-700 font-medium hover:text-blue-500 transition">Sign
                        In</a>
                    <a href="..\SignUp\signup.php"
                        class="bg-blue-500 text-white font-medium px-5 py-2 rounded-lg hover:bg-blue-600 transition text-center">Sign
                        Up</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-8 lg:mb-0">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">Health Care Now<br>Simplified For
                        Everyone</h1>
                    <p class="text-gray-600 mb-6">Health carely offers free tools to get health insurance quotes, based
                        on donations rather than restrictive health plan networks.</p>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Start Your Health Journey Here</h2>
                    <div class="flex space-x-4">
                        <button class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">Book
                            Consultation Now</button>
                        <button
                            class="border border-blue-500 text-blue-500 px-6 py-3 rounded-lg hover:bg-blue-50 transition">Learn
                            More</button>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <img src="/Includes/Images/HeroPage/hero_img.png" alt="Doctors" class="w-full rounded-lg">
                    <div class="absolute bottom-4 left-4 bg-white p-4 rounded-lg shadow-lg">
                        <h5 class="text-lg font-semibold text-gray-800">870+ Doctors</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="py-12 bg-gradient-to-r from-blue-50 to-white">
        <div class="container mx-auto px-4">
            <h3 class="text-center text-blue-500 font-semibold mb-2">Fast Solutions</h3>
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">Step by Step to Your Solutions</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full mb-4"></div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Check Health Complaints</h5>
                    <p class="text-gray-600 text-sm">Easily identify your condition to choose the right specialist.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full mb-4"></div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Choose a Specialist</h5>
                    <p class="text-gray-600 text-sm">Select a doctor based on your specific health needs.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full mb-4"></div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Make a Schedule</h5>
                    <p class="text-gray-600 text-sm">Book a consultation with your chosen specialist.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full mb-4"></div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Get Your Solutions</h5>
                    <p class="text-gray-600 text-sm">Receive tailored treatment plans from our experts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Ratings Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h3 class="text-center text-blue-500 font-semibold mb-2">Our Rating</h3>
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">Employee Benefits at 7500+ Hospitals</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-gray-800 mb-2">900+</h3>
                    <p class="text-lg font-semibold text-gray-800">Verified Specialists</p>
                    <p class="text-gray-500 text-sm">Highly Verified</p>
                </div>
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-gray-800 mb-2">45000+</h3>
                    <p class="text-lg font-semibold text-gray-800">Happy Customers</p>
                    <p class="text-gray-500 text-sm">High Performance</p>
                </div>
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-gray-800 mb-2">99.7%</h3>
                    <p class="text-lg font-semibold text-gray-800">Positive Feedback</p>
                    <p class="text-gray-500 text-sm">Customer Approved</p>
                </div>
            </div>
        </div>
    </section>





    <!-- Book an Appointment Section -->
    <section class="py-12 bg-gradient-to-l from-blue-50 to-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Book an Appointment</h2>

            <!-- Buttons with data-category -->
            <div class="flex flex-wrap gap-3 mb-6">
                <button data-category="all"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-500 transition filter-btn">All</button>
                <button data-category="cardiologist"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-500 transition filter-btn">Cardiologist</button>
                <button data-category="orthopedist"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-500 transition filter-btn">Orthopedist</button>
                <button data-category="headache"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-500 transition filter-btn">Headache</button>
                <button data-category="eyecare"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-500 transition filter-btn">Eye Care</button>
                <button data-category="nutritionist"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-500 transition filter-btn">Nutritionist</button>
            </div>

            <!-- Doctors container with ID -->
            <div id="doctorsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                // Initially show all doctors with your original PHP loop
                foreach ($allDoctors as $row) {
                ?>
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
                        <img src="/Includes/male-doctors-white-medical.jpg" alt="Doctor"
                            class="w-full h-40 object-cover rounded-lg mb-3">

                        <h5 class="text-lg font-semibold text-gray-800">
                            <?php echo $row['full_name']; ?>
                        </h5>
                        <p class="text-gray-600 text-sm">
                            <?php echo $row['specialization']; ?>
                        </p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Patient Caring Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h5 class="text-blue-500 font-semibold mb-2">Helping Patients Globally</h5>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Patient <span class="text-blue-500">Caring</span></h2>
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-6 lg:mb-0">
                    <p class="text-gray-600 mb-4">Our mission is to provide courteous, respectful, and compassionate
                        care. Let us be your first choice for healthcare.</p>
                    <ul class="list-none space-y-2">
                        <li class="text-gray-600">• Stay Updated About Your Health</li>
                        <li class="text-gray-600">• Check Your Results Online</li>
                        <li class="text-gray-600">• Manage Your Appointments</li>
                    </ul>
                </div>
                <div class="lg:w-1/2">
                    <img src="/Includes/Images/HeroPage/patient-care.jpeg" alt="Patient Care" class="w-full rounded-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Consult Section -->
    <section class="py-12 bg-gradient-to-r from-blue-50 to-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Quick Consult For</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm text-center hover:shadow-md transition">
                    <img src="/Includes/Images/Quick Consult/heart.png" alt="Heart" class="h-10 mx-auto mb-2">
                    <p class="text-gray-600 text-sm">Heart</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm text-center hover:shadow-md transition">
                    <img src="/Includes/Images/Quick Consult/heart.png" alt="Asthma" class="h-10 mx-auto mb-2">
                    <p class="text-gray-600 text-sm">Asthma</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm text-center hover:shadow-md transition">
                    <img src="/Includes/Images/Quick Consult/heart.png" alt="Lungs" class="h-10 mx-auto mb-2">
                    <p class="text-gray-600 text-sm">Lungs</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm text-center hover:shadow-md transition">
                    <img src="/Includes/Images/Quick Consult/heart.png" alt="Oxygen" class="h-10 mx-auto mb-2">
                    <p class="text-gray-600 text-sm">Oxygen</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm text-center hover:shadow-md transition">
                    <img src="/Includes/Images/Quick Consult/heart.png" alt="Diabetics" class="h-10 mx-auto mb-2">
                    <p class="text-gray-600 text-sm">Diabetics</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm text-center hover:shadow-md transition">
                    <img src="/Includes/Images/Quick Consult/heart.png" alt="Prescribe" class="h-10 mx-auto mb-2">
                    <p class="text-gray-600 text-sm">Prescribe</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">Our Patients’ Feedback</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm flex space-x-4 hover:shadow-md transition">
                    <img src="/Includes/Images/happy-patient.jpg" alt="Patient"
                        class="h-32 w-32 object-cover rounded-lg">
                    <div>
                        <p class="text-gray-600 mb-3">"Healthcarely offers 24/7 doctor services with no appointment
                            needed, making it easy to feel better."</p>
                        <h5 class="text-lg font-semibold text-gray-800">Naufal Hidayat</h5>
                        <p class="text-gray-500 text-sm">Student at Telkom University</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm flex space-x-4 hover:shadow-md transition">
                    <img src="/Includes/Images/happy-patient.jpg" alt="Patient"
                        class="h-32 w-32 object-cover rounded-lg">
                    <div>
                        <p class="text-gray-600 mb-3">"Healthcarely offers 24/7 doctor services with no appointment
                            needed, making it easy to feel better."</p>
                        <h5 class="text-lg font-semibold text-gray-800">Naufal Hidayat</h5>
                        <p class="text-gray-500 text-sm">Student at Telkom University</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include '../Includes/footer.php'; ?>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>


    <!-- FOR THE DOCTOR APOINMENT SECTION -->



    <!-- ========= -->
    <script>
        // Pass PHP arrays as JS objects
        const doctorsData = {
            all: <?php echo json_encode($allDoctors); ?>,
            cardiologist: <?php echo json_encode($cardiologist); ?>,
            orthopedist: <?php echo json_encode($orthopedist); ?>,
            headache: <?php echo json_encode($headache); ?>,
            eyecare: <?php echo json_encode($eyecare); ?>,
            nutritionist: <?php echo json_encode($nutritionist); ?>
        };

        // Render doctors keeping your exact card format and styles
        function renderDoctors(doctors) {
            const container = document.getElementById('doctorsContainer');
            container.innerHTML = ''; // clear existing

            doctors.forEach(doc => {
                const card = document.createElement('div');
                card.className = "bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition";

                card.innerHTML = `
                <img src="/Includes/male-doctors-white-medical.jpg" alt="Doctor"
                    class="w-full h-40 object-cover rounded-lg mb-3">
                <h5 class="text-lg font-semibold text-gray-800">${doc.full_name}</h5>
                <p class="text-gray-600 text-sm">${doc.specialization}</p>
            `;

                container.appendChild(card);
            });
        }

        // Add click listeners to buttons
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                const category = button.getAttribute('data-category');
                renderDoctors(doctorsData[category]);
            });
        });
    </script>


</body>

</html>