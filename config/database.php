<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	    header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
	    exit();
	}
    $DB_HOST = '127.0.0.1';
    $DB_PORT = '7777';
    $DB_USER = 'gorislav';
    $DB_PASSWORD = 'cew100bth';
    $DB_NAME = 'camagru';
?>
