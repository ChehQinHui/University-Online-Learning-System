<?php
session_start();
$conn = new mysqli("localhost", "root", "", "assignment3");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$assignment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$sql = "SELECT id, course_name, file_name, file_desc, file_path FROM assignments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$result = $stmt->get_result();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['student_id'])) {
        echo "<script>alert('Please log in to submit assignments.'); window.location.href='login.php';</script>";
        exit();
    }

    $student_id = $_SESSION['student_id']; 
    $course_id = $assignment_id; 
    $fileName = htmlspecialchars($_POST['fileName']);
    $fileDesc = htmlspecialchars($_POST['fileDesc']);


    $upload_dir = "uploads/assignments/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $new_file_name = "student_" . $student_id . "_" . time() . "." . $file_ext;
    $file_path = $upload_dir . $new_file_name;

    if (move_uploaded_file($file_tmp, $file_path)) {

        $insert_sql = "INSERT INTO submitted_assignments (student_id, course_id, file_name, file_desc, file_path) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("iisss", $student_id, $course_id, $fileName, $fileDesc, $file_path);
        
        if ($stmt->execute()) {
    echo "<script>
            alert('Assignment submitted successfully!');
            window.location.href = 'assignment_student.php?id=$assignment_id';
          </script>";
        } else {
            echo "<script>alert('Error submitting assignment.');</script>";
        }
    } else {
        echo "<script>alert('File upload failed.');</script>";
    }
}


$submitted_sql = "SELECT file_name, file_desc, file_path FROM submitted_assignments WHERE student_id = ? AND course_id = ?";
$submitted_stmt = $conn->prepare($submitted_sql);
$submitted_stmt->bind_param("ii", $_SESSION['student_id'], $assignment_id);
$submitted_stmt->execute();
$submitted_result = $submitted_stmt->get_result();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Details</title>
    <style>

        
        .grid {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;

        }


        .file-item {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .file-item strong {
            display: block;
            font-size: 16px;
            color: #333;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #1a252f;
        }
        input, button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        button {
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #1a252f;
        }
        input[type="text"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: black;
        }

        
    </style>
</head>
<body>

<?php include 'bar_student2.php'; ?>
<h2>JomLearn-System</h2>


<div class="grid">
    <h3>Assignment Files</h3>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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


<div class="grid">
    <h3>Submit Assignment</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <input type="text" name="fileName" placeholder="File Name" required>
        <input type="text" name="fileDesc" placeholder="Description" required>
        <button type="submit">Submit</button>
    </form>
</div>


<div class="grid">
    <h3>Your Submitted Assignments</h3>
    <?php
    if ($submitted_result->num_rows > 0) {
        echo "<table border='1' width='100%' style='border-collapse: collapse; text-align: left;'>
                <tr>
                    <th style='padding: 10px; background: #2c3e50; color: white;'>File Name</th>
                    <th style='padding: 10px; background: #2c3e50; color: white;'>Description</th>
                    <th style='padding: 10px; background: #2c3e50; color: white;'>Download</th>
                    <th style='padding: 10px; background: #2c3e50; color: white;'>Action</th>
                </tr>";

        while ($row = $submitted_result->fetch_assoc()) {
            echo "<tr>
                    <td style='padding: 10px;'>" . htmlspecialchars($row['file_name']) . "</td>
                    <td style='padding: 10px;'>" . htmlspecialchars($row['file_desc']) . "</td>
                    <td style='padding: 10px;'>
                        <a href='" . htmlspecialchars($row['file_path']) . "' download class='btn'>Download</a>
                    </td>
                    <td style='padding: 10px;'>
                        <form method='POST' action='remove_assignment.php' style='display:inline;'>
                            <input type='hidden' name='file_path' value='" . htmlspecialchars($row['file_path']) . "'>
                            <input type='hidden' name='assignment_id' value='" . $assignment_id . "'>
                            <button type='submit' class='btn' style='background: red;'>Remove</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>You have not submitted any assignments yet.</p>";
    }
    ?>
</div>

</body>
</html>

<?php
$stmt->close();
$submitted_stmt->close();
$conn->close();
?>