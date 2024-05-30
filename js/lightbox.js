var images = [];

document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    const lightboxClose = document.getElementById('lightbox-close');
    const lightboxPrev = document.getElementById('lightbox-prev');
    const lightboxNext = document.getElementById('lightbox-next');
    let currentIndex = 0;
    
    addFullScreenEvent();
    
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


function addFullScreenEvent(){
    // Délégation d'événement pour les images de la galerie
    const fullscreenElements = document.querySelectorAll('.fullscreen');

    // Ajouter un écouteur d'événement de clic à chaque élément "fullscreen"
    fullscreenElements.forEach(function(fullscreenElement) {
        fullscreenElement.addEventListener('click', function() {
            const photoItem = fullscreenElement.closest('.photo-item');
            
            if (photoItem) {

                const photoInfo = photoItem.querySelector('.photo-info');

                if(photoInfo){
                    images = Array.from(document.querySelectorAll('.photo-info'));

                    showLightbox(photoInfo);
                }
            }
        });
    }); 
}

// Fonction pour afficher la lightbox
function showLightbox(photoInfo) {

    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxCategory = document.getElementById('lightbox-category');
    console.log(photoInfo);
    lightboxImg.src =  photoInfo.getAttribute("data-url");
    lightboxCaption.textContent = photoInfo.getAttribute("data-reference");
    lightboxCategory.textContent = photoInfo.getAttribute("data-category"); 
    lightbox.style.display = 'flex';
}