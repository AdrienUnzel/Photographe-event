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
            'orderby' => 'post_date', 
            'order' => 'ASC', 
            'paged' => 1
        );

        $attachments = get_posts($args);

        if ($attachments) {
            foreach ($attachments as $attachment) {
                $image_url = wp_get_attachment_image_src($attachment->ID, 'full');
                $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                $image_category = wp_get_post_terms($attachment->ID, 'categorie'); 
                $category_name = !empty($image_category) ? $image_category[0]->name : 'Uncategorized';
                ?>
                <div class="photo-item">
                    <img src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" width="564" height="495" data-category="<?php echo esc_attr($category_name); ?>">
                    <div class="photo-info">
                        <p class="photo-reference"><?php echo esc_html($image_alt); ?></p>
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
