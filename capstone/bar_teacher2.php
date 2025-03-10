<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// $intake_code = $_SESSION['intake_code'] ?? '';
$course_id = $_SESSION['course_id'] ?? '';


$student_link = !empty($course_id) ? "course_details.php?course_id=" . urlencode($course_id) : "#";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JomLearn-System</title>
 <style>
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            background-color: #2c3e50; 
            width: 250px;
            height: 100vh; 
            padding-top: 20px;
            display: flex;
            flex-direction: column; 
        }

        .sidebar li {
            list-style: none;
            padding: 10px;
        }

        .sidebar a {
            text-decoration: none;
            color: #aaa; 
            display: block;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover,
        .sidebar .active {
            background-color: #1a252f; 
            color: white !important; 
        }

        .content {
            flex: 1;
            background: #ecf0f1;
            padding: 20px;
            height: 100vh; 
            overflow-y: auto; 
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            background: #34495e;
            color: white;
            padding: 10px 20px;
        }
        .user-menu {
            position: relative;
            cursor: pointer;
        }
        .user-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            color: black;
            border: 1px solid #ddd;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
            width: 120px;
        }
        .user-dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
        }
        .user-dropdown a:hover {
            background: #ddd;
        }
        </style>
</head>
<body>
<div class="sidebar">
        <ul class="sidebar">
        <li id="back"><a href="myclass_teacher.php">Back</a></li>
        <li id="mystudent">
            <a href="<?php echo $student_link; ?>">My Students</a>
        </li>
        <li id="adddownloadable"><a href="downloadable_teacher.php">Downloadable Materials</a></li>
        <li id="assignments">
            <a href="assignment_teacher.php?id=<?php echo isset($_SESSION['course_id']) ? $_SESSION['course_id'] : ''; ?>">Assignments</a>
        </li>

        <li id="quiz"><a href="quiz_teacher.php"?id=<?php echo isset($_SESSION['course_id']) ? $_SESSION['course_id'] : ''; ?>>Quiz</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="topbar">
            <div>JomLearn-System</div>
                <div class="user-menu" onclick="toggleMenu()">

                    <div class="topbar">
                    <div class="user-menu" onclick="toggleMenu()">
                        <i class="fas fa-user"></i> 
                        <?php 
                            echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : "Teacher"; 
                        ?>
                        <div class="user-dropdown" id="userDropdown">
                            <a href="login.php">Logout</a>
                        </div>
                    </div>
                </div>

                <div class="user-dropdown" id="userDropdown">
                    <a href="login.php">Logout</a>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            let currentPage = window.location.pathname.split("/").pop().split(".")[0];
            let menuItem = document.getElementById(currentPage);
            if (menuItem) {
                menuItem.querySelector("a").classList.add("active");
            }
        });
    </script>

        <script>
        function toggleMenu() {
            var menu = document.getElementById('userDropdown');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
        document.addEventListener('click', function(event) {
            var menu = document.getElementById('userDropdown');
            var userMenu = document.querySelector('.user-menu');
            if (!userMenu.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    </script>   
    
</body>
</html>