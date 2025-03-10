<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    $delete_id = intval($_POST["delete_id"]);
    $sql = "DELETE FROM students WHERE student_id=$delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student deleted successfully!'); window.location.href='students.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


$sql = "SELECT s.student_id, s.fullname, s.id_number, s.email, 
               GROUP_CONCAT(c.title SEPARATOR ', ') AS courses
        FROM students s
        LEFT JOIN student_classes sc ON s.student_id = sc.student_id
        LEFT JOIN courses c ON sc.class_id = c.id
        GROUP BY s.student_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System | Student List</title>
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

        input[type="button"], .delete-btn, .edit-btn {
            width: 120px;
            padding: 5px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            margin-left: 10px;
        }

        input[type="button"]:hover, .delete-btn:hover, .edit-btn:hover {
            background-color: #34495e;
        }

        .delete-btn {
            background-color: red;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background-color: darkred;
        }

        .edit-btn {
            background-color: orange;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .edit-btn:hover {
            background-color: darkorange;
        }
    </style>
</head>
<body>
    <?php include 'bar_admin.php'; ?>

        <h2>Student List</h2>

        <div class="btn-container">
            <input type="button" value="Add" onclick="location.href='add_student.php'">
        </div>

        <table>
            <tr>
                <th>Full Name</th>
                <th>ID Number</th>
                <th>Email</th>
                <th>Registered Courses</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["fullname"]."</td>
                            <td>".$row["id_number"]."</td>
                            <td>".$row["email"]."</td>
                            <td>".($row["courses"] ? $row["courses"] : "No Courses")."</td>
                            <td>
                                <button class='edit-btn' onclick=\"location.href='edit_student.php?id=".$row["student_id"]."'\">Edit</button>
                                <form method='POST' onsubmit='return confirm(\"Are you sure?\")' style='display:inline;'>
                                    <input type='hidden' name='delete_id' value='".$row["student_id"]."'>
                                    <button type='submit' class='delete-btn'>Remove</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No students found</td></tr>";
            }
            ?>
        </table>
</body>
</html>

<?php
$conn->close();
?>
