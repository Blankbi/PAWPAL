<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pawpal";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_POST['user_id'] ?? '';
$animal_id = $_POST['animal_id'] ?? '';

if (!$user_id || !$animal_id) {
  echo json_encode(["status" => "error", "message" => "Missing user or animal ID"]);
  exit;
}

$stmt = $conn->prepare("INSERT INTO adoptions (user_id, animal_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $animal_id);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Adoption recorded"]);
} else {
  echo json_encode(["status" => "error", "message" => "Database error"]);
}

$stmt->close();
$conn->close();
?>
