<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alert System</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Main Content -->
        <div class="flex-1 p-4">
            <div class="border border-gray-300 rounded-lg p-4 bg-white shadow-md">
                <!-- Alert Details -->
                <h1 class="text-2xl font-bold text-teal-800 mb-4">Alert Details</h1>
                <textarea class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Describe patient's situation" rows="4"></textarea>
                <textarea class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="Additional details"
                    rows="4"></textarea>

                <!-- Location Details -->
                <h1 class="text-2xl font-bold text-teal-800 mb-4">Location Details</h1>
                <input type="text" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="Address">
                <input type="text" class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Additional location info">

                <!-- Google Map -->
                <div id="map" class="w-full h-64 mt-4 rounded-lg shadow-md" style="height: 256px;"></div>

                <!-- Emergency Alert Button -->
                <button id="emergencyButton"
                    class="bg-red-600 text-white px-4 py-2 rounded mt-4 w-full hover:bg-red-700 shadow">
                    EMERGENCY ALERT
                </button>
            </div>
        </div>
    </div>

    <!-- Link to the external JavaScript file -->
    <script src="Includes/js/script.js"></script>

    <!-- Google Maps API Script -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdfxXAaDPPTh_zBLGhFf4yXXCvukktwDo&libraries=places&callback=initMap"
        async defer></script>
</body>

</html>