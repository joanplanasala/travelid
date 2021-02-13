<?php
/**
 * The template for displaying author bio.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Touriztolite
 * @subpackage widgets
 */

$is_enabled = touriztolite_theme()->customizer->get_value( 'single_author_block' );

if ( ! $is_enabled ) {
	return;
}

?>
<div class="post-author-bio">
	<div class="post-author__avatar"><?php
		touriztolite_get_post_author_avatar();
	?></div>
	<div class="post-author__content">
		<h4 class="post-author__title"><?php
			touriztolite_get_post_author();
		?></h4>
		<div class="post-author__content"><?php
			touriztolite_get_author_meta();
		?></div>
	</div>
</div>
