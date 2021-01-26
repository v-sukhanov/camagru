<?php
	session_start();
    if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
    header("Content-Type: application/json");
	require_once '../config/setup.php';
    try {
        $last_element_date = json_decode(file_get_contents('php://input'), true)['last_element_date'];
        if ($last_element_date) {
            $get_gallery_query = $connect->prepare("SELECT *,
            (SELECT COUNT(*) FROM likes WHERE post_id=posts.id) as count_like,
            (SELECT COUNT(*) FROM comments WHERE post_id=posts.id) as count_comment
            FROM posts WHERE postdate < ? ORDER BY postdate DESC LIMIT 5");
            $get_gallery_query->execute(array($last_element_date));
        } else {
            $get_gallery_query = $connect->prepare("SELECT *,
            (SELECT COUNT(*) FROM likes WHERE post_id=posts.id) as count_like,
            (SELECT COUNT(*) FROM comments WHERE post_id=posts.id) as count_comment
            FROM posts ORDER BY postdate DESC LIMIT 5");
        }
        $get_gallery_query->execute();
		echo json_encode($get_gallery_query->fetchAll());
    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }
?>
