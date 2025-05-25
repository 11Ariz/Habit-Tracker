<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['userID'] = $user['userID'];

            // Integrate streak-breaking logic
            $userID = $_SESSION['userID'];

            // Fetch all habits for the user
            $habitQuery = "SELECT * FROM Habits WHERE userID='$userID'";
            $habitResult = $conn->query($habitQuery);

            while ($habit = $habitResult->fetch_assoc()) {
                $habitID = $habit['habitID'];
                $lastCheckInDate = $habit['lastCheckInDate'] ? new DateTime($habit['lastCheckInDate']) : null;
                $currentDate = new DateTime();

                if ($lastCheckInDate) {
                    $interval = $lastCheckInDate->diff($currentDate);

                    // If more than 1 day (24 hours) has passed, reset the streak
                    if ($interval->days >= 1) {
                        $resetQuery = "UPDATE Habits SET streakPoints = 0 WHERE habitID='$habitID' AND userID='$userID'";
                        $conn->query($resetQuery);
                    }
                }
            }

            // Redirect to dashboard after streak-breaking check
            header("Location: dashboard.php");
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with this email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <form method="post" action="">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <br>
        <a href="register.php" class="register-button">Add New User</a>
    </form>
</body>
</html>
