<?php
// DB connection
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
$amount = $_POST['amount'] ?? '';
$message = $_POST['message'] ?? '';

// Basic validation
if (!$name || !$email || !$amount || $amount <= 0) {
  echo json_encode(["status" => "error", "message" => "Missing or invalid fields"]);
  exit;
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO donations (donor_name, donor_email, amount, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $name, $email, $amount, $message);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Donation recorded"]);
} else {
  echo json_encode(["status" => "error", "message" => "Database error"]);
}

$stmt->close();
$conn->close();
?>
