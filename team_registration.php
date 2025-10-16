<?php
session_start();
include 'db.php'; // assumes $conn is your mysqli connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $coach = trim($_POST['coach']);

  if ($name && $coach) {
    $stmt = $conn->prepare("INSERT INTO teams (name, coach) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $coach);
    if ($stmt->execute()) {
      echo "<p style='color:green;'>Team registered successfully!</p>";
    } else {
      echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
  } else {
    echo "<p style='color:red;'>Please fill in all fields.</p>";
  }
}
?>

<h2>Register a New Team</h2>
<form method="post">
  <label>Team Name:</label><br>
  <input type="text" name="name" required><br><br>

  <label>Coach Name:</label><br>
  <input type="text" name="coach" required><br><br>

  <button type="submit">Register Team</button>
</form>
