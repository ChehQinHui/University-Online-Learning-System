<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teacher_id'])) {
    $teacher_id = $_POST['teacher_id'];

    $sql = "DELETE FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacher_id);

    if ($stmt->execute()) {
        echo "<script>alert('Teacher deleted successfully!'); window.location.href='teachers.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error deleting teacher.'); window.location.href='teachers.php';</script>";
        exit();
    }
}

$sql = "SELECT id, name, email, department FROM teachers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System - Teachers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        input[type="submit"], .edit-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
        }
        input[type="submit"] {
            background-color: red;
            color: white;
        }
        .edit-btn {
            background-color: #f39c12;
            color: white;
        }
        .add-btn-container {
        display: flex;
        justify-content: flex-end; 
        margin-bottom: 10px;
        }

        .add-btn {
        width: 100px;
        height: 27px;
        display: flex;
        align-items: center; 
        justify-content: center; 
        background-color: #2c3e50;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include 'bar_admin.php'; ?>
    
    <h2>Teacher List</h2>
    <div class="add-btn-container">
        <a href="add_teacher.php" class="add-btn">Add</a>
    </div>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th> 
            <th>Action</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['department']) . "</td>"; 
                echo "<td>
                        <a href='edit_teacher.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>

                         <form method='post' action='' onsubmit='return confirm(\"Are you sure you want to delete?\")' style='display:inline;'>
                            <input type='hidden' name='teacher_id' value='" . $row['id'] . "'>
                            <input type='submit' value='Remove'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No teachers found</td></tr>";
        }
        ?>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
