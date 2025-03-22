<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="\Images\logo\logo.png" type="image/x-icon">
    <title>Expandable Sidebar</title>
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
    </style>
</head>

<body class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="sidebar w-16 hover:w-64 h-screen bg-white text-gray-800 flex flex-col fixed shadow-lg group z-20">
        <!-- Logo -->
        <div class="p-4 flex items-center justify-center sidebar-item">
            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                <img src="Images\logo\logo.png" class="w-6 h-6" />
            </div>
            <span class="ml-4 sidebar-text font-bold">Logo</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1">
            <!-- Search -->
            <div class="p-4 flex items-center sidebar-item">
                <svg class="w-6 h-6 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search..."
                    class="search-input bg-gray-100 text-gray-800 border-none rounded px-2 py-1 w-full focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            <!-- Dashboard -->
            <div class="p-4 flex items-center sidebar-item">
                <svg class="w-6 h-6 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </div>

            <!-- Users -->
            <div class="p-4 flex items-center sidebar-item">
                <svg class="w-6 h-6 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="sidebar-text">Users</span>
            </div>

            <!-- Messages -->
            <div class="p-4 flex items-center sidebar-item">
                <svg class="w-6 h-6 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <span class="sidebar-text">Messages</span>
            </div>

            <!-- Appointments -->
            <div class="p-4 flex items-center sidebar-item">
                <svg class="w-6 h-6 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="sidebar-text">Appointments</span>
            </div>
        </nav>

        <!-- Profile -->
        <div class="p-4 flex items-center sidebar-item">
            <svg class="w-6 h-6 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="sidebar-text">Profile</span>
        </div>
    </div>


</body>

</html>