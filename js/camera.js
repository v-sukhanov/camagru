var camera;
var cameraWrap;
var canvas;
var startVideo;
var startVideoWrap;
var uploadForm;
var takePhotoMask;
var width = 640;
var height = 480;
var turnOffCamera;
var uploadImage;
var removeMask;
var save;

window.addEventListener('load', function() {
    camera = document.getElementById('camera');
    canvas = document.getElementById('canvas');
    startVideo = document.getElementById('startVideo');
    startVideoWrap = document.getElementById('startVideoWrap');
    uploadForm = document.getElementById('uploadForm');
    takePhotoMask = document.getElementById('takePhotoMask');
    cameraWrap = document.getElementById('cameraWrap');
    turnOffCamera = document.getElementById('turnOffCamera');
    uploadImage = document.getElementById('uploadImage');
    save = document.getElementById('save');

    startVideo.addEventListener('click', startVideoFunc);
    takePhotoMask.addEventListener('click', takePhotoFunction);
    uploadImage.addEventListener('click', uploadImg);

}, false);

function startVideoFunc(){
    canvas.style.display = 'none';
    startVideoWrap.style.display = 'none';
    uploadForm.style.display = 'none';
    camera.style.display = '';
    turnOffCamera.disabled = false;
    navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia );

    navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function(stream) {
            localstream = stream;
            camera.srcObject = stream;
            takePhotoMask.disabled = false;
        },
        function(err) {
            console.log("An error occured! " + err);
        }
    );
}

function stopVideoFunc() {
    canvas.style.display = 'none';
    startVideoWrap.style.display = '';
    uploadForm.style.display = '';
    camera.style.display = 'none';
    camera.src = "";
    turnOffCamera.disabled = true;
    takePhotoMask.disabled = true;

}

function uploadImg() {
    var file = document.querySelector('input[type=file]').files[0];
    // var newImg = document.createElement('img');
    // var reader = new FileReader();

    // if (file) {
    //     reader.readAsDataURL(file);
    // }
    if (!file) {
        return ;
    }
    var fr = new FileReader();
    // console.log(file);

    fr.onload = function () {
        startVideoWrap.style.display = 'none';
        uploadForm.style.display = 'none';
        canvas.style.display = '';
        // newImg.setAttribute('src', reader.result);
        // newImg.setAttribute('class', 'uploaded');
        // context = canvas.getContext('2d');
        // context.drawImage(newImg, 0, 0, width, height);
        img = new Image(650, 480);

        img.onload = function () {
            var ctx = canvas.getContext("2d");
            ctx.drawImage(img,0,0);
        }
        img.src = fr.result;
    }
    fr.readAsDataURL(file);
    save.disabled = false;
}

function takePhotoFunction() {
    var imgs = cameraWrap.querySelectorAll(".mask");
    if (width && height) {
        context = canvas.getContext('2d');
        context.drawImage(camera, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
    }
    camera.src = "";
    localstream.getTracks()[0].stop();
    camera.style.display = 'none';
    canvas.style.display = '';
    turnOffCamera.disabled = true;
    takePhotoMask.disabled = true;
    var imgsLenght = imgs.length;
    var i = 0;
    var parentPos = canvas.getBoundingClientRect();
    while (i < imgsLenght) {
        width = imgs[i].width;
        height = imgs[i].height;

        var childrenPos = imgs[i].getBoundingClientRect(),
        relativePos = {};

        relativePos.top = childrenPos.top - parentPos.top;
        relativePos.left = childrenPos.left - parentPos.left;
        context.drawImage(imgs[i], relativePos.left, relativePos.top, width, height);
        i++;
        cameraWrap.removeChild(cameraWrap.querySelector('.mask'))
    }
    save.disabled = false;
}

function addMontageOnPhoto(path) {
    function createIMG(src) {
        const img = document.createElement('img');
        img.setAttribute('src', src);
        img.setAttribute('class', 'mask');
        img.style.width = '100px';
        img.style.position = 'absolute';
        img.style.left = '50%';
        img.style.top = '50%';
        img.style.transform = 'translate(-50%, -50%)';
        return img;
    }
    function dragAndDrop(img) {
        var mousePosition;
        var offset = [0,0];
        var isDown = false;

        img.addEventListener('mousedown', function(e) {
            isDown = true;
            offset = [
                img.offsetLeft - e.clientX,
                img.offsetTop - e.clientY
            ];
        }, true);

        document.addEventListener('mouseup', function() {
            isDown = false;
        }, true);

        document.addEventListener('mousemove', function(event) {
            event.preventDefault();
            if (isDown) {
                mousePosition = {

                    x : event.clientX,
                    y : event.clientY

                };
                img.style.left = (mousePosition.x + offset[0]) + 'px';
                img.style.top = (mousePosition.y + offset[1]) + 'px';
            }
        }, true);
    }

    if (camera.style.display !== 'none' || canvas.style.display !== 'none') {
        const img_copy = createIMG(path);

        cameraWrap.appendChild(img_copy);
        dragAndDrop(img_copy);
    }
}

function sizeDownMask() {
    var imgs = document.getElementsByClassName('mask');
    var imgsLenght = imgs.length;
    var target;
    var width;
    var height;

    if (imgsLenght > 0) {
        target = imgs[imgsLenght - 1];
        width = target.offsetWidth;
        height = target.offsetHeight;
        if (width > 20 && height > 20) {
            width -= 5;
            height -= 5;
            target.style.height = height + 'px';
            target.style.width = width + 'px';
        }
    }
}

function sizeUpMask() {
    var imgs = document.getElementsByClassName('mask');
    var imgsLenght = imgs.length;
    var target;
    var width;
    var height;

    if (imgsLenght > 0) {
        target = imgs[imgsLenght - 1];
        width = target.offsetWidth;
        height = target.offsetHeight;
        if (width < 600 && height < 400) {
            width += 5;
            height += 5;
            target.style.width = width + 'px';
            target.style.height = height + 'px';
        }
    }
}

function removeMask() {
    var imgs = document.getElementsByClassName('mask');
    var imgsLenght = imgs.length;

    if (imgsLenght > 0) {
        imgs[imgsLenght - 1].parentNode.removeChild(imgs[imgsLenght - 1]);
    }
}

function saveImage(event) {
    save.disabled = true;
    var imgs = cameraWrap.querySelectorAll(".mask");
    var context = canvas.getContext("2d");
    var imgsLenght = imgs.length;
    var i = 0;
    var parentPos = canvas.getBoundingClientRect();
    while (i < imgsLenght) {
        width = imgs[i].width;
        height = imgs[i].height;

        var childrenPos = imgs[i].getBoundingClientRect(),
            relativePos = {};

        relativePos.top = childrenPos.top - parentPos.top;
        relativePos.left = childrenPos.left - parentPos.left;
        context.drawImage(imgs[i], relativePos.left, relativePos.top, width, height);
        i++;
        cameraWrap.removeChild(cameraWrap.querySelector('.mask'))
    }
    var request = new XMLHttpRequest();
    var img = "img=" + canvas.toDataURL("image/png");
    request.open("POST", "../controls/save_photo.php", true);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            if (request.response) {
                var response = JSON.parse(request.response);
                var noPhoto = document.getElementById('no_photo');
                if (noPhoto) {
                    noPhoto.style.display = 'none';
                }
                addItemToPage(response);
                context = canvas.getContext('2d');
                context.clearRect(0, 0, canvas.width, canvas.height);
                stopVideoFunc()
            }
        }
    };
    request.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    request.send(img);
}
