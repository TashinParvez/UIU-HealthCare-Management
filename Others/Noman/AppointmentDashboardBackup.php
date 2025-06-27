<!-- appointmentdashboard.php -->


<?php

session_start();
$user_id = $_SESSION['user_id'] ?? '2003';

include "../Includes/Database_connection.php";


// Set the time zone to Bangladesh Standard Time (BST)
$bdTimeZone = new DateTimeZone('Asia/Dhaka');
$bdDateTime = new DateTime('now', $bdTimeZone);

$currentDateTime = $bdDateTime->getTimestamp(); // Current time as timestamp

$current_time = $bdDateTime->format('H:i:s'); // Output format 10:25:45
$date = $bdDateTime->format('j F'); // Output format 26 June


// ............... Taking All Appointments Information ..........................

$stmt = $conn->prepare('
    SELECT 
        d.doctor_id,
        CONCAT(u.first_name, " ", u.last_name) AS name,
        d.specialization,
        a.appointment_date,
        a.appointment_time
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    JOIN users pu ON pu.user_id = ? 
    JOIN doctors d ON a.doctor_id = d.doctor_id
    JOIN users u ON u.user_id = d.doctor_id  
    WHERE pu.user_id = ?
    ORDER BY a.appointment_date ASC, a.appointment_time ASC;
');

$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments_info = $result->fetch_all(MYSQLI_ASSOC);


$most_upcoming_appointment = $most_recent_appointment = '';
$min_time_diff = PHP_INT_MAX;
$min_past_time_diff = PHP_INT_MAX;

foreach ($appointments_info as $appointment) {
    // Skip if appointment date is empty or invalid
    if ($appointment['appointment_date'] === '0000-00-00') continue;

    // Create DateTime object
    $datetime_string = $appointment['appointment_date'] . ' ' . $appointment['appointment_time'];
    $appointmentDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $datetime_string, $bdTimeZone);

    if (!$appointmentDateTime) continue;

    $appointmentTimestamp = $appointmentDateTime->getTimestamp();
    $diff = $appointmentTimestamp - $currentDateTime;

    if ($diff >= 0 && $diff < $min_time_diff) {
        $min_time_diff = $diff;
        $most_upcoming_appointment = $appointment;
    }

    if ($diff < 0 && abs($diff) < $min_past_time_diff) {
        $min_past_time_diff = abs($diff);
        $most_recent_appointment = $appointment;
    }
}

// if ($most_upcoming_appointment) {
//     echo "Upcoming: " . $most_upcoming_appointment['name'] . '<br>';
//     print_r($most_upcoming_appointment);
// } else {
//     echo "No upcoming appointment<br>";
// }

