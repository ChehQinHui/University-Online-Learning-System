<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "assignment3";  

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_POST['fullname'], $_POST['email'], $_POST['password'], $_POST['Cpassword'])) {
    die("Please fill in all fields. <a href='signupstudent.php'>Go back</a>");
}

$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['Cpassword'];


if ($password !== $confirm_password) {
    die("Passwords do not match. <a href='signupstudent.php'>Go back</a>");
}


$check_email = $conn->prepare("SELECT email FROM students WHERE email = ?");
$check_email->bind_param("s", $email);
$check_email->execute();
$check_email->store_result();

if ($check_email->num_rows > 0) {
    die("Email already registered. <a href='signupstudent.php'>Try again</a>");
}
$check_email->close();


do {
    $random_number = mt_rand(10000, 99999); 
    $id_number = "TP0" . $random_number;

    $check_id = $conn->prepare("SELECT id_number FROM students WHERE id_number = ?");
    $check_id->bind_param("s", $id_number);
    $check_id->execute();
    $check_id->store_result();
    $id_exists = $check_id->num_rows > 0;
    $check_id->close();
} while ($id_exists); 


$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$stmt = $conn->prepare("INSERT INTO students (fullname, id_number, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fullname, $id_number, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful! Your Student ID: <strong>$id_number</strong><br><a href='login.php'>Login here</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
