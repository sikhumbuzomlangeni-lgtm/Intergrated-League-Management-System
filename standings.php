<?php
include 'connection.php';

$sql = "SELECT t.team_name, s.played, s.wins, s.draws, s.losses, s.goals_for, s.goals_against, s.points
        FROM standings s
        JOIN teams t ON s.team_id = t.team_id
        ORDER BY s.points DESC, s.goals_for - s.goals_against DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head><title>League Standings</title></head>
<body>
  <h2>League Standings</h2>
  <table border="1">
    <tr>
      <th>Team</th><th>Played</th><th>W</th><th>D</th><th>L</th>
      <th>GF</th><th>GA</th><th>Points</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['team_name'] ?></td>
        <td><?= $row['played'] ?></td>
        <td><?= $row['wins'] ?></td>
        <td><?= $row['draws'] ?></td>
        <td><?= $row['losses'] ?></td>
        <td><?= $row['goals_for'] ?></td>
        <td><?= $row['goals_against'] ?></td>
        <td><?= $row['points'] ?></td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>
