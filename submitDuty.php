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
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$task = $_POST['task'] ?? '';
$date = $_POST['date'] ?? '';

// Basic validation
if (!$name || !$email || !$task || !$date) {
  echo json_encode(["status" => "error", "message" => "Missing fields"]);
  exit;
}

// Prepare and insert
$stmt = $conn->prepare("INSERT INTO volunteer_duties (volunteer_name, volunteer_email, task, duty_date) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $task, $date);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Duty submitted"]);
} else {
  echo json_encode(["status" => "error", "message" => "Database error"]);
}

$stmt->close();
$conn->close();
?>
