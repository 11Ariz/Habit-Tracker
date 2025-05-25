<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['habitID'])) {
    $habitID = $_GET['habitID'];
    $sql = "DELETE FROM Habits WHERE habitID='$habitID' AND userID='{$_SESSION['userID']}'";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
