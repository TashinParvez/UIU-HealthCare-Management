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
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Hero/heroNav.php'); ?>

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