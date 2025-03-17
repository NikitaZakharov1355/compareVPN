<?php
$title = get_sub_field('title');
$list = get_sub_field('list');
$type = get_sub_field('type');
$customizeble_list = get_sub_field('customizeble_list');
?>
    <?php if ($customizeble_list) :
        $list = get_sub_field('custom_list');
    endif;
    ?>
<?php if ($type == 'best-choice') : ?>

    <div class="cta_wrapper">
        <h2 class="post_main-title-h2 font_im"><?php echo $title; ?></h2>
        <div class="post_main-featured-list">
            <?php foreach ($list as $item) :
                $short_text = $customizeble_list ? $item['text'] : get_field('short_text', $item);
                if ($customizeble_list) :
                    $item = $item['select_vpn'];
                endif;
                $title = get_the_title($item);
                $logo_alternate = get_field('logo_alternate', $item);
			    $logo = get_field('logo', $item);
                $is_editor_choice = get_field('is_editor_choice', $item);
                $link = get_the_permalink();
			    $link_exteranl = get_field('link', $item);
            ?>
                <div class="post_main-featured-list-item flex justify_sb align_st">
                    <?php if ($is_editor_choice) : ?>
                        <div class="post_main-featured-list-item-label font_im flex align_c">
                            <img decoding="async" src="<?php echo get_template_directory_uri(); ?>/website/dist/images/editor-c-ic.svg">
                            <?php echo __('Editors Choice', 'nordvpn') ?>
                        </div>
                    <?php endif; ?>
                    <div class="post_main-featured-list-item-logo flex_auto flex align_c">
								<?php if($logo_alternate): ?>
									<?php echo wp_get_attachment_image($logo_alternate['ID'], 'full'); ?>
								<?php elseif($logo): ?>
									<?php echo wp_get_attachment_image($logo['ID'], 'full'); ?>
								<?php elseif(get_the_post_thumbnail()): ?>
									<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full'); ?>
								<?php else : ?>
      					
								<?php endif; ?>						
                    </div>
                    <div class="post_main-featured-list-item-descr flex dir_col justify_c">
                        <div class="post_main-featured-list-item-descr-title font_sb">
                            <?php echo $title; ?>
                        </div>
                        <div class="post_main-featured-list-item-descr-text">
                            <?php echo $short_text; ?>
                        </div>
                    </div>
					
                    <div class="flex_auto flex align_fe post_main-featured-list-item-link">
						<?php if($link_exteranl): ?>
                        <a class="button font_sb" target="<?php echo $link_exteranl['target']; ?>" href="<?php echo $link_exteranl['url']; ?>"><?php echo __('Visit website', 'nordvpn'); ?></a>
						<?php endif; ?>
                    </div>
					
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php elseif ($type == 'recommend') :  ?>
    <div class="cta_wrapper">
        <h2 class="post_main-title-h2 font_im"><?php echo $title; ?></h2>
        <div class="vpn-table-rank">
            <table>
                <thead>
                    <tr>
                        <th><?php echo __('Rank', 'nordvpn'); ?></th>
                        <th><?php echo __('Provider', 'nordvpn'); ?></th>
                        <th><?php echo __('Overall Score', 'nordvpn'); ?></th>
                        <th><?php echo __('Best Deal', 'nordvpn'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 0;
                    foreach ($list as $item) :
				
                        $counter++;
                        $logo_alternate = get_field('logo_alternate', $item);
					    $logo = get_field('logo', $item);
					    $link = get_the_permalink();
                        $link_exteranl = get_field('link', $item);
                        $rating = get_rating($item);
                        $is_editor_choice = get_field('is_editor_choice', $item);
                        $save_deal = get_field('save_deal', $item);
                        
                    ?>
                        <tr>
                            <td>
                                <div class="number flex align_c justify_c font_sb"><?php echo $counter; ?></div>
                            </td>
                            <td class="logo">
								<?php if($logo_alternate): ?>
									<?php echo wp_get_attachment_image($logo_alternate['ID'], 'full'); ?>
								<?php elseif($logo): ?>
									<?php echo wp_get_attachment_image($logo['ID'], 'full'); ?>
								<?php elseif(get_the_post_thumbnail()): ?>
									<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full'); ?>
								<?php else : ?>
    					
								<?php endif; ?>	
                            </td>
                            <td>
                                <?php //if ($rating) : ?>

                                    <div class="quick_stars-wrap flex align_c justify_fs">
                                        <div class="rating-value"><?php echo $rating; ?></div>					
										<div class="quick_stars-wrapper">
											<div class="quick_stars flex justify_fs align_c" style="width: <?php echo $rating * 10; ?>%"></div>
										</div>
                                    </div>
                                <?php //endif; ?>

                            </td>
                            <td>
                                <?php if ($save_deal) : ?>
                                    <div class="save font_sb flex align_c justify_c"><?php echo __('Save', 'nordvpn'); ?> <?php echo $save_deal; ?>%</div>
                                <?php endif; ?>
                            </td>

                            <td>
								<?php if($link_exteranl): ?>
                                <a class="button" target="<?php echo $link_exteranl['target']; ?>" href="<?php echo $link_exteranl['url']; ?>"><?php echo __('Visit website'); ?></a>
								<?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php elseif ($type == 'reviews') : ?>
    <div class="cta_wrapper">
        <h2 class="post_main-title-h2 font_im"><?php echo $title; ?></h2>
        <div class="coupon_main-reviews">
            <?php foreach ($list as $item) :
				$description = $customizeble_list ? $item['text'] : get_field('description', $item);
			    if ($customizeble_list) :
                   $item = $item['select_vpn'];
                endif;	
                $logo = get_field('logo', $item);
			 $logo_alternate = get_field('logo_alternate', $item);
                $our_score = get_post_meta($item, 'average_rating', true);
                $user_rating = get_post_meta($item, 'rating', true) ? : 0;
                $comments_number = get_comments_number($item);
			    
                $link = get_the_permalink($item);
            ?>
                <div class="coupon_main-reviews-item flex align_c">
                    <div class="coupon_main-reviews-item-logo flex_wrap">
								<?php if($logo): ?>
									<?php echo wp_get_attachment_image($logo['ID'], 'full'); ?>
								<?php elseif($logo_alternate): ?>
									<?php echo wp_get_attachment_image($logo_alternate['ID'], 'full'); ?>
								<?php elseif(get_the_post_thumbnail()): ?>
									<?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full'); ?>
								<?php else : ?>
					
								<?php endif; ?>								
                    </div>
                    <div class="coupon_main-reviews-item-descr">

                        <div class="coupon_main-reviews-item-descr-top flex align_c justify_sb">
                            <div class="coupon_main-reviews-item-descr-top-score flex align_c flex_wrap">
                                <span class="font_sb"><?php echo __('Our Score:', 'nordvpn'); ?></span>
                                <div class="coupon_main-reviews-item-descr-top-score-rating flex align_c flex_auto">
                                    <?php if ($our_score) : ?>					
										<div class="quick_stars-wrapper">
											<div class="quick_stars flex justify_fs align_c" style="width: <?php echo $our_score * 10; ?>%"></div>
										</div>
                                        <span class="font_ib"><?php echo esc_html($our_score); ?></span>
                                    <?php endif; ?>
                                </div>
                               
                            </div>
                            <?php if ($user_rating) : ?>
                                <div class="coupon_main-reviews-item-descr-top-right flex align_c">
                                    <div class="coupon_main-reviews-item-descr-top-score font_ib"><?php echo $user_rating ?></div>
                                    <div class="coupon_main-reviews-item-descr-top-counter flex_auto"> <?php echo esc_html('(' . $comments_number . ' Used Reviews)'); ?></div>
                                </div>
                            <?php endif; ?>

                        </div>
                        <?php if ($description) : ?>
                            <div class="coupon_main-reviews-item-descr-text"><?php echo $description; ?></div>
                        <?php endif; ?>
                        <!-- Dynamic Button -->
						<?php if($link): ?>
                        <a href="<?php echo $link; ?>" class="button font_sb">
                            <?php echo __('Full Reviews', 'nordvpn'); ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . '/website/dist/images/arrow-l-w.svg'; ?>" />
                        </a>
						<?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>