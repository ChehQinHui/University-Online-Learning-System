<?php 
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "assignment3"; 
$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$course_options = "";
$course_query = "SELECT id, title FROM subjects"; 
$result = $conn->query($course_query);
while ($row = $result->fetch_assoc()) {
    $course_options .= "<option value='{$row['id']}'>{$row['title']}</option>";
}


$intake_options = "";
$intake_query = "SELECT id, intake_code FROM intake"; 
$result = $conn->query($intake_query);
while ($row = $result->fetch_assoc()) {
    $intake_options .= "<option value='{$row['id']}'>{$row['intake_code']}</option>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System</title>
    <style>
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            color: black;
        }
        input, select {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"], input[type="button"] {
            width: 100%;
            padding: 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php include 'bar_teacher.php'; ?>
    <h2>Add Class</h2>
    <div class="main-container">
        <div class="form-container">
            <form method="POST" action="add_class_function.php">
                <label for="course">Course</label>
                <select id="course" name="course" required>
                    <option value="">Select a course</option>
                    <?php echo $course_options; ?>
                </select>

                <label for="intake">Intake</label>
                <select id="intake" name="intake" required>
                    <option value="">Select an intake</option>
                    <?php echo $intake_options; ?>
                </select>
                <input type="submit" value="Add">
                <input type="submit" value="Back" onclick="location.href='myclass_teacher.php'">
            </form>
        </div>
    </div>
</body>
</html>
