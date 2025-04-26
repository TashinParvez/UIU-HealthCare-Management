<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex font-sans">

    <!-- Sidebar Include -->
    <?php include '../Includes/Sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-grow p-8 ml-16">
        <div class="container mx-auto max-w-6xl">

            <!-- Search Bar -->
            <div class="relative mb-8">
                <input type="text" placeholder="Search blog posts..."
                    class="w-full rounded-lg pl-10 pr-4 py-3 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none text-gray-700 placeholder-gray-400 transition">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Blog Posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Single Blog Card -->
                <div
                    class="bg-white p-6 rounded-lg border border-gray-100 hover:border-gray-200 hover:shadow-lg transition">
                    <h5 class="text-xl font-semibold text-gray-800 mb-3">5 Home Remedies for Headaches</h5>
                    <p class="text-gray-600 text-sm mb-4">Learn simple at-home solutions to relieve mild headaches,
                        including hydration and rest.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span
                            class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Headache</span>
                        <span class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Home
                            Remedies</span>
                    </div>
                    <a href="/patient/read_blog.php"
                        class="text-blue-500 text-sm font-medium hover:text-blue-600 transition">Read More</a>
                </div>

                <!-- Managing Period Cramps -->
                <div
                    class="bg-white p-6 rounded-lg border border-gray-100 hover:border-gray-200 hover:shadow-lg transition">
                    <h5 class="text-xl font-semibold text-gray-800 mb-3">Managing Period Cramps</h5>
                    <p class="text-gray-600 text-sm mb-4">Tips for girls to ease menstrual discomfort naturally with
                        heat therapy and diet.</p>
                    <div class="flex-associated with flex-wrap gap-2 mb-4">
                        <span class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Women
                            Health</span>
                        <span class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Period
                            Pain</span>
                    </div>
                    <a href="/patient/read_blog.php"
                        class="text-blue-500 text-sm font-medium hover:text-blue-600 transition">Read More</a>
                </div>

                <!-- Dealing with Acne Naturally -->
                <div
                    class="bg-white p-6 rounded-lg border border-gray-100 hover:border-gray-200 hover:shadow-lg transition">
                    <h5 class="text-xl font-semibold text-gray-800 mb-3">Dealing with Acne Naturally</h5>
                    <p class="text-gray-600 text-sm mb-4">Skincare tips for all ages to manage acne without harsh
                        chemicals.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span
                            class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Skincare</span>
                        <span class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Acne</span>
                    </div>
                    <a href="#" class="text-blue-500 text-sm font-medium hover:text-blue-600 transition">Read More</a>
                </div>

                <!-- Stress Management for Students -->
                <div
                    class="bg-white p-6 rounded-lg border border-gray-100 hover:border-gray-200 hover:shadow-lg transition">
                    <h5 class="text-xl font-semibold text-gray-800 mb-3">Stress Management for Students</h5>
                    <p class="text-gray-600 text-sm mb-4">Practical advice to reduce stress with mindfulness and
                        exercise.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Mental
                            Health</span>
                        <span
                            class="bg-blue-100 text-blue-600 text-xs font-medium rounded-full px-2.5 py-1">Students</span>
                    </div>
                    <a href="#" class="text-blue-500 text-sm font-medium hover:text-blue-600 transition">Read More</a>
                </div>
            </div>

            <!-- More to View Button -->
            <div class="text-center mt-10">
                <a href="#"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition">
                    More to View
                </a>
            </div>

        </div>
    </div>

</body>

</html>