<?php
include 'config.php';

// Get the current date and time
$currentDate = new DateTime();
$currentDate->setTime(0, 0, 0); // Normalize to midnight

// Query all habits and their last check-in dates
$sql = "SELECT habitID, userID, MAX(checkInDate) AS lastCheckInDate FROM CheckIns GROUP BY habitID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $habitID = $row['habitID'];
        $userID = $row['userID'];
        $lastCheckInDate = new DateTime($row['lastCheckInDate']);

        // Calculate the difference in days
        $interval = $currentDate->diff($lastCheckInDate)->days;

        // Reset streak if last check-in was more than 1 day ago
        if ($interval >= 1) {
            $updateSql = "UPDATE Habits SET streakPoints = 0 WHERE habitID = '$habitID' AND userID = '$userID'";
            $conn->query($updateSql);
        }
    }
}
?>
