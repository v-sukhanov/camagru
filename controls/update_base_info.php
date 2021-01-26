<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }

    $email = $_POST['email'];
    $name = $_POST['name'];
    $email_verify_checked = isset($_POST['email_verify']) ? 1 : 0;
    if (!$name || !$email) {
        $_SESSION['change_basic_info_error']= 'fill all the fields';
        header('Location: ../settings.php');
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['change_basic_info_error']= 'invalid email';
      header('Location: ../settings.php');
      exit();
    }
    if (strlen($name) > 15 || strlen($name) < 3) {
        $_SESSION['change_basic_info_error'] = 'name should be between 3 and 15 characters';
        header('Location: ../settings.php');
        exit();
    }
    require_once '../config/setup.php';
    require_once '../vendors/email.php';
    try {
        $token = hash('md5', rand(0, 77777));
	    if ($name != $_SESSION['logged_name']) {
            $update_user_query = $connect->prepare("UPDATE users SET name=?, token=? WHERE name=?");
            $update_user_query->execute(array($name, $token, $_SESSION['logged_name']));
            $_SESSION['logged_name'] = $name;
	    }
        if ($email != $_SESSION['logged_email']) {
            email_verify($email, $name, $token);
            $update_user_query = $connect->prepare("UPDATE users SET email=?, token=?, verified=? WHERE name=?");
            $update_user_query->execute(array($email, $token, 0, $_SESSION['logged_name']));
            unset($_SESSION['logged_email']);
            unset($_SESSION['logged_name']);
            echo '  <script type="text/javascript">
                alert("please verify your new email.");
                window.location = "../settings.php";
                </script>';
	        exit();
        }
        $update_user_query = $connect->prepare("UPDATE users SET token=?, notification=? WHERE name=?");
        $update_user_query->execute(array($token, $email_verify_checked, $_SESSION['logged_name']));
        $_SESSION['email_verify'] = $email_verify_checked;
        header('Location: ../settings.php');
	} catch (Throwable $exception) {
	   header('HTTP/1.1 500 Internal Server Error');
	   exit();
	}

?>
