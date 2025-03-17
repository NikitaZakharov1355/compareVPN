<?php

/**
 * The template for displaying the list of comments and the comment form.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// if (!post_type_supports(get_post_type(), 'comments')) {
// 	return;
// }

// if (!have_comments() && !comments_open()) {
// 	return;
// }

// // Comment Reply Script.
if (comments_open() && get_option('thread_comments')) {
	// wp_enqueue_script('comment-reply');
}

$select_post = get_field('select_post',get_the_ID());

?>

<section id="comments" class="comments">
	<div class="post_main-comments-form">
		<?php
		$comments_args = array(
			// Change the title of send button 
			'label_submit' => __('Post Comments', 'textdomain'),
			// Change the title of the reply section
			'title_reply' => __('Leave a Comment', 'textdomain'),
			// Remove "Text or HTML to be displayed after the set of comment fields".
			'comment_notes_after' => '',
			// Redefine your own textarea (the comment body).
			'comment_field' => '<p class="comment-form-comment">
                    <label for="comment">' . _x('Massage', 'noun') . '</label><br />
                    <textarea id="comment" name="comment" aria-required="true"></textarea></p>',
		);
		$select_post ? comment_form($comments_args, $select_post) : comment_form($comments_args);
		?>
	</div>

	<?php if ($select_post) : ?>
		<?php
		$comments = get_comments([
			'post_id' => $select_post,
			'status'  => 'approve', // Show only approved comments.
		]);
		?>
	<?php endif; ?>
	<div class="post_main-comments-list">
		<?php if (have_comments() || $comments) : ?>
			<h3 class="title-comments">
				<?php
				$comments_number = $select_post ? count($comments) : get_comments_number();
				if ('1' === $comments_number) {
					printf(esc_html_x('One Response', 'comments title', 'hello-elementor'));
				}
				?>
			</h3>
			<ol class="comment-list">
				<?php
				if ($select_post) {
					wp_list_comments([
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 56,
						'callback'   => 'default_comments_callback', // Use the default callback
					], $comments);
				} else {
					wp_list_comments(
						[
							'style'       => 'ol',
							'short_ping'  => true,
							'avatar_size' => 56,
							'callback'   => 'default_comments_callback', // Use the default callback
						]
					);
				}
				?>
			</ol>

			<div>
				<button class="load_more-comments button font_im" data-post-id="<?php echo get_the_ID(); ?>"><?php echo __('Load More'); ?></button>
			</div>


		<?php endif; ?>
	</div>

</section>