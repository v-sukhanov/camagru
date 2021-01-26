<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_confirm_password = $_POST['new_confirm_password'];
    if (!$old_password || !$new_password || !$new_confirm_password) {
        $_SESSION['change_password_error']= 'fill all the fields';
        header('Location: ../settings.php');
        exit();
    }
    if (!preg_match('/[A-Z]/', $new_password)) {
        $_SESSION['change_password_error'] = 'password should be include at least one uppercase character';
        header('Location: ../settings.php');
        exit();
    }
    if (strlen($new_password) > 25) {
        $_SESSION['change_password_error'] = 'password should be between 8 and 25 characters';
        header('Location: ../settings.php');
        exit();
    }
    if ($new_password != $new_confirm_password) {
        $_SESSION['change_password_error']= 'password is not equal confirmed password';
        header('Location: ../settings.php');
        exit();
    }
    require_once '../config/setup.php';
    try {
        $check_old_password_query = $connect->prepare("SELECT * FROM users WHERE name=? and password=?");
        $check_old_password_query->execute(array($_SESSION['logged_name'], hash('md5', $old_password)));
        $check_old_password = $check_old_password_query->fetch();
        if (!$check_old_password) {
            $_SESSION['change_password_error']= 'invalid old password';
            header('Location: ../settings.php');
            exit();
        }
        $update_password_query = $connect->prepare("UPDATE users SET password=? WHERE name=?");
        $update_password_query->execute(array(hash('md5', $new_password), $_SESSION['logged_name']));
        header('Location: ../settings.php');
	} catch (Throwable $exception) {
	   header('HTTP/1.1 500 Internal Server Error');
	   exit();
	}

?>
