<?php
	session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>recovery password</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href="assets/css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/signup.css"
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
</head>
<body>
	<?php require_once ('template/header.php')?>
	<div class="content">
		<div class="signin">
    		<div class="signin__header">
    			<span>
    				FORGOT PASSWORD
    			</span>
    		</div>
    		<div class="signin__form">
    			<form method="post" action="../controls/forgot_password.php">
    				<div><input required type="email" name="email" placeholder="email"></div>
    				<div><button>send recovery link to email</button></div>
                </form>

    		</div>
    		<div class="alternative">
    			<div class="alternative__signin">
    				<a href="signup.php">
                        Create account
                    </a>
    			</div>
    		</div>
    		<?php
                if (isset($_SESSION['forgot_password_error'])) {
                    echo '<div class="error-msg">' . $_SESSION['forgot_password_error'] . '</div>';
                    unset($_SESSION['forgot_password_error']);
                }
            ?>
    	</div>
	</div>

</body>
