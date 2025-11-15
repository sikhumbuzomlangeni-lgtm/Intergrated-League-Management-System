<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
  header("Location: signin.php");
  exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
  <h2>Welcome, <?= htmlspecialchars($username) ?> (Admin)</h2>
  <ul>
    <li><a href="register_user.php">Register New User</a></li>
    <li><a href="add_team.php">Add Team</a></li>
    <li><a href="schedule_match.php">Schedule Match</a></li>
    <li><a href="update_result.php">Add Results</a></li>
    <li><a href="recalculate_standings.php"> Update Standings</a></li>
    <li><a href="standings.php">View Standings</a></li>
  </ul>
  <p><a href="logout.php">Logout</a></p>
</body>
</html>
