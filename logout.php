<?php
    session_start();
    unset($_SESSION["mobile"]);
   unset($_SESSION["password"]);
    session_destroy();
    header("location:index.php");
?>