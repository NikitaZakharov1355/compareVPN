<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nordVpn
 */

?>

<section class="no-results not-found">
	<h2 class="post_main-title-h2 flex align_c justify_fs font_sb">
		<span class="title_inner">
			<?php esc_html_e('Nothing Found', 'nordvpn'); ?>
		</span>
	</h2>


	<div class="post_loop not-found">
		<div class="post_loop-not-found">
		<?php
		if (is_home() && current_user_can('publish_posts')) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'nordvpn'),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url(admin_url('post-new.php'))
			);

		elseif (is_search()) :
		?>

			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nordvpn'); ?></p>
		<?php

		else :
		?>

			<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'nordvpn'); ?></p>
		<?php


		endif;
		?>
				</div>
	</div><!-- .page-content -->
</section><!-- .no-results -->