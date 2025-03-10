<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment3"; 


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$department_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$department_name = "";
$person_in_charge = "";


if ($department_id > 0) {
    $sql = "SELECT department_name, person_incharge FROM department WHERE id=$department_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $department_name = $row["department_name"];
        $person_in_charge = $row["person_incharge"];
    } else {
        die("Department not found.");
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["department_name"]) && isset($_POST["person_in_charge"])) {
    $new_name = $conn->real_escape_string($_POST["department_name"]);
    $new_person = $conn->real_escape_string($_POST["person_in_charge"]);


    $update_sql = "UPDATE department SET department_name='$new_name', person_incharge='$new_person' WHERE id=$department_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Department updated successfully!'); window.location.href='department.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
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
            text-align: center;
        }

        input[type="text"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            display: block;
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

<h2>Edit Department</h2>
<div class="main-container">
    <div class="form-container">
        <form method="POST">
            <input type="text" name="department_name" value="<?php echo htmlspecialchars($department_name); ?>" required>
            <input type="text" name="person_in_charge" value="<?php echo htmlspecialchars($person_in_charge); ?>" required>
            <input type="submit" value="Update">
        </form>
        <button onclick="location.href='department.php'">Back</button>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
