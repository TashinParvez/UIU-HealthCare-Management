<?php
include "../Includes/Database_connection.php";

// --------------- Visits count ---------------------
session_start();

if (!isset($_SESSION['has_visited'])) {
    $today = date('Y-m-d');

    // Try to update today's visit count
    $stmt = $conn->prepare("UPDATE visit_counts SET visit_count = visit_count + 1 WHERE visit_date = ?");
    $stmt->bind_param('s', $today);
    $stmt->execute();

    // If no rows updated, insert new row
    if ($stmt->affected_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO visit_counts (visit_date, visit_count) VALUES (?, 1)");
        $stmt->bind_param('s', $today);
        $stmt->execute();
    }

    $_SESSION['has_visited'] = true;
}

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

//  --------------------- Our Patients’ Feedback  ---------------------
$sql = "SELECT 
            CONCAT(u.first_name, ' ', u.last_name) AS patient_name,
            pf.feedback_text
        FROM 
            patient_feedback pf
        JOIN 
            users u ON pf.patient_id = u.user_id
        ORDER BY 
            RAND()
        LIMIT 5;";

$pFeedback = mysqli_query($conn, $sql);
$pFeedback = mysqli_fetch_all($pFeedback, MYSQLI_ASSOC);  // returns associative array
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIU Medical Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Custom styles for UIU branding */
    .uiu-blue {
        background-color: #003087;
        /* UIU primary blue color */
    }

    .uiu-blue-text {
        color: #003087;
    }

    .uiu-accent {
        background-color: #F5A623;
        /* UIU accent color (gold/orange) */
    }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <!-- Navigation Bar -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Hero/heroNav.php'); ?>

    <!-- Hero Section -->
    <section class="pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-8 lg:mb-0">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">UIU Medical Center<br>Your Health, Our
                        Priority</h1>
                    <p class="text-gray-600 mb-6">The UIU Medical Center provides comprehensive healthcare services
                        tailored for students, faculty, and staff, ensuring accessible and quality medical care within
                        the university community.</p>
                    <h2 class="text-2xl font-semibold uiu-blue-text mb-4">Begin Your Wellness Journey with us</h2>
                    <div class="flex space-x-4">
                        <a href="/Hero/Booking.php"><button
                                class="uiu-blue text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">Book
                                Appointment Now</button></a>
                        <button
                            class="border border-blue-500 uiu-blue-text px-6 py-3 rounded-lg hover:bg-blue-50 transition">Learn
                            About Our Services</button>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <img src="https://www.uiu.ac.bd/wp-content/uploads/2023/11/Medical.jpg" alt="Doctors"
                        class="w-full rounded-lg">
                    <div class="absolute bottom-4 left-4 bg-white p-4 rounded-lg shadow-lg">
                        <h5 class="text-lg font-semibold text-gray-800">50+ Expert Doctors</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="py-12 bg-gradient-to-r from-blue-50 to-white">
        <div class="container mx-auto px-4">
            <h3 class="text-center uiu-blue-text font-semibold mb-2">Your Health, Simplified</h3>
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">How to Access UIU Medical Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 uiu-blue rounded-full mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 21v-6a2 2 0 012-2h0a2 2 0 012 2v6m-4-6v-6m4 6v-6m-7 6h10" />
                        </svg>
                    </div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Identify Your Needs</h5>
                    <p class="text-gray-600 text-sm">Assess your health concerns to find the right specialist at UIU
                        Medical Center.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 uiu-blue rounded-full mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Select a Specialist</h5>
                    <p class="text-gray-600 text-sm">Choose from our expert doctors based on your health requirements.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 uiu-blue rounded-full mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Schedule Your Visit</h5>
                    <p class="text-gray-600 text-sm">Book an appointment conveniently through our online system.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 uiu-blue rounded-full mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">Receive Expert Care</h5>
                    <p class="text-gray-600 text-sm">Get personalized treatment plans from UIU’s dedicated medical team.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Ratings Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h3 class="text-center uiu-blue-text font-semibold mb-2">Our Commitment</h3>
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">Trusted Healthcare at UIU Medical Center</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-gray-800 mb-2">50+</h3>
                    <p class="text-lg font-semibold text-gray-800">Certified Specialists</p>
                    <p class="text-gray-500 text-sm">Accredited Professionals</p>
                </div>
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-gray-800 mb-2">10,000+</h3>
                    <p class="text-lg font-semibold text-gray-800">Served Patients</p>
                    <p class="text-gray-500 text-sm">UIU Community Trust</p>
                </div>
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-gray-800 mb-2">98%</h3>
                    <p class="text-lg font-semibold text-gray-800">Patient Satisfaction</p>
                    <p class="text-gray-500 text-sm">Community Approved</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Departments Section -->
    <section class="py-12 bg-white" id="departments">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">UIU Medical Specialties</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <div
                    class="bg-blue-50 rounded-lg p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg transition">
                    <div
                        class="bg-blue-200 uiu-blue-text rounded-full p-4 mb-4 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.34 6.374L12 20.5l-6.5-3.548a12.083 12.083 0 01.34-6.374L12 14z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Cardiology</h3>
                    <p class="text-gray-600 text-sm">Expert heart care for the UIU community by top cardiologists.</p>
                </div>
                <div
                    class="bg-green-50 rounded-lg p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg transition">
                    <div
                        class="bg-green-200 text-green-600 rounded-full p-4 mb-4 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Orthopedics</h3>
                    <p class="text-gray-600 text-sm">Specialized bone and joint care for UIU students and staff.</p>
                </div>
                <div
                    class="bg-purple-50 rounded-lg p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg transition">
                    <div
                        class="bg-purple-200 text-purple-600 rounded-full p-4 mb-4 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Neurology</h3>
                    <p class="text-gray-600 text-sm">Advanced care for headaches and neurological conditions.</p>
                </div>
                <div
                    class="bg-yellow-50 rounded-lg p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg transition">
                    <div
                        class="bg-yellow-200 text-yellow-600 rounded-full p-4 mb-4 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Eye Care</h3>
                    <p class="text-gray-600 text-sm">Comprehensive eye care services for the UIU community.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Book an Appointment Section -->
    <section id="appointment" class="py-12 bg-gradient-to-l from-blue-50 to-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Book an Appointment at UIU Medical Center</h2>
            <div class="flex flex-wrap gap-3 mb-6">
                <button data-category="all"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:uiu-blue-text transition filter-btn">All</button>
                <button data-category="cardiologist"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:uiu-blue-text transition filter-btn">Cardiologist</button>
                <button data-category="orthopedist"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:uiu-blue-text transition filter-btn">Orthopedist</button>
                <button data-category="headache"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:uiu-blue-text transition filter-btn">Headache</button>
                <button data-category="eyecare"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:uiu-blue-text transition filter-btn">Eye
                    Care</button>
                <button data-category="nutritionist"
                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-blue-50 hover:uiu-blue-text transition filter-btn">Nutritionist</button>
            </div>
            <div id="doctorsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                foreach ($allDoctors as $row) {
                ?>
                <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
                    <img src="/Includes/male-doctors-white-medical.jpg" alt="Doctor"
                        class="w-full h-40 object-cover rounded-lg mb-3">
                    <h5 class="text-lg font-semibold text-gray-800"><?php echo $row['full_name']; ?></h5>
                    <p class="text-gray-600 text-sm"><?php echo $row['specialization']; ?></p>
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
            <h5 class="uiu-blue-text font-semibold mb-2">Caring for Our Community</h5>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">UIU’s Commitment to <span class="uiu-blue-text">Patient
                    Care</span></h2>
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg mb-6 lg:mb-0">
                    <p class="text-gray-600 mb-4">At UIU Medical Center, we are dedicated to providing compassionate,
                        accessible, and high-quality healthcare to our students, faculty, and staff.</p>
                    <ul class="list-none space-y-2">
                        <li class="text-gray-600">• Monitor Your Health Updates</li>
                        <li class="text-gray-600">• Access Results Online</li>
                        <li class="text-gray-600">• Easily Manage Appointments</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Consult Section -->
    <section class="py-12 bg-gradient-to-r from-blue-50 to-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Quick Consult at UIU Medical Center</h2>
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

    <!-- Our Patients’ Feedback Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">Feedback from the UIU Community</h2>
            <div class="relative">
                <button id="prevBtn"
                    class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-lg border border-gray-300 uiu-blue-text hover:text-white hover:uiu-blue p-3 rounded-full transition duration-300 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div id="feedbackContainer" class="grid grid-cols-2 gap-6 overflow-hidden">
                    <!-- Feedback cards will be rendered here by JS -->
                </div>
                <button id="nextBtn"
                    class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-lg border border-gray-300 uiu-blue-text hover:text-white hover:uiu-blue p-3 rounded-full transition duration-300 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
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

    <!-- FOR THE DOCTOR Appointment SECTION script -->
    <script>
    const doctorsData = {
        all: <?php echo json_encode($allDoctors); ?>,
        cardiologist: <?php echo json_encode($cardiologist); ?>,
        orthopedist: <?php echo json_encode($orthopedist); ?>,
        headache: <?php echo json_encode($headache); ?>,
        eyecare: <?php echo json_encode($eyecare); ?>,
        nutritionist: <?php echo json_encode($nutritionist); ?>
    };

    function renderDoctors(doctors) {
        const container = document.getElementById('doctorsContainer');
        container.innerHTML = '';

        doctors.forEach(doc => {
            const card = document.createElement('div');
            card.className = "bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition";

            card.innerHTML = `
                    <img src="/Includes/male-doctors-white-medical.jpg" alt="Doctor" class="w-full h-40 object-cover rounded-lg mb-3">
                    <h5 class="text-lg font-semibold text-gray-800">${doc.full_name}</h5>
                    <p class="text-gray-600 text-sm">${doc.specialization}</p>
                `;

            container.appendChild(card);
        });
    }

    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            const category = button.getAttribute('data-category');
            renderDoctors(doctorsData[category]);
        });
    });
    </script>

    <!-- FOR Our Patients’ Feedback script -->
    <script>
    const feedbacks = <?php echo json_encode($pFeedback); ?>;
    let currentIndex = 0;

    function renderFeedbacks() {
        const container = document.getElementById('feedbackContainer');
        container.innerHTML = '';

        for (let i = 0; i < 2; i++) {
            const idx = (currentIndex + i) % feedbacks.length;
            const fb = feedbacks[idx];

            const card = document.createElement('div');
            card.className = "bg-white p-6 rounded-lg shadow-sm flex space-x-4 hover:shadow-md transition";

            card.innerHTML = `
                    <img src="/Includes/Images/happy-patient.jpg" alt="Patient" class="h-32 w-32 object-cover rounded-lg">
                    <div>
                        <p class="text-gray-600 mb-3">"${fb.feedback_text}"</p>
                        <h5 class="text-lg font-semibold text-gray-800">${fb.patient_name}</h5>
                        <p class="text-gray-500 text-sm">UIU Community Member</p>
                    </div>
                `;

            container.appendChild(card);
        }
    }

    document.getElementById('prevBtn').addEventListener('click', () => {
        currentIndex = (currentIndex - 2 + feedbacks.length) % feedbacks.length;
        renderFeedbacks();
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        currentIndex = (currentIndex + 2) % feedbacks.length;
        renderFeedbacks();
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderFeedbacks();
    });
    </script>
</body>

</html>