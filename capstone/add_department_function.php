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
    $dname = trim($_POST['dname']);
    $pname = trim($_POST['pname']);

    if (!empty($dname) && !empty($pname)) {
        $sql = "INSERT INTO department (department_name, person_incharge) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $dname, $pname);

        if ($stmt->execute()) {
            echo "<script>alert('Department added successfully!'); window.location.href='department.php';</script>";
        } else {
            echo "<script>alert('Error adding department');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please fill all fields'); window.location.href='add_department.php';</script>";
    }
    $conn->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='add_department.php';</script>";
}
?>
