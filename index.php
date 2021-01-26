<?php
	session_start();
?>
<html>
	<head>
	    <meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
        <link href="assets/css/index.css" rel="stylesheet">
        <link href="assets/css/header.css" rel="stylesheet">
        <link href="assets/css/sidebar.css" rel="stylesheet">
        <link href="assets/css/controls.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
              rel="stylesheet">
		<title>Camagru</title>
	</head>
	<body>
		<?php require_once ('template/header.php')?>
		<div class="content">
			<div class="gallery" id="gallery">
			</div>
		</div>

	</body>
     <script type="text/javascript" src="js/gallery.js"></script>
</html>
