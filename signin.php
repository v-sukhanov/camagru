<?php
	session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>signin</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href="assets/css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
</head>
<body>
	<?php require_once ('template/header.php')?>
	<div class="content">
		<div class="signin">
    		<div class="signin__header">
    			<span>
    				SIGNIN
    			</span>
    		</div>
    		<div class="signin__form">
    			<form method="post" action="../controls/signin.php">
    					<div><input required minlength="3" type="text" name="name" placeholder="username"></div>
    					<div><input required minlength="8" type="password" name="password" placeholder="password"></div>
    					<div><button>sign in</button></div>
                </form>

    		</div>
    		<div class="alternative">
    			<div class="alternative__signin">
    				<a href="signup.php">
                        Create account
                    </a>
    			</div>
    			<div class="alternative__forgot-password">
                    <a href="forgot_password.php">
                        Forgot password?
                    </a>
                </div>
    		</div>
    		<?php
                if (isset($_SESSION['signin_error'])) {
                    echo '<div class="error-msg">' . $_SESSION['signin_error'] . '</div>';
                    unset($_SESSION['signin_error']);
                }
            ?>
    	</div>
	</div>

</body>
