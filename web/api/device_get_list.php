<?php

require_once "connection.php";

$sql = "
SELECT
    id,
    name,
    type,
    status
FROM devices
ORDER BY id
";

$result = $mysqli->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
	$data[] = $row;
}

header("Content-Type: application/json");

echo json_encode($data);

$mysqli->close();
