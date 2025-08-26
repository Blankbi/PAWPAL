<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pawpal";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$user_id = $_POST['user_id'] ?? '';
$vet_id = $_POST['vet_id'] ?? '';
$animal_id = $_POST['animal_id'] ?? '';
$specialization = $_POST['specialization'] ?? '';
$name = $_POST['name'] ?? '';
$contact_info = $_POST['contact_info'] ?? '';

// Basic validation
if (!$user_id || !$vet_id || !$animal_id || !$specialization || !$name || !$contact_info) {
  echo json_encode(["status" => "error", "message" => "Missing required fields"]);
  exit;
}

// Prepare and insert
$stmt = $conn->prepare("INSERT INTO VetAppointment (user_id, vet_id, animal_id, specialization, name, contact_info) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiisss", $user_id, $vet_id, $animal_id, $specialization, $name, $contact_info);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Appointment booked successfully"]);
} else {
  echo json_encode(["status" => "error", "message" => "Database error"]);
}

$stmt->close();
$conn->close();
?>
