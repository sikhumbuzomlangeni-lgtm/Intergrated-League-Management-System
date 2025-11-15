<?php
session_start();
include 'connection.php';

// Fetch standings
$stand_sql = "SELECT t.team_name, t.logo, s.played, s.wins, s.draws, s.losses, s.goals_for, s.goals_against, s.points
              FROM standings s
              JOIN teams t ON s.team_id = t.team_id
              ORDER BY s.points DESC, (s.goals_for - s.goals_against) DESC";
$standings = $conn->query($stand_sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Welcome to the League System</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; text-align: center; }
    .box { background: white; padding: 30px; border-radius: 10px; display: inline-block; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    a.button {
      display: inline-block; padding: 10px 20px; margin: 10px;
      background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;
    }
    a.button:hover { background-color: #0056b3; }
    table { margin-top: 30px; border-collapse: collapse; width: 100%; }
    th, td { padding: 8px 12px; border: 1px solid #ccc; }
    th { background-color: #007BFF; color: white; }
    img.logo { width: 30px; vertical-align: middle; margin-right: 8px; }
  </style>
</head>
<body>

<div class="box">
  <h1>⚽ Welcome to the League Management System</h1>

  <?php if (isset($_SESSION['user_id'])): ?>
    <p>Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
    <?php if ($_SESSION['role'] === 'Admin'): ?>
      <a class="button" href="admin_dashboard.php">Go to Admin Dashboard</a>
    <?php elseif ($_SESSION['role'] === 'Manager'): ?>
      <a class="button" href="view_team.php">View My Team</a>
    <?php endif; ?>
    <a class="button" href="logout.php">Logout</a>
  <?php else: ?>
    <p>Please log in or register to manage your team or league.</p>
    <a class="button" href="signin.php">Login</a>
    <a class="button" href="register.php">Register</a>
  <?php endif; ?>

  <h2>🏆 League Standings</h2>
  <table>
    <tr>
      <th>Team</th><th>Played</th><th>W</th><th>D</th><th>L</th><th>GF</th><th>GA</th><th>Points</th>
    </tr>
    <?php while ($row = $standings->fetch_assoc()): ?>
      <tr>
        <td>
          <?php if ($row['logo']) echo "<img src='{$row['logo']}' class='logo'>"; ?>
          <?= htmlspecialchars($row['team_name']) ?>
        </td>
        <td><?= $row['played'] ?></td>
        <td><?= $row['wins'] ?></td>
        <td><?= $row['draws'] ?></td>
        <td><?= $row['losses'] ?></td>
        <td><?= $row['goals_for'] ?></td>
        <td><?= $row['goals_against'] ?></td>
        <td><strong><?= $row['points'] ?></strong></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>
