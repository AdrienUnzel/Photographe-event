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

// Generate photo HTML
function generate_photo_html($post_id, $reference, $category_name) {
    $thumbnail_url = get_the_post_thumbnail_url($post_id);
    $permalink = get_the_permalink($post_id);

    $output = '<div class="photo-item">';
    $output .= '<div class="photo-clicable-element">';
    $output .= '<a href="' . esc_url($permalink) . '">';
    $output .= '<img src="wp-content/themes/Photographe-event/images/Icon_eye.png" alt="eyes" class="eyes">';
    $output .= '</a>';
    $output .= '<img src="wp-content/themes/Photographe-event/images/Icon_fullscreen.png" alt="fullscreen" class="fullscreen" data-fullscreen-url="' . esc_url($thumbnail_url) . '">';
    $output .= '</div>';
    $output .= get_the_post_thumbnail($post_id);
    $output .= '<div class="photo-info" ';
    $output .= 'data-url="' . esc_url($thumbnail_url) . '" ';
    $output .= 'data-category="' . esc_html($category_name) . '" ';
    $output .= 'data-reference="' . esc_html($reference) . '" ';
    $output .= '>';
    $output .= '<p class="photo-reference">' . esc_html($reference) . '</p>';
    $output .= '<p class="photo-category">' . esc_html($category_name) . '</p>';
    $output .= '</div>'; // Close .photo-info
    $output .= '</div>'; // Close .photo-item

    return $output;
}

// Load more photos via AJAX
function load_more_photos() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $args = array(
        'posts_per_page' => 8, // Nombre d'articles similaires à afficher
        'post_type' => 'photo', // Type de publication
        'order' => 'ASC', // Ordonner
        'paged' => $page,
    );

    $related_posts = new WP_Query($args);
    $output = '';

    if ($related_posts->have_posts()) {
        while ($related_posts->have_posts()) {
            $related_posts->the_post();
            $reference = get_post_meta(get_the_ID(), 'reference', true);
            $image_category = get_the_terms(get_the_ID(), 'categorie');
            $category_name = !empty($image_category) ? $image_category[0]->name : 'Uncategorized';

            $output .= generate_photo_html(get_the_ID(), $reference, $category_name);
        }
        wp_reset_postdata();
    }

    wp_send_json($output);
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Filter photos by category and format via AJAX
function filter_photos() {
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $format_slug = isset($_POST['format_slug']) ? sanitize_text_field($_POST['format_slug']) : '';
    $date_format = isset($_POST['date_format']) ? sanitize_text_field($_POST['date_format']) : 'ASC';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type' => 'photo',
        'post_status' => 'publish',
        'posts_per_page' => 8, // Limiter à 8 images au début
        'paged' => $page, // Utiliser le numéro de page
        'tax_query' => array(),
        'order' => $date_format,
    );

    if ($category_id) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'term_id',
            'terms' => $category_id,
        );
    }

    if ($format_slug) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format_slug,
        );
    }

    $query = new WP_Query($args);
    $filtered_images = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $reference = get_post_meta(get_the_ID(), 'reference', true);
            $image_category = get_the_terms(get_the_ID(), 'categorie');
            $category_name = !empty($image_category) ? $image_category[0]->name : 'Uncategorized';

            $filtered_images .= generate_photo_html(get_the_ID(), $reference, $category_name);
        }
        wp_reset_postdata();
    } else {
        $filtered_images = '<p>Aucune photo trouvée pour cette catégorie et ce format.</p>';
    }

    wp_send_json($filtered_images);
    wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

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

// Register taxonomies for attachments
function register_taxonomies_for_attachments() {
    register_taxonomy_for_object_type('categorie', 'attachment');
    register_taxonomy_for_object_type('format', 'attachment');
}
add_action('init', 'register_taxonomies_for_attachments');

// Lightbox
function enqueue_lightbox_script() {
    wp_enqueue_script('lightbox-js', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_script');
?>



