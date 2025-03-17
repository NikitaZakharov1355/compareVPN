<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nordVpn
 */
$select_post = get_field('select_post');
?>

<?php if ($select_post) : ?>
	<div class="post">
		<div class="container post_container flex justify_sb align_fs">
			<?php get_sidebar(); ?>
			<div class="post_main">
				<h1 class="post_main-title font_sb"><?php echo get_the_title($select_post); ?></h1>
				<?php get_template_part('template-parts/reviews/author'); ?>
				<?php

				// Check value exists.
				if (have_rows('flexible_content', $select_post)) :

					// Loop through rows.
					while (have_rows('flexible_content', $select_post)) : the_row();

						// Case: Paragraph layout.
						if (get_row_layout() == 'hero_banner') :
							get_template_part('template-parts/reviews/hero');
						endif;
						if (get_row_layout() == 'author_info') :
							get_template_part('template-parts/reviews/author');
						endif;
						if (get_row_layout() == 'inline_banner') :
							get_template_part('template-parts/banner/inline_banner');
						endif;
						if (get_row_layout() == 'preview_content') :
							get_template_part('template-parts/reviews/content-preview');
						endif;
						if (get_row_layout() == 'content') :
							get_template_part('template-parts/reviews/content');
						endif;
						if (get_row_layout() == 'pricing') :
							get_template_part('template-parts/reviews/pricing');
						endif;
						if (get_row_layout() == 'faq') :
							get_template_part('template-parts/reviews/faq');
						endif;
						if (get_row_layout() == 'overview_on_vpn_page') :
							get_template_part('template-parts/reviews/overview');
						endif;

						// post
						if (get_row_layout() == 'post_list') :
							get_template_part('template-parts/post/list');
						endif;
						if (get_row_layout() == 'overview') :
							get_template_part('template-parts/post/overview');
						endif;

						// coupon
						if (get_row_layout() == 'banner') :
							get_template_part('template-parts/coupon/banner');
						endif;
						if (get_row_layout() == 'coupon_list') :
							get_template_part('template-parts/coupon/coupon-list');
						endif;

					// End loop.
					endwhile;

				// No value.
				else :
				// Do something...
				endif; ?>

				<div class="post_main-author">
					<div class="post_main-author-title text_c font_sb">
						<?php echo 'About the Author'; ?>
					</div>
					<div class="post_main-author-descr">
					<?php get_template_part('template-parts/reviews/author'); ?>
						<div class="post_main-author-descr-text">
						<p><?php echo esc_html(get_the_author_meta('description')); ?></p>
						</div>
						<?php get_author_social_links(); ?>
						<div class="post_main-author-descr-action-title font_sb text_c">
							<?php echo 'Did you like this article? Rate it!'; ?>
						</div>
						<div class="post_main-author-descr-action-rating flex align_c justify_c" data-post-id="<?php echo get_the_ID(); ?>">
							<?php for ($i = 1; $i <= 5; $i++) : ?>
								<div class="rating-star" data-rating="<?php echo $i; ?>">

								</div>
							<?php endfor; ?>
						</div>
						<div id="rating-feedback"></div>
					</div>
				</div>
				<div class="post_main-comments">
					<?php
					if (comments_open($select_post) || get_comments_number($select_post)) :
						comments_template();
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
<?php else : ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		</header><!-- .entry-header -->

		<?php nordvpn_post_thumbnail(); ?>

		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__('Pages:', 'nordvpn'),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->

		<?php if (get_edit_post_link()) : ?>
			<footer class="entry-footer">
				<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__('Edit <span class="screen-reader-text">%s</span>', 'nordvpn'),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post(get_the_title())
					),
					'<span class="edit-link">',
					'</span>'
				);
				?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>