<?php
$conn = new mysqli("localhost", "root", "", "league2");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
