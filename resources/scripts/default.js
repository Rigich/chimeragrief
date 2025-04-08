const items = document.querySelectorAll('.header__list-link');

items.forEach(item => {
    if(item.getAttribute('href') == window.location.pathname) {
        item.parentElement.classList.add('active');
        item.addEventListener('click', (e) => {
            e.preventDefault();
        });
    }
});