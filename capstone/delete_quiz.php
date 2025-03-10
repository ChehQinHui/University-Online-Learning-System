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


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid quiz ID. <a href='quiz_teacher.php'>Go back</a>");
}

$quiz_id = intval($_GET['id']); 


$delete_query = "DELETE FROM quizzes WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $quiz_id);

if ($stmt->execute()) {

    header("Location: quiz_teacher.php");
    exit();
} else {
    echo "Error deleting quiz: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
