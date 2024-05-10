// Fonction pour afficher la modal et l'overlay
function showModal() {
    var modal = document.getElementById('myModal');
    var overlay = document.getElementById('overlay');
    modal.style.display = "block";
    overlay.style.display = "block"; // Affiche l'overlay
}

// Fonction pour masquer la modal et l'overlay
function hideModal() {
    var modal = document.getElementById('myModal');
    var overlay = document.getElementById('overlay');
    modal.style.display = "none";
    overlay.style.display = "none"; // Masque l'overlay
}

// Obtenir le bouton qui ouvre la modal
var btn = document.getElementsByClassName("myBtn");
// Obtenir l'élément de fermeture de la modal
var span = document.getElementById("closeModal");
// Obtenir l'overlay
var overlay = document.getElementById("overlay");

// Lorsque l'utilisateur clique sur le bouton, afficher la modal et l'overlay
btn.onclick = function() {
    showModal();
}

// Lorsque l'utilisateur clique sur l'élément de fermeture, masquer la modal et l'overlay
span.onclick = function() {
    hideModal();
}

// Lorsque l'utilisateur clique en dehors de la modal, masquer la modal et l'overlay
window.onclick = function(event) {
    if (event.target == overlay) {
        hideModal();
    }
}

// Appel de la fonction pour afficher la modal lors du chargement de la page
/*window.onload = function() {
    showModal();
}*/

// Obtenir l'élément de menu "Contact"
var contactMenu = document.getElementsByClassName("menu-contact");

// Lorsque l'utilisateur clique sur l'élément de menu "Contact", afficher la modal

Array.from(contactMenu).forEach(function(element) {
    element.addEventListener('click', () => {
        showModal();
    });
});

// Obtenir l'élément bouton "Contact"
var btnContact = document.getElementById("btnContact");

// Lorsque l'utilisateur clique sur l'élément bouton "Contact", afficher la modal
if(!!btnContact){
    btnContact.onclick = function() {
        showModal();
    }
}


//photo navigation creer un système de boucle infini


//pagination infini
// Fonction pour charger plus de photos via Ajax
function loadMorePhotos(page) {
    var data = {
        action: 'load_more_photos',
        page: page
    };

    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: data,
        success: function(response) {
            // Manipuler la réponse JSON pour ajouter les nouvelles photos à la galerie
            $('.photo-grid').append(response);
            
            // Déplacer le bouton "Charger plus" à l'intérieur de la galerie
            var $loadMoreBtn = $('#load-more-btn');
            $loadMoreBtn.appendTo('.photo-grid');

            // Ajuster le positionnement du bouton
            $loadMoreBtn.css({
                position: 'relative', // Utiliser le positionnement relatif pour permettre le centrage
                top: '20px', // Espacement entre le bouton et les éléments de la galerie
                left: '12%', // Centrage horizontal
                transform: 'translateX(-50%)', // Centrer horizontalement
            });
        }
    });
}

// Gestionnaire d'événement délégué pour le bouton "Charger plus"
$(document).on('click', '#load-more-btn', function() {
    var nextPage = 2; // La page suivante à charger
    loadMorePhotos(nextPage);
});






