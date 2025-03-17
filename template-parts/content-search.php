<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nordVpn
 */

?>

<article id="post-<?php the_ID(); ?>" class="post_loop-item <?php echo get_post_type(); ?>">
	<div>
	<?php nordvpn_post_thumbnail(); ?>

	<div class="post_loop-item-descr">
		<div class="post_loop-item-descr-info">
	<?php the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>
	<?php 
		get_template_part('template-parts/reviews/author')
	?>
		<div class="entry-content">
		<?php
		echo wp_trim_words(get_the_excerpt(), 20, '...');
		?>
	</div><!-- .entry-content -->
	</div>
	<a href="<?php echo get_the_permalink(); ?>" class="button">
		<?php echo __('Read More', 'nordvpn'); ?>
	</a>
	</div>
	
	</div>
	
</article><!-- #post-<?php the_ID(); ?> -->