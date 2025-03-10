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


if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $_SESSION['course_id'] = intval($_GET['course_id']);
}
$course_id = $_SESSION['course_id'] ?? 0;


$query = "SELECT title AS course_name, description FROM courses WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($course_name, $description);
$stmt->fetch();
$stmt->close();


if (empty($course_name)) {
    die("No course found with this ID. <a href='teacher_dashboard.php'>Go back</a>");
}


$student_query = "SELECT DISTINCT s.id_number, s.fullname, s.email 
                  FROM students s
                  JOIN student_classes sc ON s.student_id = sc.student_id
                  JOIN courses c ON sc.class_id = c.id
                  WHERE c.id = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$student_list = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student_list .= "<tr>
                            <td>{$row['id_number']}</td>
                            <td>{$row['fullname']}</td>
                            <td>{$row['email']}</td>
                        </tr>";
    }
} else {
    $student_list = "<tr><td colspan='3'>No students found for this course.</td></tr>";
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System | <?php echo htmlspecialchars($course_name); ?></title>
    <style>
        .icontent {
            flex: 1;
            background: #ecf0f1;
            padding: 20px;
            overflow-y: auto; 
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>

<?php include 'bar_student2.php'; ?>

<div class="icontent">
    <h2><?php echo htmlspecialchars($course_name); ?> - Students</h2>
    <h4>Description: <?php echo htmlspecialchars($description); ?></h4>

    <table>
        <tr>
            <th>ID Number</th>
            <th>Full Name</th>
            <th>Email</th>
        </tr>
        <?php echo $student_list; ?>
    </table>
</div>

</body>
</html>
