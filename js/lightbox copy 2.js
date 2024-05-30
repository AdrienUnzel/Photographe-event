document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxCategory = document.getElementById('lightbox-category');
    const lightboxClose = document.getElementById('lightbox-close');
    const lightboxPrev = document.getElementById('lightbox-prev');
    const lightboxNext = document.getElementById('lightbox-next');
    let currentIndex = 0;
    let images = [];

    // Fonction pour afficher la lightbox
    function showLightbox(img) {
        console.log(img);
        lightboxImg.src = img.src;
        lightboxCaption.textContent = img.alt;
        lightboxCategory.textContent = img.category; 
        lightbox.style.display = 'flex';
    }

    // Délégation d'événement pour les images de la galerie
    const fullscreenElements = document.querySelectorAll('.fullscreen');

    // Ajouter un écouteur d'événement de clic à chaque élément "fullscreen"
    fullscreenElements.forEach(function(fullscreenElement) {
        fullscreenElement.addEventListener('click', function() {
            const photoItem = fullscreenElement.closest('.photo-item');
            
            if (photoItem) {

                const photoInfo = photoItem.querySelector('.photo-info');

                if(photoInfo){
                    let img = {};
                    img.src = photoInfo.getAttribute("data-url");
                    img.alt = photoInfo.getAttribute("data-reference");
                    img.category = photoInfo.getAttribute("data-category");
                    showLightbox(img);
                }
            }
        });
    });

// // Attachez l'écouteur d'événements à un parent statique
// document.querySelector('.fullscreen').addEventListener('click', (event) => {
//     // Vérifiez si l'élément cliqué a la classe "photo-item"
//     if (event.target.closest('.photo-item')) {
//             const item = event.target.closest('.photo-info');
//             let img = {};

//             img.src = item.getAttribute("data-url");
//             img.alt = item.getAttribute("data-reference");
//             img.category = item.getAttribute("data-category");
//             showLightbox(img);
//     }
// });




    // Écouteurs d'événements pour la lightbox
    lightboxClose.addEventListener('click', () => {
        lightbox.style.display = 'none';
    });

    lightboxPrev.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showLightbox(images[currentIndex]);
    });

    lightboxNext.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        showLightbox(images[currentIndex]);
    });
});


