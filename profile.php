<?php
	session_start();
	if (!$_SESSION['logged_name']) {
		header('Location: signin.php');
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>profile</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href="assets/css/header.css" rel="stylesheet">
    <link href="assets/css/profile.css" rel="stylesheet">
    <link href="assets/css/sidebar.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
</head>
<body>
	<?php require_once ('template/header.php')?>
    <div class="profile__content">
        <div class="content-box">
        <div class="content__left-side">
                    <div class="camera" id="cameraWrap">
                        <video style="display: none;" id="camera" width="640" height="480" autoplay>Video stream not available.</video>
                        <canvas style="display: none;" id="canvas" width="640" height="480"></canvas>

                        <div class="camera__action">
        	                <div id="startVideoWrap" class="start-video-wrap">
        	                    <button id="startVideo">
                                    <i class="material-icons">camera_alt</i>
                                </button>
        	                </div>

                            <div class="upload-file__form" id="uploadForm" method="post" enctype="multipart/form-data">
                                    Select image to upload:
                                <br/>
                                <br/>
                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                <br/>
                                <br/>
                                <button  id="uploadImage">
                                    Upload Image
                                </button>
                            </div>
                        </div>

                    </div>
                    </br>
        			<div>
        				<button  id="turnOffCamera" onclick="stopVideoFunc()" disabled>
                            Turn off Camera
                        </button>
        			</div>

                    <div class="photo__action">

                        <button id="sizeUpMask" type="button" onclick="sizeUpMask()"><i class="material-icons">add</i></button>
                        <button id="sizeDownMask" type="button" onclick="sizeDownMask()"><i class="material-icons">remove</i></button>
                        <button id="removeMask" type="button" onclick="removeMask()"><i class="material-icons">delete</i></button>
                        <button id="takePhotoMask" type="button" disabled><i class="material-icons">camera_enhance</i></button>
                    </div>
                    <br/>
                    <div>
                        <span>
                            Add Mask:
                        </span>
                    </div>
                    <div>
                        <div class="photo-montages">
                            <div>
                                <img class="montage-img" src="assets/imgs/mustaches.png" onclick="addMontageOnPhoto('assets/imgs/mustaches.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/shark.png" onclick="addMontageOnPhoto('assets/imgs/shark.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/anonymous.png" onclick="addMontageOnPhoto('assets/imgs/anonymous.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/medical_mask.png" onclick="addMontageOnPhoto('assets/imgs/medical_mask.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/cones.png" onclick="addMontageOnPhoto('assets/imgs/cones.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/approved.png" onclick="addMontageOnPhoto('assets/imgs/approved.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/denied.png" onclick="addMontageOnPhoto('assets/imgs/denied.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/snoop_dogg.png" onclick="addMontageOnPhoto('assets/imgs/snoop_dogg.png')">
                            </div>
                            <div>
                                <img class="montage-img" src="assets/imgs/spongebob.png" onclick="addMontageOnPhoto('assets/imgs/spongebob.png')">
                            </div>
                        </div>
                        <button id="save" type="button" disabled onclick="saveImage()">save</button>
                    </div>
                </div>
            <?php require_once ('template/sidebar.php')?>
        </div>
    </div>
     <script type="text/javascript" src="js/camera.js"></script>
</body>
