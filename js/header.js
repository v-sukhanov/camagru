
var open = false;
window.addEventListener('load', function() {
    var links = document.getElementById('links')
    document.getElementById('burger').addEventListener('click', function() {
        if (!open) {
            links.style.height = 'initial';
            open = true;
        } else {
            links.style.height = '0';
            open = false;
        }
    })
});
