<?php
/**
 * Template part for displaying default posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Touriztolite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-default'); ?>>

	<header class="entry-header">
		<h3 class="entry-title"><?php 
			touriztolite_sticky_label();
			the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' );
		?></h3>
		<div class="entry-meta">
			<?php
				touriztolite_posted_by();
				touriztolite_posted_in( array(
					'prefix' => __( 'In', 'touriztolite' ),
				) );
				touriztolite_posted_on( array(
					'prefix' => __( 'Posted', 'touriztolite' )
				) );
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php touriztolite_post_thumbnail( 'touriztolite-thumb-l' ); ?>

	<?php touriztolite_post_excerpt(); ?>

	<footer class="entry-footer">
		<div class="entry-meta">
			<?php
				touriztolite_post_tags( array(
					'prefix' => __( 'Tags:', 'touriztolite' )
				) );
			?>
			<div><?php
				touriztolite_post_comments( array(
					'prefix' => '<i class="fa fa-comment" aria-hidden="true"></i>',
					'class'  => 'comments-button'
				) );
				touriztolite_post_link();
			?></div>
		</div>
		<?php touriztolite_edit_link(); ?>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-<?php the_ID(); ?> -->
