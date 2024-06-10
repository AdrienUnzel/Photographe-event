//Variable globale
var nextPage = 2;

/// Fonction pour afficher la modal et l'overlay
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


// Lorsque l'utilisateur clique en dehors de la modal, masquer la modal et l'overlay
window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    var overlay = document.getElementById('overlay');
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
function loadMorePhotos() {
    var data = {
        action: 'load_more_photos',
        page: nextPage
    };
    
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: data,
        success: function(response) {
            // Manipuler la réponse JSON pour ajouter les nouvelles photos à la galerie
            
            
            if(response == ""){
                $('#load-more-btn').hide();
                $('.photo-grid').append('<p class="no-more-photos">Plus de photo</p>');

            } else {
                $('.photo-grid').append(response);
            
                // Déplacer le bouton "Charger plus" à l'intérieur de la galerie
                let loadMoreBtn = $('#load-more-btn');
                loadMoreBtn.appendTo('.photo-grid');

                // Ajuster le positionnement du bouton
                loadMoreBtn.css({
                    position: 'relative', // Utiliser le positionnement relatif pour permettre le centrage
                    top: '20px', // Espacement entre le bouton et les éléments de la galerie
                    left: '12%', // Centrage horizontal
                    transform: 'translateX(-50%)', // Centrer horizontalement
                });
                nextPage = nextPage +1;
            }
            addFullScreenEvent();
        }
    });
}



//filtres
jQuery(document).ready(function($) {
    // Charger les catégories dans le select
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_categories_ajax'
        },
        success: function(response) {
            response.forEach(function(category) {
                $('#filter-by-category').append($('<option>', {
                    value: category.id,
                    text: category.name
                }));
            });
        }
    });

    // Charger les formats d'image dans le select
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_image_formats'
        },
        success: function(response) {
            response.forEach(function(format) {
                $('#filter-by-format').append($('<option>', {
                    value: format.slug,
                    text: format.name
                }));
            });
        }
    });
    
    // Gestionnaire d'événement délégué pour le bouton "Charger plus"
    $(document).on('click', '#load-more-btn', function() {
        loadMorePhotos();
    });

    // Gérer le changement de catégorie
    $('#filter-by-category').change(function() {
        filterPhotos();
    });

    // Gérer le changement de format
    $('#filter-by-format').change(function() {
        filterPhotos();
    });
    
    // Gérer le changement de tri par date 
    $('#sort-by').change(function() {
        filterPhotos();
    });

    function getFilterData() {
        return {
            action: 'filter_photos',
            category_id: $('#filter-by-category').val(),
            format_slug: $('#filter-by-format').val(),
            date_format: $('#sort-by').val()
        };
    }
    
    function filterPhotos() {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: getFilterData(),
            success: function(response) {
                $('.photo-grid').html(response);
                addFullScreenEvent();
            }
        });
    }

});


// Écouteur d'événement pour la création de nouvelles catégories
// $(document).change('category-add', function() {
//     // Recharger les options du select des catégories
//     reloadCategoryOptions();
// });

// // Écouteur d'événement pour la création de nouveaux formats
// $(document).on('format-add', function() {
//     // Recharger les options du select des formats
//     reloadFormatOptions();
// });

// Fonction pour recharger les options du select des catégories
function reloadCategoryOptions() {
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_categories_ajax'
        },
        success: function(response) {
            $('#filter-by-category').empty(); // Vider les options actuelles
            if (response.length > 0) {
                $('#filter-by-category').append($('<option>', { value: '', text: 'Catégories' }));
                response.forEach(function(category) {
                    $('#filter-by-category').append($('<option>', { value: category.id, text: category.name }));
                });
            }
        }
    });
}

// Fonction pour recharger les options du select des formats
function reloadFormatOptions() {
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_image_formats'
        },
        success: function(response) {
            $('#filter-by-format').empty(); // Vider les options actuelles
            if (response.length > 0) {
                $('#filter-by-format').append($('<option>', { value: '', text: 'Formats' }));
                response.forEach(function(format) {
                    $('#filter-by-format').append($('<option>', { value: format.slug, text: format.name }));
                });
            }
        }
    });
}
/*
// Fonction pour charger les termes des taxonomies
function loadTaxonomyTerms() {
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_taxonomy_terms'
        },
        success: function(response) {
            // Mettre à jour le select des catégories
            var categorySelect = $('#filter-by-category');
            categorySelect.empty(); // Effacer les options existantes
            categorySelect.append('<option value="">catégories</option>'); // Option par défaut
            response.categories.forEach(function(category) {
                categorySelect.append('<option value="' + category.slug + '">' + category.name + '</option>');
            });

            // Mettre à jour le select des formats
            var formatSelect = $('#filter-by-format');
            formatSelect.empty(); // Effacer les options existantes
            formatSelect.append('<option value="">formats</option>'); // Option par défaut
            response.formats.forEach(function(format) {
                formatSelect.append('<option value="' + format.slug + '">' + format.name + '</option>');
            });
        }
    });
}

// Appeler la fonction pour charger les termes des taxonomies lors du chargement de la page
$(document).ready(function() {
    loadTaxonomyTerms();
});
*/

$(document).ready(function(){
    $("input[name='your-reference']").val("");

    // Handle hover for navigation buttons
    $('.btn-nav.left, .btn-nav.right').hover(
        function() {
            var imageUrl = $(this).data('thumbnail-url');
            if (imageUrl) {
                var positionClass = $(this).hasClass('left') ? 'left' : 'right';
                $('.preview-thumbnail')
                    .html('<img src="'+ imageUrl +'" class="hover-thumbnail">')
                    .addClass(positionClass)
                    .show();
            }
        },
        function() {
            $('.preview-thumbnail').hide().removeClass('left right');
        }
    );
});




/**************menu burger*****************/
document.addEventListener('DOMContentLoaded', function () {
    var burger = document.querySelector('.burger');
    var menu = document.querySelector('ul#menu-menu-principal');

    burger.addEventListener('click', () => {
        burger.classList.toggle('active');
        menu.classList.toggle('active');
        // Si le menu est actif, le montrer, sinon le cacher
        if (menu.classList.contains('active')) {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    });
});



