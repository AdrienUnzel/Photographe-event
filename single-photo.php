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

// Récupérer les données des custom fields pour le post précédent
$previous_reference = get_post_meta($previous_post->ID, 'reference', true);
$previous_thumbnail = get_the_post_thumbnail($previous_post->ID);

// Récupérer les données des custom fields pour le post suivant
$next_reference = get_post_meta($next_post->ID, 'reference', true);
$next_thumbnail = get_the_post_thumbnail($next_post->ID);

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
        <div class="previous-photo">
            <a href="<?php echo get_permalink($previous_post->ID); ?>">
                <?php echo $previous_thumbnail; ?>
            </a>
        </div>
    <?php endif; ?>

    <?php if ($next_post && !$previous_post) : ?>
        <div class="next-photo">
            <a href="<?php echo get_permalink($next_post->ID); ?>">
                <?php echo $next_thumbnail; ?>
            </a>
        </div>
    <?php endif; ?>
</div>

<hr>

<div class="contact btn">
    <div class="btn-nav left">
        <a href="<?php echo get_permalink($previous_post->ID); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">
                <path d="M0.646447 3.64645C0.451184 3.84171 0.451184 4.15829 0.646447 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659728 4.53553 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646447 3.64645ZM1 4.5H26V3.5H1V4.5Z" fill="black"/>
            </svg>
        </a>
    </div>
    <div class="btn-nav right">
        <a href="<?php echo get_permalink($next_post->ID); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">
                <path d="M25.3536 3.64645C25.5488 3.84171 25.5488 4.15829 25.3536 4.35355L22.1716 7.53553C21.9763 7.7308 21.6597 7.7308 21.4645 7.53553C21.2692 7.34027 21.2692 7.02369 21.4645 6.82843L24.2929 4L21.4645 1.17157C21.2692 0.976311 21.2692 0.659728 21.4645 0.464466C21.6597 0.269204 21.9763 0.269204 22.1716 0.464466L25.3536 3.64645ZM25 4.5H0V3.5H25V4.5Z" fill="black"/>
            </svg>
        </a>
    </div>
</div>

<hr class="line">
<?php get_template_part( 'templates_parts/photo_block' ); ?>
<?php get_footer(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(document).ready(function(){
        $("input[name='your-reference']").val("<?php echo $reference; ?>");
    });
</script>