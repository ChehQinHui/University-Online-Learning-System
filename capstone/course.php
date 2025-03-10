<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT c.id, c.title, c.description, 
               t.name AS teacher_name, 
               (SELECT COUNT(*) FROM student_classes WHERE class_id = c.id) AS student_count
        FROM courses c
        LEFT JOIN teachers t ON c.teacher_id = t.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        .btn-container {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
        }

        input[type="submit"], button {
            width: 100px;
            padding: 5px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            margin-left: 10px;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #34495e;
        }

        .edit-btn {
            background-color: #f39c12;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <?php include 'bar_admin.php'; ?>

        <h2>Course List</h2>

        <div class="btn-container">
            <input type="submit" value="Add" onclick="location.href='add_course_admin.php'">
        </div>

        <table>
            <tr>
                <th>Course Title</th>
                <th>Description</th>
                <th>Teacher</th>
                <th>Students Enrolled</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["title"]."</td>
                            <td>".$row["description"]."</td>
                            <td>".($row["teacher_name"] ? $row["teacher_name"] : "Not Assigned")."</td>
                            <td>".$row["student_count"]."</td>
                            <td>
                                <form method='POST' action='edit_course.php' style='display:inline;'>
                                    <input type='hidden' name='edit_id' value='".$row["id"]."' />
                                    <button type='submit' class='edit-btn'>Edit</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No courses found</td></tr>";
            }
            ?>
        </table>
</body>
</html>

<?php
$conn->close();
?>
