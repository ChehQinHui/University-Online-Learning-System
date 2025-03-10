<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $teacher_id = !empty($_POST['teacher_id']) ? $_POST['teacher_id'] : NULL; 


    $sql = "INSERT INTO courses (title, description, teacher_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $description, $teacher_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Course added successfully!');
                window.location.href = 'course.php';
              </script>";
    } else {
        echo "<script>
                alert('Error adding course.');
                window.history.back();
              </script>";
    }

    $stmt->close();
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

        input[type="submit"] {
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
        button{
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
    <?php 
        include 'bar_admin.php'; 
        $conn = new mysqli("localhost", "root", "", "assignment3");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $sql = "SELECT id, name FROM teachers";
        $result = $conn->query($sql);
    ?>

    <h2>Add Course</h2>
    <div class="main-container">
        <div class="form-container">
            <form method="POST">
                <input type="text" id="title" name="title" placeholder="Course Title" required>
                <textarea id="description" name="description" placeholder="Course Description" rows="3" required></textarea>

                <label for="teacher">Assign a Teacher (Optional)</label>
                <select id="teacher_id" name="teacher_id">
                    <option value="">-- Select Teacher --</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                    }
                    ?>
                </select>

                <input type="submit" name="submit" value="Add Course">
                <br>
                <button type="button" onclick="location.href='course.php'">Back</button>
            </form>
        </div>
    </div>

</body>
</html>
