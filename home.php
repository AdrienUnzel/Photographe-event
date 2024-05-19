
<?php get_header(); ?>


<h1 style="background: url('<?php echo getRandomImageURL(); ?>') lightgray 50% / cover no-repeat;">
    PHOTOGRAPHE EVENT
</h1>

<!-- Ajout des selects -->
<div class="filters">
    <select id="filter-by-category">
        <option value="">catégories</option>
    </select>

    <select id="filter-by-format">
        <option value="">formats</option>
    </select>

    <select id="sort-by">
        <option value="">trier par</option>
        <option value="date">date</option>
    </select>
</div>


<section class="gallery">
    <div class="photo-grid">
        <?php
        $args = array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => 8,
            'orderby' => 'post_date', // Tri par date de publication
            'order' => 'DESC', // Du plus récent au plus ancien
            'paged' => 1 // Utilisez la pagination pour charger la prochaine page
        );

        $attachments = get_posts($args);

        $count = 0; // Compteur pour s'assurer qu'on n'affiche que 16 photos au maximum

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
        <!-- Bouton "Charger plus" -->
        <button id="load-more-btn">Charger plus</button>
</section>

<?php get_footer(); ?>
