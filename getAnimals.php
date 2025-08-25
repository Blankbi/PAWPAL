<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pawpal";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM animals";
$result = $conn->query($sql);

$animals = [];
while ($row = $result->fetch_assoc()) {
  $animals[] = $row;
}

echo json_encode($animals);
$conn->close();
?>
