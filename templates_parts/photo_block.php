<section class="photos-apparentees">
    <h3>Vous aimerez AUSSI</h3>
    <ul>
        <?php
        $current_post_id = get_the_ID();
        $current_post_categories = get_the_terms($current_post_id, 'categorie');

        if (!empty($current_post_categories)) {
            $current_category_ids = wp_list_pluck($current_post_categories, 'term_id');

            $related_posts = new WP_Query(array(
                'posts_per_page' => 2,
                'post_type' => 'photo',
                'post__not_in' => array($current_post_id),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'term_id',
                        'terms' => $current_category_ids
                    )
                ),
                'orderby' => 'rand'
            ));

            if ($related_posts->have_posts()) :
                while ($related_posts->have_posts()) : $related_posts->the_post();
                    $reference = get_post_meta(get_the_ID(), 'reference', true);
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    $category_name = !empty($categories) ? $categories[0]->name : 'Uncategorized';
                    ?>
                    <li>
                        <div class="photo-item">
                            <div class="photo-clicable-element">
                                <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/Icon_eye.png" alt="eyes" class="eyes">
                                </a>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/Icon_fullscreen.png" alt="fullscreen" class="fullscreen">
                            </div>
                            <?php the_post_thumbnail(); ?>
                            <div class="photo-info"
                                data-url="<?php echo get_the_post_thumbnail_url(); ?>"
                                data-category="<?php echo esc_html($category_name); ?>"
                                data-reference="<?php echo esc_html($reference); ?>">
                                <p class="photo-reference"><?php echo esc_html($reference); ?></p>
                                <p class="photo-category"><?php echo esc_html($category_name); ?></p>
                            </div>
                        </div>
                    </li>
                <?php endwhile;
                wp_reset_postdata();
            else :
                echo '<p>Aucun article similaire trouvé.</p>';
            endif;
        } else {
            echo '<p>Aucune catégorie trouvée pour cet article.</p>';
        }
        ?>
    </ul>
</section>










