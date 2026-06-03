<?php

require_once "connection.php";

$device_id = $_POST["device_id"];
$message = $_POST["message"];

$sql = "
INSERT INTO logs (
    device_id,
    message
)
VALUES (?, ?)
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param(
	"is",
	$device_id,
	$message
);

if ($stmt->execute()) {

	echo json_encode([
		"success" => true
	]);
} else {

	echo json_encode([
		"success" => false
	]);
}

$stmt->close();
$mysqli->close();
