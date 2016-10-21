<?php
session_start();

unset($_SESSION['useremail']);
unset($_SESSION['usernickname']);

header("location:../mydesk.php");
?>