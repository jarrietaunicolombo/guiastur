document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const menu = document.getElementById('menu');

    if (hamburger && menu) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            menu.classList.toggle('active');
        });
    } else {
        console.error("Hamburger menu elements not found");
    }
});
