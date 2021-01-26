<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
    if (!isset($_SESSION['logged_name'])) {
        exit();
    }
    header("Content-Type: application/json");
    require_once '../config/setup.php';
    require_once '../vendors/email.php';

    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $postId = $data['postId'];
        $text = $data['text'];

		$set_comment_query = $connect->prepare("INSERT INTO comments(post_id, name, text) VALUES(?, ?, ?)");
		$set_comment_query->execute(array($postId, $_SESSION['logged_name'], $text));
		$count_comment_query = $connect->prepare("SELECT * FROM comments WHERE post_id=?");
		$count_comment_query->execute(array($postId));
		if ($_SESSION['email_verify']) {
            comment_verify($_SESSION['logged_email'], $_SESSION['logged_name'], $text);
		}
		echo $count_comment_query->rowCount();
    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }
?>
