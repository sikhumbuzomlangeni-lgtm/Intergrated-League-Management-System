<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Match</title>
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
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px;
            max-width: 90%;
        }
        h1 {
            margin-bottom: 20px;
            color: #0ef;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            text-align: left;
        }
        select, input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #0ef;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 18px;
            transition: background 0.3s;
        }
        button:hover {
            background: #00c3ff;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 24px;
            }
            button {
                font-size: 16px;
            }
        }
    </style>
    <script>
        // Prevent selecting the same team
        document.addEventListener('DOMContentLoaded', function() {
            const team1Select = document.getElementById('team1');
            const team2Select = document.getElementById('team2');

            team1Select.addEventListener('change', function() {
                const selectedTeam1 = this.value;
                Array.from(team2Select.options).forEach(option => {
                    option.disabled = option.value === selectedTeam1 && selectedTeam1 !== "";
                });
            });

            team2Select.addEventListener('change', function() {
                const selectedTeam2 = this.value;
                Array.from(team1Select.options).forEach(option => {
                    option.disabled = option.value === selectedTeam2 && selectedTeam2 !== "";
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Schedule Match</h1>
        <form action="process_schedule.php" method="post">
            <label for="team1">Select Team 1:</label>
            <select id="team1" name="team1" required>
                <option value="">Select Team</option>
                <option value="team_a">Team A</option>
                <option value="team_b">Team B</option>
                <option value="team_c">Team C</option>
                <option value="team_d">Team D</option>
            </select>

            <label for="team2">Select Team 2:</label>
            <select id="team2" name="team2" required>
                <option value="">Select Team</option>
                <option value="team_a">Team A</option>
                <option value="team_b">Team B</option>
                <option value="team_c">Team C</option>
                <option value="team_d">Team D</option>
            </select>

            <label for="match_date">Match Date:</label>
            <input type="date" id="match_date" name="match_date" required>

            <label for="match_time">Match Time:</label>
            <input type="time" id="match_time" name="match_time" required>

            <button type="submit">Schedule Match</button>
        </form>
    </div>
</body>
</html>