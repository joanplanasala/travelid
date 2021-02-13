<?php
/**
 * Template part for default Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Touriztolite
 */
?>

<?php get_template_part( 'template-parts/top-panel' ); ?>

<div <?php touriztolite_header_class(); ?>>
	<?php do_action( 'touriztolite-theme/header/before' ); ?>
	<div class="space-between-content">
		<div <?php touriztolite_site_branding_class(); ?>>
			<?php touriztolite_header_logo(); ?>
		</div>
		<?php touriztolite_main_menu(); ?>
	</div>
	<?php do_action( 'touriztolite-theme/header/after' ); ?>
</div>


