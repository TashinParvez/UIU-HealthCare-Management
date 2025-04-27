<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UIU Health Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .content {
            margin-left: 64px;
            /* Match the collapsed sidebar width */
            padding: 0;
            /* Remove padding to maximize content width */
            transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            width: calc(100% - 64px);
            /* Full width minus collapsed sidebar */
        }

        .sidebar:hover+.content {
            margin-left: 256px;
            /* Match the expanded sidebar width */
            width: calc(100% - 256px);
            /* Full width minus expanded sidebar */
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

        .dashboard-header {
            background: linear-gradient(90deg, #4a90e2 0%, #a3bffa 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            min-height: 260px;
            /* Match calendar height */
            display: flex;
            align-items: center;
        }

        .dashboard-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .dashboard-header h2 {
            font-size: 1.5rem;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }

        .stats-card h2 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .stats-card p {
            font-size: 0.8rem;
            margin-bottom: 0;
        }

        .patient-list-card,
        .consultation-card,
        .calendar-card,
        .upcoming-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            /* Reduced padding to match design */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .patient-list-card h2,
        .consultation-card h2,
        .calendar-card h2,
        .upcoming-card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 10px;
            /* Reduced margin */
        }

        .patient-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            /* Reduced padding */
            border-bottom: 1px solid #e9ecef;
        }

        .patient-item:last-child {
            border-bottom: none;
        }

        .patient-item .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .patient-item .details {
            flex-grow: 1;
        }

        .patient-item .details p {
            margin: 0;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .patient-item .view-details {
            color: #007bff;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .patient-item .view-details:hover {
            text-decoration: underline;
        }

        .consultation-card .patient-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            /* Reduced margin */
        }

        .consultation-card .patient-info .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e0e0e0;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .consultation-card .symptoms {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            /* Reduced margin */
        }

        .consultation-card .symptom-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .consultation-card .details p {
            margin: 3px 0;
            /* Reduced margin */
            font-size: 0.9rem;
            color: #6c757d;
        }

        .calendar-card .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            /* Reduced margin */
        }

        .calendar-card .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            /* Reduced gap */
            text-align: center;
        }

        .calendar-card .calendar-grid .day {
            padding: 3px;
            /* Reduced padding */
            font-size: 0.8rem;
            /* Reduced font size */
        }

        .calendar-card .calendar-grid .day.header {
            font-weight: bold;
            color: #6c757d;
        }

        .calendar-card .calendar-grid .day.active {
            background: #007bff;
            color: white;
            border-radius: 50%;
        }

        .upcoming-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .upcoming-card .time {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .upcoming-card .view-all {
            color: #007bff;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .upcoming-card .view-all:hover {
            text-decoration: underline;
        }

        .row.stretched {
            margin-left: 0;
            margin-right: 0;
        }

        .row.stretched>div {
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!-- Include Sidebar -->
        <?php include '../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content">
            <!-- Header and Calendar Section -->
            <div class="row stretched mb-4">
                <!-- Header Section -->
                <div class="col-md-8">
                    <div class="dashboard-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1>Good Morning Shafayet!</h1>
                                <p class="mb-0">Visits for Today</p>
                                <h2 class="mt-2">104</h2>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="stats-card">
                                            <h2>40</h2>
                                            <p>New Patients <span class="text-success">+5%</span></p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stats-card">
                                            <h2>64</h2>
                                            <p>Old Patients <span class="text-success">+20%</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <img src="/Images/doctor.png" alt="Doctor Illustration" class="img-fluid" style="max-height: 200px;"> <!-- Increased image height -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Calendar Section -->
                <div class="col-md-4">
                    <div class="calendar-card mb-4">
                        <h2>Calendar</h2>
                        <div class="calendar-header">
                            <span id="calendarMonthYear"></span>
                            <div>
                                <i class="bi bi-chevron-left me-2" onclick="prevMonth()"></i>
                                <i class="bi bi-chevron-right" onclick="nextMonth()"></i>
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
            </div>

            <!-- Main Dashboard Sections -->
            <div class="row stretched">
                <!-- Patient List -->
                <div class="col-md-4 mb-4">
                    <div class="patient-list-card">
                        <h2>Patient List</h2>
                        <div class="patient-item">
                            <div class="avatar bg-primary">SH</div>
                            <div class="details">
                                <p class="fw-bold">Shafayet Hossain</p>
                                <p>Weekly Visit</p>
                            </div>
                            <a href="#" class="view-details">View Details</a>
                        </div>
                        <div class="patient-item">
                            <div class="avatar bg-danger">TP</div>
                            <div class="details">
                                <p class="fw-bold">Tashin Parvez</p>
                                <p>Check-up</p>
                            </div>
                            <a href="#" class="view-details">View Details</a>
                        </div>
                        <div class="patient-item">
                            <div class="avatar bg-success">AH</div>
                            <div class="details">
                                <p class="fw-bold">AH Noman</p>
                                <p>Report</p>
                            </div>
                            <a href="#" class="view-details">View Details</a>
                        </div>
                        <div class="patient-item">
                            <div class="avatar bg-warning">AD</div>
                            <div class="details">
                                <p class="fw-bold">Aranya Das</p>
                                <p>Weekly Visit</p>
                            </div>
                            <a href="#" class="view-details">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Consultation -->
                <div class="col-md-4 mb-4">
                    <div class="consultation-card">
                        <h2>Consultation</h2>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <select class="form-select w-auto">
                                <option>Today</option>
                                <option>Yesterday</option>
                                <option>This Week</option>
                            </select>
                        </div>
                        <div class="patient-info">
                            <div class="avatar bg-warning">AD</div>
                            <div>
                                <p class="fw-bold mb-0">Aranya Das</p>
                                <p class="text-muted">Male - 34 years old</p>
                            </div>
                        </div>
                        <div class="symptoms">
                            <div class="symptom-icon">
                                <i class="bi bi-thermometer"></i>
                            </div>
                            <div class="symptom-icon">
                                <i class="bi bi-lungs"></i>
                            </div>
                            <div class="symptom-icon">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                        </div>
                        <div class="details">
                            <p><strong>Last Checked:</strong> Dr. Eva on 21 April 2024</p>
                            <p><strong>Observation:</strong> High fever and cough normal hemoglobin</p>
                            <p><strong>Prescription:</strong> Paracetamol - 2 times a day, light meals, rest</p>
                        </div>
                    </div>
                </div>

                <!-- Upcoming -->
                <div class="col-md-4 mb-4">
                    <div class="upcoming-card">
                        <div>
                            <h2>Upcoming</h2>
                            <p class="mb-0">Monthly doctor's meet</p>
                            <p class="time">8 March 2025 | 04:00 PM</p>
                        </div>
                        <a href="#" class="view-all">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Dynamic Calendar Script -->
    <script>
        let currentDate = new Date('2025-04-27'); // Set to current date as per system
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        function renderCalendar() {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const calendarGrid = document.getElementById('calendarGrid');
            const calendarMonthYear = document.getElementById('calendarMonthYear');

            // Update month and year display
            calendarMonthYear.textContent = `${monthNames[currentMonth]} ${currentYear}`;

            // Get the first day of the month and number of days
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            // Clear existing days (keep headers)
            while (calendarGrid.children.length > 7) {
                calendarGrid.removeChild(calendarGrid.lastChild);
            }

            // Add empty slots for days before the 1st
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'day';
                calendarGrid.appendChild(emptyDay);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'day';
                dayElement.textContent = day;

                // Highlight current date
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

        // Initial render
        renderCalendar();
    </script>
</body>

</html>