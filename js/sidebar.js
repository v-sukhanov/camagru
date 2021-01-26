

var arrayData = [];
var firstIndexOnPage;
var lastIndexOnPage;
var currentPage;
var maxPage;
var arrayLength;

const pageSize = 3;

window.addEventListener('load', function() {
    getSidebar()
})

function getSidebar() {
    var request = new XMLHttpRequest();
    request.open("POST", '../controls/getSidebar.php', true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.response) {
                var response = JSON.parse(request.response);
                createPaginator(response, pageSize);

            } else {
                document.getElementById('sidebar_content').innerHTML = '<span class="no_photo" id="no_photo">You have no photo</span>';
            }
        }
    };
    request.send();
}

function deletePost(id) {
    var req = new XMLHttpRequest();
    req.open("POST", '../controls/delete_post.php', true);
    req.setRequestHeader("Content-Type", "application/json");
    req.onreadystatechange = function() {
        if (req.readyState === 4 && req.status === 200) {
            arrayData = arrayData.filter(function(val) {
                return val.id != id;
            });
            createPaginator(arrayData, pageSize);
        }
    }
    req.send(JSON.stringify({id: id}));
}

function createPaginator(arr, pageSize) {
    var paginator = document.getElementById('paginator');
    paginator.innerHTML = `
            <div id="paginator_label">
            </div>
            <div class="paginator__arrows">
                <div class="left-arrow" onclick="prevPage()">
                    <img src="../assets/imgs/common/left-arrow.svg">
                </div>
                <div class="right-arrow" onclick="nextPage()">
                    <img src="../assets/imgs/common/right-arrow.svg">
                </div>
            </div>
    `
    arrayData = arr;
    arrayLength = arrayData.length;
    var temp = arrayLength / pageSize;
    if (temp !== 1) {
        maxPage = Math.floor(((temp % 2 === 0) && temp) ? temp : temp + 1);
    } else {
        maxPage = 1;
    }
    currentPage = 1;
    firstIndexOnPage = 1;
    if (arrayLength < pageSize) {
        lastIndexOnPage = arrayLength;
    } else {
        lastIndexOnPage = pageSize;
    }


    displayPage(arr.slice(firstIndexOnPage - 1, lastIndexOnPage));
}

function clearPage() {
    var sidebar = document.getElementById('sidebar_content');
    sidebar.innerHTML = '';
}

function displayPage(arr) {
    clearPage();
    var sidebar = document.getElementById('sidebar_content');
    var paginator_span = document.getElementById('paginator_label')
    paginator_span.innerHTML = `
        ${firstIndexOnPage} of ${lastIndexOnPage} / ${arrayLength}
    `;
    arr.forEach(function (post) {
        sidebar.innerHTML += `
        <div id="post-${post['id']}" class="recently-post">
            <div class="recently-post__photo">
                <img src="${post['img']}">
            </div>
            <div class="recently-post__action">
                <button onclick="deletePost(${post['id']})"><i class="material-icons">delete</i></button>
            </div>
        </div>
        `;
    });
}

function addItemToPage(item) {
    arrayData.unshift(item);
    createPaginator(arrayData, pageSize);
}

function nextPage() {
    if (currentPage === maxPage) {
        return ;
    }
    currentPage++;
    firstIndexOnPage += pageSize;
    if (lastIndexOnPage + pageSize > arrayLength) {
        lastIndexOnPage = arrayLength;
    } else {
        lastIndexOnPage += pageSize;
    }
    displayPage(arrayData.slice(firstIndexOnPage - 1, lastIndexOnPage));
}

function prevPage() {
    if (currentPage === 1) {
        return ;
    }
    currentPage--;
    firstIndexOnPage -= pageSize;
    if (firstIndexOnPage + pageSize <= arrayLength) {
        lastIndexOnPage = firstIndexOnPage + pageSize - 1;
    } else {
        lastIndexOnPage = arrayLength;
    }
    if (currentPage === 1) {
        lastIndexOnPage = pageSize;
    }
    displayPage(arrayData.slice(firstIndexOnPage - 1, lastIndexOnPage));
}
