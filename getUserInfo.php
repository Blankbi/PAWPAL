<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "PetWebsiteDB";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_POST['user_id'] ?? '';

if (!$user_id) {
  echo json_encode(["status" => "error", "message" => "Missing user ID"]);
  exit;
}

$stmt = $conn->prepare("SELECT name, email, role FROM User WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  echo json_encode(["status" => "success", "data" => $user]);
} else {
  echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
