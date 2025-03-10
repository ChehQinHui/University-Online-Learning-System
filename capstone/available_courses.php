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

// Fetch courses that the student **has not joined yet**
$sql = "SELECT c.id, c.title, c.description, t.name AS teacher_name
        FROM courses c
        JOIN teachers t ON c.teacher_id = t.id
        WHERE c.id NOT IN (
            SELECT class_id FROM student_classes WHERE student_id = ?
        )";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .course-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .course-card {
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            width: 250px;
            text-align: center;
            transition: transform 0.2s;
        }
        .course-card:hover {
            transform: scale(1.05);
        }
        .join-btn {
            background-color: #2c3e50;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .join-btn:hover {
            background-color: #1a252f;
        }
    </style>
</head>
<body>

<?php include 'bar_student.php'; ?>

<h2>Available Courses</h2>

<div class="course-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='course-card'>
                    <h3>{$row['title']}</h3>
                    <p>{$row['description']}</p>
                    <p><strong>Instructor:</strong> {$row['teacher_name']}</p>
                    <form action='join_course.php' method='POST'>
                        <input type='hidden' name='course_id' value='{$row['id']}'>
                        <button type='submit' class='join-btn'>Join Class</button>
                    </form>
                  </div>";
        }
    } else {
        echo "<p>No available courses at the moment.</p>";
    }
    ?>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
