<?php
	session_start();
    if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
    header("Content-Type: application/json");
    require_once '../config/setup.php';
    try {
        $id = json_decode(file_get_contents('php://input'), true)['id'];
        $get_file_name_query = $connect->prepare("SELECT img FROM posts WHERE id=?");
        $get_file_name_query->execute(array($id));
        unlink($_SERVER["DOCUMENT_ROOT"].$get_file_name_query->fetch()['img']);
        $delete_post_query = $connect->prepare("DELETE FROM posts WHERE id=?");
        $delete_post_query->execute(array($id));
    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        exit();
    }
?>
