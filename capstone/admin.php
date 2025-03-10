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
    $sql = "DELETE FROM admins WHERE id=$delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Admin deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


$sql = "SELECT id, fullname, email FROM admins"; 
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

        .delete-btn {
            background-color: red;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: darkred;
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

        <h2>Admin List</h2>

        <div class="btn-container">
            <input type="submit" value="Add" onclick="location.href='add_admin.php'">
        </div>

        <table>
            <tr>
                <th>Fullname</th>
                <th>Email Address</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["fullname"]."</td>
                            <td>".$row["email"]."</td>
                            <td>
                                <form method='POST' action='edit_admin.php' style='display:inline-block;'>
                                    <input type='hidden' name='edit_id' value='".$row["id"]."'>
                                    <button type='submit' class='edit-btn'>Edit</button>
                                </form>
                                <form method='POST' onsubmit='return confirm(\"Are you sure?\")' style='display:inline-block;'>
                                    <input type='hidden' name='delete_id' value='".$row["id"]."'>
                                    <button type='submit' class='delete-btn'>Remove</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No admins found</td></tr>";
            }
            ?>
        </table>

</body>
</html>

<?php
$conn->close();
?>
