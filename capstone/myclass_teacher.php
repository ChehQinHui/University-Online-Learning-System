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


if (!isset($_SESSION['teacher_id'])) {
    echo "Please login first.";
    exit;
}

$teacher_id = $_SESSION['teacher_id'];


$course_query = "SELECT courses.id, courses.title, courses.description, teachers.name 
                 FROM courses 
                 JOIN teachers ON courses.teacher_id = teachers.id 
                 WHERE teacher_id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$course_cards = "";
while ($row = $result->fetch_assoc()) {
    $course_cards .= "
        <div class='course-card'>
            <h3>{$row['title']}</h3>
            <p>{$row['description']}</p>
            <p><strong>Teacher:</strong> {$row['name']}</p>
            <div class='btn-container'>
                <button onclick='openCourse({$row['id']})'>View</button>
            </div>
        </div>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System</title>
    <style>
        .course-list {
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
        .btn-container {
        margin-top: 10px;
        display: flex;
        justify-content: center; 
        text-align: center;
        align-items: center;
        padding-right: 0; 
            
        }
        button {
            padding: 8px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;

            
        }
        .delete-btn {
            background-color: red;
        }

        .icontainer {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
            
        }

        input[type="submit"], button {
            width: 100px;
            padding: 5px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            margin-left: 10px;
        }

        
    </style>
</head>
<body>
    <?php include 'bar_teacher.php'; ?>
    <h2>My Courses</h2>

    <div class="icontainer">
        <input type="submit" value="Add Course" onclick="location.href='add_course_teacher.php'">
    </div>
    <div class="course-list">
        <?php echo $course_cards; ?>
    </div>

    <script>
        function openCourse(courseId) {
            window.location.href = "course_details.php?course_id=" + courseId;
        }


    </script>
</body>
</html>
