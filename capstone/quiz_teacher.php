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

if (isset($_GET['id'])) {
    $_SESSION['course_id'] = intval($_GET['id']); // Store course ID in session
}

$course_id = $_SESSION['course_id'] ?? 0;

if (empty($course_id)) {
    die("Invalid Course ID. <a href='myclass_teacher.php'>Go back</a>");
}


$course_query = "SELECT title, description FROM courses WHERE id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$stmt->bind_result($course_title, $course_description);
$stmt->fetch();
$stmt->close();


$quiz_query = "SELECT id, question, answer FROM quizzes WHERE course_id = ?";
$stmt = $conn->prepare($quiz_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$quiz_list = "";
while ($row = $result->fetch_assoc()) {
    $quiz_list .= "<tr>
                    <td>" . htmlspecialchars($row['question']) . "</td>
                    <td>" . htmlspecialchars($row['answer']) . "</td>
                    <td>
                        <a href='delete_quiz.php?id={$row['id']}' class='btn remove' onclick='return confirm(\"Are you sure you want to delete this question?\")'>Remove</a>
                    </td>
                   </tr>";
}
$stmt->close();


$results_query = "SELECT s.fullname, qr.score, qr.taken_at 
                  FROM quiz_results qr
                  JOIN students s ON qr.student_id = s.student_id
                  WHERE qr.course_id = ?";
$stmt = $conn->prepare($results_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$results_list = "";
while ($row = $result->fetch_assoc()) {
    $results_list .= "<tr>
                        <td>" . htmlspecialchars($row['fullname']) . "</td>
                        <td>" . htmlspecialchars($row['score']) . "</td>
                        <td>" . htmlspecialchars($row['taken_at']) . "</td>
                      </tr>";
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System - Manage Quiz</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: space-between;
        }

        .downloadcontainer {
            flex: 1 1 65%;
            min-width: 300px;
            text-align: left;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .addcontainer {
            flex: 1 1 30%;
            min-width: 250px;
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        input, button, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #2c3e50;
            color: white;
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin-top: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .remove {
            background: #e74c3c;
            color: white;
        }

        .table-container {
            max-height: 300px;  
            overflow-y: auto;   
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            word-wrap: break-word;
            white-space: normal;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        input[name="question"] {
        width: 90%; 
        text-align: left; 
        display: block; 
}

    </style>
</head>
<body>

<?php include 'bar_teacher2.php'; ?>

<h2>Manage Quiz for <?php echo htmlspecialchars($course_title); ?></h2>
<p><?php echo htmlspecialchars($course_description); ?></p>

<div class="container">

    <div class="downloadcontainer">
        <h3>Quiz Questions</h3>
        <div class="table-container">
            <table>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
                <?php echo $quiz_list ?: "<tr><td colspan='3'>No quiz questions added yet.</td></tr>"; ?>
            </table>
        </div>
    </div>

    <div class="addcontainer">
        <h3>Add Quiz Question</h3>
        <form action="add_quiz.php" method="POST">
            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
            <input type="text" name="question" placeholder="Enter True/False Question" required>
            <select name="answer" required>
                <option value="True">True</option>
                <option value="False">False</option>
            </select>
            <button type="submit">Add Question</button>
        </form>
    </div>   

    <div class="downloadcontainer">
        <h3>Student Quiz Results</h3>
        <div class="table-container">
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Score</th>
                    <th>Date Taken</th>
                </tr>
                <?php echo $results_list ?: "<tr><td colspan='3'>No quiz results available.</td></tr>"; ?>
            </table>
        </div>
    </div>

</div>

</body>
</html>
