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
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $teacher_id = !empty($_POST['teacher_id']) ? $_POST['teacher_id'] : NULL; 

    $sql = "INSERT INTO courses (title, description, teacher_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $description, $teacher_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Course added successfully!');
                window.location.href = 'myclass_teacher.php';
              </script>";
    } else {
        echo "<script>
                alert('Error adding course.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
