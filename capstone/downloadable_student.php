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


if (!isset($_GET['id'])) { 
    echo "Invalid course selection.";
    exit;
}

$course_id = intval($_GET['id']); 


$course_query = "SELECT title FROM courses WHERE id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_result = $stmt->get_result();
$course = $course_result->fetch_assoc();
$stmt->close();

if (!$course) {
    echo "Course not found.";
    exit;
}


$materials_query = "SELECT file_name, file_desc, file_path FROM downloadable_materials WHERE course_id = ?";
$stmt_materials = $conn->prepare($materials_query);
$stmt_materials->bind_param("i", $course_id);
$stmt_materials->execute();
$materials_result = $stmt_materials->get_result();
$stmt_materials->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - Downloadable Materials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            padding: 20px;
        }
        .downloadcontainer {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            text-align: left;
        }
        .file-item {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin-top: 5px;
            text-decoration: none;
            background: #2c3e50;
            color: white;
            border-radius: 5px;
        }
        .btn:hover {
            background: #1a252f;
        }
    </style>
</head>
<body>
    <?php include 'bar_student2.php'; ?>
    
    <div class="container">
        <h2>Downloadable Materials for <?php echo htmlspecialchars($course['title']); ?></h2>
        
        <div class="downloadcontainer">
            <?php
            if ($materials_result->num_rows > 0) {
                while ($row = $materials_result->fetch_assoc()) {
                    echo "<div class='file-item'>
                            <strong>" . htmlspecialchars($row['file_name']) . "</strong> - " . htmlspecialchars($row['file_desc']) . "
                            <br>
                            <a href='" . htmlspecialchars($row['file_path']) . "' download class='btn'>Download</a>
                          </div>";
                }
            } else {
                echo "<p>No downloadable materials available.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
