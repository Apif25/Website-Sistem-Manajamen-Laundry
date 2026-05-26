document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const sideBar = document.querySelector('.side-bar');
    const overlay = document.getElementById('sidebarOverlay');
    const openIcon = document.querySelector('.open-icon');
    const closeIcon = document.querySelector('.close-icon');

    function toggleMenu() {
        sideBar.classList.toggle('active');
        overlay.classList.toggle('active');

        if (sideBar.classList.contains('active')) {
            openIcon.style.display = 'none';
            closeIcon.style.display = 'block';
        } else {
            openIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    }

    menuToggle.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', toggleMenu);
});