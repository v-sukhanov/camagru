<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
	require_once '../config/setup.php';
	require_once '../vendors/email.php';
	$email = $_POST['email'];
	if (!$email) {
		$_SESSION['forgot_password_error'] = 'fill email field';
        header('Location: ../forgot_password.php');
        exit();
	}
	try {
		$user_email_query = $connect->prepare('SELECT * FROM users where email=?');
        $user_email_query->execute(array($email));
        $data = $user_email_query->fetch();
        if (!$data['email']) {
            $_SESSION['forgot_password_error'] = 'this email doesnt exists';
            header('Location: ../forgot_password.php');
            exit();
        }
       // $insert_password_hash = $connect->prepare("INSERT INTO user_forgot_password_hash (user_id, hash) VALUES(?, ?)");
        forgot_password($email, $data['name'], $data['token']);
        echo '  <script type="text/javascript">
            alert("please check your email.");
            window.location = "../signin.php";
            </script>';
	} catch (Throwable $exception) {
		header('HTTP/1.1 500 Internal Server Error');
        exit();
	}
?>
