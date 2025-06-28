<?php

session_start();
$doctor_id = $_SESSION['user_id'] ?? '11';

include "../Includes/Database_connection.php";


// Set the time zone to Bangladesh Standard Time (BST)
$bdTimeZone = new DateTimeZone('Asia/Dhaka');
$bdDateTime = new DateTime('now', $bdTimeZone);

$currentDateTime = $bdDateTime->getTimestamp(); // Current time as timestamp

$current_time = $bdDateTime->format('H:i:s'); // Output format 10:25:45
$date = $bdDateTime->format('j F'); // Output format 26 June


// ............... Taking Necessary Information Blue Part ..........................

$stmt = $conn->prepare("
    SELECT 
        CASE 
            WHEN HOUR(CURTIME()) < 12 THEN 'Good Morning'
            WHEN HOUR(CURTIME()) < 17 THEN 'Good Afternoon'
            ELSE 'Good Evening'
        END AS greeting,

        CONCAT(u.first_name, ' ', u.last_name) AS doctor_name,
        u.first_name,

        COUNT(DISTINCT a.patient_id) AS total_today_patients,

        COUNT(DISTINCT CASE 
            WHEN (
                SELECT COUNT(*) 
                FROM appointments a2 
                WHERE a2.doctor_id = a.doctor_id 
                AND a2.patient_id = a.patient_id 
                AND a2.appointment_date < CURDATE()
            ) > 0 THEN a.patient_id
            ELSE NULL
        END) AS old_patients,

        COUNT(DISTINCT CASE 
            WHEN (
                SELECT COUNT(*) 
                FROM appointments a2 
                WHERE a2.doctor_id = a.doctor_id 
                AND a2.patient_id = a.patient_id 
                AND a2.appointment_date < CURDATE()
            ) = 0 THEN a.patient_id
            ELSE NULL
        END) AS new_patients

    FROM appointments a
    JOIN users u ON u.user_id = a.doctor_id
    WHERE 
        a.doctor_id = ? 
        AND a.appointment_date = CURDATE();
");

$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$blues_info = $result->fetch_assoc();

// echo $blues_info['greeting'];
// echo $blues_info['doctor_name'];
// echo $blues_info['first_name'];
// echo $blues_info['total_today_patients'];
// echo $blues_info['old_patients'];
// echo $blues_info['new_patients'];



// ............... Taking Today's Patients Informations ..........................

$stmt = $conn->prepare("
    SELECT 
        a.patient_id,
        CONCAT(u.first_name, ' ', u.last_name) AS name,
        a.conditions,
        a.appointment_time
    FROM appointments a
    JOIN users u ON u.user_id = a.patient_id
    WHERE a.appointment_date = CURDATE()
      AND a.doctor_id = ?
    ORDER BY a.appointment_time ASC
");

$stmt->bind_param('i', $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$today_patients = $result->fetch_all(MYSQLI_ASSOC);


// Example usage:
// [
//     [patient_id] => 1001
//     [name] => John Doe
//     [conditions] => Fever, Cough
//     [appointment_time] => 09:30:00
// ]
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UIU Health Care</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        .content {
            margin-left: 64px;
            /* Match collapsed sidebar width */
            padding: 1.5rem 2rem;
            /* Add right padding for gap */
            width: calc(100% - 64px);
            /* Full width minus sidebar */
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55), width 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Match expanded sidebar width */
            width: calc(100% - 256px);
            /* Adjust width on sidebar hover */
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            text-align: center;
        }

        .calendar-grid .day {
            padding: 6px;
            font-size: 0.875rem;
        }

        .calendar-grid .day.header {
            font-weight: 600;
            color: #6b7280;
        }

        .calendar-grid .day.active {
            background: #3b82f6;
            color: white;
            border-radius: 50%;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
        }
    </style>

</head>

<body>
    <div class="flex min-h-screen">
        <!-- Include Sidebar -->
        <?php include '../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content">
            <?php
                    // Simulated database data
                    $colors = ['bg-blue-500', 'bg-red-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500', 'bg-pink-500'];
                    $patients = [];

                    foreach ($today_patients as $index => $row) {
                        $patients[] = [
                            'id' => $row['patient_id'],
                            'name' => $row['name'],
                            'visit' => $row['conditions'],
                            'avatar_color' => $colors[$index % count($colors)]  // Rotate through available colors
                        ];
                    }


                    $consultations = [
                [
                    'name' => 'Aranya Das',
                    'gender' => 'Male',
                    'age' => 34,
                    'last_checked' => 'Dr. Eva on 21 April 2024',
                    'observation' => 'High fever and cough, normal hemoglobin',
                    'prescription' => 'Paracetamol - 2 times a day, light meals, rest',
                    'avatar_color' => 'bg-yellow-500',
                ],
            ];

            $upcoming_events = [
                ['title' => 'Monthly doctor\'s meet', 'date' => '8 March 2025', 'time' => '04:00 PM'],
            ];

            // Consultation filter
            $filter = isset($_GET['filter']) ? htmlspecialchars($_GET['filter']) : 'Today';
            $filter_options = ['Today', 'Yesterday', 'This Week'];
            ?>

            <!-- Header and Calendar Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Header Section -->
                <div
                    class="md:col-span-2 bg-gradient-to-r from-blue-500 to-indigo-300 text-white rounded-xl p-6 flex items-center">
                    <div>
                        <h1 class="text-lg font-semibold"><?php echo htmlspecialchars($blues_info['greeting'] . ', ' . $blues_info['first_name'] . '!'); ?></h1>
                        <p class="text-sm">Visits for Today</p>
                        <h2 class="text-2xl font-bold mt-2"><?php echo htmlspecialchars($blues_info['total_today_patients']); ?></h2>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                                <h2 class="text-xl font-bold"><?php echo htmlspecialchars($blues_info['new_patients']); ?></h2>
                                <p class="text-sm">New Patients <span class="text-green-300"><?php echo htmlspecialchars($blues_info['total_today_patients']); ?></span></p>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                                <h2 class="text-xl font-bold"><?php echo htmlspecialchars($blues_info['old_patients']); ?></h2>
                                <p class="text-sm">Old Patients <span class="text-green-300">+20%</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Calendar Section -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Calendar</h2>
                    <div class="flex justify-between items-center mb-4">
                        <span id="calendarMonthYear"></span>
                        <div>
                            <i class="bi bi-chevron-left mr-2 cursor-pointer" onclick="prevMonth()"></i>
                            <i class="bi bi-chevron-right cursor-pointer" onclick="nextMonth()"></i>
                        </div>
                    </div>
                    <div class="calendar-grid" id="calendarGrid">
                        <div class="day header">SUN</div>
                        <div class="day header">MON</div>
                        <div class="day header">TUE</div>
                        <div class="day header">WED</div>
                        <div class="day header">THU</div>
                        <div class="day header">FRI</div>
                        <div class="day header">SAT</div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Sections -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Patient List -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Patient List</h2>
                    <?php foreach ($patients as $patient): ?>
                        <div class="flex items-center py-3 border-b last:border-b-0">
                            <div class="avatar <?php echo $patient['avatar_color']; ?>">
                                <?php echo strtoupper(substr($patient['name'], 0, 2)); ?>
                            </div>
                            <div class="flex-1 ml-3">
                                <p class="font-semibold mb-0"><?php echo htmlspecialchars($patient['name']); ?></p>
                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($patient['visit']); ?></p>
                            </div>
                            <a href="all-appointments?patient_id=<?php echo $patient['id']; ?>"
                                class="text-blue-500 text-sm hover:underline">View Details</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Consultation -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Consultation</h2>
                    <form method="GET" class="mb-4">
                        <select name="filter"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            onchange="this.form.submit()">
                            <?php foreach ($filter_options as $option): ?>
                                <option value="<?php echo $option; ?>" <?php echo $filter === $option ? 'selected' : ''; ?>>
                                    <?php echo $option; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <?php foreach ($consultations as $consultation): ?>
                        <div class="flex items-center mb-4">
                            <div class="avatar <?php echo $consultation['avatar_color']; ?>">
                                <?php echo strtoupper(substr($consultation['name'], 0, 2)); ?>
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold mb-0"><?php echo htmlspecialchars($consultation['name']); ?></p>
                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($consultation['gender']); ?> -
                                    <?php echo $consultation['age']; ?> years old</p>
                            </div>
                        </div>
                        <div class="flex gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="bi bi-thermometer"></i>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="bi bi-lungs"></i>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500"><strong>Last Checked:</strong>
                                <?php echo htmlspecialchars($consultation['last_checked']); ?></p>
                            <p class="text-sm text-gray-500"><strong>Observation:</strong>
                                <?php echo htmlspecialchars($consultation['observation']); ?></p>
                            <p class="text-sm text-gray-500"><strong>Prescription:</strong>
                                <?php echo htmlspecialchars($consultation['prescription']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Upcoming -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Upcoming</h2>
                    <?php foreach ($upcoming_events as $event): ?>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold mb-0"><?php echo htmlspecialchars($event['title']); ?></p>
                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($event['date']); ?> |
                                    <?php echo htmlspecialchars($event['time']); ?></p>
                            </div>
                            <a href="#" class="text-blue-500 text-sm hover:underline">View All</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Script -->
    <script>
        let currentDate = new Date('2025-04-27');
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        function renderCalendar() {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const calendarGrid = document.getElementById('calendarGrid');
            const calendarMonthYear = document.getElementById('calendarMonthYear');

            calendarMonthYear.textContent = `${monthNames[currentMonth]} ${currentYear}`;
            while (calendarGrid.children.length > 7) {
                calendarGrid.removeChild(calendarGrid.lastChild);
            }

            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'day';
                calendarGrid.appendChild(emptyDay);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'day';
                dayElement.textContent = day;

                if (currentYear === currentDate.getFullYear() &&
                    currentMonth === currentDate.getMonth() &&
                    day === currentDate.getDate()) {
                    dayElement.classList.add('active');
                }

                calendarGrid.appendChild(dayElement);
            }
        }

        function prevMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }

        renderCalendar();
    </script>
</body>

</html>