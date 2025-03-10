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


if (isset($_POST['student_id']) && isset($_POST['course_id'])) {
    $student_id = intval($_POST['student_id']);
    $course_id = intval($_POST['course_id']);

    $delete_query = "DELETE FROM student_classes WHERE student_id = ? AND class_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $student_id, $course_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = ["type" => "success-message", "text" => "Student removed successfully!"];
    } else {
        $_SESSION['message'] = ["type" => "error-message", "text" => "Failed to remove student."];
    }
    
    $stmt->close();
    $conn->close();

    header("Location: course_details.php?course_id=" . $course_id);
    exit();
} else {
    die("Invalid request.");
}
?>
