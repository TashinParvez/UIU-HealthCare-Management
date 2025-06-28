<?php
include "../Includes/Database_connection.php";

// Handle search and filter
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$date_filter = isset($_GET['date_filter']) ? mysqli_real_escape_string($conn, $_GET['date_filter']) : 'all';

// Base SQL query
$doctor_id = '1225';
$sql = "SELECT 
            u.user_id,
            u.first_name AS Name,
            u.email AS Email,
            a.appointment_id,
            a.appointment_date AS AppointmentDate,
            a.appointment_time AS VisitTime
        FROM 
            appointments a
        JOIN 
            users u ON a.patient_id = u.user_id
        WHERE 
            a.doctor_id = '$doctor_id'";

// Add search and filter conditions
$conditions = [];
if ($search_query) {
    $conditions[] = "u.first_name LIKE '%$search_query%' OR u.email LIKE '%$search_query%'";
}
if ($date_filter === 'today') {
    $today = date('Y-m-d');
    $conditions[] = "a.appointment_date = '$today'";
} elseif ($date_filter === 'week') {
    $week_start = date('Y-m-d', strtotime('monday this week'));
    $week_end = date('Y-m-d', strtotime('sunday this week'));
    $conditions[] = "a.appointment_date BETWEEN '$week_start' AND '$week_end'";
}

if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}
$sql .= ";";

$allAppointments = mysqli_query($conn, $sql);
if (!$allAppointments) {
    die("Query failed: " . mysqli_error($conn));
}
$allAppointments = mysqli_fetch_all($allAppointments, MYSQLI_ASSOC);

// Calculate summary data
$today = date('Y-m-d');
$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));
$today_count = 0;
$week_count = 0;
$new_patients = 0;

$new_patient_ids = [];
foreach ($allAppointments as $row) {
    if ($row['AppointmentDate'] == $today) {
        $today_count++;
    }
    if ($row['AppointmentDate'] >= $week_start && $row['AppointmentDate'] <= $week_end) {
        $week_count++;
    }
    // New patients logic requires additional data; keeping as placeholder
}

