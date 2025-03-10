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


if (!isset($_SESSION['student_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit;
}

$student_id = $_SESSION['student_id'];


$sql = "SELECT c.id, c.title, c.description, 
               t.name AS teacher_name
        FROM courses c
        JOIN student_classes sc ON c.id = sc.class_id
        JOIN teachers t ON c.teacher_id = t.id
        WHERE sc.student_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$course_cards = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course_cards .= "
        <div class='course-card' onclick=\"window.location.href='course_details_students.php?course_id={$row['id']}'\">
            <h3>{$row['title']}</h3>
            <p>{$row['description']}</p>
            <p><strong>Instructor:</strong> {$row['teacher_name']}</p>
        </div>";
    }
} else {
    $course_cards = "<p>You have not joined any courses.</p>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System | My Courses</title>
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
            cursor: pointer;
            transition: transform 0.2s;
        }
        .course-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<?php include 'bar_student.php'; ?>

<h2>My Enrolled Courses</h2>

<div class="course-container">
    <?php echo $course_cards; ?>
</div>

</body>
</html>
