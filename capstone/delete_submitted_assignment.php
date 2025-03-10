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

$assignment_id = intval($_GET['id']);

$query = "SELECT file_path FROM submitted_assignments WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$stmt->bind_result($file_path);
$stmt->fetch();
$stmt->close();

if (!empty($file_path) && file_exists($file_path)) {
    unlink($file_path);
}

$delete_query = "DELETE FROM submitted_assignments WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: assignment_teacher.php");
exit;
?>
