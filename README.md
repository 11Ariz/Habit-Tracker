# Habit Tracker System

## Overview
The **Habit Tracker System** is a web-based application designed to help users build and maintain habits effectively. Users can add custom or predefined habits, check in daily to track streaks, view shared habits among users, and generate reports.

## Features
- **User Authentication**: Register, login, and logout functionality.
- **Habit Management**: Users can add, update, or delete habits.
- **Daily Check-Ins**: Users check in to maintain habit streaks.
- **Streak Tracking**: Automatically updates streak counts.
- **Shared Habits Report**: View users with similar habits.
- **Leaderboard**: Displays top users based on streaks.
- **Excel Report Export**: Download habit reports.
- **Dashboard**: Visual representation of user progress.

## Installation & Setup

### 1. Requirements
- PHP (≥7.4)
- MySQL Database
- Web Server (Apache/XAMPP)
- Composer (Optional, for libraries)

### 2. Database Setup
1. Create a MySQL database named `habit_tracker`.
2. Run the following SQL commands:
sql
CREATE TABLE Users (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE Habits (
    habitID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    habitName VARCHAR(100) NOT NULL,
    FOREIGN KEY (userID) REFERENCES Users(userID)
);

CREATE TABLE CheckIns (
    checkInID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    habitID INT,
    checkInDate DATE NOT NULL,
    streakPoints INT DEFAULT 1,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (habitID) REFERENCES Habits(habitID)
);


### 3. Install Dependencies (Optional)
Run the following command to install **PhpSpreadsheet** (if using Excel exports):
bash
composer require phpoffice/phpspreadsheet


### 4. Configure Database
- Open `config.php` and update the database credentials:
php
<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "habit_tracker";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


### 5. Run the Application
1. Start your web server (Apache/XAMPP).
2. Open `index.php` in your browser.

## Usage Guide
### **1. User Registration & Login**
- Register with an email and password.
- Login to access the dashboard.

### **2. Managing Habits**
- Navigate to `add_habit.php` to add a habit.
- View all habits in `view_habits.php`.
- Delete or update habits as needed.

### **3. Checking In**
- Visit `checkin.php` to log a daily check-in.
- Streaks increase if checked in consecutively.

### **4. Viewing Shared Habits**
- Navigate to `shared_habits.php` to see users with the same habits.

### **5. Exporting Reports**
- Click "Download Shared Habits Report" to get an Excel report.

## Contributing
If you'd like to contribute:
1. Fork the repository.
2. Make your changes.
3. Submit a pull request.
