<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .container {
            display: flex;
            flex: 1;
            margin-left: 250px;
            /* Adjust based on sidebar width */
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats {
            display: flex;
            gap: 20px;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-box h3 {
            margin: 0;
            font-size: 2em;
        }

        .stat-box p {
            margin: 0;
            font-size: 0.9em;
        }

        .calendar-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 300px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
        }

        .calendar-grid div {
            padding: 10px;
            border-radius: 5px;
        }

        .calendar-grid .day-name {
            font-weight: bold;
            color: #666;
        }

        .calendar-grid .day {
            background: #f0f0f0;
        }

        .calendar-grid .day.today {
            background: #2575fc;
            color: white;
        }

        .patient-list {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .patient-list h3 {
            margin: 0 0 10px 0;
        }

        .patient-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .patient-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .patient-item .details {
            flex: 1;
        }

        .patient-item .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8em;
        }

        .patient-item .status.fever {
            background: #ffe6e6;
            color: #ff4d4d;
        }

        .patient-item .status.cough {
            background: #e6f0ff;
            color: #4d79ff;
        }

        .right-panel {
            width: 350px;
            padding: 20px;
            background: #f5f5f5;
        }

        .profile-section {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto;
            display: block;
        }

        .upload-btn {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            color: #2575fc;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .notes-section {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Include Sidebar.php from the Includes folder
    $sidebarPath = '../Includes/Sidebar.php';
    if (file_exists($sidebarPath)) {
        include $sidebarPath;
    } else {
        // Fallback if Sidebar.php is not found
        echo "<div style='width: 250px; background: #333; color: white; height: 100vh; padding: 20px;'>";
        echo "<h2>Sidebar Placeholder</h2>";
        echo "<p>Sidebar.php not found in Includes folder. This is a placeholder.</p>";
        echo "</div>";
    }
    ?>

    <div class="container">
        <div class="main-content">
            <div class="header">
                <div>
                    <h2>Good Morning Shafayet!!</h2>
                    <p>Visits for Today</p>
                    <div class="stats">
                        <div class="stat-box">
                            <h3>104</h3>
                            <p>New Patients</p>
                        </div>
                        <div class="stat-box">
                            <h3>40</h3>
                            <p>Old Patients</p>
                        </div>
                        <div class="stat-box">
                            <h3>64%</h3>
                            <p>Consultation</p>
                        </div>
                    </div>
                </div>
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button onclick="prevMonth()">❮</button>
                        <span id="month-year"></span>
                        <button onclick="nextMonth()">❯</button>
                    </div>
                    <div class="calendar-grid" id="calendar">
                        <div class="day-name">Sun</div>
                        <div class="day-name">Mon</div>
                        <div class="day-name">Tue</div>
                        <div class="day-name">Wed</div>
                        <div class="day-name">Thu</div>
                        <div class="day-name">Fri</div>
                        <div class="day-name">Sat</div>
                    </div>
                </div>
            </div>

            <div class="patient-list">
                <h3>Patient List</h3>
                <p>Today</p>
                <div class="patient-item">
                    <img src="https://via.placeholder.com/40" alt="Patient">
                    <div class="details">
                        <p><strong>Shafayet Hossain</strong></p>
                        <p>Fever</p>
                    </div>
                    <span class="status fever">Fever</span>
                </div>
                <div class="patient-item">
                    <img src="https://via.placeholder.com/40" alt="Patient">
                    <div class="details">
                        <p><strong>Tasnim Farhan</strong></p>
                        <p>Cough</p>
                    </div>
                    <span class="status cough">Cough</span>
                </div>
                <div class="patient-item">
                    <img src="https://via.placeholder.com/40" alt="Patient">
                    <div class="details">
                        <p><strong>Anika Rahman</strong></p>
                        <p>Cough</p>
                    </div>
                    <span class="status cough">Cough</span>
                </div>
                <div class="patient-item">
                    <img src="https://via.placeholder.com/40" alt="Patient">
                    <div class="details">
                        <p><strong>Abrar Hossain</strong></p>
                        <p>Fever</p>
                    </div>
                    <span class="status fever">Fever</span>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="profile-section">
                <img src="https://via.placeholder.com/100" alt="Profile Picture" class="profile-picture" id="profile-picture">
                <label for="upload-picture" class="upload-btn">Upload Picture</label>
                <input type="file" id="upload-picture" accept="image/*" style="display: none;" onchange="previewPicture(event)">
            </div>
            <div class="notes-section">
                <h3>Upcoming Doctors Meet</h3>
                <p>10:30 AM - 11:00 AM</p>
            </div>
        </div>
    </div>

    <script>
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        function renderCalendar() {
            const calendar = document.getElementById('calendar');
            const monthYear = document.getElementById('month-year');
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const today = new Date();
            const isCurrentMonth = today.getMonth() === currentMonth && today.getFullYear() === currentYear;
            const todayDate = today.getDate();

            monthYear.textContent = $ {
                new Date(currentYear, currentMonth).toLocaleString('default', {
                    month: 'long'
                })
            }
            $ {
                currentYear
            };

            // Clear previous days, keep day names
            while (calendar.children.length > 7) {
                calendar.removeChild(calendar.lastChild);
            }

            // Add empty slots for days before the first day of the month
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                calendar.appendChild(emptyDay);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('day');
                dayElement.textContent = day;
                if (isCurrentMonth && day === todayDate) {
                    dayElement.classList.add('today');
                }
                calendar.appendChild(dayElement);
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

        function previewPicture(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById('profile-picture');
                img.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }

        renderCalendar();
    </script>
</body>

</html>