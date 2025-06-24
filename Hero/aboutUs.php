<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | UIU Health Care</title>
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
                    <a href="/Hero/aboutUs.php"
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

    <!-- About Us Content -->
    <section class="pt-24 pb-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-sm">
                <h6 class="text-blue-500 font-semibold mb-2">Who We Are</h6>
                <h1 class="text-3xl font-bold text-gray-800 mb-4">About UIU Health Care Management</h1>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    UIU Health Care Management is a modern web-based platform developed by Computer Science students of
                    <strong>United International University (UIU)</strong>, Bangladesh.
                    Our goal is to create a smart, accessible, and efficient healthcare system tailored to meet the needs of our society.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-blue-50 p-5 rounded-lg">
                        <h3 class="text-xl font-semibold text-blue-600 mb-2">🎯 Our Mission</h3>
                        <p class="text-gray-700">To digitize healthcare services across Bangladesh and help hospitals, doctors, and patients stay connected through an intelligent and secure management system.</p>
                    </div>
                    <div class="bg-blue-50 p-5 rounded-lg">
                        <h3 class="text-xl font-semibold text-blue-600 mb-2">💡 Our Vision</h3>
                        <p class="text-gray-700">A future where every patient in Bangladesh can book appointments, access health records, and receive consultations — all from a single, user-friendly platform.</p>
                    </div>
                </div>

                <div class="bg-green-50 p-5 rounded-lg mb-6">
                    <h3 class="text-xl font-semibold text-green-600 mb-2">✔️ Key Features</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Online appointment scheduling with available doctors</li>
                        <li>Secure login and dashboard for patients, doctors, and admins</li>
                        <li>Medical history and prescription tracking</li>
                        <li>Blood group and allergy record management</li>
                        <li>Role-based access and streamlined admin panel</li>
                    </ul>
                </div>

                <p class="text-gray-600">
                    This system is made with ❤️ in Bangladesh and aims to bridge the gap between technology and healthcare
                    in a meaningful, user-friendly, and localized way.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include '../Includes/footer.php'; ?>

</body>

</html>