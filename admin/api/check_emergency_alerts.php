<?php
include '../../Includes/Database_connection.php'; // ✅ Update path if needed

$sql = "SELECT COUNT(*) AS cnt FROM emergency_alerts WHERE action = 0";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

header('Content-Type: application/json'); // ✅ Important for JS to read JSON properly
echo json_encode(['has_alerts' => $row['cnt'] > 0]);
