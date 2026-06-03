<?php
require_once "connection.php";

$message = "I was clicked";
$sql = "INSERT INTO logs (message) VALUES (?)";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $message);

if ($stmt->execute()) {
	echo json_encode([
		"success" => true,
		"message" => "Saved successfully"
	]);
} else {
	echo json_encode([
		"success" => false
	]);
}

$stmt->close();
$mysqli->close();