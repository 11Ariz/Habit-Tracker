<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];

// Fetch habits along with streak points exactly as in the dashboard
$sql = "SELECT Habits.habitName, Habits.habitID, SUM(CheckIns.streakPoints) as streakPoints 
        FROM Habits 
        LEFT JOIN CheckIns ON Habits.habitID = CheckIns.habitID 
        WHERE Habits.userID='$userID' 
        GROUP BY Habits.habitID";
$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error); // Debugging if query fails
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>View Habits</title>
</head>
<body>
    <div class="habit-list-container">
        <h2>Your Habits</h2>
        <table>
            <tr>
                <th>Habit</th>
                <th>Streak Count</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($habit = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $habit['habitName'] . "</td>
                            <td>" . ($habit['streakPoints'] ?? 0) . " 🔥</td>
                            <td>
                                <a href='update_habit.php?habitID=" . $habit['habitID'] . "'>Update</a> | 
                                <a href='delete_habit.php?habitID=" . $habit['habitID'] . "'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No habits found. Start adding habits now!</td></tr>";
            }
            ?>
        </table>
        <a href="dashboard.php" class="action-button">Back to Dashboard</a>
    </div>
</body>
</html>
