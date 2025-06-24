<!-- heroNav.php -->
<nav class="bg-white shadow-sm fixed w-full z-10">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <a href="/Hero/hero_page.php" class="flex items-center">
            <img src="/Includes/Images/logo/logo-blue.png" alt="UIU Health Care" class="h-10">
        </a>
        <div class="hidden lg:flex items-center space-x-8">
            <div class="flex space-x-6">
                <a href="/Hero/hero_page.php"
                    class="text-gray-700 font-medium hover:text-blue-500 transition relative group no-underline">
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="/Hero/aboutUs.php"
                    class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                    About Us
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                    Departments
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="/Hero/hero_page.php#appointment"
                    class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                    Doctors
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="/Hero/FAQ.php"
                    class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                    FAQ
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="/Hero/contactUs.php"
                    class="no-underline text-gray-700 font-medium hover:text-blue-500 transition relative group">
                    Contact Us
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/logIn/login.php"
                    class="no-underline text-gray-700 font-medium hover:text-blue-500 transition px-4 py-2 rounded-lg hover:bg-blue-50">Sign
                    In</a>
                <a href="/SignUp/signup.php"
                    class="bg-blue-500 text-white font-medium px-5 py-2 rounded-lg hover:bg-blue-600 transition shadow-sm">Sign
                    Up</a>
            </div>
        </div>
        <button class="lg:hidden text-gray-600 focus:outline-none" onclick="toggleMenu()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <div id="mobileMenu" class="hidden lg:hidden bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex flex-col space-y-4">
            <a href="/Hero/hero_page.php" class="text-gray-700 font-medium hover:text-blue-500 transition">Home</a>
            <a href="/Hero/aboutUs.php" class="text-gray-700 font-medium hover:text-blue-500 transition">About Us</a>
            <a href="#" class="text-gray-700 font-medium hover:text-blue-500 transition">Departments</a>
            <a href="/Hero/hero_page.php#appointment" class="text-gray-700 font-medium hover:text-blue-500 transition">Doctors</a>
            <a href="/Hero/FAQ.php" class="text-gray-700 font-medium hover:text-blue-500 transition">FAQ</a>
            <a href="/Hero/contactUs.php" class="text-gray-700 font-medium hover:text-blue-500 transition">Contact Us</a>
            <div class="flex flex-col space-y-3">
                <a href="/logIn/login.php" class="text-gray-700 font-medium hover:text-blue-500 transition">Sign In</a>
                <a href="/SignUp/signup.php"
                    class="bg-blue-500 text-white font-medium px-5 py-2 rounded-lg hover:bg-blue-600 transition text-center">Sign
                    Up</a>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMenu() {
        const menu = document.getElementById("mobileMenu");
        menu.classList.toggle("hidden");
    }
</script>