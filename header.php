<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <Title>Photographe-event</Title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <?php wp_head(); ?>
</head>
<body>

<header>
    <nav role="navigation" aria-label="<?php _e('Menu principal', 'photographe-event'); ?>">
    <a href="http://localhost/Photographe-Event/"> 
        <img class="logo" src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>" alt="logo">
    </a>
        <?php
            wp_nav_menu([
                'theme_location' => 'main-menu',
                'container'      => false,
                'walker'         => new A11y_Walker_Nav_Menu()
            ]);
        ?>
    </nav>
</header>

