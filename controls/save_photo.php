<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
        exit();
    }
    if (!empty($_POST['img'])) {
        if (!file_exists("../assets/imgs/uploads/")) {
            mkdir ("../assets/imgs/uploads/");
        }
        $img = $_POST['img'];
        $img_coded = str_replace(' ', '+', explode(";base64,", $img )[1]);
        $image_base64 = base64_decode($img_coded);
        $fileName = uniqid() . '.png';
        $file = "/assets/imgs/uploads/" . $fileName;
        file_put_contents($_SERVER["DOCUMENT_ROOT"].$file, $image_base64);
        require_once '../config/setup.php';
        try {
            date_default_timezone_set( 'Europe/Moscow' );
            $name = $_SESSION['logged_name'];
            $date = date('Y-m-d H:i:s');
            $insert_post_query = $connect->prepare("INSERT INTO posts (name, img, postdate) VALUES (?, ?, ?)");
            $insert_post_query->execute(array($name, $file, $date));
            $get_post_query = $connect->prepare("SELECT * FROM posts WHERE postdate=?");
            $get_post_query->execute(array($date));
            $user_post = $get_post_query->fetch();
            echo json_encode($user_post);
        } catch(PDOException $e) {
        	header('HTTP/1.1 500 Internal Server Error');
            exit();
        }
    }
?>
