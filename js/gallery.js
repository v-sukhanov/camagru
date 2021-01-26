
var posts = [];
var loading = false;
window.addEventListener('load', function() {
    getGalleryList(null);
});

window.addEventListener('scroll', function() {
    if (Math.ceil(window.innerHeight + window.scrollY) >= document.body.offsetHeight && loading !== true) {
        if (posts) {
            getGalleryList(posts[posts.length - 1].postdate);
        }
    }
});

function getGalleryList(last_element_date) {
    loading = true;
    var req = new XMLHttpRequest();
    req.open("POST", '../controls/getGallery.php', true);
    req.setRequestHeader("Content-Type", "application/json");
    req.onreadystatechange = function() {
        if (req.readyState === 4 && req.status === 200) {
            if (req.response) {
                posts = posts.concat(JSON.parse(req.response));
                JSON.parse(req.response).forEach(function(post) {
                    insertPost(post);
                });
                loading = false;
            }
        }
    }
    req.send(JSON.stringify({last_element_date: last_element_date}));
}

function like(postId) {
    var req = new XMLHttpRequest();
    req.open("POST", '../controls/like.php', true);
    req.setRequestHeader("Content-Type", "application/json");
    req.onreadystatechange = function() {
        if (req.readyState === 4 && req.status === 200) {
            if (req.response || req.response === 0) {
                var post_like = document.getElementById(`post_like${postId}`);
                post_like.innerHTML = req.response;
            } else {
                alert("please log in if you wanna do this action")
            }

        }
    }
    req.send(JSON.stringify({postId: postId}));
}

function insertPost(post) {
    var gallery = document.getElementById('gallery');
    gallery.innerHTML += `
        <div class="post" id="post${post.id}">
            <div>
                <img src="${post['img']}">
            </div>
            <div class="post__action">
                <div class="post__action__header">
                    <div class="like">
                        <div class="like_count" id="post_like${post.id}">
                            ${post['count_like']}
                        </div>
                        <div class="like_icon" onclick="like(${post['id']})">
                            <i class="material-icons">thumb_up_alt</i>
                        </div>
                    </div>
                    <div class="comment">
                        count comment: 
                        <span id="count_comment${post.id}">${post['count_comment']}</span>
                    </div>
                </div>
                <div>
                    <textarea id="textarea${post.id}" placeholder="type a comment" rows="2" cols="2"></textarea>
                    </br>
                    </br>
                    <button id="send_comment" class="secondary-button" onclick="sendComment(${post.id})">commit</button>
                </div>
            </div>
        </div>
    `;
}

function sendComment(postId) {
    var textarea = document.getElementById(`textarea${postId}`);
    var req = new XMLHttpRequest();
    req.open("POST", '../controls/set_comment.php', true);
    req.setRequestHeader("Content-Type", "application/json");
    req.onreadystatechange = function() {
        if (req.readyState === 4 && req.status === 200) {
            textarea.value = '';
            if (req.response) {
                var comment = document.getElementById(`count_comment${postId}`);
                comment.innerHTML = req.response;
            } else {
                alert("please log in if you wanna do this action")
            }
        }
    }
    req.send(JSON.stringify({postId: postId, text: textarea.value}))
}
