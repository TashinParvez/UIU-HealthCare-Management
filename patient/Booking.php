<!-- booking.php -->


<?php

session_start();
include "../Includes/Database_connection.php";


// Set the time zone to Bangladesh Standard Time (BST)
$bdTimeZone = new DateTimeZone('Asia/Dhaka');
$bdDateTime = new DateTime('now', $bdTimeZone);

$current_time = $bdDateTime->format('H:i:s'); // Output format 10:25:45

if ($current_time < '09:00:00') {

    $date = $bdDateTime->format('j F'); // Output format 26 June
    $day = $bdDateTime->format('l'); // Output format Thursday
} else {
    // Get tomorrow's date
    $tomorrowDateTime = clone $bdDateTime;
    $tomorrowDateTime->add(new DateInterval('P1D'));

    $date = $tomorrowDateTime->format('j F');
    $day = $tomorrowDateTime->format('l');
}


// ............... Taking All Doctors Information ..........................

$stmt = $conn->prepare('
    SELECT 
        d.doctor_id, 
        CONCAT(u.first_name, " ", u.last_name) AS name, 
        d.specialization, 
        d.qualification, 
        d.available_days, 
        d.available_hours, 
        d.consultation_fee
    FROM doctors d JOIN users u
    ON d.doctor_id = u.user_id
');

$stmt->execute();
$result = $stmt->get_result();

$doctors_info = $result->fetch_all(MYSQLI_ASSOC);

// Example usage:
// echo $doctors_info[0]['doctor_id'];


// ................ Book an Appointment .....................

if (isset($_POST['book_appointment'])) {

    $patient_id = $_SESSION['user_id'] ?? '1002';
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor'] ?? '');
    $appointment_date = mysqli_real_escape_string($conn, $_POST['day'] ?? '');
    $appointment_time = mysqli_real_escape_string($conn, $_POST['time'] ?? '');

    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? 'cash');
    if ($payment_method == 'Nagad' || $payment_method == 'bKash') {
        $payment_method = 'mobile_banking';
    }
    $amount = getAmount($doctors_info, $doctor_id);

    $stmt = $conn->prepare('INSERT INTO payments (payment_method, amount) VALUES (?, ?)');
    $stmt->bind_param('sd', $payment_method, $amount);

    if ($stmt->execute()) {

        $payment_id = $conn->insert_id; // Get the auto-incremented payment_id
        $stmt->close();

        $payment_success = false;

        switch ($payment_method) {
            case 'cash':

                $payment_success = true;
                break;
            case 'mobile_banking':

                $banking_type = $payment_method;
                $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id'] ?? '');
                $transaction_number = mysqli_real_escape_string($conn, $_POST['transaction_number'] ?? '');

                $stmt = $conn->prepare('INSERT INTO mobile_banking_payments (payment_id, banking_type, transaction_id, transaction_number) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('isss', $payment_id, $banking_type, $transaction_id, $transaction_number);

                $payment_success = $stmt->execute();
                $stmt->close();

                break;
            case 'card':

                $card_number = mysqli_real_escape_string($conn, $_POST['card_number'] ?? '');
                $expiry = mysqli_real_escape_string($conn, $_POST['expiry'] ?? '');
                $cvc = mysqli_real_escape_string($conn, $_POST['cvc'] ?? '');
                $card_holder_name = mysqli_real_escape_string($conn, $_POST['card_holder_name'] ?? '');

                $stmt = $conn->prepare('INSERT INTO card_payments (payment_id, card_number, expiry, cvc, card_holder_name) VALUES (?, ?, ?, ?, ?)');
                $stmt->bind_param('issss', $payment_id, $card_number, $expiry, $cvc, $card_holder_name);

                $payment_success = $stmt->execute();
                $stmt->close();

                break;
            default:
                echo "Invalid payment method";
                break;
        }

        if ($payment_success) {

            $stmt = $conn->prepare('INSERT INTO appointments (patient_id, doctor_id, payment_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('iiiss', $patient_id, $doctor_id, $payment_id, $appointment_date, $appointment_time);

            if ($stmt->execute()) {
                $stmt->close();
                mysqli_close($conn);

                header('Location: submit_booking.php');
                exit();
            } else {
                echo "Error inserting appointment: " . $stmt->error;
            }

            mysqli_close($conn);
        } else {
            echo "Error inserting payment method details.";
        }
    } else {
        echo "Error inserting payment: " . $stmt->error;
    }
}


function getAmount($doctors_info, $doctor_id)
{

    foreach ($doctors_info as $doctor) {
        if ($doctor['doctor_id'] == $doctor_id) {
            return $doctor['consultation_fee'];
        }
    }
}

?>


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

        input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            position: absolute;
            opacity: 0;
        }

        input[type="radio"]+label {
            display: block;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        input[type="radio"]:hover+label {
            background-color: #f3f4f6;
        }

        input[type="radio"]:checked+label {
            border-color: #3b82f6;
            background-color: #eff6ff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        input[type="radio"]+label.day-label,
        input[type="radio"]+label.time-label {
            display: block;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        input[type="radio"]:hover+label.day-label,
        input[type="radio"]:hover+label.time-label {
            background-color: #f3f4f6;
        }

        input[type="radio"]:checked+label.day-label,
        input[type="radio"]:checked+label.time-label {
            border-color: #3b82f6;
            background-color: #eff6ff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

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
    </style>

    <!-- ...............Noman .............. -->
    <style>
        .day-label,
        .time-label {
            display: inline-block;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            margin: 2px;
        }

        .day-label:hover,
        .time-label:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body class="bg-white">
    <div class="flex min-h-screen">
        <!-- Include Sidebar -->
        <?php include '../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-6 content">
            <h1 class="text-3xl font-bold text-blue-900 mb-6">Book an appointment</h1>

            <!-- Specialist Dropdown -->
            <div class="mb-6">
                <label class="block text-red-600 font-semibold mb-2">Specialist</label>
                <select name="specialist" id="specialist"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select a specialist</option>

                    <?php
                    $specializations = [];

                    foreach ($doctors_info as $doctor) {
                        if (!in_array($doctor['specialization'], $specializations)) {
                            $specializations[] = $doctor['specialization'];
                        }
                    }
                    ?>

                    <?php foreach ($specializations as $specialist) { ?>

                        <option value="<?php echo htmlspecialchars($specialist); ?>">
                            <?php echo htmlspecialchars($specialist); ?>
                        </option>

                    <?php } ?>

                </select>
            </div>
            <div class="mb-6">
                <label class="block text-red-600 font-semibold mb-2">Condition</label>
                <input type="text" name="specialist" id="specialist"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter condition">
            </div>

            <!-- Form -->
            <form id="bookingForm" method="POST" action="Booking.php">

                <!-- Available Doctors -->
                <div class="mb-6">
                    <h2 class="text-red-600 font-semibold mb-4">Available doctors:</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="doctorsGrid">
                        <!-- Doctors Card -->
                        <?php
                        foreach ($doctors_info as $index => $doctor) {
                        ?>
                            <div class="doctor-card"
                                data-specialization="<?php echo htmlspecialchars(strtolower($doctor['specialization'])); ?>"
                                data-index="<?php echo $index; ?>">
                                <input type="radio" id="<?php echo htmlspecialchars($doctor['doctor_id']); ?>" name="doctor"
                                    value="<?php echo htmlspecialchars($doctor['doctor_id']); ?>" required>
                                <label for="<?php echo htmlspecialchars($doctor['doctor_id']); ?>"
                                    class="flex items-center cursor-pointer">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRripLcqGUKIBfgbtmux6U1UY9UkgezqzJzFw&s"
                                        alt="Doctor" class="w-12 h-12 rounded-full mr-4">
                                    <div>
                                        <h3 class="text-red-600 font-semibold">
                                            <?php echo htmlspecialchars($doctor['name']); ?></h3>
                                        <p class="text-gray-600 text-sm">
                                            <?php echo htmlspecialchars($doctor['qualification']); ?></p>
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
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- Available Day -->
                <div class="mb-6" id="availableDays">
                    <h2 class="text-red-600 font-semibold mb-4">Available Day:</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Initial placeholders (5 times) -->
                        <?php for ($i = 0; $i < 5; $i++) { ?>
                            <input type="radio" id="day<?php echo $i + 1; ?>" name="day" value="---" required>
                            <label for="day<?php echo $i + 1; ?>" class="day-label">---</label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Available Time -->
                <div class="mb-6" id="availableTimes">
                    <h2 class="text-red-600 font-semibold mb-4">Available Time:</h2>
                    <div class="grid grid-cols-3 sm:grid-cols-5 lg:grid-cols-7 gap-4">
                        <!-- Initial placeholders (7 times) -->
                        <?php for ($i = 0; $i < 7; $i++) { ?>
                            <input type="radio" id="time<?php echo $i + 1; ?>" name="time" value="---" required>
                            <label for="time<?php echo $i + 1; ?>" class="time-label">---</label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Book Now Button -->
                <button type="button" id="bookNowBtn"
                    class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">Book Now</button>
                <!-- </form> -->

                <!-- Payment Modal -->
                <div id="paymentModal" class="modal">
                    <div class="modal-content">
                        <div class="mb-4">
                            <div class="payment-options">
                                <input type="radio" id="card" name="payment_method" value="card" checked>
                                <label for="card" class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.5 10H20.5" stroke="#323232" stroke-width="2"
                                            stroke-linecap="round" />
                                        <path d="M6 14H8" stroke="#323232" stroke-width="2" stroke-linecap="round" />
                                        <path d="M11 14H13" stroke="#323232" stroke-width="2" stroke-linecap="round" />
                                        <path
                                            d="M3 9C3 7.11438 3 6.17157 3.58579 5.58579C4.17157 5 5.11438 5 7 5H12H17C18.8856 5 19.8284 5 20.4142 5.58579C21 6.17157 21 7.11438 21 9V12V15C21 16.8856 21 17.8284 20.4142 18.4142C19.8284 19 18.8856 19 17 19H12H7C5.11438 19 4.17157 19 3.58579 18.4142C3 17.8284 3 16.8856 3 15V12V9Z"
                                            stroke="#323232" stroke-width="2" stroke-linejoin="round" />
                                    </svg>
                                    Card
                                </label>

                                <input type="radio" id="bkash" name="payment_method" value="bKash">
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

                                <input type="radio" id="nagad" name="payment_method" value="Nagad">
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
                            <input type="text" name="card_number" placeholder="1234 1234 1234 1234"
                                class="border-gray-300" required>
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

                        <div class="mb-4">
                            <label class="block text-gray-700">Card Holder's Name</label>
                            <input type="text" name="card_holder_name" placeholder="Aranya Kishor Das"
                                class="border-gray-300" required>
                        </div>
                    </div>
                </div>
            </form>
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
            const doctor = bookingForm.querySelector('input[name="doctor"]:checked');
            const day = bookingForm.querySelector('input[name="day"]:checked');
            const time = bookingForm.querySelector('input[name="time"]:checked');

            if (doctor && day && time) {
                paymentModal.style.display = 'flex';
            } else {
                alert('Please fill out all required fields (Doctor, Day, and Time).');
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

    <!-- ............ Noman ................ -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const specialistDropdown = document.getElementById('specialist');
            const doctorCards = document.querySelectorAll('.doctor-card');

            // Show all doctors initially
            doctorCards.forEach(card => {
                card.style.display = 'block'; // Ensure all cards are visible on load
            });

            // Add event listener for dropdown change
            specialistDropdown.addEventListener('change', function() {
                const selectedSpecialist = this.value.toLowerCase(); // Get selected specialization

                doctorCards.forEach(card => {
                    const cardSpecialization = card.getAttribute('data-specialization');

                    if (selectedSpecialist === '' || cardSpecialization === selectedSpecialist) {
                        card.style.display = 'block'; // Show card if no filter or match
                    } else {
                        card.style.display = 'none'; // Hide card if no match
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const doctorCards = document.querySelectorAll('.doctor-card');
            const availableDays = document.getElementById('availableDays');
            const availableTimes = document.getElementById('availableTimes');
            const daysContainer = availableDays.querySelector('div');
            const timesContainer = availableTimes.querySelector('div');

            // Add click event to doctor cards
            doctorCards.forEach(card => {
                card.addEventListener('click', function() {
                    const doctorIndex = parseInt(this.getAttribute('data-index'));
                    const doctor = <?php echo json_encode($doctors_info); ?>[doctorIndex];
                    if (!doctor) {
                        console.error('Doctor data not found for index:', doctorIndex);
                        return;
                    }
                    const availableDaysList = doctor.available_days.split(',').map(day => day
                        .trim());
                    const availableHours = doctor.available_hours.split(',').map(hour => hour
                        .trim());

                    // Clear existing days and times
                    daysContainer.innerHTML = '';
                    timesContainer.innerHTML = '';

                    // Get today's date and day from PHP variables
                    const todayDate = '<?php echo $date; ?>'.split(' '); // e.g., ["26", "June"]
                    const todayDay = '<?php echo $day; ?>'; // e.g., "Thursday"
                    const todayNum = parseInt(todayDate[0]); // e.g., 26
                    const month = todayDate[1]; // e.g., "June"

                    // Array of days
                    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
                        'Saturday'
                    ];
                    const todayDayIndex = days.indexOf(todayDay);

                    // Function to get next 5 days with format "Day, d Month"
                    function getNextFiveDays() {
                        const result = [];
                        for (let i = 0; i < 5; i++) {
                            const dayIndex = (todayDayIndex + i) % 7;
                            const dayName = days[dayIndex];
                            const dayNum = todayNum + i;
                            const formattedDate = `${dayName}, ${dayNum} ${month}`;
                            if (availableDaysList.includes(dayName)) {
                                result.push(formattedDate);
                            }
                        }
                        // Ensure all 5 days from dataset are mapped, filling with "---" only if less than 5
                        const allDays = doctor.available_days.split(',').map(day => day.trim());
                        allDays.forEach(day => {
                            const dayIndex = days.indexOf(day);
                            if (dayIndex !== -1) {
                                const dayNumAdjusted = todayNum + (dayIndex -
                                    todayDayIndex + (dayIndex < todayDayIndex ? 7 : 0));
                                const formattedDate = `${day}, ${dayNumAdjusted} ${month}`;
                                if (!result.includes(formattedDate)) {
                                    result.push(formattedDate);
                                }
                            }
                        });
                        while (result.length < 5) {
                            result.push('---');
                        }
                        return result;
                    }

                    // Generate available days
                    const nextFiveDays = getNextFiveDays();
                    nextFiveDays.forEach((day, index) => {
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.id = `day${index + 1}`;
                        input.name = 'day';
                        input.value = day;
                        input.required = true;

                        const label = document.createElement('label');
                        label.htmlFor = `day${index + 1}`;
                        label.className = 'day-label';
                        label.textContent = day;

                        daysContainer.appendChild(input);
                        daysContainer.appendChild(label);
                    });

                    // Function to generate half-hour slots from time ranges, limited to 7
                    function generateTimeSlots(hours) {
                        const slots = [];
                        hours.forEach(range => {
                            const [start, end] = range.split('-').map(time => {
                                const [hour, minute] = time.split(':');
                                return parseInt(hour) * 60 + parseInt(
                                    minute); // Convert to minutes
                            });
                            let current = start;
                            while (current < end) {
                                const hour = Math.floor(current / 60);
                                const minute = current % 60;
                                slots.push(
                                    `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`
                                );
                                current += 30; // Add 30 minutes
                            }
                        });
                        return slots;
                    }

                    // Generate available times
                    const timeSlots = generateTimeSlots(availableHours);
                    if (timeSlots.length === 0) {
                        console.warn('No time slots generated for doctor:', doctor.name);
                    }
                    timeSlots.forEach((time, index) => {
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.id = `time${index + 1}`;
                        input.name = 'time';
                        input.value = time;
                        input.required = true;

                        const label = document.createElement('label');
                        label.htmlFor = `time${index + 1}`;
                        label.className = 'time-label';
                        label.textContent = time;

                        timesContainer.appendChild(input);
                        timesContainer.appendChild(label);
                    });

                    // Fill remaining time slots with "---" if less than 7
                    while (timesContainer.children.length / 2 <
                        7) { // /2 because each input has a label
                        const index = timesContainer.children.length / 2;
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.id = `time${index + 1}`;
                        input.name = 'time';
                        input.value = '---';
                        input.required = true;

                        const label = document.createElement('label');
                        label.htmlFor = `time${index + 1}`;
                        label.className = 'time-label';
                        label.textContent = '---';

                        timesContainer.appendChild(input);
                        timesContainer.appendChild(label);
                    }
                });
            });
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

<!-- 
To fill up doctor infromation,
'available_days' column formate will be Saturda,Sunday, Monday
'available_hours' column formate will be 10:00-12:00,3:00-5:00
-->