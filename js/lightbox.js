document.addEventListener('DOMContentLoaded', () => {
    
    const albums = document.querySelectorAll('.wp-block-gallery');

    albums.forEach(album => {
        
        const lightboxImgs = album.querySelectorAll('img');
        
        /* KLIK OP IMAGE */
        lightboxImgs.forEach(img => {
            img.addEventListener('click', () => {
                const body = document.querySelector('body');
                body.classList.toggle('lightbox-active');

                const lightbox = document.createElement('div');
                lightbox.className = 'lightbox';
                document.body.appendChild(lightbox);

                const lightboxImg = document.createElement('img');
                lightboxImg.className = 'lightboxImg';
                lightboxImg.src = img.src;
                lightbox.appendChild(lightboxImg);

                function goToSlide(n) {
                    currentSlide = (n + lightboxImgs.length) % lightboxImgs.length;
                    lightboxImg.src = lightboxImgs[currentSlide].src;
                }

                let currentSlide = 0;
                const left = createArrow('left');
                const right = createArrow('right');


                /* NAVIGATIE */
                left.addEventListener('click', () => goToSlide(currentSlide - 1));
                right.addEventListener('click', () => goToSlide(currentSlide + 1));
                window.addEventListener('wheel', event => event.deltaY < 0 ? goToSlide(currentSlide - 1) : goToSlide(currentSlide + 1));

                /* SLUITEN EVENT */
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') goToSlide(currentSlide - 1);
                    if (e.key === 'ArrowRight') goToSlide(currentSlide + 1);
                    if (e.key === 'Escape') {
                        lightbox.remove();
                        body.classList.remove('lightbox-active');
                        left.remove();
                        right.remove();
                    }
                });
                /* SLUITEN EVENT */
                document.addEventListener('click', (e) => {
                    if (e.target === lightbox) {
                        lightbox.remove();
                        body.classList.remove('lightbox-active');
                        left.remove();
                        right.remove();
                    }
                });
            });
        });
    });
    
    /* STYLES */
    const lightboxStyles = `
        body.lightbox-active { overflow: hidden; }
        .arrow { cursor: pointer; padding: 50px; z-index: 10000; position: fixed; top: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; transition: 0.4s; }
        .arrow::before { content: '<'; width: 30px; height: 30px; color: white; position: absolute; top: calc(50% - 15px); left: calc(50% - 15px); font-size: 20px; display: flex; align-items: center; justify-content: center; }
        .arrow.right { right: 5%; left: unset; }
        .arrow.right::before { content: '>'; }
        .lightbox { position: fixed; top: 0; z-index: 1000; left: 0; width: 100vw; height: 100vh; background: #000000eb; display: flex; align-items: center; justify-content: center; }
        .lightbox img { max-width: 100%; max-height: 100%; }
        @media screen and (max-width: 768px) { .lightbox img { object-fit: cover; max-width: 100vw; max-height: 100vh; } .lightbox { align-items: center; padding: 20px; box-sizing: border-box; } .arrow { display: none; } }
    `;

    const styleSheetLightbox = document.createElement("style");
    styleSheetLightbox.textContent = lightboxStyles;
    document.head.appendChild(styleSheetLightbox);

     /* NAVIGATIE PIJLTJES */
    function createArrow(direction) {
        const arrow = document.createElement('div');
        arrow.className = `${direction} arrow`;
        arrow.innerHTML = direction === 'left' ? '&#10094;' : '&#10095;';
        document.body.appendChild(arrow);
        return arrow;
    }
});
