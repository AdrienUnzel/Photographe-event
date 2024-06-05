
<footer>
    <ul>
    <li><a href="#">MENTIONS LÉGALES</a></li>
    <li><a href="<?php echo get_permalink(get_page_by_path('politique-de-confidentialite')); ?>">VIE PRIVÉE</a></li>
    <li><a href="#">TOUS DROITS RÉSERVÉS</a></li>
    </ul> 
</footer>
<?php wp_footer(); ?>

<div id="lightbox" style="display:none;">
    <div id="lightbox-content">
        
        <img id="lightbox-img" src="" alt="">
        <div id="lightbox-info">
            <p id="lightbox-caption"></p>
            <p id="lightbox-category"></p>
        </div>
    </div>
    <div><span id="lightbox-close">&times;</span></div>
    <div id="lightbox-prev" class="lightbox-arrow">
        <span class="arrow-icon">&larr;</span>
        <span class="arrow-text">Précédente</span>
    </div>
    <div id="lightbox-next" class="lightbox-arrow">
        <span class="arrow-text">Suivante</span>
        <span class="arrow-icon">&rarr;</span>
    </div>
</div>

    <?php get_template_part( 'modal' ); ?>
</body>

</html>