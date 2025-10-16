<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>League Management System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: rgba(255,255,255,0.1);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      text-align: center;
      width: 350px;
    }
    h1 {
      margin-bottom: 20px;
      color: #0ef;
    }
    a {
      display: block;
      margin: 10px 0;
      padding: 12px;
      background: #0ef;
      color: #000;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    a:hover {
      background: #00c3ff;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>League Management System</h1>
    <a href="add_team.php">Register Team</a>
    <a href="schedule_match.php">Schedule Match</a>
    <a href="record_result.php">Record Match Result</a>
    <a href="league_table.php">View League Table</a>
    <a href="admin_login.php">Admin Login</a>
  </div>
</body>
</html>
