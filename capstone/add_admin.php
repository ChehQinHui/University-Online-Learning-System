<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); 


    $sql = "INSERT INTO admins (fullname, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullname, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Admin added successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
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
        
        .main-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        color: white;
        }

        input[type="text"],input[type="email"],
        select {
        width: 95%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        color: black;
        }

        input[type="password"],
        select {
        width: 95%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        color: black;
        }

        input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #2c3e50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
        }

    </style>
</head>
<body>
    <?php 
        include 'bar_admin.php';?>
    
        <h2>Add Admin</h2>
        <div class="main-container">
            <div class="form-container">
            <form method="POST">
                    <input type="text" id="name" name="name" placeholder="Fullname" required>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Add">
                    <br>
                    <input type="submit" value="Back" onclick="location.href='admin.php'">                 
                </form>
            </div>
        </div>

    </div>
    

</body>
</html>
