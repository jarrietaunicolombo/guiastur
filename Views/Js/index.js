document.getElementById('hamburger').addEventListener('click', function () {
    var menu = document.getElementById('menu');
    if (menu.style.left === '0px') {
        menu.style.left = '-250px';
    } else {
        menu.style.left = '0px';
    }
});