<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nordVpn
 */

?>
<?php
$select_post = get_field('select_post');

if ($select_post) {
	$get_object = get_field('recommend_vpn', $select_post);
} else if (get_field('recommend_vpn')) {
	$get_object = get_field('recommend_vpn');
} else {
	$get_object = get_the_ID();
}


$rating = get_rating($get_object);
$logo = get_field('logo', $get_object);
$link = get_field('link', $get_object);
?>
<div class="post_aside flex_auto">
	<?php if (get_post_type(get_the_ID()) == 'vpn') : ?>
		<div class="post_aside-top">
			<a class="post_aside-top-image" href="<?php echo $link['url']; ?>">
				<?php echo wp_get_attachment_image($logo['ID'], ' full'); ?>
			</a>
			<div class="post_aside-top-rating flex align_c justify_c">

				<div class="post_aside-top-rating-label font_im">
					<?php echo __('Our Score', 'nordvpn'); ?>
				</div>
				<div class="post_aside-top-rating-value-wrap flex align_c justify_c">
					<img class="flex_auto" src="<?php echo get_template_directory_uri(); ?>/website/dist/images/star-ic.svg">
					<div class="post_aside-top-rating-value font_sb">
						<?php echo $rating; ?>
					</div>
				</div>
			</div>
			<a href="<?php echo $link['url']; ?>" class="button font_sb">
				<?php echo __('Visit website', 'nordvpn') ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="post_aside-contents">
		<div class="post_aside-contents-title flex align_c justify_sb font_sb" data-toggle="contents-list">
			<?php echo __('Table of Contents', 'nordvpn'); ?>
		</div>
		<div class="post_aside-contents-list scrolled-to-bottom" id="contents-list">
			<div class="post_aside-contents-list-scroll">
				<ul id="toc-list">
					<!-- Dynamic list of headings will be injected here -->
				</ul>
			</div>
		</div>
	</div>
	<?php if (get_post_type(get_the_ID()) !== 'vpn') : ?>
		<div class="post_aside-fetaured">
			<div class="coupon_main-head">
				<div class="coupon_main-head-title font_sb">
					<?php echo __('Best VPN Deals', 'nordvpn'); ?>
				</div>
			</div>
			<div class="post_aside-featured-list">
				<?php
				$list = get_field('best_deals_list');
				if ($list) {
					$list = get_field('best_deals_list', get_the_ID());
				} else {
					$list = get_field('best_deals_list', 'options');
				}
				$args = array(
					'post_type'      => 'vpn',
					'posts_per_page' => -1,
					'post__in'       => $list, // Use the IDs from ACF
					'orderby'        => 'post__in',
				);
				$query = new WP_Query($args);

				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
						$post_id = get_the_ID();
						$propouse = get_field('propouse', $post_id);
						$logo = get_field('logo', $post_id);
						$link = get_field('link', $post_id);
						$our_score = get_rating($post_id);
				?>
						<div class="post_aside-featured-list-item flex justify_sb align_fs">
							<div class="post_aside-featured-list-item-logo">
								<?php if ($propouse) : ?>
									<div class="post_aside-featured-list-item-logo-label font_sb">
										<?php echo $propouse; ?>
									</div>
								<?php endif; ?>
								<div class="post_aside-featured-list-item-logo-image flex align_c justify_c">
									<?php echo wp_get_attachment_image($logo['ID'], ' full'); ?>
								</div>
							</div>
							<div class="post_aside-featured-list-item-descr">
								<?php if ($our_score) : ?>
									
									<div class="post_aside-featured-list-item-descr-value">
										<?php echo $our_score; ?>
									</div>		
									<div class="flex justify_c align_c">							
										<div class="quick_stars-wrapper">
											<div class="quick_stars flex justify_fs align_c" style="width: <?php echo $our_score * 10; ?>%"></div>
										</div>
									</div>
								<?php endif; ?>
								<a class="button" target="<?php echo $link['target']; ?>" href="<?php echo $link['url']; ?>"><?php echo __('Get Deal!', 'nordvpn') ?></a>
							</div>
						</div>
				<?php
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p>No VPN deals found.</p>';
				endif;
				?>
			</div>
		</div>
	<?php endif; ?>
</div>