<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
  header("Location: signin.php");
  exit;
}

$error = "";
$success = "";

// Fetch scheduled matches
$matches = $conn->query("SELECT m.match_id, t1.team_name AS home, t2.team_name AS away, m.match_date
                         FROM matches m
                         JOIN teams t1 ON m.home_team_id = t1.team_id
                         JOIN teams t2 ON m.away_team_id = t2.team_id
                         WHERE m.status = 'Scheduled'");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $match_id = $_POST['match_id'];
  $home_score = (int)$_POST['home_score'];
  $away_score = (int)$_POST['away_score'];

  // Update match result
  $stmt = $conn->prepare("UPDATE matches SET home_score = ?, away_score = ?, status = 'Played' WHERE match_id = ?");
  $stmt->bind_param("iii", $home_score, $away_score, $match_id);

  if ($stmt->execute()) {
    // Get team IDs
    $match = $conn->query("SELECT home_team_id, away_team_id FROM matches WHERE match_id = $match_id")->fetch_assoc();

    if ($match) {
      $home_id = $match['home_team_id'];
      $away_id = $match['away_team_id'];

      // Ensure standings rows exist
      $conn->query("INSERT INTO standings (team_id)
                    SELECT team_id FROM teams
                    WHERE team_id IN ($home_id, $away_id)
                    AND team_id NOT IN (SELECT team_id FROM standings)");

      // Update goals and played
      $conn->query("UPDATE standings SET played = played + 1, goals_for = goals_for + $home_score, goals_against = goals_against + $away_score WHERE team_id = $home_id");
      $conn->query("UPDATE standings SET played = played + 1, goals_for = goals_for + $away_score, goals_against = goals_against + $home_score WHERE team_id = $away_id");

      // Update result
      if ($home_score > $away_score) {
        $conn->query("UPDATE standings SET wins = wins + 1, points = points + 3 WHERE team_id = $home_id");
        $conn->query("UPDATE standings SET losses = losses + 1 WHERE team_id = $away_id");
      } elseif ($home_score < $away_score) {
        $conn->query("UPDATE standings SET wins = wins + 1, points = points + 3 WHERE team_id = $away_id");
        $conn->query("UPDATE standings SET losses = losses + 1 WHERE team_id = $home_id");
      } else {
        $conn->query("UPDATE standings SET draws = draws + 1, points = points + 1 WHERE team_id IN ($home_id, $away_id)");
      }

      $success = "Result updated and standings adjusted.";
    } else {
      $error = "Match not found. Standings not updated.";
    }
  } else {
    $error = "Error updating match result.";
  }
}
?>

<!DOCTYPE html>
<html>
<head><title>Update Match Result</title></head>
<body>
  <h2>Update Match Result</h2>
  <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
  <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
  <form method="post">
    Match:
    <select name="match_id" required>
      <?php while ($row = $matches->fetch_assoc()) {
        echo "<option value='{$row['match_id']}'>{$row['home']} vs {$row['away']} ({$row['match_date']})</option>";
      } ?>
    </select><br>

    Home Score: <input type="number" name="home_score" required><br>
    Away Score: <input type="number" name="away_score" required><br>
    <button type="submit">Update Result</button>
  </form>
</body>
</html>
