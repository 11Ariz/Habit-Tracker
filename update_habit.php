<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['habitID'])) {
    $habitID = $_GET['habitID'];
    $sql = "SELECT * FROM Habits WHERE habitID='$habitID' AND userID='{$_SESSION['userID']}'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $habit = $result->fetch_assoc();
    } else {
        echo "No habit found!";
    }
}

if (isset($_POST['updateHabit'])) {
    $habitID = $_POST['habitID'];
    $habitName = $_POST['habitName'];

    $sql = "UPDATE Habits SET habitName='$habitName' WHERE habitID='$habitID' AND userID='{$_SESSION['userID']}'";
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
    <title>Update Habit</title>
</head>
<body>
    <form method="post" action="">
        <h2>Update Habit</h2>
        <input type="hidden" name="habitID" value="<?php echo $habit['habitID']; ?>" required>
        <input type="text" name="habitName" placeholder="Habit Name" value="<?php echo $habit['habitName']; ?>" required>
        <button type="submit" name="updateHabit">Update</button>
    </form>
</body>
</html>
