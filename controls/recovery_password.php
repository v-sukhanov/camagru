<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
    require_once '../config/setup.php';
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$email = $_SESSION['recovery_pass_email'];
	$hash = $_SESSION['recovery_pass_hash'];
	if (!$password || !$confirm_password) {
		$_SESSION['recovery_password_error']= 'fill all fields';
        header('Location: ../recovery_password.php?email='.$email.'&hash='.$hash);
        exit();
	}
	if ($password != $confirm_password) {
        $_SESSION['recovery_password_error']= 'password is not equal confirmed password';
        header('Location: ../recovery_password.php?email='.$email.'&hash='.$hash);
        exit();
    }
    if (strlen($password) > 25 || strlen($password) < 8) {
        $_SESSION['recovery_password_error'] = 'password should be between 8 and 25 characters';
        header('Location: ../recovery_password.php?email='.$email.'&hash='.$hash);
        exit();
    }
    $email =  $_SESSION['recovery_pass_email'];
    $hash = $_SESSION['recovery_pass_hash'];
    $get_user_query = $connect->prepare('SELECT * from users where email=?');
    $get_user_query->execute(array($email));
    $user_result = $get_user_query->fetch();
    if (!$user_result) {
        header('Location: ../recovery_password.php');
    }
    if (!$user_result['token'] != $hash) {
        header('Location: ../recovery_password.php');
    }
    try {
        $update_password_query = $connect->prepare('UPDATE users SET password=? WHERE email=?');
        $hash_password = hash('md5', $password);
        $update_password_query->execute(array($hash_password, $email));
        header('Location: ../signin.php');
    } catch (Throwable $exception) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }

?>
