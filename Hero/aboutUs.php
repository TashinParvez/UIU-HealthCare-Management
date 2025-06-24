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
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Hero/heroNav.php'); ?>

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