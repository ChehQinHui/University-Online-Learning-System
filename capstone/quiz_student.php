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


if (!isset($_SESSION['student_id']) || !isset($_SESSION['course_id'])) {
    die("Invalid access. <a href='student_dashboard.php'>Go back</a>");
}

$student_id = $_SESSION['student_id'];
$course_id = $_SESSION['course_id'];


$course_query = "SELECT title, description FROM courses WHERE id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$stmt->bind_result($course_title, $course_description);
$stmt->fetch();
$stmt->close();


$quiz_query = "SELECT id, question FROM quizzes WHERE course_id = ?";
$stmt = $conn->prepare($quiz_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();


$quiz_list = "";
while ($row = $result->fetch_assoc()) {
    $quiz_id = $row['id'];
    $quiz_list .= "<div class='quiz-item'>
                    <p><strong>Question:</strong> " . htmlspecialchars($row['question']) . "</p>
                    <label>
                        <input type='radio' name='answers[$quiz_id]' value='True' required> True
                    </label>
                    <label>
                        <input type='radio' name='answers[$quiz_id]' value='False' required> False
                    </label>
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
    <title>Quiz - <?php echo htmlspecialchars($course_title); ?></title>
    <style>
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .quiz-item {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        button {
            background: #2c3e50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include 'bar_student2.php'; ?>

<h2>Quiz for <?php echo htmlspecialchars($course_title); ?></h2>
<p><?php echo htmlspecialchars($course_description); ?></p>

<div class="container">
    <h3>Quiz Questions</h3>
    <form action="submit_quiz.php" method="POST">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <?php echo $quiz_list ?: "<p>No quizzes available for this course.</p>"; ?>
        <button type="submit">Submit Quiz</button>
    </form>
</div>

</body>
</html>
