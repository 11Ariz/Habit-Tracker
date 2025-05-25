<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['checkIn'])) {
    $userID = $_SESSION['userID'];
    $habitID = $_POST['habitID'];
    $currentDateTime = new DateTime();
    $checkInDate = $currentDateTime->format('Y-m-d');

    // Query the last check-in date for this habit
    $checkInQuery = "SELECT MAX(checkInDate) AS lastCheckInDate, streakPoints 
                     FROM CheckIns 
                     WHERE userID='$userID' AND habitID='$habitID'";
    $result = $conn->query($checkInQuery);
    $row = $result->fetch_assoc();
    $lastCheckInDate = $row['lastCheckInDate'] ? new DateTime($row['lastCheckInDate']) : null;
    $streakPoints = $row['streakPoints'] ?? 0;

    // Determine if the streak should be continued or reset
    if ($lastCheckInDate) {
        $interval = $lastCheckInDate->diff($currentDateTime);
        $daysDifference = $interval->days;

        if ($daysDifference == 0) {
            // User already checked in today
            echo "You have already checked in for this habit today.";
            exit();
        } elseif ($daysDifference == 1) {
            // Continue the streak
            $streakPoints += 1;
        } else {
            // More than 1 day passed, reset the streak
            $streakPoints = 1;
        }
    } else {
        // First-time check-in, initialize streak
        $streakPoints = 1;
    }

    // Insert the new check-in and update streak points
    $insertCheckInQuery = "INSERT INTO CheckIns (userID, habitID, checkInDate, streakPoints, isCheckedIn) 
                           VALUES ('$userID', '$habitID', '$checkInDate', '$streakPoints', 1)";
    if ($conn->query($insertCheckInQuery)) {
        echo "Check-in successful! Your streak is now $streakPoints.";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error during check-in: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <form method="post" action="">
            <h2>Check In</h2>
            <select name="habitID" required>
                <option value="" disabled selected>Select a Habit</option>
                <?php
                // Fetch habits for the current user
                $userID = $_SESSION['userID'];
                $sql = "SELECT habitID, habitName FROM Habits WHERE userID='$userID'";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['habitID'] . "'>" . $row['habitName'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="checkIn">Check In</button>
        </form>
    </div>
</body>
</html>
