<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Most Popular Course
$sql_popular_course = "SELECT courses.title, COUNT(student_classes.student_id) AS student_count 
                       FROM courses 
                       JOIN student_classes ON courses.id = student_classes.class_id 
                       GROUP BY courses.title 
                       ORDER BY student_count DESC";
$result = $conn->query($sql_popular_course);
$courses_data = [];
$course_details = "";
while ($row = $result->fetch_assoc()) {
    $courses_data[$row['title']] = $row['student_count'];
    $course_details .= "<p>{$row['title']}: {$row['student_count']} students</p>";
}

//Department with Most Teachers
$sql_teacher_department = "SELECT department, COUNT(id) AS teacher_count 
                           FROM teachers 
                           GROUP BY department 
                           ORDER BY teacher_count DESC";
$result = $conn->query($sql_teacher_department);
$departments_data = [];
$department_details = "";
while ($row = $result->fetch_assoc()) {
    $departments_data[$row['department']] = $row['teacher_count'];
    $department_details .= "<p>{$row['department']}: {$row['teacher_count']} teachers</p>";
}

// Course Completion Rate
$sql_completion_rate = "SELECT 
                        (COUNT(DISTINCT student_id) / (SELECT COUNT(student_id) FROM students)) * 100 AS completion_rate 
                        FROM submitted_assignments";
$result = $conn->query($sql_completion_rate);
$completion_rate = round($result->fetch_assoc()['completion_rate'], 2);
$completion_details = "<p>Completion Rate: {$completion_rate}%</p>";

// Average Quiz Score
$sql_quiz_performance = "SELECT AVG(score) AS avg_score FROM quiz_results";
$result = $conn->query($sql_quiz_performance);
$avg_quiz_score = round($result->fetch_assoc()['avg_score'], 2);
$quiz_details = "<p>Average Quiz Score: {$avg_quiz_score}/100</p>";

//Total Students
$sql_total_students = "SELECT COUNT(student_id) AS total_students FROM students";
$result = $conn->query($sql_total_students);
$total_students = $result->fetch_assoc()['total_students'];
$students_details = "<p>Total Students: {$total_students}</p>";

//Average Courses Per Student
$sql_avg_classes = "SELECT AVG(course_count) AS avg_classes FROM 
                    (SELECT student_id, COUNT(class_id) AS course_count FROM student_classes GROUP BY student_id) AS temp";
$result = $conn->query($sql_avg_classes);
$avg_classes = round($result->fetch_assoc()['avg_classes'], 2);
$avg_classes_details = "<p>Avg Courses Per Student: {$avg_classes}</p>";

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .chart-container {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-title {
            font-size: 18px;
            font-weight: bold;
            color: black;
            margin-bottom: 10px;
            text-align: center;
        }

        .info {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            color: black;
        }
    </style>
</head>
<body>
    <?php include 'bar_admin.php'; ?>
    <h2>Data Analytics Dashboard</h2>

    <div class="dashboard-container">
        <div class="chart-container">
            <div class="chart-title">Most Popular Course</div>
            <canvas id="popularCourseChart"></canvas>
            <div class="info"><?php echo $course_details; ?></div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Department with Most Teachers</div>
            <canvas id="departmentChart"></canvas>
            <div class="info"><?php echo $department_details; ?></div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Course Completion Rate</div>
            <canvas id="completionRateChart"></canvas>
            <div class="info"><?php echo $completion_details; ?></div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Average Quiz Score</div>
            <canvas id="quizScoreChart"></canvas>
            <div class="info"><?php echo $quiz_details; ?></div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Total Students</div>
            <canvas id="studentsChart"></canvas>
            <div class="info"><?php echo $students_details; ?></div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Average Courses Per Student</div>
            <canvas id="avgClassesChart"></canvas>
            <div class="info"><?php echo $avg_classes_details; ?></div>
        </div>
    </div>

    <script>
        const pastelColors = ['#A7C7E7', '#FFDDC1', '#B5EAD7', '#E2F0CB', '#FFB7B2', '#D4A5A5'];

        function createPieChart(ctx, labels, data) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: pastelColors
                    }]
                }
            });
        }

        createPieChart(document.getElementById('popularCourseChart'), <?php echo json_encode(array_keys($courses_data)); ?>, <?php echo json_encode(array_values($courses_data)); ?>);
        createPieChart(document.getElementById('departmentChart'), <?php echo json_encode(array_keys($departments_data)); ?>, <?php echo json_encode(array_values($departments_data)); ?>);
        createPieChart(document.getElementById('completionRateChart'), ['Completed', 'Not Completed'], [<?php echo $completion_rate; ?>, <?php echo 100 - $completion_rate; ?>]);
        createPieChart(document.getElementById('quizScoreChart'), ['Average Score', 'Remaining'], [<?php echo $avg_quiz_score; ?>, <?php echo 100 - $avg_quiz_score; ?>]);
        createPieChart(document.getElementById('studentsChart'), ['Registered Students', 'Remaining Capacity'], [<?php echo $total_students; ?>, <?php echo 1000 - $total_students; ?>]);
        createPieChart(document.getElementById('avgClassesChart'), ['Avg Courses Taken', 'Remaining'], [<?php echo $avg_classes; ?>, <?php echo 10 - $avg_classes; ?>]);
    </script>

</body>
</html>
