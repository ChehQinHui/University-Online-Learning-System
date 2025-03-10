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
    $course_id = $_POST['id'];
    $fileName = $_POST['fileName'];
    $fileDesc = $_POST['fileDesc'];


    $courseQuery = $conn->prepare("SELECT id FROM courses WHERE id = ?");
    $courseQuery->bind_param("i", $course_id);
    $courseQuery->execute();
    $courseQuery->bind_result($valid_course_id);
    $courseQuery->fetch();
    $courseQuery->close();

    if (empty($valid_course_id)) {
        die("Invalid course selected.");
    }


    if (!isset($_FILES['file']) || $_FILES['file']['error'] != UPLOAD_ERR_OK) {
        die("File upload error.");
    }


    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    $stmt = $conn->prepare("INSERT INTO assignments (id, file_name, file_desc, file_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $course_id, $fileName, $fileDesc, $target_file);
    
    if ($stmt->execute()) {
        header("Location: assignment_teacher.php?id=" . urlencode($course_id));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
