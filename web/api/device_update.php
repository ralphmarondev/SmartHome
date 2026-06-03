<?php

require_once "connection.php";

$device_id = $_POST["device_id"];
$status = $_POST["status"];

$sql = "
UPDATE devices
SET status = ?
WHERE id = ?
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param(
	"ii",
	$status,
	$device_id
);

if ($stmt->execute()) {

	$deviceQuery = "
    SELECT name, type
    FROM devices
    WHERE id = ?
    ";

	$deviceStmt = $mysqli->prepare($deviceQuery);
	$deviceStmt->bind_param("i", $device_id);
	$deviceStmt->execute();

	$device = $deviceStmt
		->get_result()
		->fetch_assoc();

	$message =
		$device["name"] .
		($status ? " turned ON" : " turned OFF");

	$logSql = "
    INSERT INTO logs (
        device_id,
        message
    )
    VALUES (?, ?)
    ";

	$logStmt = $mysqli->prepare($logSql);
	$logStmt->bind_param(
		"is",
		$device_id,
		$message
	);
	$logStmt->execute();

	echo json_encode([
		"success" => true
	]);
} else {

	echo json_encode([
		"success" => false
	]);
}

$mysqli->close();
