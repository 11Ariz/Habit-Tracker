<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Fetch shared habits and users
$sql = "SELECT H1.habitName, GROUP_CONCAT(U.username SEPARATOR ', ') AS usersWithSameHabit
        FROM Habits H1
        JOIN Users U ON H1.userID = U.userID
        GROUP BY H1.habitName
        HAVING COUNT(U.userID) > 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Shared Habits Report</title>
</head>
<body>
    <div class="report-container">
        <h2>Users with Shared Habits</h2>
        <table>
            <tr>
                <th>Habit</th>
                <th>Users</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['habitName'] . "</td>
                            <td>" . $row['usersWithSameHabit'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No shared habits found.</td></tr>";
            }
            ?>
        </table>
<a href="shared_habits_excel.php" class="action-button">Download Shared Habits Report</a>

        <a href="dashboard.php" class="action-button">Back to Dashboard</a>
    </div>
</body>
</html>
