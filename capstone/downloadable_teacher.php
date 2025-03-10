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
    header("Location: login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];


$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : ($_SESSION['course_id'] ?? 0);


$course_query = "SELECT id, title FROM courses WHERE teacher_id = ? AND id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("ii", $teacher_id, $course_id);
$stmt->execute();
$course_result = $stmt->get_result();
$stmt->close();


if ($course_result->num_rows == 0) {
    die("Invalid course ID or no permission. <a href='myclass_teacher.php'>Go back</a>");
}

$course = $course_result->fetch_assoc();
$course_title = htmlspecialchars($course['title']);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_desc = $_POST["fileDesc"];
    
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $file_path = $upload_dir . basename($file_name);
    if (move_uploaded_file($file_tmp, $file_path)) {
        $sql = "INSERT INTO downloadable_materials (course_id, file_name, file_desc, file_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $course_id, $file_name, $file_desc, $file_path);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('File uploaded successfully!'); window.location.href = 'downloadable_teacher.php?course_id=$course_id';</script>";
    } else {
        echo "<script>alert('Error uploading file.');</script>";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    $delete_id = $_POST["delete_id"];


    $sql = "SELECT file_path FROM downloadable_materials WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();


    if (file_exists($file_path)) {
        unlink($file_path);
    }


    $sql = "DELETE FROM downloadable_materials WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('File deleted successfully!'); window.location.href = 'downloadable_teacher.php?course_id=$course_id';</script>";
    }
    $stmt->close();
}


$sql = "SELECT id, file_name, file_desc, file_path FROM downloadable_materials WHERE course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System | Teacher Materials</title>
    <style>

        .upload-container, .download-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        input, select, textarea {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #2c3e50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        .delete-btn {
            background: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .disabled {
            background: #ddd;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include 'bar_teacher2.php'; ?>
    
    <div class="container">
        <h2>Manage Downloadable Materials</h2>

        <!-- Course Display (Greyed Out) -->
        <label for="course_id">Course:</label>
        <input type="text" value="<?php echo $course_title; ?>" disabled class="disabled">

        <!-- Upload Section -->
        <div class="upload-container">
            <h3>Upload a File</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
                <input type="file" name="file" required>
                <textarea name="fileDesc" placeholder="File Description" required></textarea>
                <button type="submit">Upload</button>
            </form>
        </div>

        <div class="download-container">
            <h3>Uploaded Files</h3>
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>File Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['file_desc']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($row['file_path']); ?>" download>
                                    <button>Download</button>
                                </a>
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No files uploaded for this course yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
