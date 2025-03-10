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

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

$query = "SELECT file_path FROM assignments WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($file_path);

if ($stmt->fetch()) {
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    $stmt->close();


    $delete_query = "DELETE FROM assignments WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Assignment deleted successfully!'); window.location.href='assignment_teacher.php';</script>";
    } else {
        echo "Error deleting assignment.";
    }
} else {
    echo "Assignment not found.";
}

$stmt->close();
$conn->close();
?>
