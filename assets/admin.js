// admin navbar
window.addEventListener('load', () => {
    document.getElementById('admin-nav-toggler').addEventListener('click', () => {
        document.getElementById('admin-navbar').classList.toggle('toggle');
    })

    window.addEventListener('resize', () => {
        if (document.getElementById('admin-navbar').classList.contains('toggle')) {
            document.getElementById('admin-navbar').classList.remove('toggle');
        }
    })
})