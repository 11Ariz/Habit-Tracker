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

// Prepare CSV headers
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Shared_Habits_Report.csv"');

// Open output stream for writing CSV data
$output = fopen('php://output', 'w');

// Write the header row
fputcsv($output, ['Habit', 'Users']);

// Populate rows with data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['habitName'], $row['usersWithSameHabit']]);
    }
} else {
    // Write a message if no shared habits are found
    fputcsv($output, ['No habits found', '']);
}

// Close the output stream
fclose($output);
exit();
