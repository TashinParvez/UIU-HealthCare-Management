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
                <div id="cards-container" class="flex space-x-4 overflow-x-auto hide-scrollbar">
                    <!-- Patient Card -->
                    <div class="flex-none w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h5 class="mb-4 text-xl font-medium text-gray-900">John Doe</h5>
                        <p class="text-gray-600 mb-4">Last Visit: 15 Apr 2025</p>
                        <ul role="list" class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <span>Condition: Hypertension</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <span>Next Appointment: 30 Apr 2025</span>
                            </li>
                        </ul>
                        <button type="button"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            View Details
                        </button>
                    </div>

                    <div class="flex-none w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h5 class="mb-4 text-xl font-medium text-gray-900">Jane Smith</h5>
                        <p class="text-gray-600 mb-4">Last Visit: 10 Apr 2025</p>
                        <ul role="list" class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <span>Condition: Diabetes</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <span>Next Appointment: 28 Apr 2025</span>
                            </li>
                        </ul>
                        <button type="button"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            View Details
                        </button>
                    </div>

                    <div class="flex-none w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h5 class="mb-4 text-xl font-medium text-gray-900">Emily Johnson</h5>
                        <p class="text-gray-600 mb-4">Last Visit: 20 Mar 2025</p>
                        <ul role="list" class="space-y-3 mb-6">
                            <li class="flex items-center text-gray-600">
                                <span>Condition: Asthma</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <span>Next Appointment: 05 May 2025</span>
                            </li>
                        </ul>
                        <button type="button"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            View Details
                        </button>
                    </div>
                </div>
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
                    <a href="..\patient\AppointmentDashboard.php"><button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            Book Now
                        </button>
                    </a>
                </div>
            </div>
            <!-- Medicine Section -->
            <div class="mt-8">
                <h1 class="text-5xl font-bold mb-6">Medicine</h1>
                <div class="space-y-4">
                    <?php
                    // Example array of medicines (replace with database query)
                    $medicines = [
                        ['id' => 1, 'name' => 'Drometa Zoletronic', 'dosage' => '500mg | 25ml | After Meal', 'time' => '8:30AM - 12:00AM', 'duration' => '2 Month', 'start_date' => '05 Oct 2024', 'progress' => 50],
                        ['id' => 2, 'name' => 'Drometa Zoletronic', 'dosage' => '500mg | 25ml | After Meal', 'time' => '8:30AM - 12:00AM', 'duration' => '2 Month', 'start_date' => '05 Oct 2024', 'progress' => 50],
                        ['id' => 3, 'name' => 'Drometa Zoletronic', 'dosage' => '500mg | 25ml | After Meal', 'time' => '8:30AM - 12:00AM', 'duration' => '2 Month', 'start_date' => '05 Oct 2024', 'progress' => 50],
                        ['id' => 4, 'name' => 'Drometa Zoletronic', 'dosage' => '500mg | 25ml | After Meal', 'time' => '8:30AM - 12:00AM', 'duration' => '2 Month', 'start_date' => '05 Oct 2024', 'progress' => 50],
                    ];

                    foreach ($medicines as $medicine) {
                    ?>
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
                                    <h5 class="text-lg font-semibold text-gray-900"><?php echo $medicine['name']; ?>
                                    </h5>
                                    <p class="text-sm text-gray-500"><?php echo $medicine['dosage']; ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500"><?php echo $medicine['time']; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $medicine['duration']; ?></p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-sm text-gray-500">Start Date: <?php echo $medicine['start_date']; ?></p>
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full"
                                                style="width: <?php echo $medicine['progress']; ?>%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600"><?php echo $medicine['progress']; ?>%</span>
                                    </div>
                                    <button
                                        class="px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition"
                                        onclick="window.location.href='medicine-details.php?id=<?php echo $medicine['id']; ?>'">
                                        Taken
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
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