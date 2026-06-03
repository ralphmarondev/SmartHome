<?php
require_once "connection.php";

$sql = "SELECT * FROM logs ORDER BY id DESC";
$result = $mysqli->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
	$data[] = $row;
}

echo json_encode($data);

$mysqli->close();