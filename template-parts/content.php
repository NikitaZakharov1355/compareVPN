<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nordVpn
 */

?>

<article id="post-<?php the_ID(); ?>" class="post_loop-item">
	<header class="entry-header">
		<?php
		if (is_singular()) :
			the_title('<h1 class="entry-title">', '</h1>');
		else :
			the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
		endif;

		?>
	</header><!-- .entry-header -->

	<?php nordvpn_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_excerpt();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'nordvpn'),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<a href="<?php echo get_the_permalink(); ?>" class="button">
		<?php echo __('Read More', 'nordvpn'); ?>
	</a>

	<footer class="entry-footer">
		<?php nordvpn_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->