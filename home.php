<?php get_header(); ?>

<h1 style="background: url('<?php echo getRandomImageURL(); ?>') lightgray 50% / cover no-repeat;">
    PHOTOGRAPHE EVENT
</h1>
<section class="gallery">
    <div class="photo-grid">
        <?php
        $args = array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => 8, // Nombre d'images à afficher
            'orderby' => 'rand' // Ordre aléatoire
        );

        $attachments = get_posts($args);

        $count = 0; // Compteur pour s'assurer qu'on n'affiche que 8 photos au maximum

        if ($attachments) {
            foreach ($attachments as $attachment) {
                $image_url = wp_get_attachment_image_src($attachment->ID, 'full');
                $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                ?>
                <div class="photo-item">
                    <img src="<?php echo $image_url[0]; ?>" alt="<?php echo $image_alt; ?>" width="564" height="495">
                </div>
                <?php
                $count++;
                if ($count >= 8) { // Si 8 photos ont été affichées, arrêter la boucle
                    break;
                }
            }
        } else {
            echo '<p>Aucune image trouvée.</p>';
        }
        ?>
    </div>
</section>

<?php get_footer(); ?>
