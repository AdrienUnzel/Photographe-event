<section class="photos-apparentees">
    <h3>Vous aimerez AUSSI</h3>
    <ul>
        <?php
        $current_post_id = get_the_ID();
        $current_post_categories = get_the_terms($current_post_id, 'categorie');

        // Si l'article appartient à au moins une catégorie
        if (!empty($current_post_categories)) {
            $current_category_ids = wp_list_pluck($current_post_categories, 'term_id');

            $related_posts = new WP_Query( array(
                'posts_per_page' => 2, // Nombre d'articles similaires à afficher
                'post_type' => 'photo', // Type de publication
                'post__not_in' => array( $current_post_id ), // Exclure l'article actuel
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'term_id',
                        'terms' => $current_category_ids // Utiliser les ID des catégories de l'article actuel
                    )
                ),
                'orderby' => 'rand' // Ordonner aléatoirement
            ) );

            if ( $related_posts->have_posts() ) :
                while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </li>
                <?php endwhile;
                wp_reset_postdata(); // Réinitialiser la requête
            else :
                echo '<p>Aucun article similaire trouvé.</p>';
            endif;
        } else {
            echo '<p>Aucune catégorie trouvée pour cet article.</p>';
        }
        ?>
    </ul>
</section>