// if ($most_recent_appointment) {
//     echo "Recent: " . $most_recent_appointment['name'] . '<br>';
//     print_r($most_recent_appointment);
// } else {
//     echo "No recent appointment<br>";
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Calendar styles */
        .calendar-day {
            position: relative;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }

        .calendar-day button {
            width: 100%;
            height: 100%;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #374151;
        }

        .calendar-day.today button {
            background-color: #3b82f6;
            color: white;
            border-radius: 0.5rem;
        }

        .calendar-day .appointment-dot {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .calendar-day .appointment-count {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #ef4444;
            color: white;
            font-size: 12px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        /* Appointment card styles */
        .appointment-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
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
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        .modal-content .close-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
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
        <div class="flex-1 p-6 content">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-blue-900">Appointment Dashboard</h1>
                <a href="booking.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Book New</a>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Calendar Section -->
                <div class="flex-1 bg-white p-4 rounded-lg shadow">
                    <?php
                    // Get current month and year, or use selected month/year
                    $currentMonth = date('n'); // 1-12
                    $currentYear = date('Y');
                    $today = date('j'); // Day of the month without leading zeros

                    // Check if a month/year is selected via URL parameters
                    if (isset($_GET['month']) && isset($_GET['year'])) {
                        $month = (int)$_GET['month'];
                        $year = (int)$_GET['year'];
                    } else {
                        $month = $currentMonth;
                        $year = $currentYear;
                    }

                    // Validate month and year
                    if ($month < 1 || $month > 12) $month = $currentMonth;
                    if ($year < 1900 || $year > 9999) $year = $currentYear;

                    // Get the first day of the month and number of days
                    $firstDay = new DateTime("$year-$month-01");
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $firstDayOfWeek = $firstDay->format('N') - 1; // 0 (Monday) to 6 (Sunday)

                    // Get month name
                    $monthName = $firstDay->format('F');
                    ?>

                    <div class="flex justify-between items-center mb-4">
                        <a href="?month=<?php echo ($month == 1 ? 12 : $month - 1); ?>&year=<?php echo ($month == 1 ? $year - 1 : $year); ?>"
                            class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-300">Previous</a>
                        <h2 class="text-lg font-semibold">This month: <?php echo $monthName . ' ' . $year; ?></h2>
                        <a href="?month=<?php echo ($month == 12 ? 1 : $month + 1); ?>&year=<?php echo ($month == 12 ? $year + 1 : $year); ?>"
                            class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-300">Next</a>
                    </div>

                    <!-- Calendar -->
                    <div class="space-y-1">
                        <!-- Days of the Week -->
                        <div class="grid grid-cols-7 gap-1 text-center">
                            <div class="font-semibold text-gray-600">MON</div>
                            <div class="font-semibold text-gray-600">TUES</div>
                            <div class="font-semibold text-gray-600">WED</div>
                            <div class="font-semibold text-gray-600">THUR</div>
                            <div class="font-semibold text-gray-600">FRI</div>
                            <div class="font-semibold text-gray-600">SAT</div>
                            <div class="font-semibold text-gray-600">SUN</div>
                        </div>

                        <?php
                        // Sample appointment data (day => [type, details])
                        $appointments = [];
                        if ($month == $currentMonth && $year == $currentYear) {
                            $appointments = [
                                7 => [
                                    'type' => 'EMERGENCY',
                                    'details' => [
                                        ['time' => '09:00', 'doctor' => 'Dr. Mohammed Ismail', 'specialty' => 'Cardiologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                8 => [
                                    'type' => 'EXAMINATION',
                                    'details' => [
                                        ['time' => '10:00', 'doctor' => 'Dr. Nadia Fallah', 'specialty' => 'Cardiologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                9 => [
                                    'type' => 'CONSULTATION',
                                    'details' => [
                                        ['time' => '11:00', 'doctor' => 'Dr. Salih Ahmet', 'specialty' => 'Dermatologist', 'location' => 'Binever Mahallesi'],
                                        ['time' => '14:00', 'doctor' => 'Dr. Mohammed Ismail', 'specialty' => 'Cardiologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                10 => [
                                    'type' => 'ROUTINE CHECKUP',
                                    'details' => [
                                        ['time' => '12:00', 'doctor' => 'Dr. Nadia Fallah', 'specialty' => 'Cardiologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                11 => [
                                    'type' => 'SICK VISIT',
                                    'details' => [
                                        ['time' => '13:00', 'doctor' => 'Dr. Mohammed Ismail', 'specialty' => 'Cardiologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                14 => [
                                    'type' => 'MALARIA FEVER',
                                    'details' => [
                                        ['time' => '15:00', 'doctor' => 'Dr. Salih Ahmet', 'specialty' => 'Dermatologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                18 => [
                                    'type' => 'HAND INFECTION',
                                    'details' => [
                                        ['time' => '16:00', 'doctor' => 'Dr. Nadia Fallah', 'specialty' => 'Cardiologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                25 => [
                                    'type' => 'SICK VISIT',
                                    'details' => [
                                        ['time' => '17:00', 'doctor' => 'Dr. Mohammed Ismail', 'specialty' => 'Cardiologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                                28 => [
                                    'type' => 'CONSULTATION',
                                    'details' => [
                                        ['time' => '18:00', 'doctor' => 'Dr. Salih Ahmet', 'specialty' => 'Dermatologist', 'location' => 'Binever Mahallesi'],
                                    ]
                                ],
                            ];
                        }

                        // Calculate the total number of cells needed (including empty days)
                        $firstDayOfWeek = $firstDay->format('N') - 1; // 0 (Monday) to 6 (Sunday)
                        $totalCells = $firstDayOfWeek + $daysInMonth;
                        $totalWeeks = ceil($totalCells / 7); // Number of weeks needed

                        // Generate weeks
                        $day = 1;
                        for ($week = 0; $week < $totalWeeks; $week++) {
                            echo '<div class="grid grid-cols-7 gap-1">';

                            // Generate 7 days for each week
                            for ($weekday = 0; $weekday < 7; $weekday++) {
                                $cellIndex = $week * 7 + $weekday;

                                // If the cell is before the first day or after the last day, render an empty cell
                                if ($cellIndex < $firstDayOfWeek || $day > $daysInMonth) {
                                    echo '<div class="calendar-day"></div>';
                                    continue;
                                }

                                $isToday = ($day == $today && $month == $currentMonth && $year == $currentYear);
                                $hasAppointment = isset($appointments[$day]);
                                $appointmentType = $hasAppointment ? $appointments[$day]['type'] : '';
                                $appointmentCount = $hasAppointment ? count($appointments[$day]['details']) : 0;

                                // Determine dot color based on appointment type
                                $dotColor = '';
                                if ($appointmentType === 'EMERGENCY') $dotColor = 'bg-blue-500';
                                elseif ($appointmentType === 'EXAMINATION') $dotColor = 'bg-yellow-500';
                                elseif ($appointmentType === 'CONSULTATION') $dotColor = 'bg-purple-500';
                                elseif ($appointmentType === 'ROUTINE CHECKUP') $dotColor = 'bg-red-500';
                                elseif ($appointmentType === 'SICK VISIT') $dotColor = 'bg-blue-300';
                                elseif ($appointmentType === 'MALARIA FEVER') $dotColor = 'bg-blue-300';
                                elseif ($appointmentType === 'HAND INFECTION') $dotColor = 'bg-blue-300';

                                echo '<div class="calendar-day ' . ($isToday ? 'today' : '') . '">';
                                echo '<button type="button" data-day="' . $day . '" data-month="' . $month . '" data-year="' . $year . '" data-events=\'' . ($hasAppointment ? json_encode($appointments[$day]['details']) : '[]') . '\'>';
                                echo $day;
                                echo '</button>';

                                // Show appointment dot
                                if ($hasAppointment) {
                                    echo '<div class="appointment-dot ' . $dotColor . '"></div>';
                                }

                                // Show appointment count if greater than 0
                                if ($appointmentCount > 0) {
                                    echo '<div class="appointment-count">' . $appointmentCount . '</div>';
                                }

                                echo '</div>';
                                $day++;
                            }

                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- Legend -->
                    <div class="flex gap-4 mt-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm">EMERGENCY</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-sm">EXAMINATION</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-purple-500 rounded-full mr-2"></div>
                            <span class="text-sm">CONSULTATION</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm">ROUTINE CHECKUP</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-300 rounded-full mr-2"></div>
                            <span class="text-sm">SICK VISIT</span>
                        </div>
                    </div>
                </div>

                <!-- Upcoming and Previous Appointments -->
                <div class="w-full lg:w-1/3 flex flex-col gap-6">
                    <!-- Upcoming Appointments -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h2 class="text-lg font-semibold mb-4">Upcoming Appointments</h2>
                        <div class="appointment-card">
                            <h3 class="text-red-600 font-semibold"><?php echo htmlspecialchars($most_upcoming_appointment['name'] . ' - ' . $most_upcoming_appointment['specialization']); ?></h3>
                            <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($most_upcoming_appointment['appointment_date'] . ' - ' . substr($most_upcoming_appointment['appointment_time'], 0, 5)); ?></p>
                            <p class="text-gray-600 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 12.414a1 1 0 010-1.414l4.243-4.243M4 12h8M12 4v8">
                                    </path>
                                </svg>
                                Binever Mahallesi
                            </p>
                            <div class="flex gap-2 mt-2">
                                <button
                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">View</button>
                                <button
                                    class="bg-gray-300 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-400">Cancel</button>
                            </div>
                        </div>
                        <a href="#" class="text-blue-500 text-sm hover:underline">More</a>
                    </div>

                    <!-- Previous Appointments -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h2 class="text-lg font-semibold mb-4">Previous Appointments</h2>
                        <div class="appointment-card">
                            <h3 class="text-red-600 font-semibold"><?php echo htmlspecialchars($most_recent_appointment['name'] . ' - ' . $most_recent_appointment['specialization']); ?></h3>
                            <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($most_recent_appointment['appointment_date'] . ' - ' . substr($most_recent_appointment['appointment_time'], 0, 5)); ?></p>
                            <p class="text-gray-600 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 12.414a1 1 0 010-1.414l4.243-4.243M4 12h8M12 4v8">
                                    </path>
                                </svg>
                                Binever Mahallesi
                            </p>
                            <div class="mt-2">
                                <button
                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">View</button>
                            </div>
                        </div>
                        <a href="#" class="text-blue-500 text-sm hover:underline">More</a>
                    </div>
                </div>
            </div>

            <!-- Event Details Modal -->
            <div id="eventModal" class="modal">
                <div class="modal-content">
                    <button class="close-btn">×</button>
                    <h2 id="modalDate" class="text-lg font-semibold mb-4"></h2>
                    <div id="modalEvents" class="space-y-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const eventModal = document.getElementById('eventModal');
        const modalDate = document.getElementById('modalDate');
        const modalEvents = document.getElementById('modalEvents');
        const closeBtn = document.querySelector('.close-btn');

        // Open modal when a day button is clicked
        document.querySelectorAll('.calendar-day button').forEach(button => {
            button.addEventListener('click', () => {
                const day = button.getAttribute('data-day');
                const month = button.getAttribute('data-month');
                const year = button.getAttribute('data-year');
                const events = JSON.parse(button.getAttribute('data-events'));

                // Set modal date
                const date = new Date(year, month - 1, day);
                modalDate.textContent = date.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Populate events
                if (events.length > 0) {
                    modalEvents.innerHTML = events.map(event => `
                        <div class="border-l-4 border-blue-500 pl-4 mb-2">
                            <p class="text-sm font-semibold">${event.time} - ${event.doctor}</p>
                            <p class="text-sm text-gray-600">${event.specialty}</p>
                            <p class="text-sm text-gray-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a1 1 0 010-1.414l4.243-4.243M4 12h8M12 4v8"></path>
                                </svg>
                                ${event.location}
                            </p>
                        </div>
                    `).join('');
                } else {
                    modalEvents.innerHTML = '<p class="text-sm text-gray-600">No events for this day.</p>';
                }

                eventModal.style.display = 'flex';
            });
        });

        // Close modal when close button is clicked
        closeBtn.addEventListener('click', () => {
            eventModal.style.display = 'none';
        });

        // Close modal when clicking outside of it
        eventModal.addEventListener('click', (e) => {
            if (e.target === eventModal) {
                eventModal.style.display = 'none';
            }
        });
    </script>
</body>

</html>