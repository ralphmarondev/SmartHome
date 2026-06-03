<?php
require_once "connection.php";

$sql = "
SELECT
    l.id,
    l.message,
    l.created_at,
    d.name AS device_name
FROM logs l
JOIN devices d
ON l.device_id = d.id
ORDER BY l.id DESC
";

$result = $mysqli->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
	$data[] = $row;
}

header("Content-Type: application/json");
echo json_encode($data);

$mysqli->close();
