window.addEventListener('load', () => {

    /* LIGHTBOX */
    if( document.querySelector('.wp-block-gallery')){

        let lightboxImgs = document.querySelectorAll('.wp-block-gallery img');
        let body = document.querySelector('body');

        for (let i = 0; i < lightboxImgs.length; i++){
            lightboxImgs[i].addEventListener('click', function(e) {

                let currentSlide = 0;

                body.classList.toggle('lightbox-active');

                // Create the lightbox element and add it to the page
                let lightbox = document.createElement('div');
                lightbox.classList.add('lightbox');
                document.body.appendChild(lightbox);

                // Create an image element and set its src to the full-size image
                var img = document.createElement('img');
                img.src = lightboxImgs[i].src;

                // Add the image to the lightbox
                lightbox.appendChild(img);

                // Create the arrows
                let left = document.createElement('div');
                left.classList.add('left', 'arrow');
                body.appendChild(left);
                let right = document.createElement('div');
                right.classList.add('right', 'arrow');
                body.appendChild(right);

                function goToSlide(n) {
                    lightboxImgs[currentSlide].classList.remove('active');
                    currentSlide = (n + lightboxImgs.length) % lightboxImgs.length;
                    lightboxImgs[currentSlide].classList.add('active');

                    img.remove();
                    img = document.createElement('img');
                    img.src =  lightboxImgs[currentSlide].src;
                    lightbox.appendChild(img);
                }

                // Event Listeners
                left.addEventListener('click', () => {
                    goToSlide(currentSlide + 1);
                })
                right.addEventListener('click', () => {
                    goToSlide(currentSlide - 1);
                })
                document.onkeydown = (e) => {
                    if (e.keyCode == '37') {
                        goToSlide(currentSlide - 1);
                    }
                    if (e.keyCode == '39') {
                        goToSlide(currentSlide + 1);
                    }
                    if (e.keyCode == '27' || e.keyCode == '46') {
                        lightbox.remove();
                        body.classList.remove('lightbox-active');
                        left.remove();
                        right.remove();
                    }

                }
                //mobile swiping
                document.addEventListener('touchstart', handleTouchStart, false);
                document.addEventListener('touchmove', handleTouchMove, false);

                var xDown = null;
                var yDown = null;

                function getTouches(evt) {
                  return evt.touches ||             // browser API
                         evt.originalEvent.touches; // jQuery
                }

                function handleTouchStart(evt) {
                    const firstTouch = getTouches(evt)[0];
                    xDown = firstTouch.clientX;
                    yDown = firstTouch.clientY;
                };

                function handleTouchMove(evt) {
                    if ( ! xDown || ! yDown ) {
                        return;
                    }

                    var xUp = evt.touches[0].clientX;
                    var yUp = evt.touches[0].clientY;

                    var xDiff = xDown - xUp;
                    var yDiff = yDown - yUp;

                    if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {/*most significant*/
                        if ( xDiff > 10 ) {
                            goToSlide(currentSlide + 1);
                        } else {
                            goToSlide(currentSlide - 1);
                        }
                    }
                    /* reset values */
                    xDown = null;
                    yDown = null;
                };

                 // close lightbox and arrows when clicked
                lightbox.addEventListener('click', function() {
                    lightbox.remove();
                    body.classList.remove('lightbox-active');
                    left.remove();
                    right.remove();
                });

            });
        }
    }


    let lightboxStyles = `
        body.lightbox-active{
            overflow: hidden;
        }
        .arrow{
            cursor: pointer;
            padding: 50px;
            z-index: 10000;
            position: fixed;
            top: 50%;
            left: 5%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.4s;
        }
        .arrow::before{
            content: '<';
            width: 30px;
            height: 30px;
            color: white;
            position: absolute;
            top: calc( 50% - 15px);
            left: calc( 50% - 15px);
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .arrow.right{
            right: 5%;
            left: unset;
        }
        .arrow.right::before{
            content: '>';
        }
        .lightbox{
            position: fixed;
            top: 0;
            z-index: 1000;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #000000eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .lightbox img{
            max-width: 100%;
            max-height: 100%;
        }
        @media screen and (max-width: 768px){

            .lightbox img{
                object-fit: cover;
                max-width: 100vw;
                max-height: 100vh;
            }
            .lightbox{
                align-items: center;
                padding: 20px;
                box-sizing: border-box;
            }
            .arrow{
                display: none;
            }
        }
    `;

    let styleSheetLightbox = document.createElement("style")
    styleSheetLightbox.innerText = lightboxStyles;
    document.head.appendChild(styleSheetLightbox);

})
