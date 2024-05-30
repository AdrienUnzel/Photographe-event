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
        <option value="ASC">A partir des plus récentes</option>
        <option value="DESC">A partir des plus anciennes </option>
    </select>
</div>

<section class="gallery">
    <div class="photo-grid">
        <?php
        $related_posts = new WP_Query( array(
            'posts_per_page' => 8, // Nombre d'articles similaires à afficher
            'post_type' => 'photo', // Type de publication
            'order' => 'ASC', // Ordonner
            'orderby' => 'post_date',
            'paged' => 1
        ) );
        if ( $related_posts->have_posts() ) {
            while ( $related_posts->have_posts() ) {
                $related_posts->the_post(); 
                $reference = get_post_meta(get_the_ID(), 'reference', true);
                $image_category = get_the_terms(get_the_ID(), 'categorie'); 
                $category_name = !empty($image_category) ? $image_category[0]->name : 'Uncategorized';
                ?>
                <div class="photo-item">
                    <div class="photo-clicable-element">
                        <a href="<?php the_permalink(); ?>">
                            <img src="wp-content/themes/Photographe-event/images/Icon_eye.png" alt="eyes" class="eyes">
                        </a>
                        <img src="wp-content/themes/Photographe-event/images/Icon_fullscreen.png" alt="fullscreen" class="fullscreen">
                    </div>
                    <?php the_post_thumbnail(); ?>
                    <div class="photo-info" 
                        data-url="<?php echo get_the_post_thumbnail_url(); ?>"  
                        data-category="<?php echo esc_html($category_name); ?>"
                        data-reference="<?php echo esc_html($reference); ?>"
                        >
                        <p class="photo-reference"><?php echo esc_html($reference); ?></p>
                        <p class="photo-category"><?php echo esc_html($category_name); ?></p>
                    </div>
                    
                </div>
                <?php
            }
        } else {
            echo '<p>Aucune image trouvée.</p>';
        }
        ?>
    </div>
    <button id="load-more-btn">Charger plus</button>
</section>


<?php get_footer(); ?>
