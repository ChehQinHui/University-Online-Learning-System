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
    die("Unauthorized access.");
}

$student_id = $_SESSION['student_id'];
$course_id = $_POST['course_id'];
$answers = $_POST['answers'] ?? [];

if (!$course_id || empty($answers)) {
    die("Invalid submission.");
}


$quiz_query = "SELECT id, answer FROM quizzes WHERE course_id = ?";
$stmt = $conn->prepare($quiz_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$correct_answers = [];
while ($row = $result->fetch_assoc()) {
    $correct_answers[$row['id']] = $row['answer'];
}
$stmt->close();


$total_questions = count($correct_answers);
$correct_count = 0;

foreach ($answers as $quiz_id => $student_answer) {
    if (isset($correct_answers[$quiz_id]) && $correct_answers[$quiz_id] == $student_answer) {
        $correct_count++;
    }


    $insert_query = "INSERT INTO quiz_submissions (student_id, course_id, quiz_id, student_answer) 
                     VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iiis", $student_id, $course_id, $quiz_id, $student_answer);
    $stmt->execute();
}
$stmt->close();


$score = ($correct_count / $total_questions) * 100;


$score_query = "INSERT INTO quiz_results (student_id, course_id, score) VALUES (?, ?, ?)";
$stmt = $conn->prepare($score_query);
$stmt->bind_param("iid", $student_id, $course_id, $score);
$stmt->execute();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <style>
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            text-align: center;
        }
        h2 {
            color: #2c3e50;
        }
        .score {
            font-size: 24px;
            font-weight: bold;
            color: #27ae60;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<?php include 'bar_student2.php'; ?>

<div class="container">
    <h2>Quiz Completed</h2>
    <p class="score">Your Score: <strong><?php echo $score; ?>%</strong></p>
    <p>(<?php echo $correct_count; ?> / <?php echo $total_questions; ?> correct)</p>
    <a href='course_details_students.php?course_id=<?php echo $course_id; ?>' class="back-button">Back to Course</a>
</div>

</body>
</html>
