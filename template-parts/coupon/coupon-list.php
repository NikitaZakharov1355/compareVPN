<?php 
$select_coupons = get_sub_field('select_coupons'); // Returns an array of IDs
if ($select_coupons && is_array($select_coupons)) :
    $args = array(
        'post_type'      => 'coupon',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'post__in'       => $select_coupons, // Fetch only selected coupons
        'orderby'        => 'post__in'      // Preserve the order of IDs
    );

    $coupons_query = new WP_Query($args);

    if ($coupons_query->have_posts()) : ?>
        <div class="coupon_main-list">
            <?php while ($coupons_query->have_posts()) : $coupons_query->the_post();
                $id = get_the_ID(); 
                $percent = get_field('percent',$id);
                $select_type = get_field('select_type',$id);
                $title = get_the_title();
                $description = get_field('description',$id);
                $link = get_field('link',$id);
            ?>
                <div class="coupon_main-list-card flex justify_sb align_c">
                    <!-- Discount Section -->
                    <div class="coupon_main-list-card-discount flex_auto font_sb">
                        <div class="coupon_main-list-card-discount-box">
                            <?php if ($percent): ?>
                                <?php echo esc_html($percent); ?>%<br>
                                <span class="font_ib">OFF</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="coupon_main-list-card-details flex justify_sb align_c">
                        <div class="coupon_main-list-card-details-main flex justify_sb dir_col">
                            <div class="coupon_main-list-card-details-notice flex align_c">
                                <?php $select_type['value'] == 'verified' ? $icon_path = 'green-ic.svg' : $icon_path = 'green-ic.svg';?>
                                <div class="coupon_main-list-card-details-notice-icon flex-auto">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/website/dist/images/<?php echo $icon_path; ?>" />
                                </div>
                                <div class="coupon_main-list-card-details-notice-title font_sb">
                                    <?php echo $select_type['label']; ?>
                                </div>
                            </div>
                            <?php if ($title): ?>
                                <h2 class="coupon_main-list-card-details-title font_im">
                                    <?php echo esc_html($title); ?>
                                </h2>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <p class="coupon_main-list-card-details-text font_im">
                                    <?php echo esc_html($description); ?>
                                </p>
                            <?php endif; ?>

                        </div>
                        <!-- Button Section -->
                        <?php if ($link): ?>
                            <a href="<?php echo esc_url($link['url']); ?>" class="button font_sb">
                                <?php echo __('Get Deal!','nordvpn'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p><?php echo __('No coupons found.','nordvpn')?></p>
    <?php  endif;
    wp_reset_postdata(); ?>
<?php endif; ?>
