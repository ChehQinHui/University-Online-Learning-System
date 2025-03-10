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
