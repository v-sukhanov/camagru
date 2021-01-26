<?php
	require_once '../config/setup.php';
	$email = $_GET['email'];
	$hash = $_GET['hash'];
	try {
		$check_user_token = $connect->prepare("SELECT token FROM users WHERE email=?");
		$check_user_token->execute(array($email));
        if ($check_user_token->fetch()['token'] === $hash) {
            $set_user_verified = $connect->prepare("UPDATE users SET verified=? where email=?");
            $set_user_verified->execute(array(1, $email));
        }
        header('Location: ../signin.php');
	} catch(Throwable $exception) {
		header('HTTP/1.1 500 Internal Server Error');
        exit();
	}

?>
