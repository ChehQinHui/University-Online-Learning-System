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

        input[type="text"]{
            width: 95%; 
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            display: block; 
        }

        input[type="submit"],button {
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

<h2>Add Department</h2>
<div class="main-container">
    <div class="form-container">
        <form method="POST" action="add_department_function.php">
            <input type="text" id="dname" name="dname" placeholder="Department" required>
            <input type="text" id="pname" name="pname" placeholder="Person Incharge" required>                          
            <input type="submit" name="submit" value="Add">
        </form>
        <button onclick="location.href='department.php'">Back</button>  
    </div>
</div>

</body>
</html>
