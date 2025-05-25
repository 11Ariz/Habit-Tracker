<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['addHabit'])) {
    $userID = $_SESSION['userID'];
    $habitName = $_POST['habitName'];

    $sql = "INSERT INTO Habits (userID, habitName) VALUES ('$userID', '$habitName')";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Add Habit</title>
</head>
<body>
    <div class="form-container">
        <form method="post" action="">
            <h2>Add Habit</h2>
            <!-- Dropdown for predefined habits -->
            <label for="predefinedHabits">Select a Common Habit:</label>
            <select id="predefinedHabits" onchange="updateHabitName()" class="predefined-habits">
                <option value="" disabled selected>Select a habit...</option>
                <option value="Exercise">Exercise</option>
                <option value="Meditation">Meditation</option>
                <option value="Reading">Reading</option>
                <option value="Journaling">Journaling</option>
                <option value="Drink Water">Drink Water</option>
                <option value="Sleep on Time">Sleep on Time</option>
                <option value="Daily Walk">Daily Walk</option>
                <option value="Learn a Skill">Learn a Skill</option>
                <option value="Plan the Day">Plan the Day</option>
                <option value="Eat Healthy">Eat Healthy</option>
            </select>
            <br><br>

            <!-- Input for custom habit -->
            <label for="habitName">Or Type Your Own Habit:</label>
            <input type="text" id="habitName" name="habitName" placeholder="Enter a custom habit" required>
            <br>

            <!-- Add Habit Button -->
            <button type="submit" name="addHabit">Add Habit</button>
        </form>
    </div>

    <script>
        function updateHabitName() {
            const predefined = document.getElementById('predefinedHabits').value;
            const customInput = document.getElementById('habitName');
            if (predefined) {
                customInput.value = predefined;
            }
        }
    </script>
</body>
</html>
