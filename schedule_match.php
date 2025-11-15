<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
  header("Location: signin.php");
  exit;
}

$error = "";
$success = "";

// Fetch teams for dropdowns
$teams = $conn->query("SELECT team_id, team_name FROM teams");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $home = $_POST['home_team'];
  $away = $_POST['away_team'];
  $date = $_POST['match_date'];

  if ($home === $away) {
    $error = "Home and Away teams must be different.";
  } else {
    $stmt = $conn->prepare("INSERT INTO matches (home_team_id, away_team_id, match_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $home, $away, $date);
    if ($stmt->execute()) {
      $success = "Match scheduled successfully.";
    } else {
      $error = "Error scheduling match.";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head><title>Schedule Match</title></head>
<body>
  <h2>Schedule a Match</h2>
  <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
  <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
  <form method="post">
    Home Team:
    <select name="home_team" required>
      <?php while ($row = $teams->fetch_assoc()) { ?>
        <option value="<?= $row['team_id'] ?>"><?= $row['team_name'] ?></option>
      <?php } ?>
    </select><br>

    Away Team:
    <select name="away_team" required>
      <?php
      $teams->data_seek(0); // Reset pointer
      while ($row = $teams->fetch_assoc()) {
        echo "<option value='{$row['team_id']}'>{$row['team_name']}</option>";
      }
      ?>
    </select><br>

    Match Date: <input type="date" name="match_date" required><br>
    <button type="submit">Schedule Match</button>
  </form>
</body>
</html>
