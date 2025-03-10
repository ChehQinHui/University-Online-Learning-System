<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $email = "";
$id = 0;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_id"])) {
    $edit_id = intval($_POST["edit_id"]);
    $sql = "SELECT * FROM admins WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $fullname = $row['fullname'];
        $email = $row['email'];
    } else {
        echo "<script>alert('Admin not found!'); window.location.href='admin.php';</script>";
        exit();
    }
    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = intval($_POST["id"]);
    $fullname = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $new_password = trim($_POST["password"]);

    if (!empty($new_password)) {

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE admins SET fullname=?, email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $fullname, $email, $hashed_password, $id);
    } else {

        $sql = "UPDATE admins SET fullname=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $fullname, $email, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Admin updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
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
            color: black;
        }

        input[type="text"], input[type="email"], input[type="password"] {
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
            text-align: center;
            display: block;
            text-decoration: none;
        }

        .back-button {
            width: 95%;
            padding: 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include 'bar_admin.php'; ?>

    <h2>Edit Admin</h2>
    <div class="main-container">
        <div class="form-container">
            <form method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="text" name="name" value="<?= htmlspecialchars($fullname) ?>" placeholder="Fullname" required>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="New Password (leave blank to keep existing)">
                <input type="submit" name="update" value="Update">
            </form>
            <a href="admin.php" class="back-button">Back</a>
        </div>
    </div>
</body>
</html>
