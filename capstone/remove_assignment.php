<?php
session_start();
$conn = new mysqli("localhost", "root", "", "assignment3");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['student_id'])) {
        echo "<script>alert('Please log in to remove assignments.'); window.location.href='login.php';</script>";
        exit();
    }

    $student_id = $_SESSION['student_id'];
    $file_path = $_POST['file_path'];
    $assignment_id = intval($_POST['assignment_id']);


    $delete_sql = "DELETE FROM submitted_assignments WHERE student_id = ? AND course_id = ? AND file_path = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("iis", $student_id, $assignment_id, $file_path);

    if ($stmt->execute()) {

        if (file_exists($file_path)) {
            unlink($file_path);
        }
        echo "<script>
                alert('Assignment removed successfully!');
                window.location.href = 'assignment_student.php?id=$assignment_id';
              </script>";
    } else {
        echo "<script>alert('Error removing assignment.');</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>
