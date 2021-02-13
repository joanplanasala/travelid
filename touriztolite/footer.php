<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Touriztolite
 */

?>

	</div><!-- #content -->

	<footer id="colophon" <?php echo touriztolite_get_container_classes( 'site-footer' ); ?>>
		
		<?php get_template_part( 'template-parts/footer' ); ?>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
