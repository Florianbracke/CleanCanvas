window.addEventListener('load', () => {

    let button = document.querySelector('.mobile-nav .button');
    let menu = document.querySelector('.menu-wrapper');
    let body = document.querySelector('body');
    let header = document.querySelector('header.site-header');

    button.addEventListener('click', () => {
        menu.classList.toggle('active-mobile');
        body.classList.toggle('active-mobile');
        button.classList.toggle('active-mobile')
        header.classList.toggle('active-mobile')
    })

});
