// Includes/js/script.js

// Variable to store user's location
let userLocation = null;

function initMap() {
    // Check if Google Maps API is loaded
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        console.error('Google Maps API not loaded');
        return;
    }

    // Initialize the map with a default center (will be updated with user's location)
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 40.7128, lng: -74.0060 }, // Default: Manhattan
        zoom: 14
    });

    // Check if geolocation is supported by the browser
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Save the user's location in the variable
                userLocation = userPos;

                // Center the map on the user's location
                map.setCenter(userPos);

                // Add a marker for the user's location
                new google.maps.Marker({
                    position: userPos,
                    map: map,
                    title: "Your Location",
                    icon: {
                        url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                    }
                });

                // Function to search for nearby hospitals
                const searchHospitals = (retryCount = 0) => {
                    const service = new google.maps.places.PlacesService(map);
                    const request = {
                        location: userPos,
                        radius: 10000, // 10km radius
                        type: 'hospital' // Try 'hospital' first
                    };

                    service.nearbySearch(request, (results, status) => {
                        console.log('Places API Status:', status); // Debug: Log the status
                        console.log('Places API Results:', results); // Debug: Log the results

                        if (status === google.maps.places.PlacesServiceStatus.OK && results.length > 0) {
                            for (let i = 0; i < results.length; i++) {
                                const hospital = results[i];
                                console.log('Hospital Found:', hospital.name, hospital.geometry.location); // Debug: Log each hospital

                                new google.maps.Marker({
                                    position: hospital.geometry.location,
                                    map: map,
                                    title: hospital.name,
                                    icon: {
                                        url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                                    }
                                });
                            }
                        } else if (status === google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
                            console.warn('No hospitals found with type "hospital". Trying broader "health" type...');
                            // Fallback to broader 'health' type
                            const fallbackRequest = {
                                location: userPos,
                                radius: 10000,
                                type: 'health'
                            };

                            service.nearbySearch(fallbackRequest, (fallbackResults, fallbackStatus) => {
                                console.log('Fallback Places API Status:', fallbackStatus);
                                console.log('Fallback Places API Results:', fallbackResults);

                                if (fallbackStatus === google.maps.places.PlacesServiceStatus.OK && fallbackResults.length > 0) {
                                    const hospitals = fallbackResults.filter(place => place.types.includes('hospital'));
                                    console.log('Filtered Hospitals:', hospitals);

                                    if (hospitals.length > 0) {
                                        for (let i = 0; i < hospitals.length; i++) {
                                            const hospital = hospitals[i];
                                            new google.maps.Marker({
                                                position: hospital.geometry.location,
                                                map: map,
                                                title: hospital.name,
                                                icon: {
                                                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                                                }
                                            });
                                        }
                                    } else {
                                        alert('No hospitals found within 10km of your location.');
                                    }
                                } else {
                                    alert('No health facilities found within 10km of your location.');
                                }
                            });
                        } else if (status === google.maps.places.PlacesServiceStatus.OVER_QUERY_LIMIT && retryCount < 3) {
                            // Retry after a delay if over query limit
                            console.warn('Over query limit. Retrying in 2 seconds...');
                            setTimeout(() => searchHospitals(retryCount + 1), 2000);
                        } else {
                            console.error('Places request failed due to ' + status);
                            alert('Failed to find nearby hospitals. Status: ' + status + '. Please check the console for details.');
                        }
                    });
                };

                // Start the hospital search
                searchHospitals();
            },
            (error) => {
                console.error('Error getting location:', error);
                alert('Unable to retrieve your location. Please enable location services.');
            }
        );
    } else {
        alert('Geolocation is not supported by your browser.');
    }
}

// Handle the Emergency Alert button click
document.getElementById('emergencyButton').addEventListener('click', () => {
    if (userLocation) {
        // Simulate sending the location data (in a real app, this would be sent to a server)
        alert(`Emergency alert sent! Location: Latitude ${userLocation.lat}, Longitude ${userLocation.lng}`);
    } else {
        alert('Location not available. Please ensure location services are enabled.');
    }
});

//Use this code to send the location to the server
// Uncomment the code below to send the user's location to the server
// fetch('/send-emergency-alert', {
//     method: 'POST',
//     headers: { 'Content-Type': 'application/json' },
//     body: JSON.stringify({ location: userLocation })
// })
// .then(response => response.json())
// .then(data => alert('Emergency alert sent successfully!'))
// .catch(error => alert('Error sending alert: ' + error));