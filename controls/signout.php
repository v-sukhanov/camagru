<?php
	session_start();
    unset($_SESSION['logged_name']);
    unset($_SESSION['logged_email']);
    header('Location: ../index.php');
?>
