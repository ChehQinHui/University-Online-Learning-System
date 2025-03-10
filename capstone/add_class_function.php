<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['teacher_id'])) {
        $teacher_id = $_SESSION['teacher_id']; 
        $course_id = $_POST['course'];
        $intake_id = $_POST['intake'];

       
        $sql = "INSERT INTO classes (course_id, intake_id, teacher_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $course_id, $intake_id, $teacher_id);

        if ($stmt->execute()) {
            echo "<script>alert('Class added successfully!'); window.location.href='myclass_teacher.php';</script>";
        } else {
            echo "<script>alert('Failed to add class.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    }
}

$conn->close();
?>
