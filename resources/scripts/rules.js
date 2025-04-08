const categoryItem = document.querySelectorAll('.category__title');

categoryItem.forEach( item => {
    item.addEventListener('click', () => {
        item.parentElement.classList.toggle('active');
    });
});