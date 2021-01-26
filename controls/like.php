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

    try {
        $postId = json_decode(file_get_contents('php://input'), true)['postId'];
        $check_like_count_query = $connect->prepare("SELECT * FROM likes WHERE name=? and post_id=?");
        $check_like_count_query->execute(array($_SESSION['logged_name'], $postId));
        if ($check_like_count_query->fetch()) {

            $delete_like_query = $connect->prepare("DELETE FROM likes WHERE name=? and post_id=?");
            $delete_like_query->execute(array($_SESSION['logged_name'], $postId));
        } else {
            $set_like_query = $connect->prepare("INSERT INTO likes(name, post_id) VALUES(?, ?)");
            $set_like_query->execute(array($_SESSION['logged_name'], $postId));
        }
        $like_count_query = $connect->prepare("SELECT * FROM likes WHERE post_id=?");
        $like_count_query->execute(array($postId));
        echo $like_count_query->rowCount();

    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }
?>
