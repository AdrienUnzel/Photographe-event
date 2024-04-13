<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <Title>Photographe-event</Title>
    <?php wp_head(); ?>
</head>
<body>

<header>
<nav role="navigation" aria-label="<?php _e('Menu principal', 'photographe-event'); ?>">
<img class="logo" src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?> " alt="logo">
  <?php
    wp_nav_menu([
        'theme_location' => 'main-menu',
        'container'      => false,
        'walker'         => new A11y_Walker_Nav_Menu()
    ]);
  ?>
    <h1>PHOTOGRAPHE EVENT</h1>
</header> 

    
