<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Warehouse Login</title>
    <style>
        .banner {
            width: 100%;
            height: 103vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('warehouse-rental.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="banner">
        <div class="login-container">
            <img src="JDC Logo.png" alt="Logo" style="position: relative; height: 200px; width: 200px;">
            <h2>Login</h2>
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<p class="error">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            ?>
            <form action="Loginprocess.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
