<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Leaderboard</title>
</head>
<body>
    <h2>Leaderboard</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Habit</th>
            <th>Streak Points</th>
        </tr>
        <?php
        $sql = "SELECT Users.username, Habits.habitName, SUM(CheckIns.streakPoints) as streakPoints 
                FROM CheckIns 
                JOIN Users ON CheckIns.userID = Users.userID 
                JOIN Habits ON CheckIns.habitID = Habits.habitID 
                WHERE CheckIns.isCheckedIn = TRUE 
                GROUP BY CheckIns.userID, CheckIns.habitID 
                ORDER BY streakPoints DESC 
                LIMIT 10";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['habitName'] . "</td>
                    <td>🔥 " . $row['streakPoints'] . "</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
