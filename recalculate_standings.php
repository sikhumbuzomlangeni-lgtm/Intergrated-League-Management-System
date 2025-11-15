<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
  echo "Access denied.";
  exit;
}

// Step 1: Reset all standings
$conn->query("UPDATE standings SET played = 0, wins = 0, draws = 0, losses = 0, goals_for = 0, goals_against = 0, points = 0");

// Step 2: Fetch all played matches
$matches = $conn->query("SELECT match_id, home_team_id, away_team_id, home_score, away_score FROM matches WHERE status = 'Played'");

while ($match = $matches->fetch_assoc()) {
  $home_id = $match['home_team_id'];
  $away_id = $match['away_team_id'];
  $home_score = (int)$match['home_score'];
  $away_score = (int)$match['away_score'];

  // Update played and goals
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
}

echo "<h3>Standings recalculated successfully.</h3>";
?>
