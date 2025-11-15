<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Manager') {
  header("Location: signin.php");
  exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head><title>Manager Portal</title></head>
<body>
  <h2>Welcome, <?= htmlspecialchars($username) ?> (Manager)</h2>
  <ul>
    <li><a href="view_team.php">View My Team</a></li>
    <li><a href="matches.php">Match Schedule</a></li>
    <li><a href="standings.php">League Standings</a></li>
  </ul>
  <p><a href="logout.php">Logout</a></p>
</body>
</html>
