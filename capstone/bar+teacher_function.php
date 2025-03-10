<?php
session_start(); 
?>
<div style="background-color: #2c3e50; padding: 10px; color: white; text-align: right;">
    JomLearn-System | Logged in as: 
    <strong>
        <?php 
        if (isset($_SESSION['fullname']) && !empty($_SESSION['fullname'])) {
            echo $_SESSION['fullname']; 
        } else {
            echo "Teacher"; 
        }
        ?>
    </strong>
</div>
