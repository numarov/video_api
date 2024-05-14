<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "video_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$videoId = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM videos WHERE id = $videoId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $prevId = $videoId - 1;
    $prevSql = "SELECT id FROM videos WHERE id = $prevId";
    $prevResult = $conn->query($prevSql);
    if ($prevResult->num_rows == 0) {
        $prevId = $videoId;
    }

    $nextId = $videoId + 1;
    $nextSql = "SELECT id FROM videos WHERE id = $nextId";
    $nextResult = $conn->query($nextSql);
    if ($nextResult->num_rows == 0) {
        $nextId = $videoId;
    }

    echo json_encode([
        'current_video' => $row,
        'prev_video_id' => "?id=$prevId",
        'next_video_id' => "?id=$nextId"
    ]);
} else {
    echo json_encode(['message' => 'Video not founded']);
}

$conn->close();
?>