<!-- booking.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .sidebar {
        transition: width 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        transform: translateZ(0);
        /* Force hardware acceleration */
        will-change: width;
        /* Optimize animation */
    }

    /* Hide text when collapsed */
    .sidebar:not(:hover) .sidebar-text {
        display: none;
    }

    .sidebar:not(:hover) .search-input {
        display: none;
    }

    /* Crazy cool hover effect */
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
        background: linear-gradient(120deg,
                transparent,
                rgba(147, 51, 234, 0.3),
                transparent);
        transition: all 0.5s ease;
    }

    .sidebar-item:hover::before {
        left: 100%;
    }

    .sidebar-item:hover {
        background-color: #f3f4f6;
        /* Light gray hover */
        color: #9333ea;
        /* Purple text on hover */
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    /* Hide default radio button */
    input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        position: absolute;
        opacity: 0;
    }

    /* Style for doctor card labels */
    input[type="radio"]+label {
        display: block;
        background: white;
        border: 1px solid #d1d5db;
        /* gray-300 */
        border-radius: 0.5rem;
        /* rounded-lg */
        padding: 1rem;
        /* p-4 */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        /* shadow-sm */
        cursor: pointer;
        transition: all 0.2s ease;
    }

    input[type="radio"]:hover+label {
        background-color: #f3f4f6;
        /* hover:bg-gray-100 */
    }

    input[type="radio"]:checked+label {
        border-color: #3b82f6;
        /* blue-500 */
        background-color: #eff6ff;
        /* blue-50 */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Style for day and time labels */
    input[type="radio"]+label.day-label,
    input[type="radio"]+label.time-label {
        display: block;
        background: white;
        border: 1px solid #d1d5db;
        /* gray-300 */
        border-radius: 0.5rem;
        /* rounded-lg */
        padding: 0.75rem;
        /* p-3 */
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    input[type="radio"]:hover+label.day-label,
    input[type="radio"]:hover+label.time-label {
        background-color: #f3f4f6;
        /* hover:bg-gray-100 */
    }

    input[type="radio"]:checked+label.day-label,
    input[type="radio"]:checked+label.time-label {
        border-color: #3b82f6;
        /* blue-500 */
        background-color: #eff6ff;
        /* blue-50 */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 50;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        width: 100%;
        max-width: 500px;
        position: relative;
    }

    .modal-content input,
    .modal-content select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        margin-top: 0.25rem;
    }

    .modal-content input:focus,
    .modal-content select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .payment-options {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .payment-options label {
        flex: 1;
        text-align: center;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        cursor: pointer;
    }

    .payment-options input[type="radio"]:checked+label {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    </style>
</head>

<body class="bg-white">
    <div class="flex min-h-screen">
        <!-- Include Sidebar -->
        <?php include '../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-6 ml-16">
            <h1 class="text-3xl font-bold text-blue-900 mb-6">Book an appointment</h1>

            <!-- Form -->
            <form id="bookingForm" method="POST" action="submit_booking.php">
                <!-- Specialist Dropdown -->
                <div class="mb-6">
                    <label class="block text-red-600 font-semibold mb-2">Specialist</label>
                    <select name="specialist"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Select a specialist</option>
                        <option value="Cardiologist">Cardiologist</option>
                        <option value="Neurologist">Neurologist</option>
                        <option value="Dermatologist">Dermatologist</option>
                        <option value="Pediatrician">Pediatrician</option>
                    </select>
                </div>

                <!-- Available Doctors -->
                <div class="mb-6">
                    <h2 class="text-red-600 font-semibold mb-4">Available doctors:</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Doctor Card 1 -->
                        <input type="radio" id="doctor1" name="doctor" value="Dr. Mohammed Ismail" required>
                        <label for="doctor1" class="flex items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRripLcqGUKIBfgbtmux6U1UY9UkgezqzJzFw&s"
                                alt="Doctor" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h3 class="text-red-600 font-semibold">Dr. Mohammed Ismail</h3>
                                <p class="text-gray-600 text-sm">Binever Mahallesi</p>
                                <div class="flex">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        </label>
                        <!-- Doctor Card 2 -->
                        <input type="radio" id="doctor2" name="doctor" value="Dr. Nadia Fallah">
                        <label for="doctor2" class="flex items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRripLcqGUKIBfgbtmux6U1UY9UkgezqzJzFw&s"
                                alt="Doctor" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h3 class="text-red-600 font-semibold">Dr. Nadia Fallah</h3>
                                <p class="text-gray-600 text-sm">Binever Mahallesi</p>
                                <div class="flex">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        </label>
                        <!-- Doctor Card 3 -->
                        <input type="radio" id="doctor3" name="doctor" value="Dr. Salih Ahmet">
                        <label for="doctor3" class="flex items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRripLcqGUKIBfgbtmux6U1UY9UkgezqzJzFw&s"
                                alt="Doctor" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h3 class="text-red-600 font-semibold">Dr. Salih Ahmet</h3>
                                <p class="text-gray-600 text-sm">Binever Mahallesi</p>
                                <div class="flex">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        </label>
                        <!-- Doctor Card 4 -->
                        <input type="radio" id="doctor4" name="doctor" value="Dr. Mohammed Ismail 2">
                        <label for="doctor4" class="flex items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRripLcqGUKIBfgbtmux6U1UY9UkgezqzJzFw&s"
                                alt="Doctor" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h3 class="text-red-600 font-semibold">Dr. Mohammed Ismail</h3>
                                <p class="text-gray-600 text-sm">Binever Mahallesi</p>
                                <div class="flex">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Available Day -->
                <div class="mb-6">
                    <h2 class="text-red-600 font-semibold mb-4">Available Day:</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <input type="radio" id="day1" name="day" value="Monday, 5 April" required>
                        <label for="day1" class="day-label">Monday, 5 April</label>

                        <input type="radio" id="day2" name="day" value="Tuesday, 6 April">
                        <label for="day2" class="day-label">Tuesday, 6 April</label>

                        <input type="radio" id="day3" name="day" value="Wednesday, 7 April">
                        <label for="day3" class="day-label">Wednesday, 7 April</label>

                        <input type="radio" id="day4" name="day" value="Thursday, 8 April">
                        <label for="day4" class="day-label">Thursday, 8 April</label>

                        <input type="radio" id="day5" name="day" value="Friday, 9 April">
                        <label for="day5" class="day-label">Friday, 9 April</label>
                    </div>
                </div>

                <!-- Available Time -->
                <div class="mb-6">
                    <h2 class="text-red-600 font-semibold mb-4">Available Time:</h2>
                    <div class="grid grid-cols-3 sm:grid-cols-5 lg:grid-cols-7 gap-4">
                        <input type="radio" id="time1" name="time" value="09:00" required>
                        <label for="time1" class="time-label">09:00</label>

                        <input type="radio" id="time2" name="time" value="10:00">
                        <label for="time2" class="time-label">10:00</label>

                        <input type="radio" id="time3" name="time" value="11:00">
                        <label for="time3" class="time-label">11:00</label>

                        <input type="radio" id="time4" name="time" value="12:00">
                        <label for="time4" class="time-label">12:00</label>

                        <input type="radio" id="time5" name="time" value="13:00">
                        <label for="time5" class="time-label">13:00</label>

                        <input type="radio" id="time6" name="time" value="14:00">
                        <label for="time6" class="time-label">14:00</label>

                        <input type="radio" id="time7" name="time" value="15:00">
                        <label for="time7" class="time-label">15:00</label>

                        <input type="radio" id="time8" name="time" value="16:00">
                        <label for="time8" class="time-label">16:00</label>

                        <input type="radio" id="time9" name="time" value="17:00">
                        <label for="time9" class="time-label">17:00</label>

                        <input type="radio" id="time10" name="time" value="18:00">
                        <label for="time10" class="time-label">18:00</label>
                    </div>
                </div>

                <!-- Book Now Button -->
                <button type="submit" id="bookNowBtn"
                    class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">Book Now</button>
            </form>

            <!-- Payment Modal -->
            <div id="paymentModal" class="modal">
                <div class="modal-content">
                    <div class="mb-4">
                        <div class="payment-options">
                            <input type="radio" id="card" name="payment_method" value="card" checked>
                            <label for="card" class="flex items-center">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.5 10H20.5" stroke="#323232" stroke-width="2" stroke-linecap="round" />
                                    <path d="M6 14H8" stroke="#323232" stroke-width="2" stroke-linecap="round" />
                                    <path d="M11 14H13" stroke="#323232" stroke-width="2" stroke-linecap="round" />
                                    <path
                                        d="M3 9C3 7.11438 3 6.17157 3.58579 5.58579C4.17157 5 5.11438 5 7 5H12H17C18.8856 5 19.8284 5 20.4142 5.58579C21 6.17157 21 7.11438 21 9V12V15C21 16.8856 21 17.8284 20.4142 18.4142C19.8284 19 18.8856 19 17 19H12H7C5.11438 19 4.17157 19 3.58579 18.4142C3 17.8284 3 16.8856 3 15V12V9Z"
                                        stroke="#323232" stroke-width="2" stroke-linejoin="round" />
                                </svg>
                                Card
                            </label>

                            <input type="radio" id="bkash" name="payment_method" value="bkash">
                            <label for="bkash" class="flex items-center">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <style>
                                        .a {
                                            fill: none;
                                            stroke: #000000;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                        }
                                        </style>
                                    </defs>
                                    <path class="a"
                                        d="M22.9814,8.6317s-4.1632,14.704-3.8089,14.704,16.4755,2.923,16.4755,2.923Z" />
                                    <polyline class="a"
                                        points="22.981 8.632 6.329 6.152 19.172 23.336 21.387 33.522 35.648 26.259 39.368 17.445 30.393 18.946" />
                                    <polyline class="a" points="37.929 20.855 43 20.855 39.368 17.445" />
                                    <polyline class="a"
                                        points="21.387 33.522 21.741 35.427 13.725 41.848 19.172 23.336" />
                                    <polyline class="a" points="35.648 26.259 35.117 29.138 22.848 32.778" />
                                    <polyline class="a" points="8.455 8.997 5 8.997 16.044 19.15" />
                                </svg>
                                bKash
                            </label>

                            <input type="radio" id="nagad" name="payment_method" value="nagad">
                            <label for="nagad" class="flex items-center">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <style>
                                        .a {
                                            fill: none;
                                            stroke: #000000;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                        }
                                        </style>
                                    </defs>
                                    <path class="a" d="M18.8808,6.3975A19.3468,19.3468,0,1,0,42.3963,19.3847" />
                                    <path class="a"
                                        d="M14.9194,25.893C14.8584,21.68,17.4842,13.8021,26.4,9.955L22.7968,3.5432C17.4231,6.169,10.2174,15.2066,14.9194,25.893Z" />
                                    <path class="a"
                                        d="M22.136,12.4087a16.7784,16.7784,0,0,0-2.9215,8.8424c1.8394-3.7912,7.7259-9.6477,17.4192-9.0767l-.3362-7.347A17.9936,17.9936,0,0,0,25.6848,8.683" />
                                    <path class="a"
                                        d="M34.4651,12.1527A16.506,16.506,0,0,0,23.896,20.28c3.3473-2.56,11.238-5.1453,19.64-.2781l3.0022-6.7141a17.7464,17.7464,0,0,0-9.9239-1.5322" />
                                    <path class="a" d="M13.4377,20.0692a11.6039,11.6039,0,1,0,19.0467-2.7711" />
                                </svg>
                                Nagad
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Card number</label>
                        <input type="text" name="card_number" placeholder="1234 1234 1234 1234" class="border-gray-300"
                            required>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div class="flex-1">
                            <label class="block text-gray-700">Expiry</label>
                            <input type="text" name="expiry" placeholder="12/25" class="border-gray-300" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700">CVC</label>
                            <input type="text" name="cvc" placeholder="123" class="border-gray-300" required>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div class="flex-1">
                            <label class="block text-gray-700">Country</label>
                            <select name="country" class="border-gray-300" required>
                                <option value="United States">United States</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <!-- Add more countries as needed -->
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700">Postal code</label>
                            <input type="text" name="postal_code" placeholder="90210" class="border-gray-300" required>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button id="cancelBtn"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                        <button id="nextBtn"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const bookNowBtn = document.getElementById('bookNowBtn');
    const paymentModal = document.getElementById('paymentModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const nextBtn = document.getElementById('nextBtn');
    const bookingForm = document.getElementById('bookingForm');

    // Show modal when "Book Now" is clicked
    bookNowBtn.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default form submission
        // Check if the required fields are filled
        const specialist = bookingForm.querySelector('select[name="specialist"]').value;
        const doctor = bookingForm.querySelector('input[name="doctor"]:checked');
        const day = bookingForm.querySelector('input[name="day"]:checked');
        const time = bookingForm.querySelector('input[name="time"]:checked');

        if (specialist && doctor && day && time) {
            paymentModal.style.display = 'flex';
        } else {
            alert('Please fill out all required fields (Specialist, Doctor, Day, and Time).');
        }
    });

    // Close modal when "Cancel" is clicked
    cancelBtn.addEventListener('click', () => {
        paymentModal.style.display = 'none';
    });

    // Submit form when "Next" is clicked
    nextBtn.addEventListener('click', () => {
        // Validate modal fields
        const cardNumber = document.querySelector('input[name="card_number"]').value;
        const expiry = document.querySelector('input[name="expiry"]').value;
        const cvc = document.querySelector('input[name="cvc"]').value;
        const country = document.querySelector('select[name="country"]').value;
        const postalCode = document.querySelector('input[name="postal_code"]').value;

        if (cardNumber && expiry && cvc && country && postalCode) {
            bookingForm.submit(); // Submit the form to submit_booking.php
        } else {
            alert('Please fill out all payment fields.');
        }
    });

    // Close modal when clicking outside of it
    paymentModal.addEventListener('click', (e) => {
        if (e.target === paymentModal) {
            paymentModal.style.display = 'none';
        }
    });
    </script>
</body>

</html>

<!-- 
Card number: 1234 1234 1234 1234
Expiry: 12/25
CVC: 123
Country: United States
Postal code: 90210
-->