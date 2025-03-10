<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "assignment3";


$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['student_id'])) {
    echo "Please log in first.";
    exit;
}

$student_id = $_SESSION['student_id'];
$course_id = $_POST['course_id'] ?? 0;


$check_query = "SELECT * FROM student_classes WHERE student_id = ? AND class_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ii", $student_id, $course_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('You are already enrolled in this course!'); window.location.href='available_courses.php';</script>";
    exit;
}

$stmt->close();


$insert_query = "INSERT INTO student_classes (student_id, class_id) VALUES (?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("ii", $student_id, $course_id);
if ($stmt->execute()) {
    echo "<script>alert('Successfully joined the course!'); window.location.href='myclass_student.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
