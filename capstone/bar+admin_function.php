<?php
session_start(); 
?>
<div style="background-color: #2c3e50; padding: 10px; color: white; text-align: right;">
    JomLearn-System | Logged in as: 
    <strong>
        <?php 
        if (isset($_SESSION['admin_fullname']) && !empty($_SESSION['admin_fullname'])) {
            echo $_SESSION['admin_fullname']; 
        } else {
            echo "Admin"; 
        }
        ?>
    </strong>
</div>
