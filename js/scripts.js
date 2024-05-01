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
/*var contactMenu = document.getElementById("menu-contact");

// Lorsque l'utilisateur clique sur l'élément de menu "Contact", afficher la modal
contactMenu.onclick = function() {
    showModal();
}*/

// Obtenir l'élément bouton "Contact"
var btnContact = document.getElementById("btnContact");

// Lorsque l'utilisateur clique sur l'élément bouton "Contact", afficher la modal
btnContact.onclick = function() {
    showModal();
}


//photo navigation creer un système de boucle infini



