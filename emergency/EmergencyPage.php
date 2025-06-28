<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alert System</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <?php
        include '../Includes/Sidebar.php';
        ?>
        <!-- Main Content -->
        <div class="flex-1 p-6 ml-16">
            <div class="border border-gray-300 rounded-lg p-4 bg-white shadow-md">
                <!-- Alert Details -->
                <h1 class="text-2xl font-bold text-teal-800 mb-4">Alert Details</h1>
                <textarea class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Describe patient's situation" rows="4"></textarea>
                <textarea class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="Additional details"
                    rows="4"></textarea>

                <!-- Location Details -->
                <h1 class="text-2xl font-bold text-teal-800 mb-4">Location Details</h1>
                <input type="text" id="addressInput" class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Address">
                <input type="text" class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Additional location info">

                <!-- Leaflet Map -->
                <div id="map" class="w-full h-64 mt-4 rounded-lg shadow-md" style="height: 256px;"></div>

                <!-- Emergency Alert Button -->
                <button id="emergencyButton"
                    class="bg-red-600 text-white px-4 py-2 rounded mt-4 w-full hover:bg-red-700 shadow">
                    EMERGENCY ALERT
                </button>
            </div>
        </div>
    </div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Embedded JavaScript for Map and Geolocation -->
    <script>
    // Initialize the map
    function initMap() {
        // Create a map with a default fallback location (London)
        var map = L.map('map').setView([51.505, -0.09], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Add a marker at the default location
        var marker = L.marker([51.505, -0.09]).addTo(map);
        marker.bindPopup("<b>Emergency Location</b>").openPopup();

        // Get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    map.setView([lat, lon], 13);
                    marker.setLatLng([lat, lon]);
                    marker.bindPopup("<b>Your Current Location</b>").openPopup();

                    // Reverse geocode to get address and include lat/lon
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.display_name) {
                                // Include latitude and longitude in the address input
                                document.getElementById('addressInput').value =
                                    `${data.display_name} (Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)})`;
                                marker.bindPopup(
                                    `<b>${data.display_name} (Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)})</b>`
                                ).openPopup();
                            } else {
                                // Fallback if reverse geocoding fails
                                document.getElementById('addressInput').value =
                                    `Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}`;
                                marker.bindPopup(`<b>Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}</b>`)
                                    .openPopup();
                            }
                        })
                        .catch(error => {
                            console.error('Error reverse geocoding:', error);
                            // Fallback to coordinates only if reverse geocoding fails
                            document.getElementById('addressInput').value =
                                `Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}`;
                            marker.bindPopup(`<b>Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}</b>`)
                                .openPopup();
                        });
                },
                function(error) {
                    console.error('Geolocation error:', error.message);
                    alert('Unable to retrieve your location. Using default location.');
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }

        // Address search functionality
        document.getElementById('addressInput').addEventListener('change', function() {
            var address = this.value;
            if (address) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var lat = parseFloat(data[0].lat);
                            var lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 13);
                            marker.setLatLng([lat, lon]);
                            // Include latitude and longitude in the address input and popup
                            document.getElementById('addressInput').value =
                                `${data[0].display_name} (Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)})`;
                            marker.bindPopup(
                                `<b>${data[0].display_name} (Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)})</b>`
                            ).openPopup();
                        } else {
                            alert('Address not found');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching address:', error);
                        alert('Error finding address');
                    });
            }
        });
    }

    // Call initMap when the page loads
    document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>

</html>