// Handle add appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_appointment'])) {
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    
    $insert_sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) 
                   VALUES ('$patient_id', '$doctor_id', '$appointment_date', '$appointment_time')";
    if (mysqli_query($conn, $insert_sql)) {
        header("Location: appointments.php");
        exit;
    } else {
        echo "Error adding appointment: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FullCalendar CDN -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.js"></script>
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .content {
            margin-left: 64px;
            padding: 2rem;
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            width: calc(100% - 64px);
        }

        .sidebar:hover + .content {
            margin-left: 256px;
            width: calc(100% - 256px);
        }

        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes scaleHover {
            to { transform: scale(1.02); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15); }
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .appointment-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .appointment-card:hover {
            animation: scaleHover 0.3s ease forwards;
        }

        .action-icon {
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .action-icon:hover {
            animation: iconPulse 0.4s ease;
        }

        .right-panel {
            animation: slideInRight 0.6s ease-out;
        }

        .pagination-btn {
            transition: all 0.3s ease;
        }

        .pagination-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .pagination-btn.active {
            background-color: #2563eb;
            color: white;
            transform: scale(1.1);
        }

        #calendar {
            max-height: 200px;
            font-size: 0.85rem;
        }

        .fc-daygrid-day-number {
            color: #1f2a44;
        }

        .fc-event {
            background-color: #2563eb;
            border: none;
            font-size: 0.75rem;
            padding: 2px 4px;
        }

        /* Sidebar styles (unchanged) */
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
<body>
    <div class="d-flex min-vh-100">
        <?php include '../Includes/Sidebar.php'; ?>
        <div class="content">
            <div class="max-w-7xl mx-auto py-8 flex gap-8">
                <!-- Main Content -->
                <div class="flex-1">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Appointments</h1>
                    <div class="space-y-4">
                        <?php foreach ($allAppointments as $index => $row) { ?>
                            <div class="appointment-card bg-white rounded-xl p-6 flex items-center justify-between gap-6 border border-gray-100 cursor-pointer" 
                                 data-id="<?php echo $row['appointment_id']; ?>" 
                                 data-name="<?php echo htmlspecialchars($row['Name']); ?>" 
                                 data-email="<?php echo htmlspecialchars($row['Email']); ?>" 
                                 data-date="<?php echo $row['AppointmentDate']; ?>"
                                 data-time="<?php echo $row['VisitTime']; ?>">
                                <div class="flex items-center gap-4">
                                    <img src="/Includes/Images/happy-patient.jpg" alt="<?php echo htmlspecialchars($row['Name']); ?>" class="w-12 h-12 rounded-full object-cover">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($row['Name']); ?></h3>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($row['Email']); ?></p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600"><?php echo $row['AppointmentDate']; ?></div>
                                <div class="text-sm text-gray-600"><?php echo $row['VisitTime']; ?></div>
                                <div class="text-sm text-gray-600">DOCTORNAME</div>
                                <div class="text-sm text-gray-600">CONDITION</div>
                                <div class="flex gap-4">
                                    <a href="#" class="action-icon text-gray-500 hover:text-blue-600"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="action-icon text-gray-500 hover:text-red-600"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <nav aria-label="Page navigation" class="mt-8 flex justify-center gap-2">
                        <a href="#" class="pagination-btn px-4 py-2 rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50">«</a>
                        <a href="#" class="pagination-btn px-4 py-2 rounded-lg bg-white border border-gray-200 text-blue-600 active">1</a>
                        <a href="#" class="pagination-btn px-4 py-2 rounded-lg bg-white border border-gray-200 text-blue-600">2</a>
                        <a href="#" class="pagination-btn px-4 py-2 rounded-lg bg-white border border-gray-200 text-blue-600">3</a>
                        <a href="#" class="pagination-btn px-4 py-2 rounded-lg bg-white border border-gray-200 text-blue-600">»</a>
                    </nav>
                </div>
                <!-- Right Panel -->
                <div class="w-80 space-y-6 right-panel">
                    <!-- Patient Summary Widget -->
                    <div class="bg-white rounded-xl p-4 shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Summary</h3>
                        <p class="text-sm text-gray-600">Today: <span class="font-medium"><?php echo $today_count; ?></span></p>
                        <p class="text-sm text-gray-600">This Week: <span class="font-medium"><?php echo $week_count; ?></span></p>
                        <p class="text-sm text-gray-600">New Patients: <span class="font-medium"><?php echo $new_patients; ?></span></p>
                    </div>
                    <!-- Quick Actions Panel -->
                    <div class="bg-white rounded-xl p-4 shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <button class="w-full py-2 mb-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 hover:scale-105 transition-all" 
                                onclick="document.getElementById('add-appointment-modal').classList.remove('hidden')">Add Appointment</button>
                        <form id="filter-form" method="GET" action="appointments.php">
                            <select name="date_filter" class="w-full p-2 mb-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" onchange="this.form.submit()">
                                <option value="all" <?php echo $date_filter === 'all' ? 'selected' : ''; ?>>All Dates</option>
                                <option value="today" <?php echo $date_filter === 'today' ? 'selected' : ''; ?>>Today</option>
                                <option value="week" <?php echo $date_filter === 'week' ? 'selected' : ''; ?>>This Week</option>
                            </select>
                            
                        </form>
                    </div>
                    <!-- Patient Details Preview -->
                    <div id="patient-preview" class="bg-white rounded-xl p-4 shadow-lg hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Details</h3>
                        <p class="text-sm text-gray-600">Name: <span id="preview-name"></span></p>
                        <p class="text-sm text-gray-600">Email: <span id="preview-email"></span></p>
                        <p class="text-sm text-gray-600">Last Visit: <span id="preview-last-visit">TBD</span></p>
                        <p class="text-sm text-gray-600">Notes: <span id="preview-notes">No notes available</span></p>
                    </div>
                </div>
            </div>
            <!-- Add Appointment Modal -->
            <div id="add-appointment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-xl p-6 w-96">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Appointment</h3>
                    <form method="POST" action="appointments.php">
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Patient ID</label>
                            <input type="text" name="patient_id" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Date</label>
                            <input type="date" name="appointment_date" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Time</label>
                            <input type="time" name="appointment_time" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" name="add_appointment" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
                            <button type="button" class="py-2 px-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300" 
                                    onclick="document.getElementById('add-appointment-modal').classList.add('hidden')">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Patient Preview
        document.querySelectorAll('.appointment-card').forEach(card => {
            card.addEventListener('click', (e) => {
                e.preventDefault();
                const id = card.dataset.id;
                const name = card.dataset.name;
                const email = card.dataset.email;
                const date = card.dataset.date;
                const preview = document.getElementById('patient-preview');
                document.getElementById('preview-name').textContent = name;
                document.getElementById('preview-email').textContent = email;
                document.getElementById('preview-last-visit').textContent = date;
                document.getElementById('preview-notes').textContent = 'No notes available';
                preview.classList.remove('hidden');
            });
        });

        // Search Form Submission
        document.getElementById('search-input').addEventListener('input', function() {
            setTimeout(() => this.form.submit(), 500); // Debounce and submit form
        });

        // Client-side search fallback (optional, since server-side is primary)
        document.getElementById('search-input').addEventListener('input', function() {
            setTimeout(() => this.form.submit(), 500); // Debounce and submit form
        });

    </script>
</body>
</html>