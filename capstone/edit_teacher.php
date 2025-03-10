<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "assignment3";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT id, department_name FROM department";
$departments = mysqli_query($conn, $query);


$teacher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$teacher_id) {
    die("Invalid teacher ID.");
}

$sql = "SELECT name, email, department, password FROM teachers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

if (!$teacher) {
    die("Teacher not found.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);
    $new_password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($department)) {
        echo "<script>alert('All fields except password are required.');</script>";
    } else {
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE teachers SET name = ?, email = ?, department = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $name, $email, $department, $hashed_password, $teacher_id);
        } else {
            $sql = "UPDATE teachers SET name = ?, email = ?, department = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $email, $department, $teacher_id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Teacher updated successfully!'); window.location.href='teachers.php';</script>";
        } else {
            echo "<script>alert('Error updating teacher.');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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
        input[type="text"], input[type="email"], select, input[type="password"] {
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
    <h2>Edit Teacher</h2>
    <div class="main-container">
        <div class="form-container">
            <form method="post">
                <label for="department">Department:</label>
                <select id="department" name="department" required>
                    <option value="">Select a Department</option>
                    <?php while ($row = mysqli_fetch_assoc($departments)) { ?>
                        <option value="<?php echo $row['department_name']; ?>" <?php echo ($teacher['department'] == $row['department_name']) ? 'selected' : ''; ?>>
                            <?php echo $row['department_name']; ?>
                        </option>
                    <?php } ?>
                </select>

                <input type="text" id="name" name="name" placeholder="Fullname" value="<?= htmlspecialchars($teacher['name']) ?>" required>
                <input type="email" id="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($teacher['email']) ?>" required>
                <input type="password" id="password" name="password" placeholder="New Password (leave blank to keep current)">
                <input type="submit" value="Update">
                <input type="button" value="Back" onclick="location.href='teachers.php'">
            </form>
        </div>
    </div>
</body>
</html>
