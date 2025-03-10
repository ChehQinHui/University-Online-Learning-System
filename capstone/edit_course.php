<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['edit_id'])) {
    die("No course ID received.");
}
$course_id = $_POST['edit_id'];

$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    die("Course not found.");
}

$teacher_sql = "SELECT id, name FROM teachers";
$teacher_result = $conn->query($teacher_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_course'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $teacher_id = !empty($_POST['teacher_id']) ? $_POST['teacher_id'] : NULL;

    $update_sql = "UPDATE courses SET title = ?, description = ?, teacher_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssii", $title, $description, $teacher_id, $course_id);

    if ($stmt->execute()) {
        echo "<script>alert('Course updated successfully!'); window.location.href='course.php';</script>";
    } else {
        echo "Error updating course: " . $conn->error;
    }
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
        }

        input[type="text"],
        textarea,
        select {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: black;
        }

        input[type="submit"], button {
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
    <?php include 'bar_admin.php'; ?>
    <h2>Edit Course</h2>
    <div class="main-container">
        <div class="form-container">
            <form method="POST" action="">
                <input type="hidden" name="edit_id" value="<?php echo $course_id; ?>">
                
                <input type="text" name="title" placeholder="Course Title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
                <textarea name="description" placeholder="Course Description" rows="3" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                
                <label for="teacher_id">Assign a Teacher (Optional)</label>
                <select name="teacher_id">
                    <option value="">-- Select Teacher --</option>
                    <?php while ($teacher = $teacher_result->fetch_assoc()): ?>
                        <option value="<?php echo $teacher['id']; ?>" <?php echo ($teacher['id'] == $course['teacher_id']) ? 'selected' : ''; ?>>
                            <?php echo $teacher['name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <input type="submit" name="update_course" value="Update Course">
                <br>
                <button type="button" onclick="location.href='course.php'">Back</button>
            </form>
        </div>
    </div>
</body>
</html>
