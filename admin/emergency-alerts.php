<?php
session_start();
include '../Includes/Database_connection.php';

// Handle "mark as handled"
if (isset($_POST['handle_alert'])) {
    $alert_id = intval($_POST['alert_id']);
    $update_sql = "UPDATE emergency_alerts SET action = 1 WHERE id = $alert_id";
    mysqli_query($conn, $update_sql);
    header("Location: emergency-alerts.php");
    exit;
}

$sql = "SELECT * FROM emergency_alerts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Emergency Alerts - Admin Panel</title>
    <link href="/path-to-your-css/tailwind.css" rel="stylesheet" /> <!-- adjust CSS path -->
</head>

<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
        <?php include '../Includes/try-SidebarAdmin.php'; ?>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6 overflow-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Emergency Alerts</h1>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full border-collapse border border-gray-200">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="border border-gray-300 py-2 px-4 text-center">ID</th>
                        <th class="border border-gray-300 py-2 px-4">Situation</th>
                        <th class="border border-gray-300 py-2 px-4">Details</th>
                        <th class="border border-gray-300 py-2 px-4">Address</th>
                        <th class="border border-gray-300 py-2 px-4">Location Info</th>
                        <th class="border border-gray-300 py-2 px-4 text-center">Created At</th>
                        <th class="border border-gray-300 py-2 px-4 text-center">Status</th>
                        <th class="border border-gray-300 py-2 px-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr class="border border-gray-300 hover:bg-gray-50">
                            <td class="border border-gray-300 py-2 px-4 text-center"><?= htmlspecialchars($row['id']) ?></td>
                            <td class="border border-gray-300 py-2 px-4"><?= htmlspecialchars($row['patient_situation']) ?></td>
                            <td class="border border-gray-300 py-2 px-4"><?= htmlspecialchars($row['additional_details']) ?></td>
                            <td class="border border-gray-300 py-2 px-4"><?= htmlspecialchars($row['address']) ?></td>
                            <td class="border border-gray-300 py-2 px-4"><?= htmlspecialchars($row['additional_location_info']) ?></td>
                            <td class="border border-gray-300 py-2 px-4 text-center"><?= htmlspecialchars($row['created_at']) ?></td>
                            <td class="border border-gray-300 py-2 px-4 text-center">
                                <?php if ($row['action'] == 0) : ?>
                                    <span class="text-red-600 font-semibold">Pending</span>
                                <?php else : ?>
                                    <span class="text-green-600 font-semibold">Handled</span>
                                <?php endif; ?>
                            </td>
                            <td class="border border-gray-300 py-2 px-4 text-center">
                                <?php if ($row['action'] == 0) : ?>
                                    <form method="POST" onsubmit="return confirm('Mark this alert as handled?');">
                                        <input type="hidden" name="alert_id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="handle_alert"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                            Mark as Handled
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <span class="text-gray-500 italic">No action needed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </main>

</body>

</html>