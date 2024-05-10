<?php
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
    $file_name = '/scss/style.css'; // Nom du fichier CSS
    $style_path =  get_stylesheet_directory() . $file_name; // Chemin vers votre fichier CSS
    wp_enqueue_style(
        'custom-child-style', // Identifiant unique pour votre style
        get_stylesheet_directory_uri(). $file_name,
        array(), // Dépendances, le cas échéant
        file_exists($style_path) ? filemtime($style_path) : false // Version du fichier basée sur la date de dernière modification ( pour les probleme de cache)
    );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function register_my_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'photographe-event' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );

require_once get_template_directory() . '/menus.php';


function getRandomImageURL() {
  // Obtenir un tableau de toutes les images dans la médiathèque WordPress
  $args = array(
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'posts_per_page' => -1,
  );
  $attachments = get_posts($args);

  // Vérifier s'il y a des images disponibles
  if ($attachments) {
      // Sélectionner une image aléatoire parmi les images disponibles
      $random_attachment = $attachments[array_rand($attachments)];

      // Obtenir l'URL de l'image sélectionnée
      $image_url = wp_get_attachment_url($random_attachment->ID);
      
      // Retourner l'URL de l'image sélectionnée
      return $image_url;
  } else {
      // Si aucune image n'est disponible, retourner l'URL de l'image par défaut
      return get_stylesheet_directory_uri() . '/images/nathalie-11.webp';
  }
}

// Fonction pour charger plus de photos
function load_more_photos() {
    $page = $_POST['page']; // Page à charger

    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => 8,
        'orderby' => 'post_date', // Tri par date de publication
        'order' => 'DESC', // Du plus récent au plus ancien
        'paged' => $page // Utilisez la pagination pour charger la prochaine page
    );

    $attachments = get_posts($args);

    // Générer le HTML pour les nouvelles photos
    $output = '';
    if ($attachments) {
        foreach ($attachments as $attachment) {
            $image_url = wp_get_attachment_image_src($attachment->ID, 'full');
            $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            $output .= '<div class="photo-item"><img src="' . $image_url[0] . '" alt="' . $image_alt . '" width="564" height="495"></div>';
        }
    }

    wp_send_json($output); // Renvoie la réponse JSON avec le HTML des nouvelles photos
}
add_action('wp_ajax_load_more_photos', 'load_more_photos'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos'); // Pour les utilisateurs non connectés

// Enregistrer et inclure votre script JavaScript
function enqueue_custom_scripts() {
    wp_enqueue_script('jquery'); // Assurez-vous que jQuery est chargé
    wp_register_script('custom-scripts', get_template_directory_uri() . '/scripts.js', array('jquery'), null, true);
    wp_enqueue_script('custom-scripts');

    // Passer la variable ajaxurl à votre script JavaScript
    wp_localize_script('custom-scripts', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


?>
