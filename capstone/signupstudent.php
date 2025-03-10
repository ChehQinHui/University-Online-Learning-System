<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3";  

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->close();
?>

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
        input[type="text"], input[type="email"], input[type="password"] {
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
        .signin-link {
            margin-top: 20px;
        }
        .signin-link a {
            color: #2c3e50;
            text-decoration: none;
        }
        .signin-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign up - Student</h1>
        <form id="signupForm" action="signupstudentdata.php" method="POST">
            <input type="text" name="fullname" id="fname" placeholder="Fullname" required>
            <input type="email" name="email" id="email" placeholder="Email Address" required>

            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="password" name="Cpassword" id="Cpassword" placeholder="Confirm Password" required>

            <button type="submit">Sign up</button>
        </form>
        <div class="signin-link">
            <p>Click here to login 👉🏽 <a href="login.php">Sign in</a></p>
        </div>
    </div>
</body>
</html>
