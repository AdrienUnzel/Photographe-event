<?php
/**
 * Template Name: Single Photo
 * Description: Template for displaying a single custom post type
 */
get_header();

// Arguments de requête pour récupérer les articles de type "photo"
$args = array(
    'post_type'      => 'photo', 
    'posts_per_page' => 1,      // Pour récupérer le nombre articles
);

$query = new WP_Query($args);

// Récupérer le post actuel
$current_post = get_post();

// Récupérer le post suivant
$next_post = get_next_post();

// Récupérer le post précédent
$previous_post = get_previous_post();

// Récupérer les URLs des images miniatures pour le post précédent et suivant
$previous_thumbnail_url = get_the_post_thumbnail_url($previous_post->ID, 'thumbnail');
$next_thumbnail_url = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');

// Récupérer les données des custom fields
$reference = get_post_meta(get_the_ID(), 'reference', true);
$categorie = get_the_terms(get_the_ID(), 'categorie');
$format    = get_the_terms(get_the_ID(), 'format');
$type      = get_post_meta(get_the_ID(), 'type', true);
$annee     = get_post_meta(get_the_ID(), 'annee', true);
?>

<div class="photo">
    <div class="featured-image">
        <?php the_post_thumbnail(); ?>
    </div>
    <div class="info-photo">
        <h2><?php the_title(); ?></h2>
        <p>Référence: <?php echo $reference; ?></p>
        <?php if (!empty($categorie)) : ?>
            <p>Catégorie: <?php echo $categorie[0]->name; ?></p>
        <?php endif; ?>
        <?php if (!empty($format)) : ?>
            <p>Format: <?php echo $format[0]->name; ?></p>
        <?php endif; ?>
        <p>Type: <?php echo $type; ?></p>
        <p>Année: <?php echo $annee; ?></p>
    </div>
</div>

<hr class="line">

<p class="single-text">Cette photo vous intéresse ?</p>
<button class="button-contact" id="btnContact">Contact</button>

<div class="photo-navigation">
    <?php if ($previous_post) : ?>
        <div class="previous-photo" data-thumbnail-url="<?php echo $previous_thumbnail_url; ?>">
            <a href="<?php echo get_permalink($previous_post->ID); ?>">
                <!-- Thumbnail will be displayed on hover -->
            </a>
        </div>
    <?php endif; ?>

    <?php if ($next_post) : ?>
        <div class="next-photo" data-thumbnail-url="<?php echo $next_thumbnail_url; ?>">
            <a href="<?php echo get_permalink($next_post->ID); ?>">
                <!-- Thumbnail will be displayed on hover -->
            </a>
        </div>
    <?php endif; ?>
</div>

<div class="preview-thumbnail"></div> <!-- Conteneur pour les images de prévisualisation -->

<hr>

<div class="contact btn">
    <div class="btn-nav left" data-thumbnail-url="<?php echo $previous_thumbnail_url; ?>">
        <a href="<?php echo get_permalink($previous_post->ID); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">
                <path d="M0.646447 3.64645C0.451184 3.84171 0.451184 4.15829 0.646447 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659728 4.53553 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646447 3.64645ZM1 4.5H26V3.5H1V4.5Z" fill="black"/>
            </svg>
        </a>
    </div>
    <div class="btn-nav right" data-thumbnail-url="<?php echo $next_thumbnail_url; ?>">
        <a href="<?php echo get_permalink($next_post->ID); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">
                <path d="M25.3536 3.64645C25.5488 3.84171 25.5488 4.15829 25.3536 4.35355L22.1716 7.53553C21.9763 7.7308 21.6597 7.7308 21.4645 7.53553C21.2692 7.34027 21.2692 7.02369 21.4645 6.82843L24.2929 4L21.4645 1.17157C21.2692 0.976311 21.2692 0.659728 21.4645 0.464466C21.6597 0.269204 21.9763 0.269204 22.1716 0.464466L25.3536 3.64645ZM25 4.5H0V3.5H25V4.5Z" fill="black"/>
            </svg>
        </a>
    </div>
</div>

<hr class="line">
<?php get_template_part('templates_parts/photo_block'); ?>
<?php get_footer(); ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(document).ready(function(){
        $("input[name='your-reference']").val("<?php echo $reference; ?>");

        // Handle hover for navigation buttons
        $('.btn-nav.left, .btn-nav.right').hover(
            function() {
                var imageUrl = $(this).data('thumbnail-url');
                if (imageUrl) {
                    var positionClass = $(this).hasClass('left') ? 'left' : 'right';
                    $('.preview-thumbnail')
                        .html('<img src="'+ imageUrl +'" class="hover-thumbnail">')
                        .addClass(positionClass)
                        .show();
                }
            },
            function() {
                $('.preview-thumbnail').hide().removeClass('left right');
            }
        );
    });
</script>
