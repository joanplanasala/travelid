<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Touriztolite
 */

?>

<footer class="entry-footer">
	<div class="entry-meta"><?php
		touriztolite_post_tags ( array(
			'prefix'    => __( 'Tags:', 'touriztolite' ),
			'delimiter' => ''
		) );
	?></div>
</footer><!-- .entry-footer -->