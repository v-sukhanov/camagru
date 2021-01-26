<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
	session_start();
	require_once '../config/setup.php';
	$name = $_POST['name'];
	$password = $_POST['password'];
	if (!$name || !$password) {
        $_SESSION['signin_error']= 'fill all the fields';
        header('Location: ../signin.php');
        exit();
    }
    if (strlen($name) > 15 || strlen($name) < 3) {
            $_SESSION['signin_error'] = 'name should be between 3 and 15 characters';
            header('Location: ../signin.php');
            exit();
    }
    if (strlen($password) > 25 || strlen($password) < 8) {
        $_SESSION['signin_error'] = 'password should be between 8 and 25 characters';
        header('Location: ../signin.php');
        exit();
    }
      try {
         $hash_password = hash('md5', $password);
         $user_with_name = $connect->prepare("SELECT * FROM users where name=? AND password=?");
         $user_with_name->execute(array($name, $hash_password));
         $data = $user_with_name->fetch();
         if (!$data) {
             $_SESSION['signin_error'] = 'invalid name or password';
             header('Location: ../signin.php');
             exit();
         }
         if (!$data['verified']) {
             $_SESSION['signin_error'] = 'please verify your email';
             header('Location: ../signin.php');
             exit();
         }
         $_SESSION['logged_name'] = $name;
         $_SESSION['logged_email'] = $data['email'];
         $_SESSION['email_verify'] = $data['notification'];
		header('Location: ../index.php');
      } catch (Throwable $exception) {
          header('HTTP/1.1 500 Internal Server Error');
          exit();
      }


?>
