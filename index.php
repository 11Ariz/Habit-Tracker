<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Habit Tracker</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #3A1C71, #D76D77, #FFAF7B);
            color: #FFF4E3;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            animation: gradientShift 15s infinite alternate;
        }

        @keyframes gradientShift {
            0% {
                background: linear-gradient(to bottom right, #3A1C71, #D76D77, #FFAF7B);
            }
            100% {
                background: linear-gradient(to bottom right, #D76D77, #FFAF7B, #FFD700);
            }
        }

        /* Main Container */
        .home-container {
            text-align: center;
            max-width: 700px;
            width: 90%;
            padding: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(15px);
            position: relative;
            z-index: 2;
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Heading Styling */
        .home-container h1 {
            font-size: 72px;
            font-weight: bold;
            letter-spacing: 3px;
            text-shadow: 0px 5px 10px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }

        /* Quote Styling */
        .home-container .quote {
            font-size: 24px;
            font-style: italic;
            color: #FFEDC1;
            margin-bottom: 40px;
        }

        /* Buttons Section */
        .home-container .actions {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .home-container a.home-button {
            padding: 15px 40px;
            background: #FFD700;
            border: none;
            border-radius: 25px;
            color: #3A1C71;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .home-container a.home-button:hover {
            background: #F5A623;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        /* Floating Elements */
        .floating {
            position: absolute;
            border-radius: 50%;
            opacity: 0.7;
            animation: float 10s infinite ease-in-out;
            z-index: 1;
        }

        .floating-1 {
            width: 120px;
            height: 120px;
            background: #FFD700;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-2 {
            width: 100px;
            height: 100px;
            background: #FFAF7B;
            bottom: 15%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-3 {
            width: 150px;
            height: 150px;
            background: #D76D77;
            bottom: 5%;
            left: 15%;
            animation-delay: 4s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-20px) scale(1.1);
            }
            100% {
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="home-container">
        <h1>Habit Tracker</h1>
        <p class="quote">"The journey of a thousand miles begins with one step."</p>
        <div class="actions">
            <a href="login.php" class="home-button">Login</a>
            <a href="register.php" class="home-button">Register</a>
        </div>
    </div>
    <div class="floating floating-1"></div>
    <div class="floating floating-2"></div>
    <div class="floating floating-3"></div>
</body>
</html>
