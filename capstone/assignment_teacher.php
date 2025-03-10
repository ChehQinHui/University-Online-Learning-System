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


$assignment_query = "SELECT id, file_name, file_desc FROM assignments WHERE id = ?";
$stmt = $conn->prepare($assignment_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$assignment_list = "";
while ($row = $result->fetch_assoc()) {
    $assignment_list .= "<div class='file-item'>
                            <strong>{$row['file_name']}</strong> - {$row['file_desc']}
                            <br>
                            <a href='download_assignment.php?id={$row['id']}' class='btn download'>Download</a>
                            <a href='delete_assignment.php?id={$row['id']}' class='btn remove' onclick='return confirm(\"Are you sure you want to delete this assignment?\")'>Remove</a>
                        </div>";
}
$stmt->close();


$submitted_query = "SELECT sa.id, sa.file_name, sa.file_desc, sa.file_path, sa.submitted_at, s.fullname, s.id_number 
                    FROM submitted_assignments sa
                    JOIN students s ON sa.student_id = s.student_id
                    WHERE sa.course_id = ?";
$stmt = $conn->prepare($submitted_query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$submitted_result = $stmt->get_result();

$submitted_assignment_list = "";
while ($row = $submitted_result->fetch_assoc()) {
    $submitted_assignment_list .= "<tr>
                                    <td>" . htmlspecialchars($row['file_name']) . "</td>
                                    <td>" . htmlspecialchars($row['file_desc']) . "</td>
                                    <td>" . htmlspecialchars($row['submitted_at']) . "</td>
                                    <td>" . htmlspecialchars($row['fullname']) . "</td>
                                    <td>" . htmlspecialchars($row['id_number']) . "</td>
                                    <td>
                                        <a href='" . htmlspecialchars($row['file_path']) . "' download class='btn download'>Download</a>
                                        <a href='delete_submitted_assignment.php?id={$row['id']}' class='btn remove' onclick='return confirm(\"Are you sure you want to delete this submitted assignment?\")'>Delete</a>
                                    </td>
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
    <title>JomLearn-System</title>
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
    max-height: 400px;
    overflow-y: auto;
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

@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }
    .downloadcontainer, .addcontainer {
        width: 100%;
    }
}

.file-item {
    background: #e9ecef;
    padding: 10px;
    border-radius: 5px;
    margin: 5px 0;
}

input, button {
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
.download {
    background: #3498db;
    color: white;
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
    </style>
</head>
<body>

<?php include 'bar_teacher2.php'; ?>

<h2>Assignments for <?php echo htmlspecialchars($course_title); ?></h2>
<p><?php echo htmlspecialchars($course_description); ?></p>

<div class="container">
    <div class="downloadcontainer">
        <h3>Assignment Files</h3>
        <div class="file-list">
            <?php echo $assignment_list ?: "<p>No assignments uploaded yet.</p>"; ?>
        </div>
    </div>

    <div class="addcontainer">
        <h3>Add Assignment</h3>
        <form action="upload_assignment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($course_id); ?>">
            <input type="file" name="file" required>
            <input type="text" name="fileName" placeholder="File Name" required>
            <input type="text" name="fileDesc" placeholder="Description" required>
            <button type="submit">Upload</button>
        </form>
    </div>   
</div>

<div class="downloadcontainer">
    <h3>Submitted Assignments</h3>
    <div class="table-container">
        <table>
            <tr>
                <th>File Name</th>
                <th>Description</th>
                <th>Submitted At</th>
                <th>Student Name</th>
                <th>Student ID</th>
                <th>Action</th>
            </tr>
            <?php echo $submitted_assignment_list ?: "<tr><td colspan='6'>No assignments submitted yet.</td></tr>"; ?>
        </table>
    </div>
</div>

</body>
</html>
