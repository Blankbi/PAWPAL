<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "PetWebsiteDB";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (!$email || !$password || !$role) {
  echo json_encode(["status" => "error", "message" => "Missing fields"]);
  exit;
}

// Check user
$stmt = $conn->prepare("SELECT user_id, name, password_hash, role FROM User WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password_hash']) && $user['role'] === $role) {
    echo json_encode([
      "status" => "success",
      "user_id" => $user['user_id'],
      "name" => $user['name'],
      "role" => $user['role']
    ]);
  } else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials or role"]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
