<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	    header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
	    exit();
	}
	session_start();
	require_once '../config/setup.php';
	require_once '../vendors/email.php';
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	if (!$name || !$email || !$password || !$confirm_password) {
		$_SESSION['signup_error']= 'fill all the fields';
        header('Location: ../signup.php');
        exit();
	}
	if ($password != $confirm_password) {
		$_SESSION['signup_error']= 'password is not equal confirmed password';
        header('Location: ../signup.php');
        exit();
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['signup_error']= 'invalid email';
      header('Location: ../signup.php');
      exit();
    }
    if (strlen($name) > 15 || strlen($name) < 3) {
        $_SESSION['signup_error'] = 'name should be between 3 and 15 characters';
        header('Location: ../signup.php');
        exit();
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $_SESSION['signup_error'] = 'password should be include at least one uppercase character';
        header('Location: ../signup.php');
        exit();
    }
    if (strlen($password) > 25) {
        $_SESSION['signup_error'] = 'password should be between 8 and 25 characters';
        header('Location: ../signup.php');
        exit();
    }
    try {
        $user_with_email_query = $connect->prepare("SELECT * FROM users where email=?");
        $user_with_email_query->execute(array($email));
		if ($user_with_email_query->fetch()) {
			$_SESSION['signup_error'] = 'user with this email exists';
            header('Location: ../signup.php');
            exit();
		}
        $user_with_name_query = $connect->prepare("SELECT * FROM users where name=?");
        $user_with_name_query->execute(array($name));
        if($user_with_name_query->fetch()){
            $_SESSION['signup_error'] = 'user with this name exists';
            header('Location: ../signup.php');
            exit();
        }
        $hash_password = hash('md5', $password);
        $token = hash('md5', rand(0, 77777));
        $add_user_query = $connect->prepare("INSERT INTO users (name, password, email, token) VALUES (?, ?, ?, ?)");
        $add_user_query->execute(array($name, $hash_password, $email, $token));
        email_verify($email, $name, $token);
        echo '  <script type="text/javascript">
                    alert("please verify your email.");
                    window.location = "../signin.php";
                    </script>';
    } catch (Throwable $exception) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }

?>
