<!-- Trigger/Open The Modal -->
<button id="myBtn">Open Modal</button>

<!-- The Modal -->

<div id="overlay"></div>

<div id="myModal" class="modal">
    <!-- Contenu de la modal -->

<!-- Modal content -->
<div class="modal-content">
  <span class="close">×</span>
  <div class="modal-header">
  <img src="<?php echo get_template_directory_uri() . '/images/Contact header.jpg'; ?>" alt="CONTACT">
    
  </div>
  <div class="modal-body">
  <?php echo do_shortcode('[contact-form-7 id="cc39ea2" title="Formulaire de contact"]'); ?>
  </div>


<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>