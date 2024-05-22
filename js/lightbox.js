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

    // Délégation d'événement pour les images de la galerie
    document.querySelector('.photo-grid').addEventListener('click', (event) => {
        if (event.target.tagName === 'IMG') {
            images = Array.from(document.querySelectorAll('.photo-item img'));
            currentIndex = images.indexOf(event.target);
            showLightbox(event.target);
        }
    });

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

    function showLightbox(img) {
        lightboxImg.src = img.src;
        lightboxCaption.textContent = img.alt;
        lightboxCategory.textContent = img.dataset.category; // Extract category from data-category attribute
        lightbox.style.display = 'flex';
    }
});


