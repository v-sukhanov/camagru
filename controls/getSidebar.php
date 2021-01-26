<?php
	session_start();
    if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
	header("Content-Type: application/json");
    require_once '../config/setup.php';
    if (!isset($_SESSION['logged_name'])) {
        exit();
    }
	try {
		$get_sidebar_request = $connect->prepare("SELECT * FROM posts WHERE name=? ORDER BY postdate DESC");
		$get_sidebar_request->execute(array($_SESSION['logged_name']));
		if ($posts = $get_sidebar_request->fetchAll()) {
            echo json_encode($posts);
        }
	} catch(PDOException $e) {
		header('HTTP/1.1 500 Internal Server Error');
        exit();
	}
?>
