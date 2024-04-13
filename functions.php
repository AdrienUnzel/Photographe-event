<?php 
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );    
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function register_my_menu() {
  register_nav_menu( 'main-menu', __( 'Menu principal', 'photographe-event' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );

require_once get_template_directory() . '/menus.php';
?>