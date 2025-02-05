<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include 'db.php';

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

$posts = [];
while ($row = $result->fetch_assoc()) {
    // Modify the image path to include the full URL
    $row['image'] = 'http://localhost:8000/uploads/' . $row['image'];  // Adjust the path based on your setup
    $posts[] = $row;
}

echo json_encode($posts);


?>
