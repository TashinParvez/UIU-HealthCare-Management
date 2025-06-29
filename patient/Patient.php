<?php
include "../Includes/Database_connection.php";

// --------------- Visits count ---------------------
session_start();

if (!isset($_SESSION['has_visited'])) {
    $today = date('Y-m-d');

    // Try to update today's visit count
    $stmt = $conn->prepare("UPDATE visit_counts SET visit_count = visit_count + 1 WHERE visit_date = ?");
    $stmt->bind_param('s', $today);
    $stmt->execute();

    // If no rows updated, insert new row
    if ($stmt->affected_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO visit_counts (visit_date, visit_count) VALUES (?, 1)");
        $stmt->bind_param('s', $today);
        $stmt->execute();
    }

    $_SESSION['has_visited'] = true;
}


$patient_id = $_SESSION['user_id'] ?? '2001';


// ........... Fetching Prescription Informtions ...................

$stmt = $conn->prepare("
        SELECT 
            pr.prescription_id,
            pr.appointment_id,
            pr.doctor_id,
            CONCAT(u.first_name, ' ', u.last_name) AS doctor_name,
            pr.complaints,
            pr.medicines,
            pr.tests,
            pr.advice,
            DATE(pr.followup_date) AS followup_date,
            DATE(pr.created_at) AS date
        FROM 
            prescriptions pr
        JOIN 
            users u ON pr.doctor_id = u.user_id
        WHERE 
            pr.patient_id = ?
        ORDER BY pr.created_at DESC
    ");

$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$prescriptions = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();




// Example:

// foreach ($prescriptions as $row) {
//     echo "Prescription ID: " . $row['prescription_id'] . "<br>";
//     echo "Doctor: " . $row['doctor_name'] . "<br>";
//     echo "Complaints: " . $row['complaints'] . "<br>";
//     echo "Medicines: " . $row['medicines'] . "<br>";
//     echo "Tests: " . $row['tests'] . "<br>";
//     echo "Advice: " . $row['advice'] . "<br>";
//     echo "Date: " . $row['created_at'] . "<hr>";
// }


// $patient_id = 3001; 

$stmt = $conn->prepare("
    SELECT medicines 
    FROM prescriptions 
    WHERE patient_id = ? 
    ORDER BY created_at DESC 
    LIMIT 1
");
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $medicines_raw = $row['medicines'];

    // Split by comma to separate each medicine
    $medicine_entries = explode(',', $medicines_raw);

    // Initialize array to store names
    $medicine_names = [];

    foreach ($medicine_entries as $entry) {
        $parts = explode('-', $entry);
        $name = trim($parts[0]); // First part is the medicine name
        $medicine_names[] = $name;
    }

    // Show the medicine names
    echo "Medicines:<br>";
    foreach ($medicine_names as $med) {
        echo htmlspecialchars($med) . "<br>";
    }
} else {
    echo "No prescriptions found for this patient.";
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Hide scrollbar for Chrome, Safari, and Edge */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for Firefox */
        .hide-scrollbar {
            scrollbar-width: none;
        }

        /* Optional: Smooth scrolling behavior */
        .hide-scrollbar {
            scroll-behavior: smooth;
        }

        /* Sidebar and layout adjustments */
        .content {
            margin-left: 64px;
            /* Match the collapsed sidebar width */
            padding: 20px;
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Match the expanded sidebar width */
        }

        .sidebar {
            transition: width 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            transform: translateZ(0);
            will-change: width;
        }

        .sidebar:not(:hover) .sidebar-text {
            display: none;
        }

        .sidebar:not(:hover) .search-input {
            display: none;
        }

        .sidebar-item {
            position: relative;
            overflow: hidden;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(147, 51, 234, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .sidebar-item:hover::before {
            left: 100%;
        }

        .sidebar-item:hover {
            background-color: #f3f4f6;
            color: #9333ea;
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Include Sidebar -->
        <?php include '../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 content">
            <h1 class="text-5xl font-bold mb-6">Patient</h1>
            <!-- Patient Cards Container with Controlled Overflow -->
            <!-- Patient Cards Container with Navigation Buttons -->
            <div class="relative">
                <!-- Left Button -->
                <button id="scroll-left"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white font-bold rounded-full w-12 h-12 flex items-center justify-center shadow-md hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 transition-colors duration-300 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 rotate-180" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <!-- Cards Container -->
                <style>
                    .hide-scrollbar::-webkit-scrollbar {
                        display: none;
                    }

                    .hide-scrollbar {
                        -ms-overflow-style: none;
                        scrollbar-width: none;
                    }

                    .modal {
                        display: none;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5);
                        align-items: center;
                        justify-content: center;
                        z-index: 50;
                    }

                    .modal-content {
                        background-color: white;
                        padding: 24px;
                        border-radius: 8px;
                        max-width: 500px;
                        width: 100%;
                    }
                </style>
                </head>

                <body class="p-6">
                    <h1 class="text-3xl font-bold mb-6">Patient Dashboard</h1>
                    <div id="cards-container" class="flex space-x-4 overflow-x-auto hide-scrollbar">
                        <!-- Patient cards will be dynamically inserted here -->
                    </div>

                    <!-- Modal -->
                    <div id="patientModal" class="modal">
                        <div class="modal-content">
                            <h2 id="modalTitle" class="text-2xl font-medium text-gray-900 mb-4"></h2>
                            <p id="modalDiagnosis" class="text-gray-600 mb-2"></p>
                            <p id="modalMedications" class="text-gray-600 mb-2"></p>
                            <p id="modalNotes" class="text-gray-600 mb-4"></p>
                            <button onclick="closeModal()"
                                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5">
                                Close
                            </button>
                        </div>
                    </div>

                    <script>
                        // Mock patient data (to be replaced by backend API)

                        const patients = [
                            <?php foreach ($prescriptions as $prescription): ?> {
                                    id: <?= $prescription['prescription_id'] ?>,
                                    name: "<?= htmlspecialchars($prescription['doctor_name']) ?>",
                                    last_visit: "<?= date('d M Y', strtotime($prescription['date'])) ?>",
                                    condition: "<?= htmlspecialchars($prescription['complaints']) ?>",
                                    next_appointment: "<?= date('d M Y', strtotime($prescription['followup_date'])) ?>",
                                    diagnosis: "<?= htmlspecialchars($prescription['tests']) ?>",
                                    medications: "<?= htmlspecialchars($prescription['medicines']) ?>",
                                    notes: "<?= htmlspecialchars($prescription['advice']) ?>"
                                }
                                <?= $prescription !== end($prescriptions) ? ',' : '' ?>
                            <?php endforeach; ?>
                        ];

                        // Populate patient cards
                        const container = document.getElementById('cards-container');
                        patients.forEach(patient => {
                            const card = `
                <div class="flex-none w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h5 class="mb-4 text-xl font-medium text-gray-900">${patient.name}</h5>
                    <p class="text-gray-600 mb-4">Last Visit: ${patient.last_visit}</p>
                    <ul role="list" class="space-y-3 mb-6">
                        <li class="flex items-center text-gray-600">
                            <span>Condition: ${patient.condition}</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <span>Next Appointment: ${patient.next_appointment}</span>
                        </li>
                    </ul>
                    <button type="button" onclick="openModal(${patient.id})"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5">
                        View Details
                    </button>
                </div>
            `;
                            container.innerHTML += card;
                        });

                        function openModal(patientId) {
                            // Simulate fetching patient details (replace with fetch to backend API)
                            const patient = patients.find(p => p.id === patientId);
                            if (patient) {
                                document.getElementById('modalTitle').textContent = `${patient.name}'s Details`;
                                document.getElementById('modalDiagnosis').innerHTML =
                                    `<strong>Diagnosis:</strong> ${patient.diagnosis}`;
                                document.getElementById('modalMedications').innerHTML =
                                    `<strong>Medications:</strong> ${patient.medications}`;
                                document.getElementById('modalNotes').innerHTML =
                                    `<strong>Notes:</strong> ${patient.notes}`;
                                document.getElementById('patientModal').style.display = 'flex';
                            } else {
                                alert('Patient not found');
                            }
                        }

                        function closeModal() {
                            document.getElementById('patientModal').style.display = 'none';
                        }
                    </script>
                    <!-- Right Button -->
                    <button id="scroll-right"
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white font-bold rounded-full w-12 h-12 flex items-center justify-center shadow-md hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 transition-colors duration-300 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
            </div>
            <br>
            <a href="..\patient\EmergencyAlert.php">
                <button type="button"
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    Emergency Alert
                </button>
            </a>
            <br><br>
            <!-- Book an Appointment Box -->
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8">
                <div class="flex items-center justify-between">
                    <h5 class="text-xl font-medium text-gray-500">Book an appointment</h5>
                    <a href="Booking.php"><button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            Book Now
                        </button>
                    </a>
                </div>
            </div>
            <!-- Medicine Section -->
            <div class="mt-8">
                <h1 class="text-5xl font-bold mb-6">Medicine</h1>
                <div id="medicine-container" class="space-y-4">
                    <!-- Medicine cards will be dynamically inserted here -->
                </div>
            </div>

            <script>
                // Mock medicine data (to be replaced by backend API)
                // const medicines = [{
                //         id: 1,
                //         name: "Drometa Zoletronic",
                //         dosage: "500mg | 25ml | After Meal",
                //         time: "8:30AM - 12:00AM",
                //         duration: "2 Month",
                //         start_date: "05 Oct 2024",
                //         total_doses: 120, // 2 doses/day * 60 days
                //         doses_taken: 0
                //     },
                //     {
                //         id: 2,
                //         name: "Drometa Zoletronic",
                //         dosage: "500mg | 25ml | After Meal",
                //         time: "8:30AM - 12:00AM",
                //         duration: "2 Month",
                //         start_date: "05 Oct 2024",
                //         total_doses: 120,
                //         doses_taken: 0
                //     },
                //     {
                //         id: 3,
                //         name: "Drometa Zoletronic",
                //         dosage: "500mg | 25ml | After Meal",
                //         time: "8:30AM - 12:00AM",
                //         duration: "2 Month",
                //         start_date: "05 Oct 2024",
                //         total_doses: 120,
                //         doses_taken: 0
                //     },
                //     {
                //         id: 4,
                //         name: "Drometa Zoletronic",
                //         dosage: "500mg | 25ml | After Meal",
                //         time: "8:30AM - 12:00AM",
                //         duration: "2 Month",
                //         start_date: "05 Oct 2024",
                //         total_doses: 7,
                //         doses_taken: 0
                //     }
                // ];

                const medicines = [
                    <?php
                    $id = 1;
                    foreach ($medicine_names as $index => $med) {
                        echo "{
                id: {$id},
                name: \"" . htmlspecialchars($med) . "\",
                dosage: \"500mg | 25ml | After Meal\",
                time: \"8:30AM - 12:00AM\",
                duration: \"2 Month\",
                start_date: \"05 Oct 2024\",
                total_doses: 120,
                doses_taken: 0
            }";
                        // Add comma if not last element
                        if ($index !== array_key_last($medicine_names)) {
                            echo ",";
                        }
                        echo "\n";
                        $id++;
                    }
                    ?>
                ];


                // Load saved doses from localStorage or initialize
                const savedDoses = JSON.parse(localStorage.getItem('medicineDoses')) || {};
                medicines.forEach(medicine => {
                    if (savedDoses[medicine.id]) {
                        medicine.doses_taken = savedDoses[medicine.id];
                    }
                });

                // Function to calculate progress percentage
                function calculateProgress(dosesTaken, totalDoses) {
                    return Math.min(Math.round((dosesTaken / totalDoses) * 100), 100);
                }

                // Function to render medicine cards
                function renderMedicines() {
                    const container = document.getElementById('medicine-container');
                    container.innerHTML = '';
                    medicines.forEach(medicine => {
                        const progress = calculateProgress(medicine.doses_taken, medicine.total_doses);
                        const card = `
                    <div class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <svg class="w-8 h-8 mr-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="6" y="4" width="12" height="16" rx="4" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <line x1="12" y1="4" x2="12" y2="20" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-900">${medicine.name}</h5>
                                    <p class="text-sm text-gray-500">${medicine.dosage}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">${medicine.time}</p>
                                    <p class="text-sm text-gray-500">${medicine.duration}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-sm text-gray-500">Start Date: ${medicine.start_date}</p>
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: ${progress}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600">${progress}%</span>
                                    </div>
                                    <button onclick="markDoseTaken(${medicine.id})"
                                        class="px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                        Taken
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                        container.innerHTML += card;
                    });
                }

                // Function to mark a dose as taken
                function markDoseTaken(medicineId) {
                    const medicine = medicines.find(m => m.id === medicineId);
                    if (medicine && medicine.doses_taken < medicine.total_doses) {
                        medicine.doses_taken += 1;
                        // Save to localStorage
                        savedDoses[medicine.id] = medicine.doses_taken;
                        localStorage.setItem('medicineDoses', JSON.stringify(savedDoses));
                        // Re-render cards
                        renderMedicines();
                    }
                }

                // Initial render
                renderMedicines();
            </script>
        </div>
    </div>
</body>
<script>
    const cardsContainer = document.getElementById('cards-container');
    const scrollLeftBtn = document.getElementById('scroll-left');
    const scrollRightBtn = document.getElementById('scroll-right');

    // Function to update button visibility based on scroll position
    function updateButtonVisibility() {
        const scrollLeft = cardsContainer.scrollLeft;
        const maxScrollLeft = cardsContainer.scrollWidth - cardsContainer.clientWidth;

        // Hide left button if at the start
        if (scrollLeft <= 0) {
            scrollLeftBtn.classList.add('hidden');
        } else {
            scrollLeftBtn.classList.remove('hidden');
        }

        // Hide right button if at the end
        if (scrollLeft >= maxScrollLeft - 1) { // -1 to account for rounding errors
            scrollRightBtn.classList.add('hidden');
        } else {
            scrollRightBtn.classList.remove('hidden');
        }
    }

    // Initial check for button visibility
    updateButtonVisibility();

    // Update button visibility on scroll
    cardsContainer.addEventListener('scroll', updateButtonVisibility);

    // Scroll left by the width of one card (max-w-sm = 384px + 16px gap from space-x-4)
    scrollLeftBtn.addEventListener('click', () => {
        cardsContainer.scrollBy({
            left: -400,
            behavior: 'smooth'
        });
    });

    // Scroll right by the width of one card
    scrollRightBtn.addEventListener('click', () => {
        cardsContainer.scrollBy({
            left: 400,
            behavior: 'smooth'
        });
    });
</script>

</html>