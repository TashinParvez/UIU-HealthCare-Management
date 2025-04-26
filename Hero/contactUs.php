<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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

    <!-- Main Content -->
    <section class="pt-24 pb-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm">
                <h6 class="text-blue-500 font-semibold mb-2">Get in Touch</h6>
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Contact Us</h1>
                <p class="text-gray-600 mb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text"
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="First name" required>
                        <input type="text"
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="Last name" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="email"
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="Email" required>
                        <input type="tel"
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="Phone number">
                    </div>
                    <div class="mb-4">
                        <select
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            required>
                            <option value="" disabled selected>Choose a topic...</option>
                            <option value="general">General Inquiry</option>
                            <option value="appointment">Appointment Request</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <textarea
                            class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="Type your message..." rows="5" required></textarea>
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-200 rounded"
                            id="acceptTerms" required>
                        <label for="acceptTerms" class="ml-2 text-gray-600 text-sm">I accept the terms</label>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition">Submit</button>
                </form>
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
</body>

</html>