<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 获取学生 ID
if (isset($_GET["id"])) {
    $student_id = intval($_GET["id"]);
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        echo "<script>alert('Student not found!'); window.location.href='students.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No student selected'); window.location.href='students.php';</script>";
    exit;
}

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = trim($_POST["password"]);

    // 更新语句（不修改 id_number）
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE students SET fullname=?, email=?, password=? WHERE student_id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssi", $fullname, $email, $hashed_password, $student_id);
    } else {
        $update_sql = "UPDATE students SET fullname=?, email=? WHERE student_id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssi", $fullname, $email, $student_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Student updated successfully!'); window.location.href='students.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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

        input { 
            width: 95%; 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            font-size: 16px; 
        }

        input[readonly] {
            background-color: #f0f0f0;
            cursor: not-allowed;
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
    <h2>Edit Student</h2>
    <div class="main-container">
        <div class="form-container">
            <form method="POST">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['fullname']); ?>" required>

                <label for="number">ID Number:</label>
                <input type="text" id="number" value="<?php echo htmlspecialchars($student['id_number']); ?>" readonly>
                <input type="hidden" name="number" value="<?php echo htmlspecialchars($student['id_number']); ?>">

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>

                <label for="password">New Password (leave blank to keep current):</label>
                <input type="password" id="password" name="password">

                <input type="submit" value="Update">
            </form>
            <input type="button" class="back-btn" value="Back" onclick="location.href='students.php'">
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
