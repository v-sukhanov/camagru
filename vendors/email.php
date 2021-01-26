
<?php
	function email_verify($email, $name, $hash) {
		$to = $email;
		$subject = 'Verification email';
		$message = '
		Thanks for signing up to Camagru by mgorczan!
		<br/>
		'.$name.'
		<br/>
		Please click this link to activate your account:
		<br/>
		<a href="http://localhost:7777/controls/email-verify.php?email='.$email.'&hash='.$hash.'">here</a>
		';

		$headers = 'From:no-reply@Camagru.com' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
        /*echo $to;
        echo $subject;
        echo $message;
        echo $headers;*/
		mail($to, $subject, $message, $headers);
	}

	function forgot_password($email, $name, $hash) {
        $to = $email;
        $subject = 'recovery password';
        $message =
        $name.'
            <br/>
            Please click this link to recovery your password:
            <br/>
            <a href="http://localhost:7777/recovery_password.php?email='.$email.'&hash='.$hash.'">here</a>
        ';

        $headers = 'From:no-reply@Camagru.com' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
        /*echo $to;
        echo $subject;
        echo $message;
        echo $headers;*/
        mail($to, $subject, $message, $headers);
    }

	function comment_verify($email, $name, $comment) {
        $to = $email;
        $subject = 'new comment';
        $message =
        $name.'
            <br/>
            You have a new comment:<br/>'.$comment.
            '<br/>
        ';

        $headers = 'From:no-reply@Camagru.com' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
        /*echo $to;
        echo $subject;
        echo $message;
        echo $headers;*/
        mail($to, $subject, $message, $headers);
    }
?>
