<?php
require_once "connection.php";

$device_id = isset($_POST["device_id"])
	? (int)$_POST["device_id"]
	: 0;

$status = isset($_POST["status"])
	? (int)$_POST["status"]
	: 0;

if ($device_id <= 0) {
	echo json_encode([
		"success" => false,
		"message" => "Invalid device ID"
	]);
	exit;
}

// Update device status
$updateSql = "UPDATE devices SET status = ? WHERE id = ?";
$updateStmt = $mysqli->prepare($updateSql);
$updateStmt->bind_param("ii", $status, $device_id);

if (!$updateStmt->execute()) {
	echo json_encode([
		"success" => false,
		"message" => "Failed to update device"
	]);
	exit;
}

// Get device information
$deviceSql = "SELECT id, name, type FROM devices WHERE id = ?";
$deviceStmt = $mysqli->prepare($deviceSql);
$deviceStmt->bind_param("i", $device_id);
$deviceStmt->execute();
$result = $deviceStmt->get_result();
$device = $result->fetch_assoc();

if (!$device) {
	echo json_encode([
		"success" => false,
		"message" => "Device not found"
	]);
	exit;
}

// Create log message
if ($device["type"] == "DOOR") {
	$message = $device["name"] . ($status ? " opened via sensor" : " closed via sensor");
} else {
	$message = $device["name"] . ($status ? " turned ON via sensor" : " turned OFF via sensor");
}

// Insert log
$logSql = "INSERT INTO logs(device_id, message) VALUES (?, ?)";
$logStmt = $mysqli->prepare($logSql);
$logStmt->bind_param("is", $device_id, $message);
$logStmt->execute();

// response
echo json_encode([
	"success" => true,
	"device_id" => $device_id,
	"status" => $status,
	"message" => $message
]);

$logStmt->close();
$deviceStmt->close();
$updateStmt->close();
$mysqli->close();
