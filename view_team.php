<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Manager') {
  header("Location: signin.php");
  exit;
}

$manager_id = $_SESSION['user_id'];

// Get team info
$team_sql = "SELECT team_id, team_name, logo FROM teams WHERE manager_id = ?";
$stmt = $conn->prepare($team_sql);
$stmt->bind_param("i", $manager_id);
$stmt->execute();
$team_result = $stmt->get_result();

if ($team_result->num_rows === 0) {
  echo "<h3>No team assigned to you yet.</h3>";
  exit;
}

$team = $team_result->fetch_assoc();
$team_id = $team['team_id'];

// Get standings
$stand_sql = "SELECT * FROM standings WHERE team_id = $team_id";
$stand_result = $conn->query($stand_sql);
$stand = $stand_result->fetch_assoc();

// Get match history
$match_sql = "SELECT m.match_date, t1.team_name AS home, t2.team_name AS away, m.home_score, m.away_score
              FROM matches m
              JOIN teams t1 ON m.home_team_id = t1.team_id
              JOIN teams t2 ON m.away_team_id = t2.team_id
              WHERE m.home_team_id = $team_id OR m.away_team_id = $team_id
              ORDER BY m.match_date DESC";
$matches = $conn->query($match_sql);
?>

<!DOCTYPE html>
<html>
<head><title>My Team</title></head>
<body>
  <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Manager)</h2>
  <h3>Team: <?= $team['team_name'] ?></h3>
  <?php if ($team['logo']) echo "<img src='{$team['logo']}' alt='Team Logo' width='100'><br>"; ?>

  <h4>Standings</h4>
  <table border="1">
    <tr><th>Played</th><th>W</th><th>D</th><th>L</th><th>GF</th><th>GA</th><th>Points</th></tr>
    <tr>
      <td><?= $stand['played'] ?></td>
      <td><?= $stand['wins'] ?></td>
      <td><?= $stand['draws'] ?></td>
      <td><?= $stand['losses'] ?></td>
      <td><?= $stand['goals_for'] ?></td>
      <td><?= $stand['goals_against'] ?></td>
      <td><?= $stand['points'] ?></td>
    </tr>
  </table>

  <h4>Match History</h4>
  <table border="1">
    <tr><th>Date</th><th>Fixture</th><th>Score</th></tr>
    <?php while ($row = $matches->fetch_assoc()) {
      $fixture = "{$row['home']} vs {$row['away']}";
      $score = is_null($row['home_score']) ? "TBD" : "{$row['home_score']} - {$row['away_score']}";
      echo "<tr><td>{$row['match_date']}</td><td>$fixture</td><td>$score</td></tr>";
    } ?>
  </table>

  <p><a href="logout.php">Logout</a></p>
</body>
</html>
