<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	    header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
	    exit();
	}
	require_once 'database.php';

	try {
		$connect = new PDO("mysql:host=$DB_HOST", $DB_USER, $DB_PASSWORD);
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->exec("CREATE DATABASE IF NOT EXISTS $DB_NAME");
		$connect->exec("use $DB_NAME");
		$connect->exec("CREATE TABLE IF NOT EXISTS users (
					id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    notification BOOLEAN NOT NULL DEFAULT true,
                    token VARCHAR(255) NOT NULL,
                    verified BOOLEAN NOT NULL DEFAULT false)");
        $connect->exec("CREATE TABLE IF NOT EXISTS posts (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			    name VARCHAR(255) NOT NULL,
			    img VARCHAR(255) NOT NULL,
			    postdate DATETIME NOT NULL)");
		$connect->exec("CREATE TABLE IF NOT EXISTS likes (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    post_id INT(9) UNSIGNED,
                    name VARCHAR(255) NOT NULL,
                    FOREIGN KEY (post_id) REFERENCES posts (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE)");
         $connect->exec("CREATE TABLE IF NOT EXISTS comments (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            post_id INT(9) UNSIGNED,
            name VARCHAR(255) NOT NULL,
            text VARCHAR(255) NOT NULL,
            FOREIGN KEY (post_id) REFERENCES posts (id)
                ON DELETE CASCADE
                ON UPDATE CASCADE)");
	} catch (PDOException $e) {
		header('HTTP/1.1 500 Internal Server Error');
        exit();
	}
?>
