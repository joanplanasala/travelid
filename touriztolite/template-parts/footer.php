<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package Touriztolite
 */
?>

<?php do_action( 'touriztolite-theme/widget-area/render', 'footer-area' ); ?>

<div <?php touriztolite_footer_class(); ?>>
	<div class="space-between-content"><?php
		touriztolite_footer_copyright();
		touriztolite_social_list( 'footer' );
	?></div>
</div><!-- .container -->
