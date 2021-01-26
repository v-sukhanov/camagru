<?php
	session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>signup</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href="assets/css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
</head>
<body>
	<?php require_once ('template/header.php')?>
	<div class="content">
		<div class="signup">
    		<div class="signup__header">
    			<span>
    				SIGNUP
    			</span>
    		</div>
    		<div class="signup__form">
    			<form method="post" action="../controls/signup.php">
    					<div><input required type="text" name="name" placeholder="username"></div>
    					<div><input required type="email" name="email" placeholder="email"></div>
    					<div><input required type="password" name="password" placeholder="password"></div>
    					<div><input required type="password" name="confirm_password" placeholder="confirm password"></div>
    					<div><button>sign up</button></div>
                </form>

    		</div>
    		<?php
                if (isset($_SESSION['signup_error'])) {
                    echo '<div class="error-msg">' . $_SESSION['signup_error'] . '</div>';
                    unset($_SESSION['signup_error']);
                }
            ?>
    	</div>
	</div>

</body>
