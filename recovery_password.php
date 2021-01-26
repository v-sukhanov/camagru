<?php
	session_start();
	$email = $_GET['email'];
	$hash = $_GET['hash'];
	if (!$email || !$hash) {
		header('Location: forgot_password.php');
	}
	require_once 'config/setup.php';
	$get_user_query = $connect->prepare('SELECT * from users where email=?');
	$get_user_query->execute(array($email));
	$user_result = $get_user_query->fetch();
	if (!$user_result) {
		header('Location: forgot_password.php');
	}
	if ($user_result['token'] != $hash) {
		header('Location: forgot_password.php');
	}
	$_SESSION['recovery_pass_email'] = $email;
	$_SESSION['recovery_pass_hash'] = $hash;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>recovery password</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link href="assets/css/header.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
</head>
<body>
	<?php require_once ('template/header.php')?>
	<div class="content">
		<div class="signin">
    		<div class="signin__header">
    			<span>
    				RECOVERY PASSWORD
    			</span>
    		</div>
    		<div class="signin__form">
    			<form method="post" action="../controls/recovery_password.php">
    				<div><input required minlength="8" type="password" name="password" placeholder="password"></div>
    				<div><input required minlength="8" type="password" name="confirm_password" placeholder="confirm password"></div>
    				<div><button>recovery password</button></div>
                </form>

    		</div>
    		<div class="alternative">
    			<div class="alternative__signin">
    				<a href="signup.php">
                        Create account
                    </a>
    			</div>
    			<div class="alternative__forgot-password">
                    <a href="signin.php">
                        Sign in
                    </a>
                </div>
    		</div>
    		<?php
                if (isset($_SESSION['recovery_password_error'])) {
                    echo '<div class="error-msg">' . $_SESSION['recovery_password_error'] . '</div>';
                    unset($_SESSION['recovery_password_error']);
                }
            ?>
    	</div>
	</div>

</body>
