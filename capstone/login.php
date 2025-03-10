<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        input[type="email"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color:#2c3e50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .signup-link {
            margin-top: 20px;
        }
        .signup-link a {
            color: #2c3e50;
            text-decoration: none;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>JomLearn-System</h1>
        <form id="loginForm" action="login_process.php" method="POST">
            <input type="email" name="email" id="email" placeholder="Email Address" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit">Sign in</button>
        </form>
        <div class="signup-link">
            <p>New to JomLearn? 👉🏽<a href="signupstudent.php">Student?</a> </p>
        </div>
    </div>
</body>
</html>
