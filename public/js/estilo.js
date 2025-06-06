const toggleBtn = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebarMenu');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('show');
});