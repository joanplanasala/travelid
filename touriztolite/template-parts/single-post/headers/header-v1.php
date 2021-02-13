<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Touriztolite
 */

?>

<header class="entry-header">
	<?php the_title( '<h1 class="entry-title h2-style">', '</h1>' ); ?>
	<div class="entry-meta">
		<?php
			touriztolite_posted_by();
			touriztolite_posted_in( array(
				'prefix'  => __( 'In', 'touriztolite' ),
			) );
			touriztolite_posted_on( array(
				'prefix'  => __( 'Posted', 'touriztolite' ),
			) );
			touriztolite_post_comments( array(
				'postfix' => __( 'Comment(s)', 'touriztolite' ),
			) );
		?>
	</div><!-- .entry-meta -->
</header><!-- .entry-header -->

<?php touriztolite_post_thumbnail( 'touriztolite-thumb-l', array( 'link' => false ) ); ?>