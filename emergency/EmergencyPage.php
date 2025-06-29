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
        <?php include '../Includes/Sidebar.php'; ?>
        <!-- Main Content -->
        <div class="flex-1 p-6 ml-16">
            <div class="border boarder-gray-300 rounded-lg p-4 bg-white shadow-md">
                <!-- Alert Details -->
                <h1 class="text-2xl font-bold text-teal-800 mb-4">Alert Details</h1>
                <textarea id="patientSituation" class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Describe patient's situation (optional)" rows="4"></textarea>
                <textarea id="additionalDetails" class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Additional details (optional)" rows="4"></textarea>

                <!-- Location Details -->
                <h1 class="text-2xl font-bold text-teal-800 mb-4">Location Details</h1>
                <input type="text" id="addressInput" class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Address (required)">
                <input type="text" id="additionalLocationInfo" class="w-full p-2 border border-gray-300 rounded mb-4"
                    placeholder="Additional location info (optional)">

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
    <!-- Embedded JavaScript for Map, Geolocation, and Alert Submission -->
    <script>
        // Initialize the map with UIU's location as default
        function initMap() {
            const defaultLatLng = [23.7985, 90.4041]; // United International University
            const map = L.map('map').setView(defaultLatLng, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
            const marker = L.marker(defaultLatLng).addTo(map);
            marker.bindPopup("<b>Emergency Location</b>").openPopup();

            // Set default address to UIU
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${defaultLatLng[0]}&lon=${defaultLatLng[1]}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById('addressInput').value =
                            `${data.display_name} (Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)})`;
                        marker.bindPopup(
                            `<b>${data.display_name} (Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)})</b>`
                        ).openPopup();
                    } else {
                        document.getElementById('addressInput').value =
                            `Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)}`;
                        marker.bindPopup(
                            `<b>Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)}</b>`
                        ).openPopup();
                    }
                })
                .catch(error => {
                    console.error('Error reverse geocoding:', error);
                    document.getElementById('addressInput').value =
                        `Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)}`;
                    marker.bindPopup(
                        `<b>Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)}</b>`
                    ).openPopup();
                });

            // Attempt to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        map.setView([lat, lon], 13);
                        marker.setLatLng([lat, lon]);
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data && data.display_name) {
                                    document.getElementById('addressInput').value =
                                        `${data.display_name} (Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)})`;
                                    marker.bindPopup(
                                        `<b>${data.display_name} (Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)})</b>`
                                    ).openPopup();
                                } else {
                                    document.getElementById('addressInput').value =
                                        `Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}`;
                                    marker.bindPopup(
                                        `<b>Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}</b>`
                                    ).openPopup();
                                }
                            })
                            .catch(error => {
                                console.error('Error reverse geocoding:', error);
                                // Silently fall back to UIU location
                                map.setView(defaultLatLng, 13);
                                marker.setLatLng(defaultLatLng);
                                document.getElementById('addressInput').value =
                                    `Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)}`;
                                marker.bindPopup(
                                    `<b>Lat: ${defaultLatLng[0].toFixed(6)}, Lon: ${defaultLatLng[1].toFixed(6)}</b>`
                                ).openPopup();
                            });
                    },
                    (error) => {
                        console.error('Geolocation error:', error.message);
                        // Silently fall back to UIU location (already set)
                    }
                );
            }

            // Address search functionality
            document.getElementById('addressInput').addEventListener('change', function () {
                const address = this.value;
                if (address) {
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lon = parseFloat(data[0].lon);
                                map.setView([lat, lon], 13);
                                marker.setLatLng([lat, lon]);
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

        // Handle emergency button click
        document.getElementById('emergencyButton').addEventListener('click', function () {
            const patientSituation = document.getElementById('patientSituation').value;
            const additionalDetails = document.getElementById('additionalDetails').value;
            const address = document.getElementById('addressInput').value;
            const additionalLocationInfo = document.getElementById('additionalLocationInfo').value;

            if (!address) {
                alert('Please provide an address');
                return;
            }

            fetch('http://localhost:8080/submit_alert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    patient_situation: patientSituation,
                    additional_details: additionalDetails,
                    address: address,
                    additional_location_info: additionalLocationInfo
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Emergency alert sent successfully');
                    } else {
                        alert('Failed to send emergency alert: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error sending alert:', error);
                    alert('Error sending emergency alert');
                });
        });

        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>

</html>