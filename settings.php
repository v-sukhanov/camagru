<?php
	session_start();
	if (!$_SESSION['logged_name']) {
		header('Location: signin.php');
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>settings</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href="assets/css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/signup.css">
    <link href="assets/css/settings.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
</head>
<body>
	<?php require_once ('template/header.php')?>
	<div class="content">
		<div class="content__header">
			<span>
				Edit your profile
			</span>
		</div>
		<div class="signup">
    		<div class="signup__header">
    			<span>
    				Your basic info
    			</span>
    		</div>
    		<div class="signup__form">
    			<form method="post" action="../controls/update_base_info.php">
                    <div><input minlength="3" required type="text" name="name" placeholder="username" value=<?php echo $_SESSION['logged_name'];?>></div>
                    <div><input required type="email" name="email" placeholder="email" value=<?php echo $_SESSION['logged_email'];?>></div>
                    <div class="email_verify">
                        <?php
                            if ($_SESSION['email_verify']) {
                                echo '<input type="checkbox" id="email_verify" name="email_verify" checked>';
                            } else {
                                echo '<input type="checkbox" id="email_verify" name="email_verify">';
                            }
                        ?>
                        Do you want to receive email notification when someone comments on your post?
                    </div>
                    <div><button>edit</button></div>
                </form>
    		</div>
    		<?php
                if (isset($_SESSION['signup_error'])) {
                    echo '<div class="error-msg">' . $_SESSION['signup_error'] . '</div>';
                    unset($_SESSION['change_basic_info_error']);
                }
            ?>
    	</div>
    	<div class="signup">
            <div class="signup__header">
                <span>
                    Change password
                </span>
            </div>
            <div class="signup__form">
                <form method="post" action="../controls/change_password.php">
                    <div><input minlength="8" required type="password" name="old_password" placeholder="old password"></div>
                    <div><input minlength="8" required type="password" name="new_password" placeholder="new password"></div>
                    <div><input minlength="8" required type="password" name="new_confirm_password" placeholder="confirm new password"></div>
                    <div><button>change password</button></div>
                </form>
            </div>
            <?php
                if (isset($_SESSION['change_password_error'])) {
                    echo '<div class="error-msg">' . $_SESSION['change_password_error'] . '</div>';
                    unset($_SESSION['change_password_error']);
                }
            ?>
        </div>
	</div>

</body>
