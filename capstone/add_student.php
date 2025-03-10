<?php
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "assignment3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $fullname = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $hashed_password = password_hash($_POST["password"], PASSWORD_BCRYPT);


    $check_email = $conn->prepare("SELECT email FROM students WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        die("Email already registered. <a href='signupstudent.php'>Try again</a>");
    }
    $check_email->close();


    $id_exists = true;
    do {
        $random_number = mt_rand(10000, 99999);
        $id_number = "TP0" . $random_number;

 
        $check_id = $conn->prepare("SELECT id_number FROM students WHERE id_number = ?");
        $check_id->bind_param("s", $id_number);
        $check_id->execute();
        $check_id->store_result();
        $id_exists = $check_id->num_rows > 0;
        $check_id->close();
    } while ($id_exists);


    $stmt = $conn->prepare("INSERT INTO students (fullname, id_number, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $id_number, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Student added successfully! Student ID: $id_number'); window.location.href='students.php';</script>";
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
        }

        input, select { 
            width: 95%; 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            font-size: 16px; 
        }

        input[type="submit"], .back-btn {
            width: 100%; 
            background-color: #2c3e50; 
            color: white; 
            border: none; 
            cursor: pointer; 
            padding: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
            border-radius: 5px;
        }

        input[type="submit"]:hover, .back-btn:hover { 
            background-color: #34495e; 
        }

        label {
            color: black;
        }
    </style>
</head>
<body>
    <?php include 'bar_admin.php'; ?>
    <h2>Add Student</h2>
    <div class="main-container">
        <div class="form-container">
            <form method="POST">
                <input type="text" name="name" placeholder="Fullname" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" value="Add">
            </form>
            <button class="back-btn" onclick="location.href='students.php'">Back</button>
        </div>
    </div>
</body>
</html>
