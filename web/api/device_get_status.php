<?php
require_once "connection.php";

$device_id = isset($_GET["device_id"])
	? (int)$_GET["device_id"]
	: 0;

if ($device_id <= 0) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Invalid device ID"
	]);

	exit;
}

$stmt = $mysqli->prepare("
    SELECT status
    FROM devices
    WHERE id = ?
");

$stmt->bind_param("i", $device_id);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
	echo json_encode([
		"success" => true,
		"status" => (int)$row["status"]
	]);
} else {
	echo json_encode([
		"success" => false,
		"message" => "Device not found"
	]);
}

$stmt->close();
$mysqli->close();
