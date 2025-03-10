<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT id, department_name FROM department";
$result = mysqli_query($conn, $query);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = isset($_POST['department']) ? htmlspecialchars(trim($_POST['department'])) : "";
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : "";
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    if (empty($department) || empty($name) || empty($email) || empty($password)) {
        die("<script>alert('All fields are required!'); window.history.back();</script>");
    }


    $check_email = $conn->prepare("SELECT email FROM teachers WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        die("<script>alert('Email already registered!'); window.location.href='add_teacher.php';</script>");
    }
    $check_email->close();


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO teachers (department, name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $department, $name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Teacher added successfully!'); window.location.href='teachers.php';</script>";
        exit();
    } else {
        die("<script>alert('Failed to add teacher: " . $stmt->error . "');</script>");
    }

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
            color: black;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: black;
        }
        input[type="submit"], input[type="button"] {
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
<?php include 'bar_admin.php'; ?>
    <h2>Add Teacher</h2>
    <div class="main-container">
        <div class="form-container">
            <form action="add_teacher_function.php" method="post">
                <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select a Department</option>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['department_name']; ?>"><?php echo $row['department_name']; ?></option>
                        <?php } ?>
                    </select>

                <input type="text" id="name" name="name" placeholder="Fullname" required>
                <input type="email" id="email" name="email" placeholder="Email Address" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" value="Add">
                <input type="button" value="Back" onclick="location.href='teachers.php'">
            </form>
        </div>
    </div>
</body>
</html>
