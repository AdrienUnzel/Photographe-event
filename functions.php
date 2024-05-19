<?php
// Enqueue parent and child theme styles
function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css'); 
    $file_name = '/scss/style.css'; // Name of the CSS file
    $style_path = get_stylesheet_directory() . $file_name; // Path to your CSS file
    wp_enqueue_style(
        'custom-child-style', // Unique ID for your style
        get_stylesheet_directory_uri() . $file_name,
        array(), // Dependencies, if any
        file_exists($style_path) ? filemtime($style_path) : false // File version based on last modified date (for cache issues)
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Register main menu
function register_my_menu() {
    register_nav_menu('main-menu', __('Menu principal', 'photographe-event'));
}
add_action('after_setup_theme', 'register_my_menu');

// Require additional menu functions
require_once get_template_directory() . '/menus.php';

// Get random image URL from the media library
function getRandomImageURL() {
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => -1,
    );
    $attachments = get_posts($args);

    if ($attachments) {
        $random_attachment = $attachments[array_rand($attachments)];
        return wp_get_attachment_url($random_attachment->ID);
    } else {
        return get_stylesheet_directory_uri() . '/images/nathalie-11.webp';
    }
}

// Load more photos via AJAX
function load_more_photos() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => 8,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'paged' => $page,
    );

    $attachments = get_posts($args);
    $output = '';
    if ($attachments) {
        foreach ($attachments as $attachment) {
            $image_url = wp_get_attachment_image_src($attachment->ID, 'full');
            $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            $output .= '<div class="photo-item"><img src="' . esc_url($image_url[0]) . '" alt="' . esc_attr($image_alt) . '" width="564" height="495"></div>';
        }
    }

    wp_send_json($output);
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Enqueue custom scripts and localize ajaxurl
function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_register_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
    wp_enqueue_script('custom-scripts');
    wp_localize_script('custom-scripts', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

// Get categories via AJAX
function get_categories_ajax() {
    $terms = get_terms(array(
        'taxonomy' => 'categorie',
        'hide_empty' => false,
    ));

    $categories = array();
    foreach ($terms as $term) {
        $categories[] = array(
            'id' => $term->term_id,
            'name' => $term->name,
        );
    }

    wp_send_json($categories);
}
add_action('wp_ajax_get_categories_ajax', 'get_categories_ajax');
add_action('wp_ajax_nopriv_get_categories_ajax', 'get_categories_ajax');

// Get image formats via AJAX
function get_image_formats_ajax() {
    $formats = get_terms(array(
        'taxonomy' => 'format',
        'hide_empty' => false,
    ));

    $image_formats = array();
    foreach ($formats as $format) {
        $image_formats[] = array(
            'slug' => $format->slug,
            'name' => $format->name,
        );
    }

    wp_send_json($image_formats);
}
add_action('wp_ajax_get_image_formats', 'get_image_formats_ajax');
add_action('wp_ajax_nopriv_get_image_formats', 'get_image_formats_ajax');

// Filter photos by category and format via AJAX
function filter_photos() {
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $format_slug = isset($_POST['format_slug']) ? sanitize_text_field($_POST['format_slug']) : '';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => 8, // Limiter à 8 images au début
        'paged' => $page, // Utiliser le numéro de page
        'tax_query' => array(),
    );

    // Ajouter la taxonomie de catégorie à la requête si une catégorie est sélectionnée
    if ($category_id) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $category_id,
        );
    }

    $query = new WP_Query($args);
    $filtered_images = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image_url = wp_get_attachment_image_src(get_the_ID(), 'full');
            $image_alt = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true);
            $filtered_images .= '<div class="photo-item">';
            $filtered_images .= '<img src="' . esc_url($image_url[0]) . '" alt="' . esc_attr($image_alt) . '" width="564" height="495">';
            $filtered_images .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $filtered_images = '<p>Aucune photo trouvée pour cette catégorie et ce format.</p>';
    }

    echo $filtered_images;
    wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');




// Register taxonomies for attachments
function register_taxonomies_for_attachments() {
    register_taxonomy_for_object_type('categorie', 'attachment');
    register_taxonomy_for_object_type('format', 'attachment');
}
add_action('init', 'register_taxonomies_for_attachments');
?>

