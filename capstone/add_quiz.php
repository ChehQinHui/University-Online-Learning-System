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

$course_id = $_POST['course_id'] ?? 0;
$question = trim($_POST['question'] ?? '');
$answer = $_POST['answer'] ?? '';

if (empty($course_id) || empty($question) || empty($answer)) {
    die("Invalid input. <a href='quiz_teacher.php?id={$course_id}'>Go back</a>");
}

$stmt = $conn->prepare("INSERT INTO quizzes (course_id, question, answer) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $course_id, $question, $answer);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: quiz_teacher.php?id={$course_id}");
exit;
?>
