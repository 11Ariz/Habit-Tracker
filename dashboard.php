<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];

$sql = "SELECT * FROM Users WHERE userID='$userID'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Get leaderboard data
$leaderboardSQL = "SELECT Users.username, COUNT(CheckIns.checkInDate) as totalStreak FROM Users 
                   JOIN CheckIns ON Users.userID = CheckIns.userID 
                   GROUP BY Users.userID 
                   ORDER BY totalStreak DESC 
                   LIMIT 10";
$leaderboardResult = $conn->query($leaderboardSQL);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard-container">
        <div class="profile">
            <h2>Welcome, <?php echo $user['username']; ?></h2>
            <p>Email: <?php echo $user['email']; ?></p>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
        <div class="actions">
            <a href="add_habit.php" class="action-button">Add Habit</a>
            <a href="checkin.php" class="action-button">Check In</a>
            <a href="register.php" class="action-button">Add New User</a>
            <a href="shared_habits.php" class="action-button">View Shared Habits</a>
            <a href="view_habits.php" class="action-button">View Habits</a>
        </div>
        <h3>Leaderboard</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Total Streak</th>
            </tr>
            <?php
            while ($row = $leaderboardResult->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['totalStreak'] . " 🔥</td>
                      </tr>";
            }
            ?>
        </table>
        <h3>Your Habits</h3>
        <table>
            <tr>
                <th>Habit</th>
                <th>Streak Points</th>
                <th>Actions</th>
            </tr>
            <?php
            // Dynamically calculate streak points from the CheckIns table
            $sql = "SELECT Habits.habitID, Habits.habitName, COUNT(CheckIns.checkInDate) as streakPoints 
                    FROM Habits 
                    LEFT JOIN CheckIns ON Habits.habitID = CheckIns.habitID 
                        AND CheckIns.userID = '$userID'
                    WHERE Habits.userID = '$userID'
                    GROUP BY Habits.habitID, Habits.habitName";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['habitName'] . "</td>
                        <td>" . $row['streakPoints'] . " 🔥</td>
                        <td>
                            <a href='update_habit.php?habitID=" . $row['habitID'] . "'>Update</a> | 
                            <a href='delete_habit.php?habitID=" . $row['habitID'] . "'>Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
        <div id="calendar">
            <!-- Display calendar here -->
        </div>
    </div>
</body>
</html>
