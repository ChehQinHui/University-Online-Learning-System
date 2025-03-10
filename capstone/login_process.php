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

$email = $_POST['email'];
$password = $_POST['password'];


$stmt = $conn->prepare("SELECT student_id, fullname, password FROM students WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($student_id, $fullname, $hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        $_SESSION['student_id'] = $student_id;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        header("Location: myclass_student.php");
        exit();
    }
}
$stmt->close();


$stmt = $conn->prepare("SELECT id, name, password FROM teachers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($teacher_id, $name, $hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        $_SESSION['teacher_id'] = $teacher_id;
        $_SESSION['fullname'] = $name;
        $_SESSION['email'] = $email;
        header("Location: myclass_teacher.php");
        exit();
    }
}
$stmt->close();


$stmt = $conn->prepare("SELECT fullname, password FROM admins WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($fullname, $hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {  
        $_SESSION['admin_fullname'] = $fullname;
        $_SESSION['email'] = $email;
        header("Location: dashboard_admin.php");
        exit();
    }
}
$stmt->close();


echo "<script>alert('Invalid login. Please try again.'); window.location.href='login.php';</script>";

$conn->close();
?>
